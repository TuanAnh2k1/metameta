@extends('layouts.index')
@section('title', 'Add user')
@section('content')
    <div class="page-header">
        <div class="row">
            <div class="col-md-6 col-sm-12">
                <div class="title">
                    <h4>@lang('app.add_user')</h4>
                </div>
            </div>
        </div>
    </div>
    <form action="{{route('users.store')}}" method="post">
        @csrf
        <div class="form-group">
            <label>@lang('app.display_name')</label>
            <span class="text-require-red">*</span>
            <input type="text" class="form-control" name="display_name" value="{{ old('display_name') }}">
            @error('display_name')
            <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>
        <div class="form-group">
            <label>@lang('app.username')</label>
            <span class="text-require-red">*</span>
            <input type="text" class="form-control" name="username" value="{{ old('username') }}">
            @error('username')
            <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>
        <div class="form-group">
            <label>@lang('app.role')</label>
            <select class="form-control" name="role_id">
                @foreach($roles as $role)
                    <option value="{{ $role->id }}" @if(old('role_id') == $role->id) selected @endif>{{ $role->name }}</option>
                @endforeach
            </select>
            @error('role_id')
            <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>
        <div class="text-right">
            <a class="btn btn-secondary" href="{{route('users.index')}}">@lang('app.cancel')</a>
            <button type="submit" class="btn btn-primary">@lang('app.save')</button>
        </div>
    </form>
@endsection