@extends('layouts.cpanel')

@section('page-title', 'Tarif - Add new')

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
                                    <label class="col-sm-2 control-label" for="Title">Title</label>
                                    <div class="col-sm-10">
                                        <input type="text" name="Title" class="form-control" id="Title" value="{!! Request::old('Title') !!}" required/>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-2 control-label" for="Amount">Amount</label>
                                    <div class="col-sm-10">
                                        <input type="number" name="Amount" class="form-control" id="Amount" value="{!! Request::old('Amount') !!}" required min="1" step="0.01" />
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-sm-2 control-label" for="Type">Type</label>
                                    <div class="col-sm-10">
                                        <select id="Type" class="form-control" name="Type">
                                            <option value="0">грн</option>
                                            <option value="1">%</option>
                                        </select>
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
                        <h3 class="panel-title">Publish</h3>
                    </div>
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <div class="col-md-12 text-center">
                                        <button type="submit" class="btn btn-block btn-success btn-md"><i class="fa fa-floppy-o"></i>Add New</button>
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