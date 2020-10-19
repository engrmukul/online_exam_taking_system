@extends('app')
@section('title') {{ $pageTitle }} @endsection
@section('content')
    @include('partials.flash')
    <div class="wrapper wrapper-content animated fadeInRight">
        <div class="row">
            <div class="col-lg-12">
                <div class="ibox ">
                    <div class="ibox-title">
                        <h5><i class="fa fa-book"></i> Exam {{ trans('common.create')}}</h5>
                        <div class="ibox-tools">
                            <a style="margin-top: -8px;" href="{{ route( strtolower($pageTitle) . '.index') }}" class="btn btn-primary"><i
                                    class="fa fa-list"></i> {{ trans('common.list')}}</a>
                        </div>
                    </div>
                    <div class="ibox-content">
                        <!---FORM--->
                        <form role="form" method="post" action="{{route( strtolower($pageTitle) . '.store')}}">
                            @csrf
                                
                            <!---Subject--->
                            <div class="form-group">
                                <label for="parent">{{ trans('exam.subject')}}</label>
                                <select id="subject_id" class="form-control custom-select mt-15" name="subject_id" required>
                                    <option value="">{{ trans('exam.subject')}}</option>
                                    @foreach($subjects as $key => $subject)
                                        @if (old('subject_id') == $subject->id)
                                            <option value="{{ $subject->id }}" selected> {{ $subject->name }} </option>
                                        @else
                                            <option value="{{ $subject->id }}"> {{ $subject->name }} </option>
                                        @endif
                                    @endforeach
                                </select>
                                <span class="form-text m-b-none text-danger"> @error('subject_id') {{ $message }} @enderror </span>
                            </div>

                            <!---Exam Title--->
                            <div class="form-group">
                                <label for="exam_title" class="font-bold">{{ trans('exam.exam_title')}}</label>
                                <input type="text" name="exam_title" value="{{ old('exam_title') }}" placeholder="{{ trans('exam.exam_title')}}" maxlength="255" class="form-control" required>
                                <span class="form-text m-b-none text-danger"> @error('exam_title') {{ $message }} @enderror </span>
                            </div>

                            <!---Exam Date--->
                            <div class="form-group" id="dateItem">
                                <label for="exam_date" class="font-bold">{{ trans('exam.exam_date')}}</label>
                                <div class="input-group date">
                                    <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                                    <input type="text" name="exam_date" class="form-control" value="{{ old('exam_date') }}" placeholder="{{ trans('exam.exam_date')}}" required>
                                </div>
                                <span class="form-text m-b-none text-danger"> @error('exam_date') {{ $message }} @enderror </span>
                            </div>


                                <!---NOP--->
                            <div class="form-group">
                                <label for="noq" class="font-bold">{{ trans('exam.noq')}}</label>
                                <input type="text" name="noq" value="{{ old('noq') }}" placeholder="{{ trans('exam.noq')}}" maxlength="3" class="form-control" required>
                                <span class="form-text m-b-none text-danger"> @error('noq') {{ $message }} @enderror </span>
                            </div>


                            <!---Exam Start Time--->
                            <div class="form-group">
                                <label for="start_time" class="font-bold">{{ trans('exam.start_time')}}</label>
                                <div class="input-group clockpicker" data-autoclose="true">
                                    <input type="text"  name="start_time" class="form-control" value="09:30">
                                    <span class="input-group-addon">
                                        <span class="fa fa-clock-o"></span>
                                    </span>
                                </div>
                            </div>

                            <!---Exam End Time--->
                            <div class="form-group">
                                <label for="end_time" class="font-bold">{{ trans('exam.end_time')}}</label>
                                <div class="input-group clockpicker" data-autoclose="true">
                                    <input type="text" name="end_time" class="form-control" value="10:30">
                                    <span class="input-group-addon">
                                        <span class="fa fa-clock-o"></span>
                                    </span>
                                </div>
                            </div>

                            <!---Exam Status--->
                            <div class="form-group">
                                <label for="exam_status">{{ trans('exam.exam_status')}}</label>
                                <select id="exam_status" class="form-control custom-select mt-15" name="exam_status" required>
                                    <option value="">{{ trans('exam.exam_status')}}</option>
                                    <option value="not_start">Not Start</option>
                                    <option value="on_going">On Going</option>
                                    <option value="expire">Expire</option>
                                </select>
                                <span class="form-text m-b-none text-danger"> @error('exam_status') {{ $message }} @enderror </span>
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
