@extends('layouts.master')

@section('content')
    <div class="container-fluid">
        <div class="container">
            <div class="row">
                <div class="col-sm-6 col-md-4 offset-md-4">
                    <div class="container-form-login">
                        @include('partials.notifications')
                        <form class="form-login" method="POST" action="/login">
                            <input type="hidden" name="_token" value="{!! csrf_token() !!}">
                            <div class="form-group">
                                <input type="text" class="form-control" placeholder="Email or Username" name="email" autofocus>
                            </div>
                            <div class="form-group">
                                <input type="password" class="form-control" placeholder="Password" name="password">
                            </div>
                            <div class="checkbox">
                                <label>
                                    <input type="checkbox" value="remember-me"/>Remember me
                                </label>
                            </div>
                            <div class="form-group">
                                <button class="btn btn-lg btn-warning btn-block" type="submit">Sign in</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop