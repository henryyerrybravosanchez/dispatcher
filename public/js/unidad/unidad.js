/**
 * Created by hbs on 18/08/16.
 */

var base='';
$(document).ready(function() {
    base=$("#baseUrl").val();
    if($.fn.dataTable.isDataTable(".tableeeeee")){
        $(".tableeeeee").DataTable();
    } else {
        $('.tableeeeee').DataTable({
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

    $("#addUnidad").click(function () {
        $("#modalAddUnidad").modal('show')
    });

    $("#btnGuardarU").click(function () {
        var nplaca=$("#nplaca");
        var tipounidad=$("input[name=tipounidad]:checked").val();
        var consumo=$("#consumo");
        if(nplaca.val()&&tipounidad)
        {
            makePost({
                o:1,
                p:nplaca.val(),
                t:tipounidad,
                c:consumo.val()
            });
        }
        else{
            swal("error", "Error al intentar guardar, ingrese placa y seleccione tipo", "error");
        }
    })
});

$('input[name=tipounidad]').on('change',function () {
    var val=$(this).val();
    var consumo=$("#consumo");
    switch (val)
    {
        case '1':
            consumo.attr('placeholder', "En galones por hora");
            break;
        case '2':
            consumo.attr('placeholder', "En galones por kilometro");
            break;
    }
});

function makePost(data)
{
    var modalLoading=$("#modalLoading");
    modalLoading.modal("show");
    $("#modalAddUnidad").modal("hide");
    $.ajax({
        async: true,
        type: "POST",
        dataType: "json",
        data: data,
        url: base+"/unidad/unidad",
        success: function (datar) {
            if(datar.data===-1)
            {
                modalLoading.modal("hide");
                swal("Error!", "error al intentar guardar", "error");
            }
            else
                switch (data.o)
                {
                    case 1:
                        swal({
                            title: "Registrado!",
                            text: "El registro fue realizado correctamente",
                            type: 'success',
                            showCancelButton: true,
                            confirmButtonColor: '#0093ff',
                            cancelButtonColor: '#DD6B55',
                            confirmButtonText: 'Recargar!'
                        }).then(function () {
                            location.reload(true);

                        });
                        break;
                    case 2:
                        location.reload(true);
                        break;

                }
        }

    });
}
$(document).on('click','.estado', function() {
    $("#changeEstado").modal('show');
    $("#btn-confirmar").attr('idc', $(this).attr('idc'));
});