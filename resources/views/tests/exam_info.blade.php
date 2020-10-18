@extends('app')
@section('title') {{ $pageTitle }} @endsection
@section('content')
    @include('partials.flash')
    <div class="wrapper wrapper-content text-center">
        <h1>{{$pageData->examInfo}}</h1>
    </div>
@endsection
