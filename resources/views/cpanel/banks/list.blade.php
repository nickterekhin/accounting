@extends('layouts.cpanel')

@section('page-title', 'Banks - list')

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
                            <th>MFO</th>
                            <th>Address</th>
                            <th>Active</th>
                            <th class="action-buttons">Actions</th>
                        </tr>
                        </thead>
                        <tbody class="ui-sortable" role="alert" aria-live="polite" aria-relevant="all">
                        @foreach($banks as $index=>$item)
                            <tr>
                                <td>{!! $item->getId() !!}</td>
                                <td>{!! $item->getTitle() !!}</td>
                                <td>{!! $item->getMfo() !!}</td>
                                <td>{!! $item->getCity() !!}</td>
                                <td>
                                    @if($item->isActive())
                                        <a href="/cpanel/bank/close/{!! $item->getId() !!}" data-toggle="tooltip" title="Click to disable"><span class="badge badge-success">Active</span></a>
                                    @else
                                        <a href="/cpanel/bank/open/{!! $item->getId() !!}" data-toggle="tooltip" title="Click to activate"><span class="badge badge-dark">Disabled</span></a>
                                    @endif
                                </td>
                                <td class="action-buttons">
                                    <a href="/cpanel/bank/edit/{!! $item->getId() !!}" class="btn btn-info" title="Редактировать"><i class="fa fa-pencil"></i></a>
                                    <a href="/cpanel/bank/delete/{!! $item->getId() !!}" class="btn btn-danger" title="Удалить"><i class="fa fa-trash"></i></a>
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