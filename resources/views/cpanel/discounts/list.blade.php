@extends('layouts.cpanel')

@section('page-title', 'Льготы')

@section('page-sub-title')
    @if(isset($owner))
        <ul class="h5 payment-info info-hor">
            <li>ОСМД: "{{ $owner->Flat->Building->getTitle() }}"</li>
            <li>Дом: "{{ $owner->Flat->Building->getTitle() }}"</li>
            <li>Квартира: "{{ $owner->Flat->getNumber() }}"</li>
            <li class="back-button"><a href="/cpanel/owner" class="btn btn-info"><i class="fa fa-arrow-alt-circle-left"></i>Назад к спсику Жильцов</a></li>
        </ul>
    @endif
@stop
@section('content')
    <div class="row">
        <div class="col-lg-12 col-md-12">
            <div class="flat-block-info">
                <div class="content ">
                    @if(isset($owner))
                        <h5>ФИО: {!! $owner->getFullName() !!}</h5>
                        @endif
                    <input type="hidden" name="_token" value="{!! csrf_token() !!}">
                    <table class="table table-striped table-hover" id="Headers">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>Created</th>
                            <th>Title</th>
                            <th>Amount</th>
                            <th>Status</th>
                            <th class="action-buttons">Actions</th>
                        </tr>
                        </thead>
                        <tbody class="ui-sortable" role="alert" aria-live="polite" aria-relevant="all">
                        @foreach($discounts_list as $index=>$item)
                            <tr>
                                <td>{!! $item->getId() !!}</td>
                                <td>{!! date("d-m-Y",$item->getCreated()) !!}</td>
                                <td>{!! $item->getTitle() !!}</td>
                                <td>{!! $item->getAmountWithSymbol() !!}</td>

                                <td>
                                    @if($item->isActive())
                                        <a href="/cpanel/flats/close/{!! $item->getId() !!}" data-toggle="tooltip" title="Click to disable"><span class="badge badge-success">Active</span></a>
                                    @else
                                        <a href="/cpanel/flats/open/{!! $item->getId() !!}" data-toggle="tooltip" title="Click to activate"><span class="badge badge-dark">Disabled</span></a>
                                    @endif
                                </td>
                                <td class="action-buttons">
                                    <a href="/cpanel/owner/{!! $item->Owner->getId() !!}/discount/edit/{!! $item->getId() !!}" class="btn btn-info" title="Edit"><i class="fas fa-pencil-square-o"></i><span>Edit</span></a>
                                    <a href="/cpanel/discount/delete/{!! $item->getId() !!}" class="btn btn-danger" title="Delete"><i class="fas fa-trash-o"></i><span>Delete</span></a>


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