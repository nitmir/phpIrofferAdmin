jQuery.extend( jQuery.fn.dataTableExt.oSort, {
    "num-html-pre": function ( a ) {
        var x = String(a).replace( /<[\s\S]*?>/g, "" );
        return parseFloat( x );
    },

    "num-html-asc": function ( a, b ) {
        return ((a < b) ? -1 : ((a > b) ? 1 : 0));
    },

    "num-html-desc": function ( a, b ) {
        return ((a < b) ? 1 : ((a > b) ? -1 : 0));
    }
} );


jQuery.extend( jQuery.fn.dataTableExt.oSort, {
    "file-size-pre": function ( a ) {
        if(a == '&lt;1k')
            return 0.5;
        if(a == '-' || a =='symlink')
            return -1;
        var x = a.substring(0,a.length - 1);
             
        var x_unit = (a.substring(a.length - 1, a.length) == "M" ?
            1000 : (a.substring(a.length - 1, a.length) == "G" ? 1000000 : 1));
          
        return parseInt( x * x_unit, 10 );
    },
 
    "file-size-asc": function ( a, b ) {
        return ((a < b) ? -1 : ((a > b) ? 1 : 0));
    },
 
    "file-size-desc": function ( a, b ) {
        return ((a < b) ? 1 : ((a > b) ? -1 : 0));
    }
} );
