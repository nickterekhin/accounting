(function($){

    $.fn.Payments = function(options){

        let payments  = $.data(this[0],"payments_ctrl");
        if(!payments)
        {
            payments =  new $.td_payments_service(options,this[0]);
        }
        $.data(this[0],"payments_ctrl",payments);
        return payments;

    };
    $.td_payments_service = function(options,el){
      this.settings = $.extend(true,{},$.td_payments_service.defaults,options);
      this.curr_el = el;
      this.$curr_el = $(el);
      this.ctrls = {
          $outstanding:$("#"+(typeof this.$curr_el.data("outstanding") !== 'undefined'?this.$curr_el.data("outstanding"):"outstanding")),
          $amount:$("#"+(typeof this.$curr_el.data("amount") !== 'undefined'?this.$curr_el.data("amount"):"Amount")),
          $total:$("#"+(typeof this.$curr_el.data("total") !== 'undefined'?this.$curr_el.data("total"):"Total")),
          $refresh:$("#"+(typeof this.$curr_el.data("refresh") !== 'undefined'?this.$curr_el.data("refresh"):"refresh-payment-form")),
          $payment_notify:$("#payment-notify"),
      };
      this.init();
    };
    $.extend($.td_payments_service,{
        defaults:{

        },
        prototype:{
            init:function(){

                let _self = this;
                this.ctrls.$outstanding.find("input[type='checkbox']").on("change",function(){
                    let total = parseFloat(_self.ctrls.$total.val()),
                        amount = parseFloat($(this).data("amount")),
                        res = total - amount;

                    if($(this).is(":checked"))
                    {
                        res = total + amount;
                    }
                    _self.ctrls.$total.val(res.toFixed(2));
                });

                this.ctrls.$amount.on("change",function(){
                    let val = parseFloat($(this).val());
                    let def_value = _self.ctrls.$amount.data("receiptValue");
                    _self.ctrls.$outstanding.find("input[type='checkbox']:checked").each(function(){
                        $(this).prop("checked",false).trigger("change");
                    });
                    _self.ctrls.$total.val($(this).val());
                    let res = val-def_value;
                    if(res<0)
                        _self.ctrls.$payment_notify.html("<em style='color:#8e0000; font-weight: 500;line-height:2'>Долг на следующий месяц: "+Math.abs(res.toFixed(2))+"</em>");
                    else if(res>0)
                    {
                        _self.ctrls.$payment_notify.html("<em style='color:#008b00;font-weight: 500;line-height:2'>Переплата на следующий месяц: "+Math.abs(res.toFixed(2))+"</em>");
                    }else
                    {
                        _self.ctrls.$payment_notify.empty();
                    }


                });

                this.ctrls.$refresh.on('click',function(){
                    let def_value = _self.ctrls.$amount.data("receiptValue");
                    _self.ctrls.$outstanding.find("input[type='checkbox']:checked").each(function(){
                        $(this).prop("checked",false);
                    });
                    _self.ctrls.$amount.val(def_value);
                    _self.ctrls.$total.val(def_value);
                    _self.ctrls.$payment_notify.text("");
                });

            }
        }
    });
})(jQuery);