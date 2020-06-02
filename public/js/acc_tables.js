(function($,obj){

    obj.table_obj = null;

    obj.init_table = function(id,options)
    {
        //var _self = this;
        var opt_table = $.extend({
                "pageLength": 50,
                stateSave:false,
                fnRowCallback: function (nRow, aData, iDisplayIndex) {
                    nRow.setAttribute('id', aData[1]);
                }

            },options),
            table_node_id = $(id).attr('id'),
            table_node = $('#'+table_node_id);

        this.table_obj = table_node.dataTable(opt_table);


    };

/*
    var initFilters = function(table_api,filters)
    {
        var tableState =table_api.state.loaded();

        $.each(filters,function(i,v){
            var el = $("#"+ v.id);

            //set default value for status filter
            if(/^status_id/.test(v.id))
            {
                table_api.columns(v.column).search('(,|^)Active(,|$)',true,false).draw();
                el.find('option[value="Active"]').attr('selected','true');
            }
            if(/^is_read/.test(v.id))
            {
                table_api.columns(v.column).search('(,|^)0(,|$)',true,false).draw();
                el.find('option[value="0"]').attr('selected','true');
            }
            el.on('change',function(){
                var val = this.value;
                val = val.replace(/\+/g,'\\\+');
                table_api.columns(v.column).search(val?'(,|^)'+val+'(,|$)':'',true,false).draw();
            });

            //use state values
            if (typeof tableState !== 'undefined' && tableState != null) {
                var column = tableState.columns[v.column];
                var search_val = column.search.search;
                if (!isEmpty(search_val)) {
                    var found = search_val.match(/\)(.*?)\(/i);
                    if (found) {
                        el.find('option[value="' + found[1] + '"]').attr('selected', 'true');
                    }

                }
            }
        });

    };

    obj.add_filters =function(filters,table)
    {
        var _self = this,
            filters_node = $("#filter-table");
        _self.table_obj = table || _self.table_obj;

        if(filters_node.length==0) return;

        var parent_div_length = $("#"+_self.table_obj[0].id+"_length").parent();
        var parent_div_filter = $("#"+_self.table_obj[0].id+"_filter").parent();

        parent_div_length.removeClass();
        parent_div_length.addClass('col-sm-2');
        parent_div_filter.removeClass();
        parent_div_filter.addClass('col-sm-3');

        parent_div_length.after(filters_node.html());

        initFilters(this.table_obj.api(),filters);
    };*/



})(jQuery,window.acc_tables = window.acc_tables||{});