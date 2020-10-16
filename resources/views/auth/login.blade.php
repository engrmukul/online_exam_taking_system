<!DOCTYPE html>
<html>

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>OES</title>

    <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('font-awesome/css/font-awesome.css') }}" rel="stylesheet">

    <link href="{{ asset('css/style.css') }}" rel="stylesheet">
    <link href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"
    />

</head>

<body class="gray-bg lp">

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-4 col-md-6 col-sm-12 lpform">
                <div class="card animate__animated animate__fadeIn animate__delay-0s">
                    <div class="card-header"><i class="fa fa-lock" aria-hidden="true"></i>{{ trans('Login') }} <span class="float-right text-success">Online Exam System</span></div>

                    <div class="card-body">
                        <form method="POST" action="{{ route('login') }}">
                            @csrf

                            {{-- User ID --}}
                            <div class="form-group">
                                <label for="login">
                                    {{ __('Username or Email') }}
                                </label>
                                <input type="text"
                                       class="form-control {{ $errors->has('username') || $errors->has('email') ? ' is-invalid' : '' }}"
                                       id="login"
                                       aria-describedby="emailHelp"
                                       placeholder="email or username"
                                       name="login"
                                       value="{{ old('username') ?: old('email') }}"
                                       required
                                       autofocus>
                                @if ($errors->has('username') || $errors->has('email'))
                                    <span class="invalid-feedback">
                                        <strong>{{ $errors->first('username') ?: $errors->first('email') }}</strong>
                                    </span>
                                @endif
                            </div>

                            {{-- Passwords --}}
                            <div class="form-group">
                                <label for="login">
                                    {{ __('Password') }}
                                </label>
                                <input type="password"
                                       class="form-control {{ $errors->has('password') ? ' is-invalid' : '' }}"
                                       id="password"
                                       aria-describedby="emailHelp"
                                       placeholder="password"
                                       name="password"
                                       value="{{ old('username') ?: old('email') }}"
                                       required/>
                                @if ($errors->has('password'))
                                    <span class="invalid-feedback">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                @endif
                            </div>


                            <div class="form-group row">
                                <div class="col-md-6 offset-md-4">
                                    <div class="checkbox">
                                        <label>
                                            <input type="checkbox"
                                                   name="remember" {{ old('remember') ? 'checked' : '' }}> {{ __('Remember Me') }}
                                        </label>
                                    </div>
                                </div>
                            </div>

                            <button type="submit" class="btn btn-primary">
                                {{ __('Login') }}
                            </button>

                            <a class="btn btn-link" href="#">
                                {{ __('Forgot Your Password?') }}
                            </a>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>








