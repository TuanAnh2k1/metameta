@extends('layouts.index')
@php
    use App\Core\Helper\DateHelper;
    use App\Core\Common\CoreConst;
@endphp
@section('title', 'Users')
@section('content')
    <div class="page-header">
        <div class="row">
            <div class="col-md-6 col-sm-12">
                <div class="title">
                    <h4>@lang('app.list_user')</h4>
                </div>
            </div>
            @if($authUser->isAdmin())
                <div class="col-md-6 col-sm-12 text-right">
                    <ul>
                        <li>
                            <a href="{{route('users.create')}}" class="dropdown-toggle no-arrow text-add-comment">
                                <span class="micon bi bi-plus"></span><span class="mtext">@lang('app.users')</span>
                            </a>
                        </li>
                    </ul>
                </div>
            @endif
        </div>
    </div>
    <div class="d-flex justify-content-between">
        <div class="input-group mb-3">
            <input type="text" class="form-control col-5" name="search" id="search"
                   placeholder="@lang('app.display_name'), @lang('app.username')" value="{{$search}}">
            <div class="input-group-append">
                <button class="btn btn-success" type="submit" type="submit"
                        id="js__search-btn">@lang('app.search')</button>
            </div>
        </div>
    </div>
    <table class="table table-striped card-box" id="example">
        <thead>
        <tr>
            <th scope="col">@sortablelink('id', 'Id')</th>
            <th scope="col">@sortablelink('display_name', __('app.display_name'))</th>
            <th scope="col">@sortablelink('username', __('app.username'))</th>
            <th scope="col">@sortablelink('created_at', __('app.created_at'))</th>
            <th scope="col"></th>
        </tr>
        </thead>
        <tbody>
        @foreach ($users as $user)
            <tr>
                <td class="width-col">{{$user->id}}</td>
                <td>{{$user->display_name}}</td>
                <td>{{$user->username}}</td>
                <td class="width-col-created-at">{{DateHelper::format($user->created_at)}}</td>
                <td class="width-col">
                    @if($authUser->id != $user->id)
                        @can('update',$user)
                            <a href="{{ route('users.edit', $user->id) }}" class="text-add-comment margin-icon">
                                <i class="fa-solid fa-pen-to-square font-18"></i>
                            </a>
                        @endcan
                        @can('delete',$user)
                            <a class="text-danger delete_user_id margin-icon cursor-pointer"
                               data-delete-url="{{route('users.destroy', $user->id)}}">
                                <i class="fa-solid fa-trash font-18"></i>
                            </a>
                        @endcan
                    @endif
                </td>
            </tr>
        @endforeach
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
            {{$users->withQueryString()->links()}}
        </div>
    </div>
@endsection
<div class="modal" id="myModalShow">
    <div class="modal-dialog">
        <div class="modal-content confirm-delete-metameta">
            <div class="modal-header">
                <h4 class="modal-title">@lang('app.delete_user')</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">@lang('app.delete_confirm')</div>
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
            $('#search').keypress(function (e) {
                if (e.which == 13) {
                    $search = $('#search').val().trim();
                    setURL();
                }
            })
            $('#js__search-btn').on('click', function () {
                $search = $('#search').val().trim();
                setURL();
            })
            $('#page_size').on('change', function () {
                setURL();
            })
            $('.js-paginate').on('click', function () {
                $page = $(this).html().trim();
                setURL();
            })
            $('.delete_user_id').on('click', function () {
                let delete_url = $(this).attr('data-delete-url')
                $('.modal').modal("show");
                $('.delete_modal').attr('action', delete_url);
            });
        });

        function setURL() {
            $page = $page.trim();
            $page_size = $('#page_size').val().trim();
            $search = $('#search').val().trim();
            $url_res = `../users?page_size=${$page_size}&page=${$page}&search=${$search}`;
            window.location = $url_res;
        };
    </script>
@endsection