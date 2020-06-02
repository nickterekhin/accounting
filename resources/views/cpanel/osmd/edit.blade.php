@extends('layouts.cpanel')

@section('page-title', 'Osmd - Add new')

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
                                    <label class="col-sm-2 control-label" for="Bank">Bank</label>
                                    <div class="col-sm-10 input-field">
                                        <select class="form-control" id="Bank" name="Bank" required>
                                            <option value="" class="disabled">Choose Bank</option>
                                            @foreach($banks as $items)
                                                <option value="{!! $items->getId() !!}" @if($osmd->getBankId()==$items->getId())selected="selected"@endif>{!! $items->getTitle() !!}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-2 control-label" for="Title">Title</label>
                                    <div class="col-sm-10">
                                        <input type="text" name="Title" class="form-control" id="Title" value="{!! $osmd->getTitle() !!}" required/>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-sm-2 control-label" for="okpo">OKPO</label>
                                    <div class="col-sm-10">
                                        <input type="text" name="okpo" class="form-control" id="okpo" value="{!! $osmd->getOkpo() !!}" required/>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-2 control-label" for="Account">Рсчетный счет</label>
                                    <div class="col-sm-10">
                                        <input type="text" name="Account" class="form-control" id="Account" value="{!! $osmd->getAccount() !!}" required/>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-2 control-label" for="City">City</label>
                                    <div class="col-sm-10">
                                        <input type="text" name="City" class="form-control" id="City" value="{!! $osmd->getCity() !!}" required/>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-2 control-label" for="Street1">Street1</label>
                                    <div class="col-sm-10">
                                        <input type="text" name="Street1" class="form-control" id="Street1" value="{!! $osmd->getStreet1() !!}" required/>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-2 control-label" for="Street2">Street2</label>
                                    <div class="col-sm-10">
                                        <input type="text" name="Street2" class="form-control" id="Street2" value="{!! $osmd->getStreet2() !!}"/>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-2 control-label" for="ZipCode">Zip</label>
                                    <div class="col-sm-10">
                                        <input type="text" name="ZipCode" class="form-control" id="ZipCode" value="{!! $osmd->getZip() !!}" required/>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-sm-offset-2 col-sm-10 text-left">
                                        <div class="checkbox">
                                            <label>
                                                <input type="checkbox" name="Active" value="1" @if($osmd->isActive())checked="checked"@endif> Active
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