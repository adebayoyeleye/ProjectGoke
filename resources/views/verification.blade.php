@extends('layouts.app')
@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Registration</div>
                <div class="panel-body">
                    You have successfully registered. An email is sent to you for verification.
                    <br/>
                    <p>Didn't get the email? <a href={{url('/resendverifyemail/'.$id)}}>Resend email.</a></p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection