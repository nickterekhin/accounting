@extends('layouts.cpanel')

@section('page-title', ' Список домов')
@section('page-sub-title')
    @if(isset($osmd))
        <ul class="h5 payment-info info-hor">
            <li>ОСМД: "{{ $osmd->getTitle() }}"</li>
             <li><a href="/cpanel/osmd" class="btn btn-info"><i class="fa fa-arrow-alt-circle-left"></i>Назад к спсику ОСМД</a></li>
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
                            <th>Osmd</th>
                            <th>Title</th>
                            <th>Levels</th>
                            <th>Address</th>
                            <th>Flats</th>
                            <th>Active</th>
                            <th class="action-buttons">Actions</th>
                        </tr>
                        </thead>
                        <tbody class="ui-sortable" role="alert" aria-live="polite" aria-relevant="all">
                        @foreach($buildings as $index=>$item)

                            <tr>
                                <td>{!! $item->getId() !!}</td>
                                <td>{!! $item->Osmd->getTitle() !!}</td>
                                <td>{!! $item->getTitle() !!}</td>
                                <td>{!! $item->getLevels() !!}</td>
                                <td>{!! $item->getCity() !!}</td>
                                <td>{!! count($item->Flats) !!}</td>
                                <td>
                                    @if($item->isActive())
                                        <a href="/cpanel/building/close/{!! $item->getId() !!}" data-toggle="tooltip" title="Click to disable"><span class="badge badge-success">Active</span></a>
                                    @else
                                        <a href="/cpanel/building/open/{!! $item->getId() !!}" data-toggle="tooltip" title="Click to activate"><span class="badge badge-dark">Disabled</span></a>
                                    @endif
                                </td>
                                <td class="action-buttons">
                                    <a href="/cpanel/osmd/{!! $item->Osmd->getId() !!}/building/edit/{!! $item->getId() !!}" class="btn btn-info" title="Редактировать"><i class="fa fa-pencil"></i></a>
                                    <a href="/cpanel/building/{!! $item->getId() !!}/flat/all" class="btn btn-warning" title="Квартиры"><i class="fa fa-home"></i></a>
                                    <a href="/cpanel/building/delete/{!! $item->getId() !!}" class="btn btn-danger" title="Удалить"><i class="fa fa-trash"></i></a>

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