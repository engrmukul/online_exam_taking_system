@extends('app')
@section('title') {{ $pageTitle }} @endsection
@section('content')

    @include('partials.flash')
    <div class="wrapper wrapper-content animated fadeInRight">
        <div class="row">
            <div class="col-md-12">
                <div class="ibox ">
                    <div class="ibox-title">
                        <h5><i class="fa fa-list"></i> {{ trans('common.list')}}</h5>
                        <div class="ibox-tools">
                            <a style="margin-top: -8px;" href="{{ route( 'permissions.index') }}" class="btn btn-primary"><i
                                        class="fa fa-list"></i> {{ trans('permission.permissions')}}</a>

                            <a style="margin-top: -8px;" href="{{ route( 'roles.index') }}" class="btn btn-primary"><i
                                        class="fa fa-list"></i> {{ trans('role.roles')}}</a>

                            <a style="margin-top: -8px;" href="{{ route( strtolower($pageTitle) . '.create') }}" class="btn btn-primary"><i
                                    class="fa fa-plus"></i> {{ trans('common.create')}}</a>

                            <a style="margin-top: -8px;" href="{{ route( strtolower($pageTitle) . '.restore') }}" class="btn btn-primary"><i
                                    class="fa fa-window-restore"></i> {{ trans('common.restore')}}</a>
                        </div>
                    </div>
                    <div class="ibox-content">

                        <div class="table-responsive">
                            @include('partials.datatable')
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
