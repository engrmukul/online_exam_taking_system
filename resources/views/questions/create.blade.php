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
                        <form role="form" method="post" action="{{route( strtolower($pageTitle) . '.store')}}">
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
                                <textarea name="question" class="form-control" placeholder="Enter Question" required></textarea>
                                <span class="form-text m-b-none text-danger"> @error('name') {{ $message }} @enderror </span>
                            </div>

                            <!---Image--->
                            <div class="form-group">
                                <label for="ques" class="font-bold">{{ trans('question.image')}}</label>
                                <input type="file" name="image" class="form-control">
                            </div>

                            <spn>ANSWER ( Select radio button for correct answer )</spn> <br/>
                            <hr>
                            <div class="form-group row">
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="is_correct" id="exampleRadios1" value="1">
                                    <label class="form-check-label" for="defaultCheck1">
                                        <textarea name="answer[]" class="form-control" placeholder="Enter Answer" required></textarea>
                                    </label>
                                </div>
                                &nbsp;

                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="is_correct" id="exampleRadios1" value="2">
                                    <label class="form-check-label" for="defaultCheck1">
                                        <textarea name="answer[]" class="form-control" placeholder="Enter Answer" required></textarea>
                                    </label>
                                </div>

                                &nbsp;
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="is_correct" id="exampleRadios1" value="3">
                                    <label class="form-check-label" for="defaultCheck1">
                                        <textarea name="answer[]" class="form-control" placeholder="Enter Answer" required></textarea>
                                    </label>
                                </div>

                                &nbsp;
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="is_correct" id="exampleRadios1" value="4">
                                    <label class="form-check-label" for="defaultCheck1">
                                        <textarea name="answer[]" class="form-control" placeholder="Enter Answer" required></textarea>
                                    </label>
                                </div>

                                &nbsp;
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="is_correct" id="exampleRadios1" value="5">
                                    <label class="form-check-label" for="defaultCheck1">
                                        <textarea name="answer[]" class="form-control" placeholder="Enter Answer" required></textarea>
                                    </label>
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
