@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">{!! Auth::user()->userDetail ? 'Edit User Details' : 'Complete User Details' !!}</div>
                <div class="panel-body">
                    <form class="form-horizontal" method="POST" action="/profile">
                        {{ csrf_field() }}

                        <div class="form-group{{ $errors->has('full_name') ? ' has-error' : '' }}">
                            <label for="full-name" class="col-md-4 control-label">Full Name</label>

                            <div class="col-md-6">
                                <input id="full-name" type="text" class="form-control" name="full_name" {!! Auth::user()->userDetail ? 'value="'.Auth::user()->userDetail->full_name.'"' : 'placeholder="Enter Full Name"' !!} required autofocus>

                                       @if ($errors->has('full_name'))
                                       <span class="help-block">
                                    <strong>{{ $errors->first('full_name') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('account_number') ? ' has-error' : '' }}">
                            <label for="account-number" class="col-md-4 control-label">Account Number</label>

                            <div class="col-md-6">
                                <input id="account-number" type="text" class="form-control" name="account_number" {!! Auth::user()->userDetail ? 'value="'.Auth::user()->userDetail->account_number.'"'.' readonly' : 'placeholder="Enter Account Number"' !!} required>

                                       @if ($errors->has('account_number'))
                                       <span class="help-block">
                                    <strong>{{ $errors->first('account_number') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('bank') ? ' has-error' : '' }}">
                            <label for="bank" class="col-md-4 control-label">Name of Bank</label>

                            <div class="col-md-6">
                                <input id="bank" type="text" class="form-control" name="bank" {!! Auth::user()->userDetail ? 'value="'.Auth::user()->userDetail->bank.'"'.' readonly' : 'placeholder="Enter Bank Name"' !!} required>

                                       @if ($errors->has('bank'))
                                       <span class="help-block">
                                    <strong>{{ $errors->first('bank') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('location') ? ' has-error' : '' }}">
                            <label for="location" class="col-md-4 control-label">Location</label>

                            <div class="col-md-6">
                                <input id="location" type="text" class="form-control" name="location" {!! Auth::user()->userDetail ? 'value="'.Auth::user()->userDetail->location.'"' : 'placeholder="Enter Location"' !!} required>

                                       @if ($errors->has('location'))
                                       <span class="help-block">
                                    <strong>{{ $errors->first('location') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-4">
                                <button type="submit" class="btn btn-primary">
                                    Save
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Referrals</div>
                <div class="panel-body">
                    <div class="alert alert-info text-center">
                        Your referral code is <strong>{{ Auth::user()->referral_code }}</strong> .
                    </div>

                    <!--facebook share button -JavaScript SDK-->
<!--                    <div id="fb-root"></div>
                    <script>(function (d, s, id) {
                            var js, fjs = d.getElementsByTagName(s)[0];
                            if (d.getElementById(id))
                                return;
                            js = d.createElement(s);
                            js.id = id;
                            js.src = 'https://connect.facebook.net/en_GB/sdk.js#xfbml=1&version=v2.11&appId=1739035963071828';
                            fjs.parentNode.insertBefore(js, fjs);
                        }(document, 'script', 'facebook-jssdk'));</script>

                    <div class="fb-share-button" data-href="http://localhost:8000/referral/adebay1" data-layout="button" data-size="large" data-mobile-iframe="true">
                        <a class="fb-xfbml-parse-ignore" target="_blank" href="https://www.facebook.com/sharer/sharer.php?u=http%3A%2F%2Flocalhost%3A8000%2Freferral%2Fadebay1&amp;src=sdkpreparse">Share</a>
                    </div>-->

                    <!--alternate facebook share button -iFrame-->
                    <iframe src="https://www.facebook.com/plugins/share_button.php?href=http%3A%2F%2Flocalhost%3A8000%2Freferral%2Fadebay1&layout=button&size=large&mobile_iframe=true&appId=1739035963071828&width=73&height=28" width="73" height="28" style="border:none;overflow:hidden" scrolling="no" frameborder="0" allowTransparency="true"></iframe>

                    <!--twitter share button-->
                    <a href="https://twitter.com/share?ref_src=twsrc%5Etfw" class="twitter-share-button" data-size="large" data-url="{{ url('/referral/'.Auth::user()->referral_code) }}" data-show-count="false">Tweet</a><script async src="https://platform.twitter.com/widgets.js" charset="utf-8"></script>
                    <!--<a href="https://twitter.com/share?ref_src=twsrc%5Etfw" class="twitter-share-button" data-size="large" data-url="{{ url('/referral') }}" data-show-count="false">Tweet</a><script async src="https://platform.twitter.com/widgets.js" charset="utf-8"></script>-->

<!--                    <a class="twitter-share-button"
  href="https://twitter.com/intent/tweet?url={{ url('/referral/'.Auth::user()->referral_code) }}">
Tweet</a><script async src="https://platform.twitter.com/widgets.js" charset="utf-8"></script>-->

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
