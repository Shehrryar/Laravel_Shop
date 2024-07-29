@extends('front.layouts.app')


@section('content')
<section class="section-5 pt-3 pb-3 mb-3 bg-white">
    <div class="container">
        <div class="light-font">
            <ol class="breadcrumb primary-color mb-0">
                <li class="breadcrumb-item"><a class="white-text" href="#">{{trans("Home")}}</a></li>
                <li class="breadcrumb-item">{{trans("Login")}}</li>
            </ol>
        </div>
    </div>
</section>

<section class=" section-10">
    <div class="container">
        @if(Session::has('success'))
        <div class='alert alert-success'>
            {{Session::get('success')}}
        </div>
        @elseif(Session::has('error'))
        <div class='alert alert-danger'>
            {{Session::get('error')}}
        </div>
        @endif
        <div class="login-form">
            <form action="{{route('account.authenticate')}}" method="post">
                @csrf
                <h4 class="modal-title">{{trans("Login to Your Account")}}</h4>
                <div class="form-group">
                    <input type="text" class="form-control @error('email') is-invalid @enderror" placeholder="Email"
                        name="email" value="{{old('email')}}">
                    @error('email')
                    <p class="invalid-feedback">{{$message}}</p>
                    @enderror
                </div>
                <div class="form-group">
                    <input type="password" class="form-control @error('password') is-invalid @enderror"
                        placeholder="Password" name="password">
                    @error('password')
                    <p class="invalid-feedback">{{$message}}</p>
                    @enderror
                </div>
                <div class="form-group small">
                    <a href="#" class="forgot-link">{{trans("Forgot Password?")}}</a>
                </div>
                <input type="submit" class="btn btn-dark btn-block btn-lg" value="{{trans("Login")}}">

                <hr>

                <div class="form-group social-login">
                    <a href="{{route('auth.google')}}" class="btn btn-success">{{trans("Login with Google")}}</a>
                    <a href="{{route('auth.github')}}" class="btn btn-primary">{{trans("Login with GitHub")}}</a>
                </div>
            </form>
            <div class="text-center small">{{trans("Don't have an account?")}} <a href="{{route('account.register')}}">{{trans("Sign up")}}</a>
            </div>
        </div>
    </div>
</section>
@endsection