/**
 * Created by hbs on 18/08/16.
 */
var base='';

$(document).ready(function() {
    base=$("#baseUrl").val();

    if($.fn.dataTable.isDataTable("#table-reservas")){
        $("#table-reservas").DataTable();
    }else {
        $('#table-reservas').DataTable({
            "language": {
                "lengthMenu": "Mostrar _MENU_ registros por página.",
                "zeroRecords": "Ningún registro encontrado.",
                "info": "Mostrando página _PAGE_ de _PAGES_",
                "infoEmpty": "Ningún registro disponible.",
                "infoFiltered": "(filtered from _MAX_ total records)",
                "search": "Buscar",
                paginate: {
                    previous: 'Anterior',
                    next:     'Siguiente'
                },
                aria: {
                    paginate: {
                        previous: 'Anterior',
                        next:     'Siguiente'
                    }
                }
            }
        });
    }

});


$(document).on('click','div.eliminar', function() {
    var num=$(this).attr('num');
    $.each($(".paneles"), function()
    {
        if($(this).attr('num')==num)
        {
            $(this).hide();
        }
    })
});