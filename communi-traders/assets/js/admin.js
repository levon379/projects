var url = _getThisURL();
url    += '/analysis_tool/ajax/get_users'; 

$(document).ready(function() {
    $('#all').dataTable({
        "bProcessing": true,
        "bServerSide": true,
        "bPaginate": true,
        "bSortable": true,
        "iDisplayLength": 5,
        "aoColumns": [
                                        null,
                                        null //put as many null values as your columns

                    ],
        "aLengthMenu": [[5, 10, 25, 50, 100], [5, 10, 25, 50, 100]],
        "sAjaxSource": url,
        "fnServerData": function ( sSource, aoData, fnCallback ) {
						aoData.push( { "name": "status", "value": "TA" } );
						$.getJSON( sSource, aoData, function (json) { 
							fnCallback(json);
						} );
					},
        "sPaginationType": "full_numbers",
        "sDom": '<"top">rt<"bottom"plf><"clear">'
    });
});

function _getThisURL()
{
    pathArray = location.href.split("://");
    pathArray = pathArray[1].split( '/' );
    host = pathArray[0];
    return host;
}
