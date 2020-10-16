@extends('app')
@section('title') {{ $pageTitle }} @endsection
@section('content')
    @include('partials.flash')
    <div class="wrapper wrapper-content animated fadeInRight">
        <div class="row">
            <div class="col-lg-12">
                <div class="ibox ">

                    <div class="ibox-content">
                        <!---FORM--->
                        <form role="form" method="post" action="{{route( 'reset-password')}}">
                            @method('PUT')
                            @csrf
                            <div class="row" id="pwd-container2">
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <label for="password">Password</label>
                                        <input type="password" name="password" class="form-control example2" id="password" placeholder="Password" value="" required>
                                        <span
                                            class="form-text m-b-none text-danger"> @error('password') {{ $message }} @enderror </span>
                                    </div>
                                    <div class="form-group">
                                        <div class="pwstrength_viewport_verdict"></div>
                                    </div>
                                </div>
                            </div>
                            <!---{{ $pageTitle }} CONTROL BUTTON--->
                            <div class="form-group row">
                                <div class="col-sm-4 col-sm-offset-2">
                                    <button class="btn btn-success" type="submit"><i class="fa fa-fw fa-lg fa-check-circle"></i>{{ trans('common.create')}}</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <!-- Password meter -->
    <script src="{{ asset('js/plugins/pwstrength/pwstrength-bootstrap.min.js') }}"></script>
    <script src="{{ asset('js/plugins/pwstrength/zxcvbn.js') }}"></script>

    <script type="text/javascript">

        $(document).ready(function(){


            // Example 1
            var options1 = {};
            options1.ui = {
                container: "#pwd-container1",
                showVerdictsInsideProgressBar: true,
                viewports: {
                    progress: ".pwstrength_viewport_progress"
                }
            };
            options1.common = {
                debug: false,
            };
            $('.example1').pwstrength(options1);
        })

    </script>
@endpush
