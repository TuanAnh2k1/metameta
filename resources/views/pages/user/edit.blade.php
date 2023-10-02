@extends('layouts.index')
@section('title', 'Edit user')
@section('content')
    <div class="page-header">
        <div class="row">
            <div class="col-md-6 col-sm-12">
                <div class="title">
                    <h4>@lang('app.edit_user')</h4>
                </div>
            </div>
        </div>
    </div>
    <form action="{{route('users.update', $user->id)}}" method="post">
        @csrf
        {{ method_field('PUT') }}
        <div class="form-group">
            <label>@lang('app.display_name')</label>
            <span class="text-require-red">*</span>
            <input type="text" class="form-control" name="display_name" value="{{ old('display_name') ?? $user->display_name }}" required>
            @error('display_name')
            <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>
        <div class="form-group">
            <label>@lang('app.username')</label>
            <span class="text-require-red">*</span>
            <input type="text" class="form-control" name="username" value="{{ old('username') ?? $user->username }}" required>
            @error('username')
            <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>
        <div class="form-group">
            <label>{{__('app.role')}}</label>
            @php($oldRoleId = old('role_id') ?? $user->role_id)
            <select class="form-control" name="role_id" required>
                @foreach($roles as $role)
                    <option value="{{ $role->id }}" @if($oldRoleId == $role->id) selected @endif>{{ $role->name }}</option>
                @endforeach
            </select>
            @error('role_id')
            <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>
        <div class="text-right">
            <a class="btn btn-secondary" href="{{route('users.index')}}">@lang('app.cancel')</a>
            <button type="submit" class="btn btn-primary">{{__('app.update')}}</button>
        </div>
    </form>
@endsection