@extends('layouts.cpanel')

@section('page-title', 'ОСМД')

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
                            <th>OKPO</th>
                            <th>BankId</th>
                            <th>CreatedAt</th>
                            <th>Address</th>
                            <th>Buildings</th>
                            <th>Active</th>
                            <th class="action-buttons">Actions</th>
                        </tr>
                        </thead>
                        <tbody class="ui-sortable" role="alert" aria-live="polite" aria-relevant="all">
                        @foreach($osmd_list as $index=>$item)
                            <tr>
                                <td>{!! $item->getId() !!}</td>
                                <td>{!! $item->getTitle() !!}</td>
                                <td>{!! $item->getOkpo() !!}<br/> р/с:{!! $item->getAccount() !!}</td>
                                <td>{!! $item->Bank->GetTitle() !!}</td>
                                <td>{!! date('m-d-Y',$item->getAddedAt()) !!}</td>
                                <td>{!! $item->getCity() !!}</td>
                                <td>{!! count($item->Buildings) !!}</td>
                                <td>
                                    @if($item->isActive())
                                        <a href="/cpanel/osmd/close/{!! $item->getId() !!}" data-toggle="tooltip" title="Click to disable"><span class="badge badge-success">Active</span></a>
                                    @else
                                        <a href="/cpanel/osmd/open/{!! $item->getId() !!}" data-toggle="tooltip" title="Click to activate"><span class="badge badge-dark">Disabled</span></a>
                                    @endif
                                </td>
                                <td class="action-buttons">
                                    <a href="/cpanel/osmd/edit/{!! $item->getId() !!}" class="btn btn-info" title="Редактировть"><i class="fa fa-pencil"></i></a>
                                    <a href="/cpanel/osmd/delete/{!! $item->getId() !!}" class="btn btn-danger" title="Удалить"><i class="fa fa-trash"></i></a>
                                    <a href="/cpanel/osmd/{!! $item->getId() !!}/building/all" class="btn btn-warning" title="Дома"><i class="fa fa-building"></i></a>
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