/**
 * Created by hbs on 18/08/16.
 */
var base='';
var palas=[];
var placaseleccionada=0;
var idcamion;
var idpala;
var tipo;
var fdesdeDatepicker=0;
var fhastaDatepicker=0;
var tipovalor=1;
$(document).ready(function() {
    base=$("#baseUrl").val();
    tipo=$('input[type=radio][name=tUnidad]');
    tipo.change(function() {
        if (this.value == '1') {
            $("#divPalas").show();
            $("#divCamiones").hide();
            tipovalor=1;
            makePost({
                o:1,
                t:tipo.val(),
                p:idpala.val(),
                fi:fdesdeDatepicker.val(),
                ff:fhastaDatepicker.val()
            })
        }
        else if (this.value == '2') {

            $("#divPalas").hide();
            $("#divCamiones").show();
            tipovalor=2;
            makePost({
                o:1,
                t:tipo.val(),
                p:idcamion.val(),
                fi:fdesdeDatepicker.val(),
                ff:fhastaDatepicker.val()
            })
        }
        preparaLinkDesplazamiento();

    });
    fdesdeDatepicker=$("#fDesde");
    fhastaDatepicker=$("#fHasta");
    idpala=$("#palas");
    idcamion=$("#camiones");
    placaseleccionada=idpala.val();
    var dateNow=$.date(new Date());
    var dateNowArray=dateNow.split("-");
    var month=0;
    var year=0;
    if(dateNowArray[1]==="1") {
        year= dateNow[0] - 1;
        month= 12;
        dateNow = year + "-" + month + "-" + dateNowArray[2];
    }
    else{
        month=dateNowArray[1]-1;
        year=dateNowArray[0];
        dateNow=dateNowArray[0]+"-"+month+"-"+dateNowArray[2];
    }
    if (!validar(dateNow)) {
        var day=dateNowArray[2] - 1;
        if(month<10)
            month='0'+month;
        dateNow = year + "-" + month + "-" + day;

        if (!validar(dateNow)) {
            day=dateNowArray[2] - 2;

            dateNow = year + "-" + month + "-" + day;
            if (!validar(dateNow)) {
                day=dateNowArray[2] - 3;
                dateNow = year + "-" + month + "-" + day;
            }
        }
    }
    fdesdeDatepicker.datetimepicker({
        inline: false,
        sideBySide: true,
        format:'YYYY-MM-DD HH:mm:ss',
        stepping: 5,
        locale: "es"
    }).val(dateNow+" 12:00:00");

    fhastaDatepicker.datetimepicker({
        inline: false,
        sideBySide: true,
        format:'YYYY-MM-DD HH:mm:ss',
        stepping: 5,
        locale: "es"
    }).val($.date(new Date())+" 12:00:00");
    fdesdeDatepicker.on('dp.change', function(e){
        console.log(e)
        preparaLinkDesplazamiento();
        if(tipovalor=="1")
            makePost({
                o:1,
                t:tipo.val(),
                p:idpala.val(),
                fi:fdesdeDatepicker.val(),
                ff:fhastaDatepicker.val()
            });
        else {
            makePost({
                o:1,
                t:tipo.val(),
                p:idcamion.val(),
                fi:fdesdeDatepicker.val(),
                ff:fhastaDatepicker.val()
            })
        }
    });
    fhastaDatepicker.on('dp.change', function(e){
        preparaLinkDesplazamiento();
        if(tipovalor=="1")
            makePost({
                o:1,
                t:tipo.val(),
                p:idpala.val(),
                fi:fdesdeDatepicker.val(),
                ff:fhastaDatepicker.val()
            });
        else {
            makePost({
                o:1,
                t:tipo.val(),
                p:idcamion.val(),
                fi:fdesdeDatepicker.val(),
                ff:fhastaDatepicker.val()
            })
        }
    });
    makePost({
        o:1,
        t:tipo.val(),
        p:placaseleccionada,
        fi:fdesdeDatepicker.val(),
        ff:fhastaDatepicker.val()
    })
    idcamion.change(function () {
        makePost({
            o:1,
            t:tipo.val(),
            p:$(this).val(),
            fi:fdesdeDatepicker.val(),
            ff:fhastaDatepicker.val()
        })
        preparaLinkDesplazamiento();

    });
    idpala.change(function () {
        makePost({
            o:1,
            t:tipo.val(),
            p:$(this).val(),
            fi:fdesdeDatepicker.val(),
            ff:fhastaDatepicker.val()
        })
        preparaLinkDesplazamiento();

    });
    preparaLinkDesplazamiento();

});

function preparaLinkDesplazamiento() {
    var btnDesplazamiento=$("#bDesplzamiento");
    var idunidad=0;
    if(tipovalor===1)
    {
        idunidad=idpala.val();
    }else {
        idunidad=idcamion.val();
    }

    btnDesplazamiento.attr('href',
        base+"/reporte/desplazamiento/"+idunidad+"/"+fdesdeDatepicker.val()
        .replace('-','a').replace('-','a').replace(' ','a').replace(':','a').replace(':','a')+"a"
        +fhastaDatepicker.val().replace('-','a').replace('-','a').replace(' ','a').replace(':','a').replace(':','a'));
}
function makePost(data) {
    var modalLoading=$("#modalLoading");
    modalLoading.modal("show");
    $.ajax({
        async: true,
        type: "POST",
        dataType: "json",
        data: data,
        url: base+"/reporte/ubicaciones",
        success: function (datar) {
            if(datar.data===-1)
            {
                modalLoading.modal("hide");
                swal("Error!", "error al intentar realizar la operación, mensaje: ", "error");
                alert(datar.m.xdebug_message)
            }
            else
            {
                switch (data.o)
                {
                    case 1:
                        var html="";
                        var n=0;
                        $.each(datar.data, function (k,v) {
                            n++;
                            html+="<tr><td>"+n+"</td><td>"+v.latitud+"</td>" +
                                "<td>"+v.longitud+"</td>" +
                                "<td>"+v.fecha+"</td>" +
                                "<td>" +
                                "<a href='#' class='btn btn-xs btn-info mapa' lt='"+v.latitud+"' lg='"+v.longitud+"'><span class='fa fa-map-marker'></span></a>" +
                                "</td></tr>";
                        });
                        $("#tablaUbicaciones").remove();
                        $("#tablaUbicaciones_wrapper").remove();
                        $("#divTable").append(
                            '<table id="tablaUbicaciones" class="table table-striped table-bordered table-hover dataTable no-footer dtr-inline">' +
                            '<thead>' +
                            '<tr role="row">' +
                            '<td>Nº</td>' +
                            '<td>Latitud</td>' +
                            '<td>Longitud</td>' +
                            '<td>Fec. Registro</td>' +
                            '<td>opción</td>' +
                            '</tr>' +
                            '</thead>' +
                            '<tbody id="tableBodyAdd">' +
                            '</tbody>' +
                            '</table>'
                        );
                        $("#tableBodyAdd").append(html);
                        if($.fn.dataTable.isDataTable("#tablaUbicaciones")){
                            $("#tablaUbicaciones").DataTable();
                        } else {
                            $('#tablaUbicaciones').DataTable({
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
                        modalLoading.modal('hide');
                    break;
                }
            }
        }
    });
}

$.date = function(dateObject) {
    var d = new Date(dateObject);
    var day = d.getDate();
    var month = d.getMonth() + 1;
    var year = d.getFullYear();
    if (day < 10) {
        day = "0" + day;
    }
    if (month < 10) {
        month = "0" + month;
    }
    return year+"-" +month + "-" + day;
};

function validar(text) {
    text=text+"";
    var comp = text.split('-');
    var m = parseInt(comp[1], 10);
    var d = parseInt(comp[2], 10);
    var y = parseInt(comp[0], 10);
    var date = new Date(y,m-1,d);
    return date.getFullYear() === y && date.getMonth() + 1 === m && date.getDate() === d;
}

var marker =null;
$(document).on('click', '.mapa', function () {

    var latitud=$(this).attr('lt');
    var longitud=$(this).attr('lg');
    if(marker!==null)
        marker.setMap(null);

    map.setCenter(new google.maps.LatLng(latitud, longitud));
    //map.setMapTypeId(google.maps.MapTypeId.ROADMAP);
    map.setCenter(new google.maps.LatLng(latitud, longitud));
    map.setZoom(22);

    $("#MapaPunto").modal('show');
    marker = new google.maps.Marker({
        position:  {
            lat:parseFloat(latitud),
            lng:parseFloat(longitud)
        },
        map: map,
        title:"Punto"
    });
});