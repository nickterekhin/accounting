@extends('layouts.cpanel')

@section('page-title', 'Banks - Add new')

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
                                <div class="form-group">
                                    <label class="col-sm-2 control-label" for="BankTitle">Bank Title</label>
                                    <div class="col-sm-10">
                                        <input type="text" name="BankTitle" class="form-control" id="BankTitle" value="{!! $bank->getTitle() !!}" required/>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-sm-2 control-label" for="mfo">MFO</label>
                                    <div class="col-sm-10">
                                        <input type="text" name="mfo" class="form-control" id="mfo" value="{!! $bank->getMfo() !!}" required/>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-2 control-label" for="City">City</label>
                                    <div class="col-sm-10">
                                        <input type="text" name="City" class="form-control" id="City" value="{!! $bank->getCity() !!}" required/>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-2 control-label" for="Street1">Street1</label>
                                    <div class="col-sm-10">
                                        <input type="text" name="Street1" class="form-control" id="Street1" value="{!! $bank->getStreet1() !!}" required/>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-2 control-label" for="Street2">Street2</label>
                                    <div class="col-sm-10">
                                        <input type="text" name="Street2" class="form-control" id="Street2" value="{!! $bank->getStreet2() !!}"/>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-2 control-label" for="ZipCode">Zip</label>
                                    <div class="col-sm-10">
                                        <input type="text" name="ZipCode" class="form-control" id="ZipCode" value="{!! $bank->getZip() !!}" required/>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-sm-offset-2 col-sm-10 text-left">
                                        <div class="checkbox">
                                            <label>
                                                <input type="checkbox" name="Active" value="1" @if($bank->isActive())checked="checked"@endif> Active
                                            </label>
                                        </div>
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