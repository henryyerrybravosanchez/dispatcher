//creado por Henry Bravo 02/11/2017 call to: 976379726
$(document).ready(function () {
    var map;
    var markers=[], markerClick={}, windowInfo=[];
    var unidadDisponiblesArray=[];//guadará un taxi con todos sus atributos


    function addPlaceMarker(lugar) {
        var image = {
            url: 'https://developers.google.com/maps/documentation/javascript/examples/full/images/beachflag.png',
            // This marker is 20 pixels wide by 32 pixels high.
            size: new google.maps.Size(40, 32),
            // The origin for this image is (0, 0).
            origin: new google.maps.Point(0, 0),
            // The anchor for this image is the base of the flagpole at (0, 32).
            anchor: new google.maps.Point(0, 32)
        };

        var myLatLng = {lat:parseFloat(lugar.latitud), lng: parseFloat(lugar.longitud)};
        var marker = new google.maps.Marker({
            position: myLatLng,
            map: map,
            icon: image,

            label: {
                color: '#6bff9e',
                fontWeight: '900',
                text:lugar.nombre,
            },
            title: lugar.nombre
        });
    }
    function addMarket(unidad, tipo) {

        unidadDisponiblesArray[unidad.idunidad]=(unidad);
        var myLatLng = {lat:parseFloat(unidad.latitud), lng: parseFloat(unidad.longitud)};
        var iconBase;
        if(tipo===1)
            iconBase = base+ "/public/img/volquete.png";
        if(tipo===2)
            iconBase = base+ "/public/img/pala.png";
        var marker = new google.maps.Marker({
            position: myLatLng,
            map: map,
            label: {
                color: '#6bff9e',
                fontWeight: '900',
                text: unidad.placa,
            },
            icon: iconBase,
            title: unidad.placa
        });
        if(typeof markerClick[unidad.idunidad] === 'undefined'){

            markerClick[unidad.idunidad]=false;
        }
        markers[unidad.idunidad]=(marker);
        marker.addListener('click', function() {
            for (key in markerClick) {
                if(markerClick[key])
                    markerClick[key]=false;
            }
            markerClick[unidad.idunidad]=true;
        });
        for (var i = 0; i  <windowInfo.length; i++) {
            // Iterate over numeric indexes from 0 to 5, as everyone expects.
            windowInfo[i].close();
            windowInfo.splice(i, 1);
        }
        for (key in markerClick) {
            var m = markers[key];
            if(markerClick[key]){
                var u =unidadDisponiblesArray[key]
                var infowindow = new google.maps.InfoWindow({
                    content: "<div><label>Placa: "+u.placa+"</label><br><label>Incio: inicio</label><br><label>Destino: destino</label></div>"
                });
                windowInfo.push(infowindow);
                infowindow.open(map, m);
                google.maps.event.addListener(infowindow,'closeclick',function(){
                    for (key in markerClick) {
                        markerClick[key]=false;
                    }
                });
            }
        }
    }
    function agregarArrayRutas(data) {
        var flightPlanCoordinates = [ ];
        var color="#";
        $.each(data, function (d, k) {
            flightPlanCoordinates.push({lat: parseFloat(k.latitud), lng: parseFloat(k.longitud)})
            color="#"+k.color;
        });
        dibujarRuta(flightPlanCoordinates,color)
    }
    function dibujarRuta(flightPlanCoordinates, color) {
        var flightPath = new google.maps.Polyline({
            path: flightPlanCoordinates,
            geodesic: true,
            strokeColor: color,
            strokeOpacity: 1.0,
            strokeWeight: 4
        });
        flightPath.setMap(map);
    }
    function setMapOnAll(map) {

        for (key in markers) {

            var marker = markers[key];
            marker.setMap(map);
        }
        markers=[];
    }

    function traerDisponibles(data)
    {

        $.ajax({
            async: true,
            type: "POST",
            dataType: "json",
            data: data,
            url:  $("#baseUrl").val()+"/unidad/index",
            success: function (data2) {
                setMapOnAll();
                if(data2.data!=-1)
                {
                    $.each(data2.data, function (d, k) {
                        if(k.latitud && k.longitud)
                            addMarket(k,1);
                    })
                    $.each(data2.datapalas, function (d, k) {

                        if(k.latitud && k.longitud)
                            addMarket(k,2);
                    })

                }
                else {
                    if(data.o!=2)
                        alert("Algo fue mal, intentar nuevamente en unos segundos")

                }
            }

        });
    }
    function traerRoutes(data)
    {
        $.ajax({
            async: true,
            type: "POST",
            dataType: "json",
            data: data,
            url:  $("#baseUrl").val()+"/unidad/index",
            success: function (data2) {
                setMapOnAll();
                if(data2.data!=-1)
                {
                    $.each(data2.data, function (k, v) {
                        agregarArrayRutas(v);
                    })
                    $.each(data2.lugares, function (k,v) {
                        addPlaceMarker(v)
                    })

                }
                else {
                    if(data.o!=2)
                        alert("Algo fue mal, intentar nuevamente en unos segundos")

                }
            }

        });
    }

    function maximizar(){
        window.moveTo(0,0);
        window.resizeTo(screen.width,screen.height);
    }
});
