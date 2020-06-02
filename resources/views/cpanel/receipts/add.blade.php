@extends('layouts.cpanel')

@section('page-title', 'Новая квитанция')

@section('scripts')
    <script type="text/javascript">
        (function($){
            $(document).ready(function(){
                acc.initDropDowns({main_id:'Osmd'{{Request::old('Building')?",default_value:".Request::old('Building'):""}}}); //add options instead of variables
                acc.initDropDowns({main_id:'Building'{{Request::old('Flat')?",default_value:".Request::old("Flat"):""}},function_name:'getFlatsList'});//add options instead of variables
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
                                @endif

                            </div>
                            <div class="col-md-12">
                                <div class="form-group">


                                    <label class="col-sm-2 control-label" for="Month">Месяц</label>
                                    <div class="col-sm-10 input-field">

                                        <select class="form-control" id="Month" name="Month" required>
                                            <option value="" class="disabled">Выбрать</option>
                                            <?php for($i=1;$i<=12;$i++){ ?>
                                            <option value="{!! $i !!}" class="disabled">{!! date('F',mktime(0,0,0,$i,1,1)) !!}</option>
                                            <?php } ?>
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