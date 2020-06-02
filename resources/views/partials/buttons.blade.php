<?php
if(!$hideManageButtons){
$currentPath  = Route::getCurrentRoute()->getPrefix();

$params = Route::getCurrentRoute()->parameters();
$matches = array();

preg_match('/\{id\}\/(owner|receipt|payment|building|flat|payment|discount)\/(all|edit|add|del)/',Route::current()->uri(),$matches);

?>

<div class="float-right" id="manage-buttons">
<?php if(!empty($matches)){ ?>
    @if($matches[1]=='receipt')
        <div class="btn-group">
            <a href="javascript:void(0)" id="add-receipt" class="btn btn-success float-right add-btn"><i class="fa fa-plus"></i>Add New</a>
        </div>
        @elseif($matches[1]=='payment')
        <div class="btn-group">
            <a href="javascript:void(0)" id="add-payment" class="btn btn-success float-right add-btn"><i class="fa fa-plus"></i>Add New</a>
        </div>
        @else

    <div class="btn-group">
        <a href="/{{ $currentPath }}/{{$params['id']}}/{!! $matches[1] !!}/add" class="btn btn-success float-right add-btn"><i class="fa fa-plus"></i>Add New</a>
    </div>


        @endif
    <div class="btn-group">
        <a href="/{{ $currentPath }}/{{$params['id']}}/{!! $matches[1] !!}/all" class="btn btn-primary float-right add-btn"><i class="fa fa-hand-o-right"></i>View All</a>
    </div>
    <?php } else { ?>
        <div class="btn-group">
            <a href="/{{ $currentPath }}/create{{ (Request::is('admin/cache-settings','admin/cache-settings/*')?'-cache':'') }}" class="btn btn-success float-right add-btn"><i class="fa fa-plus"></i>Add New</a>
        </div>

    <div class="btn-group">
        <a href="/{{ $currentPath }}/" class="btn btn-primary float-right add-btn"><i class="fa fa-hand-o-right"></i>View All</a>
    </div>
    <?php } ?>
</div>
<?php }  ?>