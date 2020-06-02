@extends('layouts.cpanel')

@section('page-title', 'Тариф')

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
                            <th>Title</th>
                            <th>Amount</th>
                            <th>Type</th>
                            <th>Created</th>
                            <th>Active</th>
                            <th class="action-buttons">Actions</th>
                        </tr>
                        </thead>
                        <tbody class="ui-sortable" role="alert" aria-live="polite" aria-relevant="all">
                        @foreach($tarifes as $index=>$item)
                            <tr>
                                <td>{!! $item->getId() !!}</td>
                                <td>{!! $item->getTitle() !!}</td>
                                <td>{!! $item->getAmount() !!}</td>
                                <td>{!! $item->getType() !!}</td>
                                <td>{!! date("d-m-Y",$item->getCreated()) !!}</td>
                                <td>
                                    @if($item->isActive())
                                        <span class="badge badge-success">Active</span>
                                    @else
                                        <span class="badge badge-dark">Disabled</span>
                                    @endif
                                </td>
                                <td class="action-buttons">
                                    <a href="/cpanel/tarif/delete/{!! $item->getId() !!}" class="btn btn-danger" title="Удалить"><i class="fa fa-trash"></i></a>
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