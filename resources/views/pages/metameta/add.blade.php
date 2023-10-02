@extends('layouts.index')
@php
    use App\Core\Common\CoreConst;
@endphp
@section('title', 'Add metameta')
@section('content')
    <div class="page-header">
        <div class="row">
            <div class="col-md-6 col-sm-12">
                <div class="title">
                    <h4>{{__('metameta.add_metameta')}}</h4>
                </div>
            </div>
        </div>
    </div>
    <form class="comment" action="{{route('metameta.store')}}" method="post">
        @csrf
        <div class="form-group d-flex">
            <label class="form-elements">{{__('metameta.dataset_name_ja')}}</label>
            <input class="form-control" name="dataset_name_ja">
        </div>
        <div class="form-group d-flex">
            <label class="form-elements">{{__('metameta.dataset_name_en')}}</label>
            <input class="form-control" name="dataset_name_en">
        </div>
        <div class="form-group d-flex">
            <label class="form-elements">{{__('metameta.severity')}}</label>
            <select class="form-control form-elements" name="severity">
                @foreach($severity as $value)
                    <option value={{array_keys($severity,$value)[0]}} >@lang($value['text'])</option>
                @endforeach
            </select>
        </div>
        <div class="form-group d-flex">
            <label class="form-elements">{{__('metameta.remarks')}}</label>
            <textarea class="form-control" name="remarks"></textarea>
        </div>
        <div class="text-right">
            <a class="btn btn-secondary" href="{{route('metameta.index')}}">{{__('app.cancel')}}</a>
            <button type="submit" class="btn btn-primary">{{__('app.save')}}</button>
        </div>
    </form>
@endsection