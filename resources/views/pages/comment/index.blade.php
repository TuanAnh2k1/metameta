@extends('layouts.index')
@php
    use Carbon\Carbon;
    use App\Core\Common\CoreConst;
@endphp
@section('title', 'Comments')
@section('content')
    <div class="page-header">
        <div class="row">
            <div class="col-md-6 col-sm-12">
                <div class="title">
                    <h4>@lang('app.list_comment')</h4>
                </div>
            </div>
            <div class="col-md-6 col-sm-12 text-right">
                <ul>
                    <li>
                        <a href="{{route('comments.create')}}" class="dropdown-toggle no-arrow text-add-comment">
                            <span class="micon bi bi-plus"></span><span class="mtext">@lang('app.comment')</span>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
    <div class="d-flex justify-content-between">
        <div class="input-group mb-3">
            <input type="text" class="form-control col-6" name="search" id="search"
                   placeholder="@lang('metameta.id'), @lang('metameta.metameta_element'), @lang('app.comment')"
                   value="{{$search}}">
            <div class="input-group-append">
                <button class="btn btn-success" type="submit" type="submit"
                        id="js__search-btn">@lang('app.search')</button>
            </div>
        </div>

        <select class="form-control btn-hover col-sm-2" name="created_by" id="created_by">
            <option value="">@lang('app.select_author')</option>
            @foreach($users as $user)
                <option value="{{$user->id}}" @if($created_by == $user->id) selected @endif>
                    @if($authUser->id == $user->id)
                        Me({{$user->display_name ?? $user->username}})
                    @else
                        {{$user->display_name ?? $user->username}}
                    @endif
                </option>
            @endforeach
        </select>
    </div>
    <table class="table table-striped card-box">
        <thead>
        <tr>
            <th scope="col" class="vertical-align">@sortablelink('id', 'ID')</th>
            <th scope="col" class="vertical-align">@sortablelink('metadata_no', __('metameta.id'))</th>
            <th scope="col" class="vertical-align">@sortablelink('metameta_element_id',
                __('metameta.metameta_element'))
            </th>
            <th scope="col" class="vertical-align">@sortablelink('comment', __('app.comment'))</th>
            <th scope="col" class="vertical-align">@sortablelink('creator.display_name', __('app.author'))</th>
            <th scope="col" class="vertical-align">@sortablelink('created_at', __('app.created_at'))</th>
            <th scope="col"></th>
        </tr>
        </thead>
        <tbody>
        @if($comment->isEmpty())
            <tr style="background: transparent;">
                <td class="table-no-data" style="background: transparent; border: none !important;">{{trans('app.no_data_exists')}}</td>
            </tr>
        @else
            @foreach ($comment as $key => $value)
                <tr>
                    <td class="width-col">{{$value->id}}</td>
                    <td class="width-col-id">{{$value->metadata_no}}</td>
                    <td class="width-col-id">
                        @if(!empty($value->metadata_element))
                            {{$value->metadata_element->name}}
                        @else
                            <br>
                        @endif
                    </td>
                    <td>
                        <span class="comment text-comment" id="text_comment">{!! nl2br($value->comment) !!}</span>
                    </td>
                    <td class="width-col-author">
                        {{$value->creator ? ($value->creator->display_name ?: $value->creator->username ) : null}}
                    </td>
                    <td class="width-col-created-at">{{Carbon::parse($value->created_at)->format('Y-m-d H:i')}}</td>
                    <td class="width-col">
                        @can('update',$value)
                            <a href="{{ route('comments.edit', $value->id) }}" class="text-add-comment margin-icon">
                                <i class="fa-solid fa-pen-to-square font-18"></i>
                            </a>
                        @endcan
                        @can('delete',$value)
                            <a class="text-danger delete_comment_id width-col cursor-pointer margin-icon"
                               data-delete-url="{{route('comments.destroy', $value->id)}}">
                                <i class="fa-solid fas fa-trash font-18"></i>
                            </a>
                        @endcan
                    </td>
                </tr>
            @endforeach
        @endif
        </tbody>
    </table>
    <div class="input-group d-flex justify-content-between">
        <div></div>
        <div class="d-flex justify-content-between">
            <select class="select-page" name="page_size" id="page_size">
                @foreach(CoreConst::PAGE_SIZES as $size)
                    <option value="{{$size}}" @if($page_size == $size) selected @endif>{{$size}}</option>
                @endforeach
            </select>
            {{$comment->withQueryString()->links()}}
        </div>
    </div>

@endsection
<div class="modal" id="myModalShow">
    <div class="modal-dialog">
        <div class="modal-content confirm-delete-metameta">
            <div class="modal-header">
                <h4 class="modal-title">@lang('app.delete_comment')</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                @lang('app.delete_confirm')
            </div>
            <form class="delete_modal" method="POST">
                {{ csrf_field() }}
                {{ method_field('DELETE') }}

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" id="cancel-delete"
                            data-dismiss="modal">@lang('app.cancel')</button>
                    <button type="submit" class="btn btn-danger" id="confirm-delete">@lang('app.delete')</button>
                </div>
            </form>
        </div>
    </div>
</div>
@section('script')
    <script type="text/javascript">
        $page = '1';
        $(document).ready(function () {
            $('.comment').on('click', function () {
                let obj = $(this);
                if (obj.hasClass('text-comment')) {
                    obj.removeClass("text-comment");
                } else {
                    obj.addClass("text-comment");
                }
            })
            $('#created_by').on('change', function () {
                setURL();
            })
            $('#page_size').on('change', function () {
                setURL();
            })
            $('.js-paginate').on('click', function () {
                $page = $(this).html().trim();
                setURL();
            })
            $('#search').keypress(function (e) {
                if (e.which == 13) {
                    setURL();
                }
            })
            $('#js__search-btn').on('click', function () {
                setURL();
            })
            $(".delete_comment_id").on('click', function () {
                let delete_url = $(this).attr('data-delete-url')
                $('.modal').modal("show");
                $('.delete_modal').attr('action', delete_url);
            });
        });

        function setURL() {
            $page = $page.trim();
            $created_by = $('#created_by').val().trim();
            $page_size = $('#page_size').val().trim();
            $search = $('#search').val().trim();
            $url_res = `../comments?page_size=${$page_size}&page=${$page}&search=${$search}&created_by=${$created_by}`;
            window.location = $url_res;
        };
    </script>
@endsection