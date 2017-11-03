
$(function(){
    $(window).load(function(){
        var Ubicaciones=[];
        var markers=[];
        var infoWindows=[];
        for (var i=0; i<aLat.length; i++)
        {
            Ubicaciones.push(
                {
                    lat:parseFloat(aLat[i]),
                    lng:parseFloat(aLgt[i])
                }
            );

            var contentString = '<div id="content">'+
                '<div id="siteNotice">'+
                '</div>'+
                '<h1 id="firstHeading" class="firstHeading">Fecha de registro</h1>'+
                '<div id="bodyContent">'+
                '<p class="nojodas"><b>'+aDate[i]+'</b></p>'+
                '</div>'+
                '</div>';
            var infowindow = new google.maps.InfoWindow({
                content: contentString
            });

            var marker = new google.maps.Marker({
                position:  {
                    lat:parseFloat(aLat[i]),
                    lng:parseFloat(aLgt[i])
                },
                map: map,
                title: aDate[i]
            });
            infoWindows.push(infowindow);
            markers.push(marker);

            /*markers[i].addListener('click', function() {
                infoWindows[i].open(map, markers[j]);
            });*/
            map.setCenter({
                lat:parseFloat(aLat[i]),
                lng:parseFloat(aLgt[i])
            });
            map.setZoom(22);
            google.maps.event.trigger(map, "resize");

        }
        var flightPath = new google.maps.Polyline({
            path: Ubicaciones,
            geodesic: true,
            strokeColor: '#5bc1ff',
            strokeOpacity: 1.0,
            strokeWeight: 2
        });

        flightPath.setMap(map);
        console.log(Ubicaciones)
    });
});