@extends('layouts.cpanel')

@section('page-title', 'Квартиры')

@section('page-sub-title')
    @if(isset($building))
        <ul class="h5 payment-info info-hor">
            <li>ОСМД: "{{ $building->Osmd->getTitle() }}"</li>
            <li>Дом: "{{ $building->getTitle() }}"</li>
            <li class="back-button"><a href="/cpanel/osmd/{!! $building->Osmd->getId()  !!}/building/all" class="btn btn-info"><i class="fa fa-arrow-alt-circle-left"></i>Назад к спсику Домов</a></li>
        </ul>
    @endif
@stop
@section('content')
    <div class="row">
        <div class="col-lg-12 col-md-12">
            <div class="flat-block-info">
                <div class="content ">
                    <input type="hidden" name="_token" value="{!! csrf_token() !!}">
                    <table class="table table-striped table-hover" id="Headers">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>ОСМД</th>
                            <th>Дом</th>
                            <th>Квартира</th>
                            <th>Лиц. счет</th>
                            <th>Подъзд</th>
                            <th>Этаж</th>
                            <th>Жильцы</th>
                            <th>Площадь</th>
                            <th>Владелец</th>
                            <th>Фин. Статус</th>

                            <th class="action-buttons">Actions</th>
                        </tr>
                        </thead>
                        <tbody class="ui-sortable" role="alert" aria-live="polite" aria-relevant="all">
                        @foreach($flats_list as $index=>$item)
                            <tr>
                                <td>{!! $item->getId() !!}</td>
                                <td>{!! $item->Building->Osmd->getTitle() !!}</td>
                                <td>{!! $item->Building->getTitle() !!}</td>
                                <td>{!! $item->getNumber() !!}</td>
                                <td>{!! $item->getPublicAccount() !!}</td>
                                <td>

                                        {!! $item->getSection() !!}


                                </td>
                                <td>
                                    {!! $item->getLevel() !!}

                                </td>
                                <td>{!! $item->getPeople() !!}</td>
                                <td>{!! $item->getSquare() !!}</td>

                                <td>

                                    @if($item->Owner)
                                        <a href="/cpanel/owner/edit/{!! $item->Owner->getId() !!}" title="Edit"><i class="fas fa-pencil"></i><span>{!! $item->Owner->getLastName() !!}</span></a>
                                    @else
                                        <a href="/cpanel/owner/create?flatId={!! $item->getId() !!}" class="badge badge-info" title="Add Owner"><i class="fa fa-plus"></i><span>Add</span></a>
                                    @endif
                                </td>
                                <td>
                                    {!! $item->getFinState() !!}
                                </td>

                                <td class="action-buttons">
                                    <a href="/cpanel/building/{!! $item->Building->getId() !!}/flat/edit/{!! $item->getId() !!}" class="btn btn-info" title="Редактировать"><i class="fa fa-pencil"></i></a>

                                    @if($item->Owner)
                                    <a href="/cpanel/flats/{!! $item->getId() !!}/receipt/all" class="btn btn-warning" title="Квитанции"><i class="fa fa-file-invoice-dollar"></i></a>
                                        @endif
                                    <a href="/cpanel/flats/{!! $item->getId() !!}/owner/all" class="btn btn-warning" title="Жильцы"><i class="fa fa-users"></i></a>
                                    <a href="/cpanel/flats/delete/{!! $item->getId() !!}" class="btn btn-danger" title="Удалить"><i class="fa fa-trash"></i></a>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@stop