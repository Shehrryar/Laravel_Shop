@extends('front.layouts.app')
@section('content')
    <section class="section-5 pt-3 pb-3 mb-3 bg-white">
        <div class="container">
            <div class="light-font">
                <ol class="breadcrumb primary-color mb-0">
                    <li class="breadcrumb-item"><a class="white-text" href="#">{{trans("Home")}}</a></li>
                    <li class="breadcrumb-item">{{trans("Register")}}</li>
                </ol>
            </div>
        </div>
    </section>
    <section class=" section-10">
        <div class="container">
            <div class="login-form">
                <form name="registerationForm" id="registerationForm" action="post">
                    <h4 class="modal-title">{{trans("Register Now")}}</h4>
                    <div class="form-group">
                        <input type="hidden" id="fcm_token" name="fcm_token">
                        <input type="text" class="form-control" placeholder="{{trans("Name")}}" id="name" name="name">
                        <p></p>
                    </div>
                    <div class="form-group">
                        <input type="text" class="form-control" placeholder="{{trans("Email")}}" id="email" name="email">
                        <p></p>
                    </div>
                    <div class="form-group">
                        <input type="text" class="form-control" placeholder="{{trans("Phone")}}" id="phone" name="phone">
                        <p></p>
                    </div>
                    <div class="form-group">
                        <input type="password" class="form-control" placeholder="{{trans("Password")}}" id="password"
                            name="password">
                        <p></p>
                    </div>
                    <div class="form-group">
                        <input type="password" class="form-control" placeholder="{{trans("Confirm Password")}}"
                            id="password_confirmation" name="password_confirmation">
                        <p></p>
                    </div>
                    <div class="form-group small">
                        <a href="#" class="forgot-link">{{trans("Forgot Password?")}}</a>
                    </div>
                    <button type="submit" class="btn btn-dark btn-block btn-lg"
                        value="Register">{{trans("Register")}}</button>
                    <hr>
                    <div class="form-group social-login">
                        <a href="{{route('auth.google')}}" class="btn btn-success">{{trans("Login with Google")}}</a>
                        <a href="{{route('auth.facebook')}}" class="btn btn-primary">{{trans("Login with Facebook")}}</a>
                    </div>
                </form>
                <div class="text-center small">{{trans("Already have an account?")}} <a
                        href="login.php">{{trans("Login Now")}}</a></div>
            </div>
        </div>
    </section>
@endsection
@section('customJs')
    <script type="module" src="{{ asset('front-assets/js/firebase-messaging.js') }}"></script>
    <script type="text/javascript">
        $('#registerationForm').submit(function (event) {
            event.preventDefault();
            $.ajax({
                url: '{{route('account.processRegister')}}',
                type: 'post',
                data: $(this).serializeArray(),
                dataType: 'json',
                success: function (response) {
                    if (response.status === false) {
                        var errors = response.errors;
                        if (errors.name) {
                            $('#name').siblings('p').addClass('invalid-feedback').html(errors.name);
                            $('#name').removeClass('is-valid').addClass('is-invalid'); // Added .removeClass('is-valid') here
                        } else {
                            $('#name').siblings('p').removeClass('invalid-feedback').html('');
                            $('#name').removeClass('is-invalid').addClass('is-valid'); // Added .removeClass('is-invalid') here
                        }
                        if (errors.email) {
                            $('#email').siblings('p').addClass('invalid-feedback').html(errors.email);
                            $('#email').removeClass('is-valid').addClass('is-invalid'); // Added .removeClass('is-valid') here
                        } else {
                            $('#email').siblings('p').removeClass('invalid-feedback').html('');
                            $('#email').removeClass('is-invalid').addClass('is-valid'); // Added .removeClass('is-invalid') here
                        }
                        if (errors.password) {
                            $('#password').siblings('p').addClass('invalid-feedback').html(errors.password);
                            $('#password').removeClass('is-valid').addClass('is-invalid'); // Added .removeClass('is-valid') here
                        } else {
                            $('#password').siblings('p').removeClass('invalid-feedback').html('');
                            $('#password').removeClass('is-invalid').addClass('is-valid'); // Added .removeClass('is-invalid') here
                        }
                    } else {
                        // If the response is successful, clear the error messages and invalid feedback
                        $('#name').siblings('p').removeClass('invalid-feedback').html('');
                        $('#name').removeClass('is-invalid is-valid');
                        $('#email').siblings('p').removeClass('invalid-feedback').html('');
                        $('#email').removeClass('is-invalid is-valid');
                        $('#password').siblings('p').removeClass('invalid-feedback').html('');
                        $('#password').removeClass('is-invalid is-valid');
                        window.location.href = "{{route('account.login')}}";
                    }
                }
                ,
                error: function (jQXHR, exception) {
                    console.log('something went wrong');
                }
            });
        });
    </script>
@endsection