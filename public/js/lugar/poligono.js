/**
 * Created by hbs on 18/08/16.
 */
var base='', btnShowModalAddPoli, btnGuardarP;
$(document).ready(function() {
    btnShowModalAddPoli=$("#btnAddP");
    btnGuardarP=$("#btnGuardarP");

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

    btnShowModalAddPoli.click(function () {
        $("#modalAddPoligono").modal('show');
    });
    btnGuardarP.click(function () {
        if(flightPlanCoordinates.length>3){
            makePost({
                o:1,
                d:flightPlanCoordinates,
                co:$("#nColor").val(),
                np:$("#nText").val()
            });
        }
    })
});

$(document).on('click', '.mapa', function () {
    makePost({
        o:2,
        idl:$(this).attr('idl')
    });
});

function makePost(data){
    $.ajax({
        async: true,
        type: "POST",
        dataType: "json",
        data: data,
        url:  $("#baseUrl").val()+"/lugar/poligono",
        success: function (data2) {
            $("#modalLoading").modal('hide');
            if(data2.data!==-1)
            {
                switch (data.o)
                {
                    case 1:
                        break;
                    case 2:
                        agregarArrayPoligonos(data2.data);
                        break;
                }
            }
            else {
                swal("error","Algo fue mal, intentar nuevamente en unos segundos","error")
            }
        }
    });
}
var poligonosArray=[];
function agregarArrayPoligonos(data) {
    poligonosArray=[];
    var color="";
    $.each(data, function (d, k) {
        poligonosArray.push({lat: parseFloat(k.latitud), lng: parseFloat(k.longitud)});
        color=k.color;
    });
    dibujarPoligonos("#"+color);
}

var infoWindow;
function showArrays(event) {
    // Since this polygon has only one path, we can call getPath() to return the
    // MVCArray of LatLngs.
    var vertices = this.getPath();

    var contentString = '<b>Polígono uno</b><br>' +
        'Clicked location: <br>' + event.latLng.lat() + ',' + event.latLng.lng() +
        '<br>';

    // Iterate over the vertices.
    for (var i =0; i < vertices.getLength(); i++) {
        var xy = vertices.getAt(i);
        contentString += '<br>' + 'Coordinate ' + i + ':<br>' + xy.lat() + ',' +
            xy.lng();
    }

    // Replace the info window's content and position.
    infoWindow.setContent(contentString);
    infoWindow.setPosition(event.latLng);

    infoWindow.open(map);
}
function dibujarPoligonos(color) {
    var flightPath = new google.maps.Polygon({
        path: poligonosArray,
        geodesic: true,
        strokeColor: color,
        strokeOpacity: 1.0,//opacidad de contorno
        fillColor: color,
        fillOpacity: 1,//Opacidad de relleno
        strokeWeight: 4
        });
    flightPath.setMap(map);
    flightPath.addListener('click', showArrays);
    infoWindow = new google.maps.InfoWindow;
}
