@extends('layouts.cpanel')

@section('page-title', 'Квитанции')

    @section('page-sub-title')
        @if(isset($flat))
            <ul class="h5 payment-info info-hor">
                <li>ОСМД: "{{ $flat->Building->Osmd->getTitle() }}"</li>
                <li>Дом: {{ $flat->Building->getTitle() }}</li>
                <li>Квартира: {{ $flat->getNumber() }}</li>
                <li class="back-button"><a href="/cpanel/building/{!! $flat->Building->getId()  !!}/flat/all" class="btn btn-info" title="Назад к спсику Квартир"><i class="fa fa-arrow-alt-circle-left"></i>Назад к спсику Квартир</a></li>
            </ul>
        @endif
        @stop

@section('scripts')
    @if(isset($flat))
    <script type="text/javascript">
        (function(){
            var $dlg = null;
            $(document).ready(function(){
                $dlg = $("#add-receipt-dlg").dialog({
                    autoOpen:false,
                    modal:true,
                    height: 300,
                    width: 350,
                });
                $("#add-receipt").on("click",function(){
                    if($dlg && !$dlg.dialog("isOpen")) {
                        $dlg.dialog("open");
                        console.log('closed');
                    }else
                    {
                        console.log('opened');
                    }
                });

            });
        })(jQuery);
    </script>
    @endif
    @stop
@section('content')
    <div class="row">
        <div class="col-lg-12 col-md-12">
            <div class="flat-block-info">
                <div class="content ">
                    @if(isset($flat))
                    <h5>ФИО: {!! $flat->Owner->getFullName() !!}
                        <ul class="sub-info">
                            <li><label>на</label><span>{!! date('m-d-Y',time()) !!}</span></li>
                            <li><label>Долг:</label><span>{!! $flat->getOutstanding() !!}</span></li>
                            <li><label>Переплата:</label><span>{!! $flat->getOverpaid() !!}</span></li>
                        </ul>
                    </h5>



                    @endif
                    <input type="hidden" name="_token" value="{!! csrf_token() !!}">
                    <table class="table table-striped table-hover" id="Headers">
                        <thead>
                        <tr>

                            <th>#</th>
                            <th>Период</th>
                            <th>Создана</th>
                            @if(!isset($flat))
                            <th>ОСМД</th>
                            <th>Дом</th>
                            <th>Квартира</th>
                            @endif
                            <th>Площадь</th>
                            <th>Тариф</th>
                            <th>Сумма</th>
                            <th>Льготы</th>
                            <th>Начисленно</th>
                            <th>Статус</th>
                            <th>Долг</th>
                            <th>Переплата</th>
                            <th class="action-buttons">Действия</th>
                        </tr>
                        </thead>
                        <tbody class="ui-sortable" role="alert" aria-live="polite" aria-relevant="all">
                        @foreach($receipts_list as $index=>$item)
                            <tr>

                                <td>{!! $item->getNumber() !!}</td>
                                <td>{!! "за ".$item->getDate() !!}</td>
                                <td>{!! date('d-m-Y',$item->getCreated()) !!}</td>
                                @if(!isset($flat))
                                <td>{!! $item->Flat->Building->Osmd->getTitle() !!}</td>
                                <td>{!! $item->Flat->Building->getTitle() !!}</td>
                                <td>{!! $item->Flat->getNumber() !!}</td>
                                @endif
                                <td>{!! $item->Flat->getSquare() !!}</td>
                                <td>{!! $item->Tarif->getAmount() !!}</td>
                                <td>{!! $item->getAmount() !!}</td>
                                <td>{!! $item->getDiscount() !!}</td>
                                <td>{!! $item->getTotal() !!}</td>
                                <td>

                                    <?php
                                        $state = 'dark';
                                        if($item->getStatusId()==2)
                                                $state = 'success';
                                        if($item->getStatusId()==3)
                                            $state = 'warning';

                                    ?>
                                    <span class="badge badge-{!! $state !!}" style="font-size:0.8em;">
                                        {!! $item->Status->getName() !!}
                                    </span>
                                </td>
                                <td>
                                    @if($item->getOutstanding()>0)
                                        <span class="badge badge-danger" style="font-size:0.8em;">
                                    {!! $item->getOutstanding() !!}
                                        </span>
                                        @endif

                                </td>
                                <td>
                                    @if($item->getOverPaid()>0)
                                        <span class="badge badge-primary" style="font-size:0.8em;">
                                                {!! $item->getOverPaid() !!}
                                        </span>
                                        @endif
                                </td>
                                {{--<td>
                                    @if($item->isActive())
                                        <a href="/cpanel/receipt/close/{!! $item->getId() !!}" data-toggle="tooltip" title="Click to disable"><span class="badge badge-success">Active</span></a>
                                    @else
                                        <a href="/cpanel/receipt/open/{!! $item->getId() !!}" data-toggle="tooltip" title="Click to activate"><span class="badge badge-dark">Disabled</span></a>
                                    @endif
                                </td>--}}
                                <td class="action-buttons">
                                    <a href="/cpanel/receipt/view/{!! $item->getId() !!}" class="btn btn-warning" title="Просмотр"><i class="fa fa-eye"></i></a>

                                    <a href="/cpanel/receipt/{!! $item->getId() !!}/payment/all" class="btn btn-info" title="Платежи"><i class="fa fa-dollar-sign"></i></a>

                                    <a href="/cpanel/receipt/delete/{!! $item->getId() !!}" class="btn btn-danger" title="Удалить"><i class="fa fa-trash"></i></a>
                                </td>

                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    @if(isset($flat))
<div class="add-receipt-dlg" id="add-receipt-dlg">
    <form class="form-horizontal" method="POST" action="/cpanel/flats/{!! $flat->getId() !!}/receipt/add">
        <input type="hidden" name="_token" value="{!! csrf_token() !!}" />
        <div class="row">
            <div class="col-lg-12 col-md-12">
                <div class="panel panel-admin">
                    <div class="panel-heading">
                        <h3 class="panel-title">Новая квитанция</h3>
                    </div>
                    <div class="panel-body">
                        <div class="row">
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
                            <div class="col-md-12">
                                <div class="form-group">
                                    <div class="col-md-12 text-center">
                                        <button type="submit" class="btn btn-block btn-success btn-md"><i class="fa fa-floppy-o"></i>Добавить</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
@endif
@stop