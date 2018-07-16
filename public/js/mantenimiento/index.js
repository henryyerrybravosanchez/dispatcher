/**
 * Created by hbs on 18/08/16.
 */
var base='';

function contador(){

}
$(document).ready(function() {
    base=$("#baseUrl").val();
    sendData({o:1});
});

function sendData(data)
{

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
                }
            }
            else {
                swal("Algo fue mal, intentar nuevamente en unos segundos")
            }
        }

    });
}
var htmlMate="", mantenimientos=[];
function actualizarMantenimiento(data) {
    htmlMate="";
    $.each(data, function (k,v) {
        if(jQuery.inArray(v.idmantenimiento, mantenimientos) === -1){
            mantenimientos.push(v.idmantenimiento)
            var tipo="", estado="no estado";
            switch (v.tipo){
                case "1":
                    tipo="Mantenimiento correctivo";
                    break;
                case "2":
                    tipo="Mantenimiento preventivo";
                    break;
                case "3":
                    tipo="Mantenimiento combustible";
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
                "<td>"+v.fechaingreso+"</td>"+
                "<td>"+estado+"</td>"+
                "<td>" +
                    "<a class='btn btn-success btn-xs'><i class='fa fa-chevron-circle-right'></i></a>" +
                    "<a class='btn btn-danger btn-xs deleteMan'><i class='fa fa-trash'></i></a></td>"+
                "</tr>";
        }
    });
    $("#tablemante").append(htmlMate);
}
$(document).on("click", ".deleteMan", function () {

    swal({
        title: "¿Estas seguro?",
        text: "Este mantenimiento será desactivado",
        icon: "warning",
        buttons: ["Cancelar", "Eliminar!"],
        dangerMode: true
    }).then(function(isConfirm) {
        if (isConfirm) {
            swal({
                title: 'Eliminando..!',
                text: 'El registro se está eliminando, por favor espere',
                icon: 'success'
            }).then(function() {
                alert(8);
                form.submit(); // <--- submit form programmatically
            });
        } else {
          //  swal("Proceso cancelado!", "No se preocupe, todo está como antes", "error");
        }
    })
});

