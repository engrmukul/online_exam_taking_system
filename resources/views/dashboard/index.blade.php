@extends('app')
@section('title') {{ $pageTitle }} @endsection

<style>
    .ibox .label {
        font-size: 12px !important;
    }
</style>

@section('content')
    @include('partials.flash')

    <div class="wrapper wrapper-content text-center">
        <h1>WELCOME <strong class="text-success">Mr {{auth()->user()->username}}</strong> TO</h1>
        <h2>Online Exam Taking Application</h2>
    </div>

@endsection
