@extends('layouts.cpanel')

@section('page-title', 'Платежи по квитанции за '.$receipt->getDate())
@section('page-sub-title')

        <ul class="h5 payment-info info-hor">
            <li>Квитанция N: {!! $receipt->getNumber() !!}</li>
            <li>ОСМД "{!! $receipt->Flat->Building->Osmd->getTitle() !!}"</li>
            <li>Дом: {!! $receipt->Flat->Building->getTitle() !!}</li>
            <li>Квартира: {!! $receipt->Flat->getNumber() !!}</li>
            <li class="back-button"><a href="/cpanel/flats/{!! $receipt->Flat->getId()  !!}/receipt/all" class="btn btn-info" title="Назад к спсику Квитанций"><i class="fa fa-arrow-alt-circle-left"></i>Назад к спсику Квитанций</a></li>
        </ul>

@stop
@section('scripts')
    <script type="text/javascript">
        (function(){
            var $dlg = null;
            $(document).ready(function(){
                $("#payments").Payments();
               /* $dlg = $("#add-payment-dlg").dialog({
                    autoOpen:false,
                    modal:true,
                    height: 300,
                    width: 350,
                });
                $("#add-payment").on("click",function(){
                    if($dlg && !$dlg.dialog("isOpen")) {
                        $dlg.dialog("open");
                        console.log('closed');
                    }else
                    {
                        console.log('opened');
                    }
                });
*/
            });
        })(jQuery);
    </script>
@stop
@section('content')
    <div class="row">
        <div class="{!! ($receipt->getStatusId()==2)?'col-lg-12 col-md-12':'col-lg-8 col-md-8'!!}">
            <div class="row">
                <div class="col-lg-12 col-md-12">
                    <div class="flat-block-info">
                        <div class="content ">
                            <input type="hidden" name="_token" value="{!! csrf_token() !!}">
                            <h5>
                                @if($receipt->getStatusId()==2)
                                    <img class="embed-responsive" style="width:150px;margin:-30px auto 0;" src="/images/oplacheno.png">
                                    @else
                                <ul class="sub-info">
                                    <li><label>Сумма по квитанции:</label><span>{!! $receipt->getAmount() !!}</span></li>
                                    <li><label>Льгота:</label><span>{!! $receipt->getDiscount() !!}</span></li>
                                    <li><label>Долг:</label><span>{!! $receipt->getOutstanding() !!}</span></li>
                                    <li><label>Переплата:</label><span>{!! $receipt->getOverpaid() !!}</span></li>
                                    <li><label>Начислено:</label><span>{!! $receipt->getFullTotal() !!}</span></li>
                                </ul>
                                  @endif
                            </h5>
                            <table class="table table-striped table-hover" id="Headers">
                                <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Создан</th>
                                    <th>Статус</th>
                                    <th>Сумма</th>
                                    <th class="action-buttons">Действия</th>
                                </tr>
                                </thead>
                                <tbody class="ui-sortable" role="alert" aria-live="polite" aria-relevant="all">
                                @foreach($payments as $index=>$item)
                                    <tr>
                                        <td>{!! $item->getId() !!}</td>
                                        <td>{!! date('d-n-Y',$item->getCreated()) !!}</td>
                                        <td>{!! $item->PaymentStatus->getName() !!} <br/>
                                            @if($item->getLevel()!=0)
                                                 за {!!  date("F Y",mktime(0,0,0,$item->Receipt->getMonth(),1,$item->Receipt->getYear())) !!}
                                            @endif
                                        </td>
                                        <td>{!! $item->getAmount() !!}</td>

                                        <td class="action-buttons">
                                        @if($item->getLevel()==0)
                                            <a href="/cpanel/payment/delete/{!! $item->getId() !!}" class="btn btn-danger" title="Payments"><i class="fa fa-trash"></i></a>
                                        @endif
                                        </td>

                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @if($receipt->getStatusId()!=2)
        <div class="col-lg-4 col-md-4">

           {{-- <div class="add-payment-dlg" id="add-payment-dlg">--}}
                <form class="form-horizontal" method="POST" action="/cpanel/receipt/{!! $receipt->getId() !!}/payment/add">
                    <input type="hidden" name="_token" value="{!! csrf_token() !!}" />
                    <div class="row">
                        <div class="col-lg-12 col-md-12">
                            <div class="panel panel-admin" id="payments">
                                <div class="panel-heading">
                                    <h3 class="panel-title">Новый платеж
                                        <a href="javascript:void(0)" class="btn btn-info float-right" id="refresh-payment-form"><i class="fa fa-sync" style="margin:0"></i></a>
                                    </h3>
                                </div>
                                <div class="panel-body">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group" id="outstanding">
                                                @foreach($list_of_outstanding as $i=>$o)
                                                    <div class="col-sm-offset-2 col-sm-10 text-left">
                                                        <div class="checkbox">
                                                            <label>
                                                                <input type="checkbox" name="outstanding[{!! $o->Id !!}]" value="{!! $o->Outstanding !!}" data-amount="{!! $o->Outstanding !!}"> {!! date("F Y",mktime(0,0,0,$o->Month,1,$o->Year)) ."-". $o->Outstanding !!}
                                                            </label>
                                                        </div>
                                                    </div>
                                                @endforeach
                                            </div>
                                            <div class="form-group">
                                                <label class="col-sm-2 control-label" for="Amount">Сумма</label>
                                                <div class="col-sm-10 input-field">
                                                    <input type="number" value="{!! $receipt->getTotal() !!}" step="0.01" min="0.00" name="Amount"  id="Amount" class="form-control" data-receipt-value="{!! $receipt->getTotal() !!}">
                                                    <span id="payment-notify"></span>
                                                </div>
                                            </div>
                                           <div class="form-group">
                                                <label class="col-sm-2 control-label" for="Amount">Итого</label>
                                                <div class="col-sm-10 input-field">
                                                    <input type="number" value="{!! $receipt->getTotal() !!}" step="0.01" min="0.00" name="Total"  id="Total" class="form-control" readonly>
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


           {{-- </div>--}}
        </div>
        @endif
    </div>



@stop