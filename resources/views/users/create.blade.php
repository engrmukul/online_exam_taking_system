@extends('app')
@section('title') {{ $pageTitle }} @endsection
@section('content')
    @include('partials.flash')
    <div class="wrapper wrapper-content animated fadeInRight">
        <div class="row">
            <div class="col-lg-12">
                <div class="ibox ">
                    <div class="ibox-title">
                        <h5><i class="fa fa-book"></i> {{ trans('common.create')}}</h5>
                        <div class="ibox-tools">
                            <a style="margin-top: -8px;" href="{{ route( strtolower($pageTitle) . '.index') }}" class="btn btn-primary"><i
                                    class="fa fa-list"></i> {{ trans('common.list')}}</a>
                        </div>
                    </div>
                    <div class="ibox-content">
                        <!---FORM--->

                            <form user="form" method="post" action="{{route( strtolower($pageTitle) . '.store')}}">
                                @csrf
                                <div class="row">
                                    <div class="col-md-6">
                                        <!---Name--->
                                        <div class="form-group">
                                            <label for="name" class="font-bold">{{ trans('user.name')}}</label>
                                            <input type="text" name="name" value="{{ old('name') }}" placeholder="{{ trans('user.name')}}" maxlength="255" class="form-control" required>
                                            <span class="form-text m-b-none text-danger"> @error('name') {{ $message }} @enderror </span>
                                        </div>

                                        <!---mobile--->
                                        <div class="form-group">
                                            <label for="mobile" class="font-bold">{{ trans('user.mobile')}}</label>
                                            <input type="text" name="mobile" value="{{ old('mobile') }}" placeholder="{{ trans('user.mobile')}}" maxlength="20" class="form-control" required>
                                            <span class="form-text m-b-none text-danger"> @error('mobile') {{ $message }} @enderror </span>
                                        </div>

                                        <!---username--->
                                        <div class="form-group">
                                            <label for="username" class="font-bold">{{ trans('user.username')}}</label>
                                            <input type="text" name="username" value="{{ old('username') }}" placeholder="{{ trans('user.username')}}" maxlength="50" class="form-control" required>
                                            <span class="form-text m-b-none text-danger"> @error('username') {{ $message }} @enderror </span>
                                        </div>

                                        <!---mobile--->
                                        <div class="form-group">
                                            <label for="email" class="font-bold">{{ trans('user.email')}}</label>
                                            <input type="text" name="email" value="{{ old('email') }}" placeholder="{{ trans('user.email')}}" maxlength="50" class="form-control" required>
                                            <span class="form-text m-b-none text-danger"> @error('email') {{ $message }} @enderror </span>
                                        </div>
                                    </div>

                                    <div class="col-md-6">

                                        <!---password--->
                                    <div class="form-group">
                                        <label for="password" class="font-bold">{{ trans('user.password')}}</label>
                                        <input type="text" name="password" value="" placeholder="{{ trans('user.password')}}" maxlength="50" class="form-control" required>
                                        <span class="form-text m-b-none text-danger"> @error('password') {{ $message }} @enderror </span>
                                    </div>

                                    <!---role--->
                                    <div class="form-group">
                                        <label for="role" class="font-bold">{{ trans('user.role')}}</label>

                                        <select class="form-control" name="role_id[]" required multiple="">
                                            @forelse($roles as $key => $role)
                                                <option value="{{ $role->id }}">{{ $role->name }}</option>
                                            @empty
                                            @endforelse
                                        </select>

                                        <span class="form-text m-b-none text-danger"> @error('role_id') {{ $message }} @enderror </span>
                                    </div>
                                </div>
                                    <div class="col-md-6">
                                        <!---Menu--->
                                        <div class="form-group">
                                            <label for="menu" class="font-bold">{{ trans('user.menu')}}</label>

                                            @forelse($menus as $key => $menu)
                                                <input type="checkbox" name="menu_id[]" value="{{ old('menu_id', $menu->id) }}" placeholder="{{ trans('user.menu')}}" class="form-control"> {{$menu->name}}
                                            @empty
                                            @endforelse

                                            <span class="form-text m-b-none text-danger"> @error('menu_id') {{ $message }} @enderror </span>
                                        </div>
                                    </div>
                                </div>
                                <!---CONTROL BUTTON--->
                                <div class="form-group row">
                                    <div class="col-sm-4 col-sm-offset-2">
                                        <button class="btn btn-success" type="submit"><i class="fa fa-fw fa-lg fa-check-circle"></i>{{ trans('common.submit')}}</button>
                                        <a class="btn btn-danger" href="{{route( strtolower($pageTitle) . '.index')}}"><i class="fa fa-fw fa-lg fa-arrow-left"></i>{{ trans('common.go_back')}}</a>
                                    </div>
                                </div>
                            </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
