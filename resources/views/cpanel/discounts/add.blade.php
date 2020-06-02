@extends('layouts.cpanel')

@section('page-title', 'Создать новую Льготу')

@section('scripts')
    <script type="text/javascript">
        (function($){
            $(document).ready(function(){
                acc.initDropDowns({main_id:'Osmd',default_value:'{{Request::old('Building')}}'});
            });
        })(jQuery);
    </script>
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
                                @if(isset($owner))
                                    <h5 style="margin-left:20px;margin-top:20px;">Льгота для: {!! $owner->getFullName() !!}</h5>
                                @endif
                                @if(!isset($owner))
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
                                    <input type="hidden" id="Owner" name="Owner" value="{!! $owner->getId() !!}" readonly class="form-control" />
                                @endif
                                <div class="form-group">
                                    <label class="col-sm-2 control-label" for="Title">Наименование</label>
                                    <div class="col-sm-10">
                                        <input type="text" name="Title" class="form-control" id="Title" value="{!! Request::old('Title') !!}" required/>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-2 control-label" for="AMount">Amount</label>
                                    <div class="col-sm-10">
                                        <input type="number" name="Amount" class="form-control" id="Amount" value="{!! Request::old('Amount') !!}" required min="0" step="0.01"/>
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