    <script src="{$ROOT}deps/jquery/jquery.min.js" type="text/javascript"></script>
    <script src="{$ROOT}deps/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
    <script src="{$ROOT}deps/bootstrap/js/bootbox.min.js" type="text/javascript"></script>
    <script src="{$ROOT}deps/datatables/js/jquery.dataTables.min.js" type="text/javascript"></script>
    <script src="{$ROOT}deps/datatables/js/jquery.dataTables.plugins.js" type="text/javascript"></script>
    <script type="text/javascript">
    /* Some gobals params for dataTables */
    function dataTablesDefaultsParams(params) { 
        return $.extend({
                   "aLengthMenu": [[10, 25, 50, 100, 500, -1], [10, 25, 50, 100, 500, "{"All"|gettext}"]],
                   "iDisplayLength": 50,
                   "oLanguage": { "sUrl": "{$ROOT}deps/datatables/lang/{$params.lang}.txt" },
               }, params);
    }
    </script>
