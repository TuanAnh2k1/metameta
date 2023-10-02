@extends('layouts.index')
@section('title', 'Dashboard')
@section('content')
    <div class="page-header">
        <div class="row">
            <div class="col-md-6 col-sm-12">
                <div class="title">
                    <h4>{{__('app.dashboard')}}</h4>
                </div>
            </div>
        </div>
    </div>
    @if($profile->isAdmin())
        <div class="row pb-10">
            <div class="col-xl-3 col-lg-3 col-md-6 mb-20">
                <div class="card-box height-100-p widget-style3">
                    <div class="d-flex flex-wrap">
                        <div class="widget-data">
                            <div class="weight-700 font-24 text-dark">{{ number_format($data_user)}}</div>
                            <div class="font-14 text-secondary weight-500">{{__('app.users')}}</div>
                        </div>
                        <div class="widget-icon">
                            <div class="icon ic-color-user">
                                <i class="icon-copy bi bi-people"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-lg-3 col-md-6 mb-20">
                <div class="card-box height-100-p widget-style3">
                    <div class="d-flex flex-wrap">
                        <div class="widget-data">
                            <div class="weight-700 font-24 text-dark">{{ number_format($data_comment)}}</div>
                            <div class="font-14 text-secondary weight-500">{{__('app.comments')}}</div>
                        </div>
                        <div class="widget-icon">
                            <div class="icon ic-color-comment">
                                <i class="icon-copy bi bi-card-text"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif
    <div class="pd-10 card-box height-100-p w-50">
        <div class="profile-info">
            <h5 class="mb-20 h5 text-blue">{{__('app.information')}}</h5>
            <ul>
                <li>
                    <span>{{__('app.username')}}:</span>
                    {{$profile->username}}
                </li>
                <li>
                    <span>{{__('app.display_name')}}:</span>
                    {{$profile->display_name}}
                </li>
                <li>
                    <span>{{__('app.role')}}:</span>
                    {{$profile->role->name}}
                </li>
                <li>
                    <span>{{__('app.created_at')}}:</span>
                    {{$profile->created_at}}
                </li>
            </ul>
        </div>
    </div>
@endsection