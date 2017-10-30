/**
 * Created by hbs on 18/08/16.
 */
var base='';
var materiales=[];
$(document).ready(function() {

    base=$("#baseUrl").val();
    var dateNow=$.date(new Date());
    var dateNowArray=dateNow.split("-");
    var month=0;
    var year=0;
    var fdesdeDatepicker=$("#fechadesde");
    var fhastaDatepicker=$("#fechahasta");
    var fdesdeDatepickerR=$("#fechadesdeR");
    var fhastaDatepickerR=$("#fechahastaR");
    var idmaterial=$("#material");

    $.each($('.material'), function () {
       materiales[$(this).val()]=$(this).text();
    });
    //console.log(materiales)
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
    fdesdeDatepickerR.datetimepicker({
        inline: false,
        sideBySide: true,
        format:'YYYY-MM-DD',
        stepping: 5,
        locale: "es"
    }).val(dateNow);

    fhastaDatepickerR.datetimepicker({
        inline: false,
        sideBySide: true,
        format:'YYYY-MM-DD',
        stepping: 5,
        locale: "es"
    }).val($.date(new Date()));

    fdesdeDatepicker.datetimepicker({
        inline: false,
        sideBySide: true,
        format:'YYYY-MM-DD',
        stepping: 5,
        locale: "es"
    }).val(dateNow);

    fhastaDatepicker.datetimepicker({
        inline: false,
        sideBySide: true,
        format:'YYYY-MM-DD',
        stepping: 5,
        locale: "es"
    }).val($.date(new Date()));

    fdesdeDatepicker.on('dp.change', function(e){
        if(validarFechas(fdesdeDatepicker.val(),fhastaDatepicker.val())){
            makePost({
                o:1,
                fi:fdesdeDatepicker.val(),
                ff:fhastaDatepicker.val(),
                idm:idmaterial.val()
            })
        }
        else {
            swal("Lo sentimos!", "El intervalo de fechas no es correo, coleque una fecha superior que la primera", "error");

        }
    });
    fhastaDatepicker.on('dp.change', function(e){
        if(validarFechas(fdesdeDatepicker.val(),fhastaDatepicker.val())){
            makePost({
                o:1,
                fi:fdesdeDatepicker.val(),
                ff:fhastaDatepicker.val(),
                idm:idmaterial.val()

            })
        }
        else {
            swal("Lo sentimos!", "El intervalo de fechas no es correo, coleque una fecha superior que la primera", "error");

        }

    });
    fdesdeDatepickerR.on('dp.change', function(e){
        if(validarFechas(fdesdeDatepicker.val(),fhastaDatepicker.val())){
            makePost({
                o:2,
                fi:fdesdeDatepickerR.val(),
                ff:fhastaDatepickerR.val()
            })
        }
        else {
            swal("Lo sentimos!", "El intervalo de fechas no es correo, coleque una fecha superior que la primera", "error");

        }
    });
    fhastaDatepickerR.on('dp.change', function(e){
        if(validarFechas(fdesdeDatepicker.val(),fhastaDatepicker.val())){
            makePost({
                o:2,
                fi:fdesdeDatepickerR.val(),
                ff:fhastaDatepickerR.val()

            })
        }
        else {
            swal("Lo sentimos!", "El intervalo de fechas no es correo, coleque una fecha superior que la primera", "error");

        }

    });

    idmaterial.change(function () {
        makePost({
            o:1,
            fi:fdesdeDatepicker.val(),
            ff:fhastaDatepicker.val(),
            idm:idmaterial.val()
        })
    });

    makePost({
        o:1,
        fi:fdesdeDatepicker.val(),
        ff:fhastaDatepicker.val(),
        idm:idmaterial.val()
    });
    makePost({
        o:2,
        fi:fdesdeDatepickerR.val(),
        ff:fhastaDatepickerR.val()
    });
});
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
};//Convierte Date en String yyyy-mm-dd

function validar(text) {
    text=text+"";
    var comp = text.split('-');
    var m = parseInt(comp[1], 10);
    var d = parseInt(comp[2], 10);
    var y = parseInt(comp[0], 10);
    var date = new Date(y,m-1,d);
    return date.getFullYear() === y && date.getMonth() + 1 === m && date.getDate() === d;
}
function validarFechas(fechaI, fechaF) {

    var splitIniDsd=fechaI.split('-');
    var splitIniHst=fechaF.split('-');
    //var boolean=false;
    if(parseInt(splitIniDsd[0])===parseInt(splitIniHst[0]))
    {
        if(parseInt(splitIniDsd[1])<parseInt(splitIniHst[1]))
        {
            return true;
        }
        if(parseInt(splitIniDsd[1])>parseInt(splitIniHst[1]))
        {
            return false;
        }
        if(parseInt(splitIniDsd[1])===parseInt(splitIniHst[1]))
            return parseInt(splitIniDsd[2])<parseInt(splitIniHst[2]);
    }
    return parseInt(splitIniDsd[0])<parseInt(splitIniHst[0]);
}

function actualizarCargasCanvas(labels, data) {
    $('#myChart').remove(); // this is my <canvas> element
    $('#conteinerCanvas').append(' <canvas id="myChart" width="100" height="100"></canvas>');
    var ctx = document.getElementById("myChart").getContext('2d');
    var idmaterial=$("#material");
    var text= '# de cargas';
    if(idmaterial.val()>0)
        text= '# de cargas de '+$("#material option:selected").text();
    var myChart = new Chart(ctx, {
        type: 'line',
        data: {
            labels: labels,
            datasets: [{
                label: text,
                data: data,
                backgroundColor: [
                    '#19B5FE'
                ],
                borderColor: [
                    '#b0f0ff'
                ],
                borderWidth: 1
            }]
        },
        options: {
            scales: {
                yAxes: [{
                    ticks: {
                        beginAtZero:true
                    }
                }]
            }
        }
    });
}
function actualizarCargasRadar(labels, data) {
    $('#myChartRadar').remove(); // this is my <canvas> element
    $('#conteinerCanvasRadar').append(' <canvas id="myChartRadar" width="100" height="100"></canvas>');
    var ctx = document.getElementById("myChartRadar").getContext('2d');
    var myChart = new Chart(ctx, {
        type: 'polarArea',
        data: {
            labels: labels,
            datasets: [{
                label: "",
                data: data,
                backgroundColor: [
                    '#19B5FE',
                    'rgba(240, 100, 0, 0.4)',
                    'rgba(255, 0, 255, 0.2)',
                ],
                borderColor: [
                    '#b0f0ff'
                ],
                borderWidth: 1
            }]
        },
        options: {
            animateRotate: true
        }
    });
}

function makePost(data) {
    var modalLoading=$("#modalLoading");
    modalLoading.modal("show");
    $.ajax({
        async: true,
        type: "POST",
        dataType: "json",
        data: data,
        url: base+"/reporte/cargas",
        success: function (datar) {
            if(datar.data===-1)
            {
                modalLoading.modal("hide");
                swal("Error!", "error al intentar realizar la operación, mensaje: ", "error");
                alert(datar.m.xdebug_message)
            }
            else
                switch (data.o)
                {
                    case 1:
                        var cargas=datar.data;
                        var fechadesde=data.fi;
                        var fechafin=data.ff;
                        var arrayDataCantidades=[];
                        var arrayLabelsFechas=[];
                        while (fechadesde!==fechafin)
                        {
                            arrayLabelsFechas.push(fechadesde);
                            var fDarr=fechadesde.split('-');
                            var bandera=false;
                            $.each(cargas, function (k,v) {
                                if(parseInt(v.anio)===parseInt(fDarr[0])&&parseInt(v.mes)===parseInt(fDarr[1])&&parseInt(v.dia)===parseInt(fDarr[2]))
                                {
                                    arrayDataCantidades.push(v.cantidad);
                                    bandera=true;
                                }
                            });
                            if(!bandera)
                            {
                                arrayDataCantidades.push(0);
                            }
                            var anio=fDarr[0];
                            var mes=parseInt(fDarr[1]);
                            var dia=parseInt(fDarr[2])+1;
                            if(dia<10)
                                dia='0'+dia;
                            if(mes<10)
                                mes='0'+mes;
                            if(validar(anio+"-"+mes+"-"+dia))
                            {
                                fechadesde=anio+"-"+mes+"-"+dia;
                            }else{
                                if(fDarr[1]==='12')
                                {
                                    mes=1;
                                    anio=parseInt(fDarr[0])+1;
                                }else{
                                    mes=parseInt(fDarr[1])+1;
                                    anio=fDarr[0];
                                }
                                dia=1;
                                if(mes<10)
                                    mes='0'+mes;
                                if(dia<10)
                                    dia='0'+dia;
                                fechadesde=anio+"-"+mes+"-"+dia;
                            }
                        }
                        arrayLabelsFechas.push(fechadesde);
                        fDarr=fechadesde.split('-');
                        if(fechadesde===fechafin)
                        {
                            var bande=false;
                            $.each(cargas, function (k,v) {
                                if(parseInt(v.anio)===parseInt(fDarr[0])&&parseInt(v.mes)===parseInt(fDarr[1])&&parseInt(v.dia)===parseInt(fDarr[2]))
                                {
                                    arrayDataCantidades.push(v.cantidad);
                                    bande=true;
                                }
                            });
                            if(!bande)
                            {
                                arrayDataCantidades.push(0);
                            }
                        }
                        actualizarCargasCanvas(arrayLabelsFechas,arrayDataCantidades);
                        modalLoading.modal('hide');
                        break;
                    case 2:
                        var cargas=datar.data;
                        var labelesArray=[];
                        var dataArray=[];
                        $.each(cargas, function (k, v) {
                            labelesArray.push(v.nombre);
                            dataArray.push(v.cantidad)
                        });
                        actualizarCargasRadar(labelesArray, dataArray);
                        modalLoading.modal('hide');
                        break;

                }
        }

    });
}