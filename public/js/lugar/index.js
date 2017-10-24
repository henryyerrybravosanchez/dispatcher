/**
 * Created by hbs on 18/08/16.
 */
var base='';
var cordenadas=[], markerEdit=[];
var flightPath;
$(document).ready(function() {

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
    $("#modalAddLugar").modal('show');
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
function makePost(data){
    $("#modalLoading").modal('show');
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
                }
            }
            else {
                swal("error","Algo fue mal, intentar nuevamente en unos segundos","error")
            }
        }
    });
}

function agregarArrayCoordenadas(data) {
    var color ='#FFF';
    cordenadas=[];
    setMapOnAll();
    $.each(data, function (d, k) {
        color="#"+k.color;
        addMarketEdit(k.latitud, k.longitud, k.orden, color);
        cordenadas.push({lat: parseFloat(k.latitud), lng: parseFloat(k.longitud)})
    });
    dibujarRutaEdit(color);
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
