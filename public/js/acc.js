(function($,acc){
    $(document).ready(function(){
        initCSRFToken();
        $('#menu').metisMenu();

    });

    initCSRFToken = function()
    {
        if($('input[name="_token"]').length>0) {
            $.ajaxSetup({
                headers: {'X-CSRF-Token': $('input[name="_token"]').attr('value')}
            });

        }


    };
    acc.initDropDowns = function(options)
    {

        let opt = $.extend({
            url:'/cpanel/ajax/buildings',
            main_id:null,
            default_value:0,
            function_name:'getBuildingsList',
            edit:false
        },options);
console.log(opt);
        let $main_dd = $("#"+opt.main_id),
            $child = $("#"+$main_dd.data('child')),
            $sub_child = $("#"+$child.data('child'));
console.log($main_dd.val());
        if($main_dd.val())
        {
            sendRequest($main_dd.val(),opt,$child,$sub_child,true);
        }


            $main_dd.on('change',function(e,isTrigger){

                $child.find('option').not(':first').remove();
                if($sub_child.length>0)
                    $sub_child.find('option').not(':first').remove();
                console.log(opt);
                  sendRequest($(this).val(),opt,$child,$sub_child,isTrigger);
            });
    };
    let sendRequest=function(value,opt,$child,$sub_child,isTrigger)
    {
        isTrigger = isTrigger || 0;

        $.ajax({
            method:"POST",
            url:opt.url,
            data:{id:1,cmd:opt.function_name,val:value,edit:opt.edit?1:0},
            beforeSend:function()
            {
                $("#loading-indicator-" + opt.main_id).show();
            },
            complete:function(){
                $("#loading-indicator-" + opt.main_id).hide();

            },
            success:function(data, status, jqXHR){
                let buildings =eval(jqXHR.responseText);
                if(buildings.length>0) {
                    $.each(buildings, function (i, v) {

                        if(isTrigger && v.id ===opt.default_value)
                        {
                            $child.append('<option value="' + v.id + '" selected>' + v.Title + '</option>');

                        }else
                        {
                            $child.append('<option value="' + v.id + '">' + v.Title + '</option>');
                        }

                    });
                    $child.prop('disabled',false);
                    if($sub_child.length>0)
                        $child.trigger('change',true);

                }else
                {
                    $child.prop('disabled',true);
                    if($sub_child.length>0)
                    {
                        $sub_child.prop('disabled',true);
                    }
                }
            }
        });
    }
})(jQuery,window.acc = window.acc||{});