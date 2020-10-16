@extends('app')
@section('title') {{ $pageTitle }} @endsection

<style>
    .ibox .label {
        font-size: 12px !important;
    }
</style>

@section('content')
    @include('partials.flash')

    <div class="wrapper wrapper-content">

    </div>

@endsection
