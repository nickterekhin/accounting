@extends('layouts.cpanel')

@section('page-title', 'Flat - Add new')
@section('page-sub-title')
@if(isset($flat))
    <ul class="h5 payment-info info-hor">
        <li>ОСМД: "{{ $flat->Building->Osmd->getTitle() }}"</li>
        <li>Дом: "{{ $flat->Building->getTitle() }}"</li>
        <li class="back-button"><a href="/cpanel/flats/{!! $flat->getId()  !!}/owner/all" class="btn btn-info"><i class="fa fa-arrow-alt-circle-left"></i>Назад к спсику Жильцов</a></li>
    </ul>
@endif
@stop
@section('scripts')
    @if(!isset($flat))
    <script type="text/javascript">
        (function($){
            $(document).ready(function(){
                acc.initDropDowns({main_id:'Osmd'{{Request::old('Building')?",default_value:".Request::old('Building'):""}}}); //add options instead of variables
                acc.initDropDowns({main_id:'Building'{{Request::old('Flat')?",default_value:".Request::old("Flat"):""}},function_name:'getFlatsList'});//add options instead of variables
            });
        })(jQuery);
    </script>
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
                                @if(isset($flat))
                                    <h5 style="margin-left:20px;margin-top:20px;">Owner for the Flat : {!! $flat->getNumber() !!}</h5>
                                @endif
                                @if(!isset($flat))
                                    <div class="form-group">

                                        <label class="col-sm-2 control-label" for="Osmd">OSMD</label>
                                        <div class="col-sm-10 input-field">

                                            <select class="form-control" id="Osmd" name="Osmd" required data-child="Building">
                                                <option value="" class="disabled">Choose Osmd</option>
                                                @foreach($osmds as $items)
                                                    <option value="{!! $items->getId() !!}" @if(Request::old( 'Osmd')==$items->getId())selected="selected"@endif >{!! $items->getTitle() !!}</option>
                                                @endforeach
                                            </select>
                                                <span class="loading" id="loading-indicator-Osmd"><i class="fas fa-spinner fa-spin"></i></span>
                                        </div>

                                    </div>
                                <div class="form-group">


                                    <label class="col-sm-2 control-label" for="Building">Building</label>
                                    <div class="col-sm-10 input-field">

                                        <select class="form-control" id="Building" name="Building" required disabled data-child="Flat">
                                            <option value="" class="disabled">Choose Building</option>
                                        </select>

                                    </div>

                                </div>
                                    <div class="form-group">


                                        <label class="col-sm-2 control-label" for="Flat">Flat</label>
                                        <div class="col-sm-10 input-field">

                                            <select class="form-control" id="Flat" name="Flat" required disabled>
                                                <option value="" class="disabled">Choose Flat</option>
                                            </select>

                                        </div>

                                    </div>
                                @else
                                    <input type="hidden" id="Flat" name="Flat" value="{!! $flat->getId() !!}" readonly class="form-control" />
                                @endif
                                <div class="form-group">
                                    <label class="col-sm-2 control-label" for="FirstName">First Name</label>
                                    <div class="col-sm-10">
                                        <input type="text" name="FirstName" class="form-control" id="FirstName" value="{!! Request::old('FirstName') !!}" required/>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-2 control-label" for="LastName">Last Name</label>
                                    <div class="col-sm-10">
                                        <input type="text" name="LastName" class="form-control" id="LastName" value="{!! Request::old('LastName') !!}" required/>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-2 control-label" for="MiddleName">Middle Name</label>
                                    <div class="col-sm-10">
                                        <input type="text" name="MiddleName" class="form-control" id="MiddleName" value="{!! Request::old('MiddleName') !!}"/>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-sm-2 control-label" for="Email">Email</label>
                                    <div class="col-sm-10">
                                        <input type="email" name="Email" class="form-control" id="Email" value="{!! Request::old('Email') !!}"/>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-2 control-label" for="Square">Phone</label>
                                    <div class="col-sm-10">
                                        <input type="text" name="Phone" class="form-control" id="Phone" value="{!! Request::old('Phone') !!}"/>
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