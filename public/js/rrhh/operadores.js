/**
 * Created by hbs on 18/08/16.
 */
var base='', urlimges;
var idcoSe=0;
var nombres="", ap="", am="", dni="", telefono="", direccion="", user="", password="", estado="";
var nombresE="", apE="", amE="", dniE="", telefonoE="", direccionE="", userE="", passwordE="", estadoE="";
var inputKey="";//Elementos que escucharan al evento KeyUp
$(document).ready(function() {
    base=$("#baseUrl").val();
    urlimges=base+"/public/files/server/php/files/";

    convertTable("table-operadores");

    $(".calendar").datetimepicker({
        inline: false,
        sideBySide: true,
        format:'YYYY-MM-DD HH:mm:ss',
        stepping: 5,
        locale: "es"
    });
    nombres=$("#nombres");
    ap=$("#ap");
    am=$("#am");
    dni=$("#dni");
    telefono=$("#telefono");
    direccion=$("#direccion");
    user=$("#usuario");
    password=$("#contrasena");
    nombresE=$("#nombresE");
    apE=$("#apE");
    amE=$("#amE");
    dniE=$("#dniE");
    telefonoE=$("#telefonoE");
    direccionE=$("#direccionE");
    userE=$("#usuarioE");
    passwordE=$("#contrasenaE");
    estadoE=$('input[name=estadooperador]:checked').val();

    inputKey=$(".inputtext");
    //Events elements
    dni.keyup(function() {
        var d=parseInt(dni.val());
        if(isNaN(d))
        {
            dni.val("");
        }
        else {
            dni.val(d);
        }
        user.val($(this).val());
        password.val($(this).val());
    });
    inputKey.keyup(function (e) {

        var code = (e.keyCode ? e.keyCode : e.which);
        var tab=parseInt($(this).attr('e'));
        //   alert(code)
        if (code===13) {
            tab=tab+1;
        }
        if(code===38){
            tab=tab-1;
        }
        inputKey.each(function() {
            var t=parseInt($(this).attr('e'))
            if(t===tab){
                $(this).focus();
            }
        })
    });
    //FileUpload
    'use strict';
    // Metodo para subir la imagen al servidor
    $('#fileupload').fileupload({
        // Uncomment the following to send cross-domain cookies:
        //xhrFields: {withCredentials: true},
        url: base+'/public/files/server/php/'
    }).on('fileuploadadd', function (e, data) {
      // console.log('fileuploadadd')
    }).on('fileuploadprocessalways', function (e, data) {
      //  console.log('fileuploadprocessalways')

    }).on('fileuploadprogressall', function (e, data) {

    }).on('fileuploaddone', function (e, data) {
        $.each(data.result.files, function (index, file) {
            makePost({
                o:8,
                idc :idcoSe,
                f:file.name
            });
            $(".btnsubir").attr('disabled', true);
        });

    }).on('fileuploadfail', function (e, data) {
      //  console.log('fileuploadfail')

    }).prop('disabled', !$.support.fileInput)
        .parent().addClass($.support.fileInput ? undefined : 'disabled');
});
//Popover al pasar el mouse por la imagen
$('a[rel=popover]').popover({
    html: true,
    trigger: 'hover',
    placement: 'right',
    content: function(){return '<img width="200" src="'+$(this).data('img') + '" />';}
});
//Cuando cambia la seleccion del Select para que se actualice las placas segun lo seleccionado
$('input[name=tipounidad]').on('change', function(e) {
    makePost(
        {
            o:4,
            t:$(this).val()
        }
    )
});
//Funcion para mostrar el modal de agregar colaborador luego de precionar las teclas N+C
var codigoteclaanteriror=0;
$(document).keypress(function(e) {
    var code = (e.keyCode ? e.keyCode : e.which);

    if(code===99&&codigoteclaanteriror===110){
        $("#modalAddOperador").modal('show');
    }
    codigoteclaanteriror=code;
});
//MEtodo para centralizar las peticiones GET, DELETE para los archivos de fotos: API de JQUERY UPLOAD FILE
function makePostFile(data) {
    $.ajax({
        async: true,
        type: data.type,
        dataType: "json",
        data: data,
        url: data.url,
        success: function (datar) {
            switch (data.type){
                //Actualizamos el modal de agregar foto con la foto del colaborador seleccionado
                case "GET":
                    if((datar.file)!==null){
                        var bytes=parseInt(datar.file.size);
                        var mega=(bytes*(9.537)*(1/10000000)).toFixed(2);
                        var kbs=(bytes*0.000977).toFixed(2);
                        $("#imgPreview")
                            .attr('src', datar.file.thumbnailUrl);

                        $("#imgOtherW")
                            .attr('src', datar.file.url)
                            .attr('href', datar.file.url);

                        $("#btnEliminar")
                            .attr('url', datar.file.deleteUrl)
                            .attr('ni', datar.file.name);

                        $("#imgDownload")
                            .attr('href', datar.file.url)
                            .attr('download', datar.file.name)
                            .attr('title', datar.file.name);

                        $("#size").empty().append(mega+ "MB / "+kbs+"KB");
                    }
                    else{
                        swal("Lo sentimos!", "La imagen no ha sido encontrada, actualizaremos la base de datos inmediatamente...", "error");
                        makePost({
                            o:8,
                            idc :idcoSe,
                            f:null
                        });
                        $(".imgShowModal").hide();
                        $(".btnsubir").attr('disabled', false);
                    }

                    break;
                //Actualizamos el modal de agregar foto luego de eliminar la foto del colaborador
                case "DELETE":
                    if(datar[data.ni]){
                        $(".imgShowModal").hide();
                        $(".btnsubir").attr('disabled', false);
                        makePost({
                            o:8,
                            idc :idcoSe,
                            f:null
                        });
                    } else {
                        swal("Lo sentimos!", "Algo no anda bien, vuelva a intentarlo en unos minutos, pruebe su conexión", "error");
                    }
                    break;
            }
        }
    });
}
//Metodo para centralizar los post que se hacen al controlador
function makePost(data) {
    var modalLoading=$("#modalLoading");
    modalLoading.modal("show");
    $.ajax({
        async: true,
        type: "POST",
        dataType: "json",
        data: data,
        url: base+"/rrhh/operador",
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
                    //Traemos todas las asginaciones de un colaborador seleccionado
                    case 1:
                        var html="";
                        var tablavolquetes=$("#volquetes");
                        tablavolquetes.hide();
                        var tablapalas=$("#palas");
                        var mjnopalas=$("#nopalas");
                        var mjnovolquetes=$("#novolquetes");
                        tablapalas.hide();
                        mjnopalas.show();
                        mjnovolquetes.show();
                        $.each(datar.data.datavolquetes , function (k, v) {//cargamos los volquetes que habn sido operados por el colaborador "n"
                            tablavolquetes.show();
                            mjnovolquetes.hide();
                            console.log(mjnovolquetes)
                            var fechafin="No definido", fechai="", fechaf="";

                            if(v.fechafin!==null){
                                fechafin=v.fechafin;
                                fechaf=v.fechafin.toString().replace(" ", "|");
                            }
                            else {
                                fechaf=0;
                            }
                            if(v.fechainicio!==null){
                                fechai=v.fechainicio.toString().replace(" ", "|");
                            }
                            else {
                                fechai=0;
                            }
                            html+='<tr>' +
                                '<td>'+v.placa+' </td>' +
                                '<td>'+v.fechainicio+'</td>' +
                                '<td>'+fechafin+'</td>' +
                                '<td>' +
                                '<a class="btn btn-xs btn-info estado" ido='+v.idopera+' fi='+fechai+' ff='+fechaf+'><i class="fa fa-pencil"></i></a>' +
                                '<a class="btn btn-xs btn-danger eliminar" ido='+v.idopera+'><i class="fa fa-trash"></i></a>' +
                                '</td>' +
                                '</tr>';
                        });

                        var htmlpalas="";
                        $.each(datar.data.datapalas , function (k, v) {//cargamos las palas que han sido operados por el colaborador "n"
                            tablapalas.show();
                            mjnopalas.hide();
                            var fechafin="No definido", fechai="", fechaf="";
                            if(v.fechafin!==null){
                                fechafin=v.fechafin;
                                fechaf=v.fechafin.toString().replace(" ", "|");
                            }
                            else {
                                fechaf=0;
                            }
                            if(v.fechainicio!==null){
                                fechai=v.fechainicio.toString().replace(" ", "|");
                            }
                            else {
                                fechai=0;
                            }
                            htmlpalas+='<tr>' +
                                '<td>'+v.placa+' </td>' +
                                '<td>'+v.fechainicio+'</td>' +
                                '<td>'+fechafin+'</td>' +
                                '<td>' +
                                '<a class="btn btn-xs btn-info estado" ido='+v.idopera+' fi='+fechai+' ff='+fechaf+'><i class="fa fa-pencil"></i></a>' +
                                '<a class="btn btn-xs btn-danger eliminar" ido='+v.idopera+' fi='+fechai+' ff='+fechaf+'><i class="fa fa-trash"></i></a>' +
                                '</td>' +
                                '</tr>';
                        })
                        $('#tablehistorial').empty().append(html);
                        $('#tablehistorialpalas').empty().append(htmlpalas);
                        convertTable("table-historial");
                        convertTable("table-historial-palas");
                        modalLoading.modal('hide');
                        $("#modalHistorial").modal('show');
                        break;
                    //Actualizamos las fechas de un asignacion de un colaborador seleccionado
                    case 2:
                        $("#changeEstado").modal('hide');
                        makePost({o:1, idc:idcoSe});//Actualizamos
                        break;
                    //Actaulziamos la tabla luego de agregar un colaborador
                    case 3:
                        swal("Agregado!!", "El colaborasdor "+data.n+" "+data.ap+", ha sido agregado correctamente", "success")
                        location.reload();
                        break;
                    //Traemos las placas segun el radio button seleccionado 1: palas y 2: volquetes
                    case 4:
                        var html="<option value='0'>__Seleccionar placa__</option>";

                        switch(datar.t){
                            case 1:
                                $.each(datar.data, function (k,v) {
                                    html+="<option value='"+v.idcargador+"'>Placa: "+v.placa+"</option>";
                                })
                                break;
                            case 2:
                                $.each(datar.data, function (k,v) {
                                    html+="<option value='"+v.idvolquete+"'>Placa: "+v.placa+"</option>";
                                })
                                break;
                        }
                        $("#selectUnidad").empty().append(html);
                        modalLoading.modal('hide');
                        break;
                    //Actualizamos las asinaciones luego de haber agregado una nueva
                    case 5:
                        $("#addAsignarnModal").modal('hide');
                        makePost({o:1, idc:idcoSe});//Actualizamos
                        break;
                    //Actualizamos asignaciones luego que una asigacion ha cambiado de esado a eliminado(2)
                    case 6:
                        makePost({o:1, idc:idcoSe});//Actualizamos
                        swal(
                            'Elininado!',
                            'el registro ha sido eliminado.',
                            'success'
                        );
                        break;
                    //Mostramos los datos actuales del colaborador a actualizar
                    case 7:
                        nombresE.val(datar.data.nombres);
                        apE.val(datar.data.ap);
                        amE.val(datar.data.am);
                        dniE.val(datar.data.dni);
                        telefonoE.val(datar.data.telefono);
                        direccionE.val(datar.data.direccion);
                        userE.val(datar.data.user);
                        passwordE.val(datar.data.contrasena);
                        switch (datar.data.estado){
                            case "1":
                                $("#checkedac").prop('checked', "true");
                                break;
                            case "2":
                                    $("#checkeddes").prop('checked', "true");
                                break;
                        }
                        modalLoading.modal('hide');
                        $("#modalEditOperador").modal('show')
                        break;
                    //Actualizamos la foto incluso luego de eliminar el archivo, se ingresa foto=null
                    case 8:
                        var idcolaborador=datar.data.idcolaborador;
                        var foto=datar.data.foto;
                        var nombre = datar.data.nombres+" "+datar.data.ap+" "+datar.data.am;
                        if(data.f===null){
                            swal(
                                "Excelente!",
                                "La foto "+foto+" se eliminó correctamente al colaborador "+nombre+"!",
                                'success');

                            $("#popover"+idcolaborador).attr('data-img', urlimges+"thumbnail/sinimagen.jpg");
                            $("#imagecircle"+idcolaborador).attr('src', urlimges+"thumbnail/sinimagen.jpg");


                        }else{
                            swal(
                                "Excelente!",
                                "La foto "+foto+" se asignó correctamente al colaborador "+nombre+"!",
                                'success');
                            $("#popover"+idcolaborador).attr('data-img', urlimges+foto);
                            $("#imagecircle"+idcolaborador).attr('src', urlimges+"thumbnail/"+foto);
                        }

                        //Popover al hacer click en las imagenes
                        modalLoading.modal('hide');
                        break;
                }
        }

    });
}
//Aperturamos el modal del historial de manejo o asignaciones del colaborador
$(document).on('click','.opera', function() {
    idcoSe=$(this).attr('idc');
    var nombre=$(this).attr('nom');
    $("#modaltitle").empty().append("Historial de manejo de "+nombre);
    makePost({
        o:1,
        idc:$(this).attr('idc')
    })
});
//Eliminamos la foto del colaborador
$(document).on('click','#btnEliminar', function() {
    var url=$(this).attr('url');
    var nombreim=$(this).attr('ni');
    swal({
        title: "¿Está seguro?",
        text: "La foto se eliminará permanentemente, aunque podrá agregar otra.",
        type: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#0093ff',
        cancelButtonColor: '#DD6B55',
        confirmButtonText: 'Si, eliminar!'
    }).then(function () {
        makePostFile({
            type:"DELETE",
            url:url,
            idc:idcoSe,
            ni:nombreim
        })
    })
});
//Consultamos los datos del colaborador a editar y luego mostramos el modal luego de obtener la data
$(document).on('click','.editar', function() {
    idcoSe=$(this).attr('idc');
    makePost({
        o:7,
        idc:idcoSe
    })
});
//Confirmamos la edicion de las fechas de asignacion
$(document).on('click','#btn-confirmar-editar', function() {
    makePost(
        {
            o:2,
            ido:$(this).attr('ido'),
            fi:$('#fechainicio').val().replace(" ","T"),
            ff:$('#fechafin').val().replace(" ","T")
        })
});
//Insertamos nuevo colaborador
$(document).on('click','#btn-confirmar-guardar', function() {
    var nom=nombres.val().trim();
    var apa=ap.val().trim();
    var ama=am.val().trim();
    var t=telefono.val().trim();
    var d=direccion.val().trim();
    var u=user.val().trim();
    var p=password.val();
    var dn=dni.val();
    if(nom!=="" && apa!==""&&dn!==""&&ama!==""&&t!==""&&d!==""&&u!==""&&p!=="")
    {
        makePost(
            {
                o:3,
                n:nom,
                ap:apa,
                am:ama,
                t:t,
                d:d,
                u:u,
                p:p,
                dni:dn,
                e:1,
                idc:0
            })
    }else {
        swal("Alerta!", "Hay campos sin llenar, todos los campos son obligatorios", "warning")
    }
});
//Actualizar datos de Colaborador
$(document).on('click','#btnUCol', function() {
    var nom=nombresE.val().trim();
    var apa=apE.val().trim();
    var ama=amE.val().trim();
    var t=telefonoE.val().trim();
    var d=direccionE.val().trim();
    var u=userE.val().trim();
    var p=passwordE.val();
    var dn=dniE.val();
    estadoE=$('input[name=estadooperador]:checked').val();
    if(nom!=="" && apa!==""&&dn!==""&&ama!==""&&t!==""&&d!==""&&u!==""&&p!=="")
    {
        makePost(
            {
                o:3,
                n:nom,
                ap:apa,
                am:ama,
                t:t,
                d:d,
                u:u,
                p:p,
                dni:dn,
                idc:idcoSe,
                e:estadoE
            })
    }else {
        swal("Alerta!", "Hay campos sin llenar, todos los campos son obligatorios", "warning")
    }
});
//Mostramos modal agregar colaborador
$(document).on('click','#addOperador', function () {
    clearElements();
    $("#modalAddOperador").modal('show');
});
//Mostramos modal de asignar foto a colaborador
$(document).on('click','.foto', function () {
    $("#modalAddPhoto").modal('show');
    idcoSe=$(this).attr('idc');
    var src=$(this).attr('src');
    if(src!==""){
        makePostFile({
            url:src,
            type:'GET'
        });
        $(".imgShowModal").show();
        $(".btnsubir").attr('disabled', true);
    }else{
        $(".imgShowModal").hide();
        $(".btnsubir").attr('disabled', false);
    }
   // $("#tituloModal").empty().append('Asginar nuevo Chofe '+nombre)

});
//Mostramos modal para asignar nuevo servicio de meneja
$(document).on('click','#addAsignar', function () {
    $("#addAsignarnModal").modal('show');
    $("#checkpala").prop('checked', 'true')
    makePost({o:4,t:1})
});
//Guardamos nueva asignacion al operador
$(document).on('click','#btn-confirmar-asignar', function () {
    var idunidad=parseInt($("#selectUnidad").val());
    var fecinicio=$("#fechainicioN").val().replace(" ","T");
    var fecfin=$("#fechafinN").val().replace(" ","T");
    if(idunidad!==0&&fecinicio){
        makePost(
            {
                o:5,
                idc: idcoSe,
                fi:fecinicio,
                ff:fecfin,
                idu:idunidad
            }
        )
    }else {
        swal("Alerta!", "Hay campos sin llenar, todos los campos son obligatorios par poder asignar", "warning")
    }
   // makePost({o:4,t:1})
});
//Actaulizamos la asignacion realizada antes
$(document).on('click','.estado', function() {
    $("#changeEstado").modal('show');
    var fechainicio=$('#fechainicio');
    var fechafin=$('#fechafin');
    fechainicio.data("DateTimePicker").date(new Date($(this).attr('fi').replace("|", " ")));
    fechafin.data("DateTimePicker").date(new Date($(this).attr('ff').replace("|", " ")) );
    $("#btn-confirmar-editar").attr('ido', $(this).attr('ido'));
});
//Eliminamos/Desabilidatmas/pasamos a estado 2 la asignacion de opera
$(document).on('click','.eliminar', function() {
    var ido=$(this).attr('ido');
    swal({
        title: "¿Está seguro?",
        text: "La asignación se desactivará y no habrá marcha atras!",
        type: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#0093ff',
        cancelButtonColor: '#DD6B55',
        confirmButtonText: 'Si, eliminar!'
    }).then(function () {
        makePost({
            o:6,
            ido:ido
        })
    })
});
//Cuando se abre el modal de agregar colaborador, el cursos o el foto se localiza en el input de nombre

$('#modalAddOperador').on('shown.bs.modal', function () {
    nombres.focus();
});
//Limpiamos todos los elementos luego de agregar un colaborador
function clearElements() {
    nombres.val("");
    ap.val("");
    am.val("");
    telefono.val("");
    direccion.val("");
    user.val("");
    dni.val("");
    password.val("");
}
//Convertimos una tabla en datatable para hacerla dinamica
function convertTable(id){

    if($.fn.dataTable.isDataTable("#"+id)){
        $("#"+id).DataTable();
    }else {
        $("#"+id).DataTable({
            "language": {
                "lengthMenu": "Mostrar _MENU_",
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

