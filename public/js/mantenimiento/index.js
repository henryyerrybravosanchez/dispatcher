/**
 * Created by hbs on 18/08/16.
 */
var base='';
var inFechaFinal, inFechaInicio, divFechaFinal, divObservacionIngreso, divObservacionSalida, inObservaI, inObservaF;

$(document).ready(function() {
    base=$("#baseUrl").val();
    inFechaInicio =$("#fechainicio");
    inFechaFinal =$("#fechafinal");
    divFechaFinal=$("#divFF");
    divObservacionIngreso=$("#divOI");
    divObservacionSalida=$("#divOS");
    inObservaI=$("#observingre");
    inObservaF=$("#observasali");
    inFechaInicio.datetimepicker();
    inFechaFinal.datetimepicker();

    inObservaF.limitText({limit: 500});
    inObservaI.limitText({limit: 500});
    sendData({o:1});
});

$('input[type="radio"]').on('click change', function(e) {
    var es=parseInt($(this).val());
    cambioEstado(es);
});
function cambioEstado(e) {
    switch (e) {
        case 1://programardo
            inFechaInicio.prop('disabled','false');
            divObservacionIngreso.hide();
            divObservacionSalida.hide();
            divFechaFinal.hide();
            break;
        case 2://cancelar
            inFechaInicio.prop('disabled','false');
            divObservacionIngreso.hide();
            divObservacionSalida.hide();
            divFechaFinal.hide();
            break;
        case 3://en proceso
            inFechaInicio.prop('disabled','true');
            divObservacionIngreso.show();
            inObservaI.prop('disabled', false);
            divObservacionSalida.hide();
            divFechaFinal.hide();
            break;
        case 4://terminar
            inFechaInicio.prop('disabled','true');
            divObservacionIngreso.show();
            inObservaI.prop('disabled', 'true');
            inObservaF.prop('disabled', false);
            divObservacionSalida.show();
            divFechaFinal.show();
            break;
    }
}

$(document).on("click",".detalleMan", function () {
    $("#modalB").modal("show");
    sendData({
        o:3,
        ide:$(this).attr('ide')
    })
});
$(document).on("click", ".deleteMan", function () {

    var idestado=parseInt($(this).attr('ide'));
    swal({
        title: "¿Estas seguro?",
        text: "Este mantenimiento será desactivado",
        icon: "warning",
        buttons: ["Cancelar", "Eliminar!"],
        dangerMode: true
    }).then(function(isConfirm) {
        if (isConfirm) {
            sendData({
                o:2,
                ide:idestado
            });
            swal({
                title: 'Eliminando..!',
                text: 'El registro se está eliminando, por favor espere',
                icon: 'success'
            }).then(function() {
                sendData({o:1});
                // form.submit(); // <--- submit form programmatically
            });
        } else {
            //  swal("Proceso cancelado!", "No se preocupe, todo está como antes", "error");
        }
    })
});

function sendData(data){
    $.ajax({
        async: true,
        type: "POST",
        dataType: "json",
        data: data,
        url:  base+"/mantenimiento/index",
        success: function (data2) {
            if(data2.data!==-1)
            {
                switch (data2.o){
                    case 1:
                        actualizarMantenimiento(data2.data);
                        break;
                    case 2:
                        break;
                    case 3:
                        mostrarMantenimiento(data2.data);
                        break;
                    case 4://Actualizar man
                        break;
                }
            }
            else {
                swal("Algo fue mal, intentar nuevamente en unos segundos")
            }
        }

    });
}
function contador(){
    sendData({o:1});
}
function mostrarMantenimiento(man) {
    $("#estado"+man.estado).prop('checked', true);
    cambioEstado(parseInt(man.estado));
    llenarDatosMan(man)
}
function llenarDatosMan(man) {
    inObservaI.val(man.observacioningreso);
    inObservaF.val(man.observacionsalida);
    inFechaInicio.val(man.fechainicio);
    inFechaFinal.val(man.fechasalida);
}
function actualizarMantenimiento(data) {
    htmlMate="";mantenimientos=[];
    $.each(data, function (k,v) {
        if(jQuery.inArray(v.idestado, mantenimientos) === -1){
            mantenimientos.push(v.idestado);
            var tipo="No tipo", estado="no estado";
            switch (v.tipo){
                case "1":
                    tipo="Man correctivo";
                    break;
                case "2":
                    tipo="Man preventivo";
                    break;
                case "3":
                    tipo="Man combustible";
                    break;
                case "4":
                    tipo="Clima adverso";
                    break;
                case "5":
                    tipo="Voladura";
                    break;
                case "6":
                    tipo="Refrigerio";
                    break;
                case "7":
                    tipo="Falla mecánica";// Solo va a taller
                    break;
                case "8":
                    tipo="Cargando";
                    break;
                case "9":
                    tipo="Trayecto";
                    break;
                case "A":
                    tipo="descargando";
                    break;
                case "B":
                    tipo="En cola";
                    break;
            }
            switch (v.estado){
                case "1":
                    estado="Programado";
                    break;
                case "2":
                    estado="Desactivado";
                    break;
                case "3":
                    estado="En proceso";
                    break;
                case "4":
                    estado="Finalizado";
                    break;
            }
            htmlMate+=
                "<tr>" +
                "<td>"+v.placa+"</td>"+
                "<td>"+tipo+"</td>"+
                "<td>"+v.fechainicio+"</td>"+
                "<td>"+estado+"</td>"+
                "<td>" +
                "<a class='btn btn-success btn-xs detalleMan' ide='"+v.idestado+"' ><i class='fa fa-chevron-circle-right'></i></a>" +
                "<a class='btn btn-danger btn-xs deleteMan' ide='"+v.idestado+"'><i class='fa fa-trash' ></i></a></td>"+
                "</tr>";
        }
    });
    $("#tableDiv").empty().append(tablaHtml);
    $("#tablemante").empty().append(htmlMate);
    if($.fn.dataTable.isDataTable("#table-reservas")){
        $("#table-unidades").DataTable();
    } else {
        $('#table-unidades').DataTable({
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
}
var htmlMate="", mantenimientos=[],
    tablaHtml=
    '<table  id="table-unidades" class="table table-striped table-bordered table-hover dataTable no-footer dtr-inline tableeeeee" role="grid" aria-describedby="dataTables-example_info" style="width: 98%;">\n' +
        '<thead>' +
            '<tr role="row">' +
                '<td>Nº Placa</td>' +
                '<td>Tipo</td>' +
                '<td>Fecha Programación</td>' +
                '<td>Estado</td>' +
                '<td>Opción</td>' +
            '</tr>' +
        '</thead>' +
        '<tbody id="tablemante">' +
        '</tbody>' +
    '</table>';



