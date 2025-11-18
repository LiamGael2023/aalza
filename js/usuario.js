var idioma_espanol = {
    "sProcessing": "Procesando...",
    "sLengthMenu": "Mostrar _MENU_ registros",
    "sZeroRecords": "No se encontraron resultados",
    "sEmptyTable": "Ningún dato disponible en esta tabla",
    "sInfo": "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
    "sInfoEmpty": "Mostrando registros del 0 al 0 de un total de 0 registros",
    "sInfoFiltered": "(filtrado de un total de _MAX_ registros)",
    "sInfoPostFix": "",
    "sSearch": "Buscar:",
    "sUrl": "",
    "sInfoThousands": ",",
    "sLoadingRecords": "Cargando...",
    "oPaginate": {
        "sFirst": "Primero",
        "sLast": "Último",
        "sNext": "Siguiente",
        "sPrevious": "Anterior"
    },
    "oAria": {
        "sSortAscending": ": Activar para ordenar la columna de manera ascendente",
        "sSortDescending": ": Activar para ordenar la columna de manera descendente"
    }
};

$('.tablaUsuarioSistema').DataTable( {
    language: idioma_espanol,
    ajax: "ajax/datatable-usuario.ajax.php"
    
    
} );

/*=============================================
ACTIVAR USUARIO
=============================================*/
$(".tablaUsuarioSistema").on("click", ".btnActivar", function(){

	var idUsuario = $(this).attr("idUsuario");
	var estadoUsuario = $(this).attr("estadoUsuario");

	var datos = new FormData();
 	datos.append("activarId", idUsuario);
  	datos.append("activarUsuario", estadoUsuario);

  	$.ajax({

	  url:"ajax/usuarios.ajax.php",
	  method: "POST",
	  data: datos,
	  cache: false,
      contentType: false,
      processData: false,
      success: function(respuesta){

      		if(window.matchMedia("(max-width:767px)").matches){

	      		 swal({
			      title: "El usuario ha sido actualizado",
			      type: "success",
			      confirmButtonText: "¡Cerrar!"
			    }).then(function(result) {
			        if (result.value) {

			        	window.location = "usuarios";

			        }


				});

	      	}

      }

  	})

  	if(estadoUsuario == 0){

  		$(this).removeClass('btn-success');
  		$(this).addClass('btn-danger');
  		$(this).html('Desactivado');
  		$(this).attr('estadoUsuario',1);

  	}else{

  		$(this).addClass('btn-success');
  		$(this).removeClass('btn-danger');
  		$(this).html('Activado');
  		$(this).attr('estadoUsuario',0);

  	}

});

$(".tablaUsuarioSistema").on("click", ".btnEditarUsuario", function(){

	var idedit = $(this).attr("idedit");
	
	var datos = new FormData();
	datos.append("idedit", idedit);

	$.ajax({

		url:"ajax/usuarios.ajax.php",
		method: "POST",
		data: datos,
		cache: false,
		contentType: false,
		processData: false,
		dataType: "json",
		success: function(respuesta){
                    console.log(respuesta);

                    // Asegúrate de que estás accediendo al primer elemento del array
                    if (respuesta.length > 0) {
                        var usuarios = respuesta[0];
                        $("#editarNombre").val(usuarios["nombre"]);
                        $("#editarUsuario").val(usuarios["usuario"]);
                        $("#passwordActual").val(usuarios["password"]);
                        $("#editarPerfil").val(usuarios["perfil"]);
                        $("#editarIdUsuario").val(usuarios["id"]);
//                        $("#editarabreviatura").val(junta["abreviatura"]);
//                        $("#editarIdJunta").val(junta["id"]);
                    }
                },
                error: function(xhr, status, error) {
                    console.error("Error en la solicitud AJAX:", status, error);
                }

	});

})