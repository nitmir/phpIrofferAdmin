    <script src="{$ROOT}deps/jquery/jquery.min.js" type="text/javascript"></script>
    <script src="{$ROOT}deps/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
    <script src="{$ROOT}deps/bootstrap/js/bootbox.min.js" type="text/javascript"></script>
    <script src="{$ROOT}deps/datatables/js/jquery.dataTables.min.js" type="text/javascript"></script>
    <script src="{$ROOT}deps/datatables/js/jquery.dataTables.plugins.js" type="text/javascript"></script>
    <script type="text/javascript">
//<![CDATA[
    /* Some gobals params for dataTables */
    function dataTablesDefaultsParams(params) { 
        return $.extend({
                   "aLengthMenu": [[10, 25, 50, 100, 500, -1], [10, 25, 50, 100, 500, "{"All"|gettext}"]],
                   "iDisplayLength": {$config.datatables.elements_to_display},
                   "oLanguage": { "sUrl": "{$ROOT}deps/datatables/lang/{$params.lang}.txt" },
               }, params);
    }

    function getRanges(array) {
      var ranges = [], rstart, rend;
      for (var i = 0; i < array.length; i++) {
        rstart = array[i];
        rend = rstart;
        while (array[i + 1] - array[i] == 1) {
          rend = array[i + 1]; // increment the index if the numbers sequential
          i++;
        }
        ranges.push(rstart == rend ? rstart+'' : rstart + '-' + rend);
      }
      return ranges;
    }
//]]>
    </script>
