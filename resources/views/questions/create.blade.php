@extends('app')
@section('title') {{ $pageTitle }} @endsection
@section('content')
    @include('partials.flash')
    <div class="wrapper wrapper-content animated fadeInRight">
        <div class="row">
            <div class="col-lg-12">
                <div class="ibox ">
                    <div class="ibox-title">
                        <h5><i class="fa fa-book"></i> Question {{ trans('common.create')}}</h5>
                        <div class="ibox-tools">
                            <a style="margin-top: -8px;" href="{{ route( strtolower($pageTitle) . '.index') }}" class="btn btn-primary"><i
                                    class="fa fa-list"></i> {{ trans('common.list')}}</a>
                        </div>
                    </div>
                    <div class="ibox-content">
                        <!---FORM--->
                        <form role="form" method="post" action="{{route( strtolower($pageTitle) . '.store')}}" enctype="multipart/form-data">
                            @csrf
                                
                            <!---Subject--->
                            <div class="form-group">
                                <label for="parent">{{ trans('question.subject')}}</label>
                                <select id="subject_id" class="form-control custom-select mt-15" name="subject_id" required>
                                    <option value="">{{ trans('question.subject')}}</option>
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

                            <!---Question--->
                            <div class="form-group">
                                <label for="ques" class="font-bold">{{ trans('question.question')}}</label>
                                <textarea name="question" class="form-control" placeholder="Enter Question" required>{{old('question')}}</textarea>
                                <span class="form-text m-b-none text-danger"> @error('name') {{ $message }} @enderror </span>
                            </div>

                            <!---Image--->
                            <div class="form-group">
                                <label for="ques" class="font-bold">{{ trans('question.image')}}</label>
                                <input type="file" name="image" class="form-control">
                                <span class="form-text m-b-none text-danger"> @error('image') {{ $message }} @enderror </span>
                            </div>

                            <spn>ANSWER ( Select radio button for correct answer )</spn> <br/>
                            <hr>
                            <div class="form-group">
                                <div class="input-group m-b">
                                    <div class="input-group-prepend"><span class="input-group-addon"><input type="radio" name="is_correct" value="1" required></span></div>
                                    <textarea name="answer[]" class="form-control" placeholder="Enter Answer" required></textarea>
                                </div>
                                <div class="input-group m-b">
                                    <div class="input-group-prepend"><span class="input-group-addon"><input type="radio" name="is_correct" value="2" required></span></div>
                                    <textarea name="answer[]" class="form-control" placeholder="Enter Answer" required></textarea>
                                </div>
                                <div class="input-group m-b">
                                    <div class="input-group-prepend"><span class="input-group-addon"><input type="radio" name="is_correct" value="3" required></span></div>
                                    <textarea name="answer[]" class="form-control" placeholder="Enter Answer" required></textarea>
                                </div>
                                <div class="input-group m-b">
                                    <div class="input-group-prepend"><span class="input-group-addon"><input type="radio" name="is_correct" value="4" required></span></div>
                                    <textarea name="answer[]" class="form-control" placeholder="Enter Answer" required></textarea>
                                </div>
                                <div class="input-group m-b">
                                    <div class="input-group-prepend"><span class="input-group-addon"><input type="radio" name="is_correct" value="5" required></span></div>
                                    <textarea name="answer[]" class="form-control" placeholder="Enter Answer" required></textarea>
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
