@extends('layouts.cpanel')

@section('page-title', 'Жильцы')
@section('page-sub-title')
    @if(isset($flat))
        <ul class="h5 payment-info info-hor">
            <li>ОСМД: "{{ $flat->Building->Osmd->getTitle() }}"</li>
            <li>Дом: "{{ $flat->Building->getTitle() }}"</li>
            <li>Квартира: "{{ $flat->getNumber() }}"</li>
            <li class="back-button"><a href="/cpanel/building/{!! $flat->Building->Osmd->getId()  !!}/flats/all" class="btn btn-info"><i class="fa fa-arrow-alt-circle-left"></i>Назад к спсику Домов</a></li>
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
                            <th>OSMD</th>
                            <th>Building</th>
                            <th>Flat</th>
                            <th>LastName</th>
                            <th>FirstName</th>
                            <th>Phone</th>
                            <th>Email</th>
                            <th>Льготы</th>
                            <th>Active</th>
                            <th class="action-buttons">Actions</th>
                        </tr>
                        </thead>
                        <tbody class="ui-sortable" role="alert" aria-live="polite" aria-relevant="all">
                        @foreach($owners as $index=>$item)
                            <tr>
                                <td>{!! $item->getId() !!}</td>
                                <td>{!! $item->Flat->Building->Osmd->GetTitle() !!}</td>
                                <td>{!! $item->Flat->Building->getTitle() !!}</td>
                                <td><a href="/cpanel/building/{!! $item->Flat->Building->getId() !!}/flat/edit/{!! $item->Flat->getId() !!}" data-toggle="tooltip" title="Edit Flat"><i class="fas fa-pencil"></i>{!! $item->Flat->getNumber() !!}</a></td>
                                <td>{!! $item->getLastName() !!}</td>
                                <td>{!! $item->getFirstName() !!}</td>
                                <td>{!! $item->getPhone() !!}</td>
                                <td>{!! $item->getEmail() !!}</td>
                                <td style="text-align: center">@if(count($item->Discounts)>0)
                                        <i class="fa fa-check" style="color:#008300"></i>
                                        @else
                                        <i class="fa fa-times" style="color:#999"></i>
                                    @endif
                                </td>
                                <td>
                                    @if($item->isActive())


                                        <span class="badge badge-success">Active</span>

                                    @else
                                        <a href="/cpanel/owner/open/{!! $item->getId() !!}" data-toggle="tooltip" title="Click to activate"><span class="badge badge-dark">Disabled</span></a>
                                    @endif
                                </td>
                                <td class="action-buttons">
                                    <a href="/cpanel/flats/{!! $item->Flat->getId() !!}/owner/edit/{!! $item->getId() !!}" class="btn btn-info" title="Редактировать"><i class="fa fa-pencil"></i></a>
                                    <a href="/cpanel/owner/delete/{!! $item->getId() !!}" class="btn btn-danger" title="Удалить"><i class="fa fa-trash"></i></a>
                                    <a href="/cpanel/owner/{!! $item->getId() !!}/discount/all" class="btn btn-warning" title="Льготы"><i class="fa fa-percent"></i></a>
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