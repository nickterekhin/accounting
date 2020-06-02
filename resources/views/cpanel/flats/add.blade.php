@extends('layouts.cpanel')

@section('page-title', 'Flat - Add new')
@section('page-sub-title')
    @if(isset($building))
        <ul class="h5 payment-info info-hor">
            <li>ОСМД: "{{ $building->Osmd->getTitle() }}"</li>
            <li>Дом: "{{ $building->getTitle() }}"</li>
            <li class="back-button"><a href="/cpanel/osmd/{!! $building->Osmd->getId()  !!}/building/all" class="btn btn-info"><i class="fa fa-arrow-alt-circle-left"></i>Назад к спсику Домов</a></li>
        </ul>
    @endif
@stop
@section('scripts')
    @if(!isset($building))
    <script type="text/javascript">
        (function($){
            $(document).ready(function(){
                acc.initDropDowns({main_id:'Osmd',default_value:'{{Request::old('Building')}}'});
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
                                @if(isset($building))
                                    <h5 style="margin-left:20px;margin-top:20px;">Квартира в доме: {!! $building->getTitle() !!}</h5>
                                @endif
                                @if(!isset($building))
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

                                        <select class="form-control" id="Building" name="Building" required disabled>
                                            <option value="" class="disabled">Choose Building</option>
                                        </select>

                                    </div>

                                </div>
                                @else
                                    <input type="hidden" id="Building" name="Building" value="{!! $building->getId() !!}" readonly class="form-control" />
                                @endif
                                <div class="form-group">
                                    <label class="col-sm-2 control-label" for="Number">Number</label>
                                    <div class="col-sm-10">
                                        <input type="text" name="Number" class="form-control" id="Number" value="{!! Request::old('Number') !!}" required/>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-2 control-label" for="Section">Section</label>
                                    <div class="col-sm-10">
                                        <input type="number" name="Section" class="form-control" id="Section" value="{!! Request::old('Section') !!}" required min="1"/>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-sm-2 control-label" for="Level">Level</label>
                                    <div class="col-sm-10">
                                        <input type="number" name="Level" class="form-control" id="Level" value="{!! Request::old('Level') !!}" required/>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-2 control-label" for="Square">Square (m2)</label>
                                    <div class="col-sm-10">
                                        <input type="number" name="Square" class="form-control" id="Square" value="{!! Request::old('Square') !!}" required min="0" step="0.1"/>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-2 control-label" for="People">Жильцов</label>
                                    <div class="col-sm-10">
                                        <input type="number" name="People" class="form-control" id="People" value="{!! Request::old('People')?Request::old('People'):1 !!}" required min="0" step="1" />
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-2 control-label" for="PublicAccount">Лицевой счет</label>
                                    <div class="col-sm-10">
                                        <input type="text" name="PublicAccount" class="form-control" id="PublicAccount" value="{!! Request::old('PublicAccount') !!}" required />
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