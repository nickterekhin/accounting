@extends('layouts.cpanel')

@section('page-title', 'Owner - Edit')
@section('page-sub-title')
    @if(isset($owner))
        <ul class="h5 payment-info info-hor">
            <li>ОСМД: "{{ $owner->Flat->Building->getTitle() }}"</li>
            <li>Дом: "{{ $owner->Flat->Building->getTitle() }}"</li>
            <li>Квартира: "{{ $owner->Flat->getNumber() }}"</li>
            <li class="back-button"><a href="/cpanel/owner" class="btn btn-info"><i class="fa fa-arrow-alt-circle-left"></i>Назад к спсику Жильцов</a></li>
        </ul>
    @endif
@stop

@section('content')
    <form class="form-horizontal" method="POST" action="">
        <input type="hidden" name="_token" value="{!! csrf_token() !!}" />
        <div class="row">
            <div class="col-lg-9 col-md-8">
                <div class="panel panel-admin">
                    <div class="panel-heading">
                        <h3 class="panel-title">Main Settings</h3>
                    </div>
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-md-12">
                                <!--Insert Main Form content -->

                                    <input type="hidden" id="Flat" name="Flat" value="{!! $owner->Flat->getId() !!}" readonly class="form-control" />

                                <div class="form-group">
                                    <label class="col-sm-2 control-label" for="FirstName">First Name</label>
                                    <div class="col-sm-10">
                                        <input type="text" name="FirstName" class="form-control" id="FirstName" value="{!! $owner->getFirstName() !!}" required/>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-2 control-label" for="LastName">Last Name</label>
                                    <div class="col-sm-10">
                                        <input type="text" name="LastName" class="form-control" id="LastName" value="{!! $owner->getLastName() !!}" required/>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-2 control-label" for="MiddleName">Middle Name</label>
                                    <div class="col-sm-10">
                                        <input type="text" name="MiddleName" class="form-control" id="MiddleName" value="{!! $owner->getMiddleName() !!}"/>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-sm-2 control-label" for="Email">Email</label>
                                    <div class="col-sm-10">
                                        <input type="email" name="Email" class="form-control" id="Email" value="{!! $owner->getEmail() !!}"/>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-2 control-label" for="Square">Phone</label>
                                    <div class="col-sm-10">
                                        <input type="text" name="Phone" class="form-control" id="Phone" value="{!! $owner->getPhone() !!}"/>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-3 col-md-4">
                <div class="panel panel-admin">
                    <div class="panel-heading">
                        <h3 class="panel-title">Update</h3>
                    </div>
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <div class="col-md-12 text-center">
                                        <button type="submit" class="btn btn-block btn-success btn-md"><i class="fa fa-floppy-o"></i>Update</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

        </div>
    </form>
@stop