@extends('layouts.cpanel')

@section('page-title', 'Просмотр - Квитанции')
@section('page-sub-title')

        <ul class="h5 payment-info info-hor">
            <li>ОСМД: "{{ $building->Osmd->getTitle() }}"</li>
            <li>Дом: {{ $building->getTitle() }}</li>
            <li>Квартира: {{ $receipt->Flat->getNumber() }}</li>
            <li class="back-button"><a href="/cpanel/flats/{!! $receipt->Flat->getId()  !!}/receipt/all" class="btn btn-info" title="Назад к спсику Квитанций"><i class="fa fa-arrow-alt-circle-left"></i>Назад к спсику Квитанций</a></li>
        </ul>

@stop
@section('scripts')
    <script type="text/javascript">
        (function($){
            $(document).ready(function(){
                var $print_btn =$("#print_btn");
                if ($print_btn.length > 0) {
                    $print_btn.on('click',function () {
                        window.print();
                    });
                }
            });
        })(jQuery);
    </script>
    @stop
@section('content')
<div class="row">
    <div class="col-lg-12 col-md-12">
        <div class="flat-block-info">
            <div class="content ">
                <div class="row">
                    <div class="col-md-12">
                        <div class="btn-group float-right">
                            <a href="javascript:void(0);" id="print_btn" class="btn btn-success float-right add-btn"><i class="fa fa-plus"></i>Print</a>
                        </div>
                    </div>
                </div>
                <br/>
                <table class="receipt-view">
                    <tr>
                        <td class="receipt-view-cell left-side">
                            <ul class="receipt-view-data">
                                 <li>ОСМД "{!! $building->Osmd->getTitle() !!}"</li>
                                <li>ОКПО "{!! $building->Osmd->getOkpo() !!}"</li>
                                <li>МФО "{!! $building->Osmd->Bank->getMfo() !!}"</li>
                                <li>р/с "{!! $building->Osmd->getAccount() !!}"</li>
                                <li>{!! $building->Osmd->Bank->getTitle() !!}</li>
                            </ul>
                            <ul class="receipt-view-data">
                                <li><h5>Квитанция <br/> <small>за {!! $receipt->getDate() !!}</small></h5></li>
                                <li><strong>{!! $receipt->Flat->Owner->getFullName() !!}</strong></li>
                                <li>Лицевой счет: {!! $receipt->Flat->getPublicAccount() !!}</li>
                                <li>{!! $building->getCity(). ', '.$building->getStreet1().', кв.'.$receipt->Flat->getNumber() !!}</li>

                            </ul>
                            <ul class="receipt-view-data">
                                <li>Начсилено: {!! $receipt->getAmount() !!}</li>
                                <li>Льгота: {!! $receipt->getDiscount() !!}</li>
                                <li>Долг: {!! $receipt->getOutstanding() !!}</li>
                                <li>Переплата: {!! $receipt->getOverpaid() !!}</li>
                                <li>К оплате: {!! $receipt->getFullTotal() !!}</li>
                            </ul>
                        </td>
                        <td class="receipt-view-cell right-side">
                            <ul class="receipt-view-data">
                                <li>ОСМД "{!! $building->Osmd->getTitle() !!}"</li>
                                <li>ОКПО "{!! $building->Osmd->getOkpo() !!}"</li>
                                <li>МФО "{!! $building->Osmd->Bank->getMfo() !!}"</li>
                                <li>р/с "{!! $building->Osmd->getAccount() !!}"</li>
                                <li>{!! $building->Osmd->Bank->getTitle() !!}</li>
                            </ul>
                            <ul class="receipt-view-data">
                                <li><h5>Квитанция за {!! $receipt->getDate() !!}</h5></li>
                                <li><strong>{!! $receipt->Flat->Owner->getFullName() !!}</strong></li>
                                <li>Лицевой счет: {!! $receipt->Flat->getPublicAccount() !!}</li>
                                <li>{!! $building->getCity(). ', '.$building->getStreet1().', кв.'.$receipt->Flat->getNumber() !!}</li>

                            </ul>
                            <table class="receipt-sub-data">
                                <thead>
                                    <tr>
                                        <th>Площадь</th>
                                        <th>Тариф</th>
                                        <th>Начислено</th>
                                        <th>Льгота</th>
                                        <th>Итого</th>
                                    </tr>
                                </thead>
                                <tbody>
                                <tr>
                                    <td>{!! $receipt->Flat->getSquare() !!}</td>
                                    <td>{!!  $receipt->Tarif->getAmount()!!}</td>
                                    <td>{!! $receipt->getAmount() !!}</td>
                                    <td>{!! $receipt->getDiscount() !!}</td>
                                    <td>{!! $receipt->getTotal() !!}</td>
                                </tr>
                                @foreach($receipt->getOutstandingList() as $index=>$res)
                                <tr>
                                    <td></td>
                                    <td colspan="1" style="text-align:right">@if($index==0)Долг@endif</td>
                                    <td colspan="2">за {!! date("F Y",mktime(0,0,0,$res->Month,1,$res->Year)) !!}</td>
                                    <td>{!! $res->Outstanding !!}</td>
                                </tr>
                                    @endforeach
                                <tr>
                                    <td colspan="1"></td>
                                    <td colspan="3" style="border-top:1px solid #d9d9d9"></td>
                                    <td style="border-top:1px solid #d9d9d9;font-weight: 600;">{!! $receipt->getFullTotal() !!}</td>
                                </tr>
                                </tbody>
                            </table>
                        </td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
</div>
    @stop
