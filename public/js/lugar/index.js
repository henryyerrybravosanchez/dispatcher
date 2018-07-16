/**
 * Created by hbs on 18/08/16.
 */
var base='';
var cordenadas=[], markerEdit=[], cordenadasDesplazamiento=[], markerDesplazamiento=[];
var flightPath, polilyneRecorrido;
var btnshowAddRuta, modalAddRuta, btdShearPoint, selectCamion, inFechaInicio, inFechaFin;
$(document).ready(function() {
    btnshowAddRuta=$("#btnAddRuta");
    modalAddRuta=$("#modalAddRuta");
    btdShearPoint=$("#btdShearPoint");
    selectCamion=$("#camion");
    inFechaInicio=$("#fechainicio");
    inFechaFin=$("#fechafin");
    base=$("#baseUrl").val();
    if($.fn.dataTable.isDataTable(".tableeeeee")){
        $(".tableeeeee").DataTable();
    }else {
        $('.tableeeeee').DataTable({
            "language": {
                "lengthMenu": "Mostrar _MENU_ registros por página.",
                "zeroRecords": "Ningún registro encontrado.",
                "info": "",
                "infoEmpty": "Ningún registro disponible.",
                "infoFiltered": "(filtered from _MAX_ total records)",
                "search": "                       ",
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
    btnshowAddRuta.click(function () {
        modalAddRuta.modal('show');
    });

    $(".calendario").datetimepicker({
        inline: false,
        sideBySide: true,
        format:'YYYY-MM-DD HH:mm:ss',
        locale: "es"
    });
    btdShearPoint.click(function () {
        var camion=parseInt(selectCamion.val());
        if(camion){
            var desde=inFechaInicio.val().replace(" ","T");
            var hasta=inFechaFin.val().replace(" ","T");
            if(desde!==""&&hasta!==""){
                makePost(
                    {
                        o:6,
                        c:camion,
                        d:desde,
                        h:hasta
                    }
                )
            }else {
                swal("Falta datos","Seleccione una fecha de inicio y de fin de busqueda","warning")
            }

        }else {
            swal("Falta datos","Seleccione un camión","warning")
        }
    })
    $("#btnActualizar").click(function () {
        makePost({o:7})
    })
});
$(document).on('click', "#btnGuardarRuta", function () {
    var idi=parseInt($("#lugarinicio").val());
    var idd=parseInt($("#lugardestino").val());
    if(idi&&idd){
        makePost({
            o:8,
            idi:idi,
            idd:idd,
            d:cordenadasDesplazamiento
        })
    }else{
        swal(
            "¡Alerta!",
            "Seleccione un lugar de inicio y destino",
            "warning"
        )
    }
});

$(document).on('click','div.eliminar', function() {
    var num=$(this).attr('num');
    $.each($(".paneles"), function()
    {
        if($(this).attr('num')===num)
        {
            $(this).hide();
        }
    })
});
$(document).on('click','.modalTxt', function() {
    $("#tableBodyAdd").empty();
    $("#file-input").val('');
    $("#modalEditRuta").modal('show');
    $("#btnUpdateRoute").attr('idr', $(this).attr('idr'));
    makePost({
        o:4,
        idr:$(this).attr('idr')
    })

});
$(document).on('click','#btnUpdateRoute', function() {
    makePost({
        o:5,
        d:cordenadas,
        idr: $(this).attr('idr')
    });

});

$("#modalAddLugar").on("shown.bs.modal", function () {
    google.maps.event.trigger(map2, "resize");
});
$("#modalAddRuta").on("shown.bs.modal", function () {
    google.maps.event.trigger(mapAddRuta, "resize");
    makePost({o:7})
});
function makePost(data){
    //$("#modalLoading").modal('show');
    $.ajax({
        async: true,
        type: "POST",
        dataType: "json",
        data: data,
        url:  $("#baseUrl").val()+"/lugar/index",
        success: function (data2) {
            $("#modalLoading").modal('hide');
            if(data2.data!==-1)
            {
                switch (data.o)
                {
                    case 4:
                        var html="";
                        agregarArrayCoordenadas(data2.data);
                        $.each(data2.data, function (k,v) {

                            html+="<tr><td>"+v.orden+"</td><td>"+v.latitud+"</td>" +
                                "<td>"+v.longitud+"</td>" +
                                "<td>" +
                                "<a href='#' class='btn btn-xs btn-info estado'>Mapa</a>" +
                                "</td></tr>";
                        })
                        $("#tableBodyAdd").empty().append(html);
                        if($.fn.dataTable.isDataTable("#editmapatable")){
                            $("#editmapatable").DataTable();
                        } else {
                            $('#editmapatable').DataTable({
                                "language": {
                                    "lengthMenu": "Mostrar _MENU_ registros por página.",
                                    "zeroRecords": "Ningún registro encontrado.",
                                    "info": "",
                                    "infoEmpty": "Ningún registro disponible.",
                                    "infoFiltered": "(filtered from _MAX_ total records)",
                                    "search": "                       ",
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
                        break;
                    case 5:
                        makePost({
                            o:4,
                            idr:data2.data
                        });
                        swal("Actualizado!","El registro de puntos ha sido actualizado correctamente","success");
                        break;
                    case 6:
                        agregarArrayDesplazamiento(data2.data);
                        break;
                    case 7:
                        var htmlLugares="<option>--Seleccione--</option>";
                        $.each(data2.data, function (k,v) {
                           htmlLugares +="<option value='"+v.idlugar+"'>"+v.nombre+"</option>";
                        });
                        $("#lugardestino").empty().append(htmlLugares);
                        $("#lugarinicio").empty().append(htmlLugares);
                        break;
                    case 8:
                        makePost({o:7});
                        break;
                }
            }
            else {
                swal("error","Algo fue mal, intentar nuevamente en unos segundos","error")
            }
        }
    });
}

function agregarArrayDesplazamiento(data) {

    var color ='#FFF';
    cordenadasDesplazamiento=[];
    setMapOnAllDesplazamiento();
    var orden=0,
        html="<table border='1' id='tablaCoordenadas'>" +
                "<thead>" +
                    "<tr>" +
                        "<th>Fecha</th>" +
                        "<th>Latitud</th>" +
                        "<th>Longitud</th>" +
                    "</tr>" +
                "</thead>" +
                "<tbody id='bodyTable'>";
    $.each(data, function (d, k) {
        orden++;
        color="#"+k.color;
        addMarketDes(k.latitud, k.longitud, orden+"" , color);
        cordenadasDesplazamiento.push({lat: parseFloat(k.latitud), lng: parseFloat(k.longitud)})
        html+=
            "<tr>" +
                "<td>"+orden+" "+k.fecha+"<input lt='"+k.latitud+"' lg='"+k.longitud+"' n='"+orden+"' type='checkbox' name='coordenadas' class='coordenadas' checked></td>" +
                "<td>"+k.latitud+"</td>"+
                "<td>"+k.longitud+"</td>"+
            "</tr>";
    });
    html+="</tbody>"+
    " </table>";
    $("#tablapuntos").empty().append(html);
    acPuntosMap();
    dibujarTrayecto(color);
}
$(document).on('change', '.coordenadas', function () {
   if(this.checked){
       markerDesplazamiento[parseInt($(this).attr('n'))-1].setMap(mapAddRuta);
       cordenadasDesplazamiento[parseInt($(this).attr('n'))-1]={lat: parseFloat($(this).attr('lt')), lng: parseFloat($(this).attr('lg'))};
   }
   else {
       markerDesplazamiento[parseInt($(this).attr('n'))-1].setMap(null);
       cordenadasDesplazamiento[parseInt($(this).attr('n'))-1]=null;
   }
    dibujarTrayecto(null);
});
function acPuntosMap() {

    $('#tablaCoordenadas').DataTable({
        "language": {
            "lengthMenu": "Mostrar _MENU_ registros por página.",
            "zeroRecords": "Ningún registro encontrado.",
            "info": "",
            "infoEmpty": "Ningún registro disponible.",
            "infoFiltered": "(filtered from _MAX_ total records)",
            "search": "                       ",
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
        },
        "pageLength": 10,
        "bSort": false
    });
}

function agregarArrayCoordenadas (data) {
    var color ='#FFF';
    cordenadas=[];
    setMapOnAll();
    $.each(data, function (d, k) {
        //color="#"+k.color;
        addMarketEdit(k.latitud, k.longitud, k.orden, color);
        cordenadas.push({lat: parseFloat(k.latitud), lng: parseFloat(k.longitud)})
    });
    dibujarRutaEdit(color);
}

function addMarketDes(latitud, longitud, title, color) {
    var myLatLng = {lat:parseFloat(latitud), lng: parseFloat(longitud)};
    var marker = new google.maps.Marker({
        position: myLatLng,
        label: {
            color: '#e8ebff',
            fontWeight: '900',
            text: title
        },
        map: mapAddRuta,
        title: title
    });
    /*
    google.maps.event.addListener(marker, 'drag', function()
    {
        geocodePosition(marker.getPosition(), color, marker.getTitle());
    });*/
    markerDesplazamiento.push(marker)
}

function addMarketEdit(latitud, longitud, title, color) {
    var myLatLng = {lat:parseFloat(latitud), lng: parseFloat(longitud)};
    var marker = new google.maps.Marker({
        position: myLatLng,
        draggable:true,
        label: {
            color: '#2f60ff',
            fontWeight: '900',
            text: title
        },
        map: map2,
        title: title
    });
    google.maps.event.addListener(marker, 'drag', function()
    {
        geocodePosition(marker.getPosition(), color, marker.getTitle());
    });
    markerEdit.push(marker)
}
// Sets the map on all markers in the array.
function setMapOnAll() {
    for (var i = 0; i < markerEdit.length; i++) {
        markerEdit[i].setMap(null);
    }
    markerEdit=[]
}
function setMapOnAllDesplazamiento() {
    for (var i = 0; i < markerDesplazamiento.length; i++) {
        markerDesplazamiento[i].setMap(null);
    }
    markerDesplazamiento=[]
}

function geocodePosition(pos, color, title){
    $("#btnUpdateRoute").show();
    var i=1;
    var position=parseInt(title);
    $.each(cordenadas, function (k, v) {
        if(i===position)
            cordenadas[i-1]={lat: pos.lat(), lng: pos.lng()};
        i++;
    });
    dibujarRutaEdit(color);
}
function dibujarRutaEdit(color) {
    if (typeof flightPath !== "undefined") {
        flightPath.setMap(null);
    }
    flightPath = new google.maps.Polyline({
        path: cordenadas,
        geodesic: true,
        strokeColor: color,
        strokeOpacity: 1.0,
        strokeWeight: 4
    });
    flightPath.setMap(map2);
}
function dibujarTrayecto(color) {
    if (typeof polilyneRecorrido !== "undefined") {
        polilyneRecorrido.setMap(null);
    }
    var newCord=[];
    for (var j=0; j<cordenadasDesplazamiento.length; j++){
        if(cordenadasDesplazamiento[j]!=null)
            newCord.push(cordenadasDesplazamiento[j]);
    }
    polilyneRecorrido = new google.maps.Polyline({
        path: newCord,
        geodesic: true,
        strokeColor: "#85aeff",
        strokeOpacity: 1.0,
        strokeWeight: 4
    });
    polilyneRecorrido.setMap(mapAddRuta);
}
