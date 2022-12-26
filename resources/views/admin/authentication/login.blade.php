@extends('admin.layouts.loginlayout')
@section('content')
<div class="container">
    <div class="row">
        <div class="col-12 col-md-6 col-lg-4 mr-auto ml-auto">
            <form class="bg-light login-form" method="post" action="{{route('admin.login')}}" ectype="">
                @csrf
                @if(Session::has('success_msg'))
                    <div class="alert alert-success">{{Session::get('success_msg')}}</div>
                @endif
                @if(Session::has('err_msg'))
                    <div class="alert alert-danger">{{Session::get('err_msg')}}</div>
                @endif
                <div class="form-group">
                    <label for="exampleInputEmail1">{{__('admin.email')}}</label>
                    <input type="text" class="form-control email" name="email" placeholder="{{__('admin.enter_email')}}">
                    <small class="form-text text-danger email-valid d-none @error('email') d-block @enderror">
                        @error('email')
                            {{$message}}
                        @enderror
                    </small>
                </div>
                <div class="form-group">
                    <label for="exampleInputPassword1">{{__('admin.password')}}</label>
                    <input type="password" class="form-control password" name="password" placeholder="{{__('admin.enter_password')}}">
                    <small class="form-text text-danger pass-valid d-none @error('password') d-block @enderror">
                        @error('password')
                            {{$message}}
                        @enderror
                    </small>
                </div>
                <div class="form-group form-check">
                    <input type="checkbox" class="form-check-input" id="exampleCheck1" name="remember_me">
                    <label class="form-check-label" for="exampleCheck1">{{__('admin.remember_me')}}</label>
                </div>
                <div class="form-group">
                    <button type="submit" class="btn btn-primary submit-btn w-100">{{__('admin.login')}}</button>
                </div>
                <div class="form-group text-center">
                    <a href="{{route('login.forgot-password')}}">{{__('admin.forget-password')}}</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection()
@section('validation')
<script>
    /*
    * function to validate the email 
    * inpt parameter to receive the email element
    * textState parameter to receive the element that will include the validation msg
    */
    function validateEmail(inpt, txtState) {
        let inptVal = inpt.val();
        // $ => match the last of string 
        let emailPattern = "^[a-zA-Z0-9_\.\-]+[@][a-zA-Z0-9\-]+[\.][a-zA-Z0-9]{2,4}$";
        if (!inptVal) {
            txtState.removeClass("d-none");
            txtState.html("{{__('admin.required_msg')}}");
            return false;
        }
        else if (inptVal.length < 5) {
            txtState.removeClass("d-none");
            txtState.html("{{__('admin.email_length')}}");
            return false;
        }
        else if (inptVal.search(emailPattern) == -1) {
            txtState.removeClass("d-none");
            txtState.html("{{__('admin.email_msg')}}");
            return false;
        }
        else {
            txtState.addClass("d-none");
        }
        return true;
    }
    /*
    * function to validate the password 
    * inpt parameter to receive the password element
    * textState parameter to receive the element that will include the validation msg
    */
    function validatePassword(inpt, txtState) {
        let inptVal = inpt.val();
        if (!inptVal) {
            txtState.removeClass("d-none");
            txtState.html("{{__('admin.required_msg')}}");
            return false;
        }
        else if (inptVal.length < 5) {
            txtState.removeClass("d-none");
            txtState.html("{{__('admin.password_length')}}");
            return false;
        }
        else {
            txtState.addClass("d-none");
        }
        return true;
    }
    $(window).ready(function () {
        "use strict";
        /* Start Admin Form Login Validation */
        $(".submit-btn").click(function (e) {
            let email_valid = true;
            let pass_valid = true;
            e.preventDefault();
            if ($(".login-form").find(".email").length != 0)
            {
                email_valid = validateEmail($(".email"), $(".email-valid"));
            }
            if ($(".login-form").find(".password").length != 0)
            {
                pass_valid = validatePassword($(".password"), $(".pass-valid"));
            }
            if (email_valid && pass_valid) {
                $(".login-form").submit();
            }
        });
        /* End Admin Form Login Validation */
    });
</script>
@endsection