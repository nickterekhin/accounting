    <div class="row">
        <div class="col-sm-12" id="notification-message">
            @if (count($errors) > 0)
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{!! $error !!}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            @if(null !== Session::get('form-message') && null!==Session::get('form-message-type'))
                <div class="alert {!!  Session::get('form-message-type')!!}">
                    <p>{!! Session::get('form-message') !!}</p>
                </div>
            @endif
        </div>
    </div>
