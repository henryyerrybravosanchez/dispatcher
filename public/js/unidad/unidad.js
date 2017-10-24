/**
 * Created by hbs on 18/08/16.
 */
var base='';
$(document).ready(function() {
    base=$("#baseUrl").val();
    $("#modalAddFoto").on("hidden.bs.modal", function () {
        location.reload()
    });

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
        if(nplaca.val()&&tipounidad)
        makePost({
            o:1,
            p:nplaca.val(),
            t:tipounidad
        });
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
                        modalLoading.modal("hide");
                        swal(
                            {
                                title: "Registrado!",
                                text: "El registro fue realizado correctamente",
                                type: "success",
                                confirmButtonColor: "#DD6B55",
                                closeOnConfirm: false
                            },
                            function () {
                                location.reload(true);
                            }
                        );

                        break;
                    case 2:
                        location.reload(true);
                        break;

                    case 11:
                        location.reload(true);
                        break;
                    case 3:
                        location.reload(true);
                        break;

                    case 4:
                        location.reload(true);
                        break;

                    case 5:
                        location.reload(true);
                        break;
                    case 7:
                        if(datar!==-1)
                        {
                            swal(
                                {
                                    title: "Actualización",
                                    text: "La actualización del registro fue correctamente",
                                    type: "success",
                                    confirmButtonColor: "#DD6B55",
                                    closeOnConfirm: false
                                },
                                function () {
                                    location.reload(true);
                                }
                            )

                        }
                        else
                            swal("Error","Hubo un error","error")
                        break;
                    case 8:
                        if(datar!==-1)
                        {
                            swal(
                                {
                                    title: "Actualización",
                                    text: "La actualización del registro fue correctamente",
                                    type: "success",
                                    confirmButtonColor: "#DD6B55",
                                    closeOnConfirm: false
                                },
                                function () {
                                    location.reload(true);
                                }
                            )

                        }
                        else
                            swal("Error","Hubo un error","error")
                        break;
                    case 9:
                        if(datar.data!==-1)
                        {
                            $("#modalEditChofer").modal('show');
                            console.log()
                            $("#nombreE").val(datar.data.nombre);
                            $("#dniE").val(datar.data.dni);
                            $("#direccionE").val(datar.data.direccion);
                            $("#telefonoE").val(datar.data.telefono);
                            $("#passwordE").val(datar.data.contrasena);
                            $("#passwordrE").val(datar.data.contrasena);
                        }
                        else
                            swal("Error","Hubo un error al traer los datos del chofer","error")

                        break;
                    case 10:

                        if(datar.data!==-1)
                        {
                            $("#modalEditUnidad").modal('show');
                            $("#nplacaE").val(datar.data.nplaca);
                            $("#internoE").val(datar.data.interno);
                        }
                        else
                            swal("Error","Hubo un error al traer los datos de la unidad","error")

                        break;
                }
        }

    });
}

$(document).on('click','.foto', function() {
    $("#modalAddFoto").modal('show').attr('idm', $(this).attr('idm'))
});

$(document).on('click','.fotochofer', function() {
    $("#modalAddFotoChofer").modal('show').attr('idc', $(this).attr('idc'))
});

$(document).on('click','.editchofer', function() {
    var idchofer= $(this).attr('idc');
    makePost({
        o:9,
        idc:idchofer})//Lenar casillas con datos de chofer
    $("#btnEditarCh").click(function () {
        $(this).append('<i class="fa fa-spinner fa-pulse fa-3x fa-fw"></i> <span class="sr-only">Loading...</span>')
        var nombre=$("#nombreE").val();

        var dni=$("#dniE").val();
        var direccion=$("#direccionE").val();
        var telefono=$("#telefonoE").val();
        var nContra=$("#passwordE").val();
        var nContraR=$("#passwordrE").val();
        if(nContra===nContraR&&nContra.length>0)
        {
            makePost({
                o:7,
                idc:idchofer,
                n:nombre,
                d:dni,
                di:direccion,
                t:telefono,
                c:nContra})
        }
        else {
            swal("Contraseñas","Las contraseñas no son iguales, repita la misma contraseña, o es muy pequeña","error");
        }
    })
});
$(document).on('click','.editmovilidad', function() {
    var idmovilidad= $(this).attr('idm');
    makePost({
        o:10,
        idm:idmovilidad})//Lenar casillas con datos de chofer
    $("#btnEditUnidad").click(function () {
        $(this).append('<i class="fa fa-spinner fa-pulse fa-3x fa-fw"></i> <span class="sr-only">Loading...</span>')
        var nplaca=$("#nplacaE").val();

        var interno=parseInt($("#internoE").val());
        if(interno>0)
        {
            makePost({
                o:8,
                idm:idmovilidad,
                np:nplaca,
                i:interno
            })
        }
        else {
            swal("Número interno","El número interno debe ser mayor que 0","error");
        }
    })
});

$(document).on('click','.chofer', function() {
    $("#modalAsignar").modal('show');
    $("#btnAsginar").attr('idm', $(this).attr('idm'));
});

$(document).on('click','.estado', function() {
    $("#changeEstado").modal('show');
    $("#btn-confirmar").attr('idc', $(this).attr('idc'));
});