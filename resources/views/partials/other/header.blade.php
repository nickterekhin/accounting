<link rel="stylesheet" href="/css/libs/all.css">
<link rel="stylesheet" href="/css/libs/datatables.min.css">
<link rel="stylesheet" href="/css/libs/bootstrap.min.css">
<link rel="stylesheet" href="/css/libs/metismenu.min.css">
<link rel="stylesheet" href="/css/libs/jquery-ui.min.css">
<link rel="stylesheet" href="/css/acc.css">
<link rel="stylesheet" href="/css/acc_print.css" media="print">

@yield('styles')

<script src="/js/libs/jquery.min.js" type="text/javascript"></script>
<script src="/js/libs/jquery-ui.min.js" type="text/javascript"></script>
<script src="/js/libs/bootstrap.min.js" type="text/javascript"></script>
<script src="/js/libs/datatables.min.js" type="text/javascript"></script>
<script src="/js/libs/metismenu.min.js" type="text/javascript"></script>
<script src="/js/global.js" type="text/javascript"></script>
<script src="/js/acc_tables.js" type="text/javascript"></script>
<script src="/js/acc.js" type="text/javascript"></script>
<script src="/js/payments.js" type="text/javascript"></script>
<script type="text/javascript">
        opt.stateSave = false;
        opt.order = [1, 'asc'];
</script>

@yield('extra-table-options')
<script type="text/javascript">
    $(document).ready(function(){
        acc_tables.init_table('.table',opt);
    });
</script>
@yield('scripts')