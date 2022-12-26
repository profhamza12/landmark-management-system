@extends('admin.layouts.loginlayout')
@section('content')
<div class="container">
    <div class="row">
        <div class="col-12 col-md-6 col-lg-4 mr-auto ml-auto">
            <form class="bg-light forget-pass-form" method="post" action="{{route('password.email')}}" ectype="">
                @csrf
                @if(Session::has('success_msg'))
                <div class="alert alert-success text-center">{{Session::get('success_msg')}}</div>
                @endif
                @if(Session::has('err_msg'))
                <div class="alert alert-success text-center">{{Session::get('err_msg')}}</div>
                @enderror
                <div class="form-group">
                    <label for="exampleInputEmail1">Email</label>
                    <input type="text" class="form-control email @error('email') is-invalid @enderror" name="email" placeholder="Enter email">
                    <small class="form-text text-danger email-valid d-none @error('email') d-block @enderror">
                        @error('email')
                            {{$message}}
                        @enderror
                    </small>
                </div>
                <div class="form-group">
                    <button type="submit" class="btn btn-primary submit-btn w-100">{{__('admin.reset_pass')}}</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
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

    $(window).ready(function () {
        "use strict";
        /* Start Admin Form Login Validation */
        $(".submit-btn").click(function (e) {
            e.preventDefault();
            let email_valid = true;
            if ($(".forget-pass-form").find(".email").length != 0)
            {
                email_valid = validateEmail($(".email"), $(".email-valid"));
            }
            if (email_valid) {
                $(".forget-pass-form").submit();
            }
        });
        /* End Admin Form Login Validation */
    });
</script>
@endsection