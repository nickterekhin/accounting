@extends('layouts.cpanel')

@section('page-title', 'Добавть новый дом')

@section('content')
    <form class="form-horizontal" method="POST" action="">
        <input type="hidden" name="_token" value="{!! csrf_token() !!}" />
        <div class="row">
            <div class="col-lg-9 col-md-8">
                <div class="panel panel-admin">
                    <div class="panel-heading">
                        <h3 class="panel-title">Модель</h3>
                    </div>
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-md-12">
                                <!--Insert Main Form content -->
                                <div class="form-group">
                                    <label class="col-sm-2 control-label" for="OSMD">ОСМД</label>
                                    <div class="col-sm-10 input-field">
                                        @if(isset($osmd_list))
                                        <select class="form-control" id="OSMD" name="OSMD" required>
                                            <option value="" class="disabled">Choose OSMD</option>
                                            @foreach($osmd_list as $items)
                                                <option value="{!! $items->getId() !!}" @if(Request::old( 'OSMD')==$items->getId())selected="selected"@endif>{!! $items->getTitle() !!}</option>
                                            @endforeach
                                        </select>
                                            @endif
                                        @if(isset($osmd))
                                        <input type="text" value="{!! $osmd->getTitle() !!}" readonly class="form-control">
                                            <input type="hidden" value="{!! $osmd->getId() !!}" name="OSMD" id="OSMD">
                                            @endif
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-2 control-label" for="Title">Title</label>
                                    <div class="col-sm-10">
                                        <input type="text" name="Title" class="form-control" id="Title" value="{!! Request::old('Title') !!}" required/>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-2 control-label" for="Levels">Levels</label>
                                    <div class="col-sm-10">
                                        <input type="number" name="Levels" class="form-control" id="Levels" value="{!! Request::old('Levels')?Request::old('Levels'):1 !!}" required min="1"/>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-sm-2 control-label" for="City">City</label>
                                    <div class="col-sm-10">
                                        <input type="text" name="City" class="form-control" id="City" value="{!! Request::old('City') !!}" required/>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-2 control-label" for="Street1">Street1</label>
                                    <div class="col-sm-10">
                                        <input type="text" name="Street1" class="form-control" id="Street1" value="{!! Request::old('Street1') !!}" required/>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-2 control-label" for="Street2">Street2</label>
                                    <div class="col-sm-10">
                                        <input type="text" name="Street2" class="form-control" id="Street2" value="{!! Request::old('Street2') !!}"/>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-2 control-label" for="ZipCode">Zip</label>
                                    <div class="col-sm-10">
                                        <input type="text" name="ZipCode" class="form-control" id="ZipCode" value="{!! Request::old('ZipCode') !!}" required/>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-sm-offset-2 col-sm-10 text-left">
                                        <div class="checkbox">
                                            <label>
                                                <input type="checkbox" name="Active" value="1" @if(Request::old('Active')==1)checked="checked"@endif> Active
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