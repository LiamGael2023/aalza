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

$('.tablaExpedientes').DataTable( {
    language: idioma_espanol,
    ajax: "ajax/datatable-expedientes.ajax.php"
    
    
} );

// ============================================
// MANEJO DEL FORMULARIO DE EXPEDIENTES
// ============================================

// Variable para evitar múltiples inicializaciones
var expedienteFormIniciado = false;

// Inicializar solo una vez
if (!expedienteFormIniciado) {
    expedienteFormIniciado = true;
    
    // Limpiar formulario al abrir modal para nuevo expediente
    // Evento al abrir modal
$('#exampleModal').on('show.bs.modal', function (e) {
    var relatedTarget = e.relatedTarget;
    var accionActual = $('#accion').val();
    
    console.log('Modal abriendo - Acción actual:', accionActual);
    
    // Si NO es edición, resetear para nuevo expediente
    if (accionActual !== 'editar' && (!relatedTarget || !$(relatedTarget).hasClass('btnEditarExpediente'))) {
        console.log('Preparando para NUEVO expediente');
        
        // Limpiar formulario
        $('#formExpediente')[0].reset();
        $('#id_expediente').val('');
        $('#accion').val('crear');
        
        // Restablecer título original
        $('#tituloModal').html('<i class="fas fa-file-alt me-2"></i>Nuevo Expediente');
        
        // Restablecer color del header a azul
        $('#exampleModal .modal-header')
            .removeClass('bg-warning text-dark')
            .addClass('bg-primary');
        
        // Limpiar mensajes
        $('#mensajeRespuesta').addClass('d-none');
    }
});

// Evento al cerrar modal - limpiar todo
$('#exampleModal').on('hidden.bs.modal', function (e) {
    console.log('Modal cerrado - Limpiando formulario');
    
    // Limpiar formulario completamente
    $('#formExpediente')[0].reset();
    $('#id_expediente').val('');
    $('#accion').val('crear');
    
    // Restablecer título
    $('#tituloModal').html('<i class="fas fa-file-alt me-2"></i>Nuevo Expediente');
    
    // Restablecer color del header
    $('#exampleModal .modal-header')
        .removeClass('bg-warning text-dark')
        .addClass('bg-primary');
    
    // Limpiar mensajes
    $('#mensajeRespuesta').addClass('d-none');
});

    // Enviar formulario
    $('#formExpediente').on('submit', function(e) {
        e.preventDefault();
        
        // Recopilar datos del formulario - SOLO LOS CAMPOS DEL MODAL
        var datos = {
            accion: $('#accion').val(),
            id_expediente: $('#id_expediente').val(),
            propietario: $('#propietario').val().trim(),
            copropietario: $('#copropietario').val().trim(),
            zonificacion: $('#zonificacion').val(),
            ubicacion: $('#ubicacion').val().trim(),
            estructura_urbana: $('#estructura_urbana').val(),
            partida_electronica: $('#partida_electronica').val().trim(),
            area_terreno: $('#area_terreno').val(),
            frente: $('#frente').val(),
            derecha: $('#derecha').val(),
            izquierda: $('#izquierda').val(),
            fondo: $('#fondo').val()
        };
        
        console.log('=== GUARDAR EXPEDIENTE ===');
        console.log('Acción:', datos.accion);
        console.log('Datos a enviar:', datos);
        
        $.ajax({
            url: 'ajax/expediente.ajax.php',
            method: 'POST',
            data: datos,
            dataType: 'json',
            beforeSend: function() {
                console.log('Enviando datos al servidor...');
                $('#btnGuardarExpediente').prop('disabled', true).html(
                    '<span class="spinner-border spinner-border-sm me-2" role="status"></span>Guardando...'
                );
            },
            success: function(response) {
                console.log('Respuesta del servidor:', response);
                
                if (response.success) {
                    mostrarMensaje('success', response.message);
                    
                    // Recargar tabla
                    $('.tablaExpedientes').DataTable().ajax.reload(null, false);
                    
                    // Cerrar modal después de 1.5 segundos
                    setTimeout(function() {
                        $('#exampleModal').modal('hide');
                        $('#formExpediente')[0].reset();
                    }, 1500);
                } else {
                    mostrarMensaje('danger', response.message || 'Error al guardar el expediente');
                }
            },
            error: function(xhr, status, error) {
                console.error('=== ERROR AJAX ===');
                console.error('Error:', error);
                console.error('Estado:', status);
                console.error('Respuesta del servidor:', xhr.responseText);
                
                mostrarMensaje('danger', 'Error de conexión. Revisa la consola del navegador (F12).');
            },
            complete: function() {
                $('#btnGuardarExpediente').prop('disabled', false).html(
                    '<i class="fas fa-save me-1"></i>Guardar Expediente'
                );
            }
        });
    });
}

// ============================================
// FUNCIONES AUXILIARES
// ============================================

function mostrarMensaje(tipo, mensaje) {
    var alertClass = 'alert-' + tipo;
    var icono = tipo === 'success' ? 'check-circle' : 'exclamation-triangle';
    
    $('#mensajeRespuesta')
        .removeClass('d-none alert-success alert-danger alert-warning')
        .addClass(alertClass)
        .html('<i class="fas fa-' + icono + ' me-2"></i>' + mensaje);
    
    // Scroll al inicio del modal
    $('#exampleModal .modal-body').animate({ scrollTop: 0 }, 300);
    
    // Auto-ocultar después de 5 segundos si es éxito
    if (tipo === 'success') {
        setTimeout(function() {
            $('#mensajeRespuesta').addClass('d-none');
        }, 5000);
    }
}

function editarExpediente(idExpediente) {
    console.log('=== CARGAR EXPEDIENTE PARA EDITAR ===');
    console.log('ID:', idExpediente);
    
    $.ajax({
        url: 'ajax/expediente.ajax.php',
        method: 'POST',
        data: {
            accion: 'obtener',
            id_expediente: idExpediente
        },
        dataType: 'json',
        success: function(response) {
            console.log('Datos recibidos:', response);
            
            if (response.success && response.data) {
                var exp = response.data;
                
                // Llenar SOLO los campos que existen en el modal
                $('#id_expediente').val(exp.id_expediente || '');
                $('#accion').val('editar');
                $('#propietario').val(exp.propietario || '');
                $('#copropietario').val(exp.copropietario || '');
                $('#zonificacion').val(exp.zonificacion || '');
                $('#ubicacion').val(exp.ubicacion || '');
                $('#estructura_urbana').val(exp.estructura_urbana || '');
                $('#partida_electronica').val(exp.partida_electronica || '');
                $('#area_terreno').val(exp.area_terreno || '');
                $('#frente').val(exp.frente || '');
                $('#derecha').val(exp.derecha || '');
                $('#izquierda').val(exp.izquierda || '');
                $('#fondo').val(exp.fondo || '');
                
                // Cambiar título del modal
                $('#tituloModal').html('<i class="fas fa-edit me-2"></i>Editar Expediente #' + exp.id_expediente);
                
                // Abrir modal
                $('#exampleModal').modal('show');
            } else {
                alert('Error al cargar los datos del expediente');
                console.error('Error en respuesta:', response);
            }
        },
        error: function(xhr, status, error) {
            console.error('=== ERROR AL OBTENER EXPEDIENTE ===');
            console.error('Error:', error);
            console.error('Respuesta:', xhr.responseText);
            alert('Error de conexión al obtener los datos');
        }
    });
}

function eliminarExpediente(idExpediente) {
    console.log('=== ELIMINAR EXPEDIENTE ===');
    console.log('ID:', idExpediente);
    
    $.ajax({
        url: 'ajax/expediente.ajax.php',
        method: 'POST',
        data: {
            accion: 'eliminar',
            id_expediente: idExpediente
        },
        dataType: 'json',
        success: function(response) {
            console.log('Respuesta:', response);
            
            if (response.success) {
                // Recargar tabla
                $('.tablaExpedientes').DataTable().ajax.reload(null, false);
                
                // Mostrar mensaje
                if (typeof Swal !== 'undefined') {
                    Swal.fire({
                        icon: 'success',
                        title: '¡Eliminado!',
                        text: response.message,
                        timer: 2000,
                        showConfirmButton: false
                    });
                } else {
                    alert(response.message);
                }
            } else {
                if (typeof Swal !== 'undefined') {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: response.message
                    });
                } else {
                    alert(response.message || 'Error al eliminar el expediente');
                }
            }
        },
        error: function(xhr, status, error) {
            console.error('=== ERROR AL ELIMINAR ===');
            console.error('Error:', error);
            console.error('Respuesta:', xhr.responseText);
            alert('Error de conexión al eliminar el expediente');
        }
    });
}

// ============================================
// EVENTOS DE BOTONES (DELEGACIÓN)
// ============================================

// ============================================
// EVENTOS DE BOTONES (DELEGACIÓN)
// ============================================

// Botón EDITAR con debugging mejorado
$(document).off('click', '.btnEditarExpediente').on('click', '.btnEditarExpediente', function(e) {
    e.preventDefault();
    e.stopPropagation();
    
    var idExpediente = $(this).data('id');
    
    console.log('=================================');
    console.log('CLIC EN BOTÓN EDITAR');
    console.log('=================================');
    console.log('Elemento clickeado:', this);
    console.log('ID del expediente:', idExpediente);
    console.log('Tipo de ID:', typeof idExpediente);
    console.log('Atributo data-id:', $(this).attr('data-id'));
    
    if (!idExpediente) {
        console.error('ERROR: No se pudo obtener el ID del expediente');
        alert('Error: No se pudo obtener el ID del expediente');
        return;
    }
    
    editarExpediente(idExpediente);
});

// Función de editar con más debugging
function editarExpediente(idExpediente) {
    console.log('=== EDITAR EXPEDIENTE ===');
    console.log('ID:', idExpediente);
    
    $.ajax({
        url: 'ajax/expediente.ajax.php',
        method: 'POST',
        data: {
            accion: 'obtener',
            id_expediente: idExpediente
        },
        dataType: 'json',
        success: function(response) {
            console.log('Respuesta:', response);
            
            if (response.success && response.data) {
                var exp = response.data;
                
                // Limpiar formulario primero
                $('#formExpediente')[0].reset();
                
                // Asignar valores
                $('#id_expediente').val(exp.id_expediente);
                $('#accion').val('editar');
                $('#propietario').val(exp.propietario || '');
                $('#copropietario').val(exp.copropietario || '');
                $('#zonificacion').val(exp.zonificacion || '');
                $('#ubicacion').val(exp.ubicacion || '');
                $('#estructura_urbana').val(exp.estructura_urbana || '');
                $('#partida_electronica').val(exp.partida_electronica || '');
                $('#area_terreno').val(exp.area_terreno || '');
                $('#frente').val(exp.frente || '');
                $('#derecha').val(exp.derecha || '');
                $('#izquierda').val(exp.izquierda || '');
                $('#fondo').val(exp.fondo || '');
                
                console.log('Datos cargados en el formulario');
                
                // CAMBIAR TÍTULO DEL MODAL - MÚLTIPLES FORMATOS
                var numeroExp = exp.numero_expediente || 'SIN-NÚMERO';
                var propietario = exp.propietario || 'Sin propietario';
                
                // Opción 1: Título simple con número de expediente
                $('#tituloModal').html(
                    '<i class="fas fa-edit me-2"></i>Editar Expediente: ' + numeroExp
                );
                
                // Opción 2: Título con ID y número (descomenta si prefieres esta)
                // $('#tituloModal').html(
                //     '<i class="fas fa-edit me-2"></i>Editar Expediente #' + exp.id_expediente + ' - ' + numeroExp
                // );
                
                // Opción 3: Título con propietario (descomenta si prefieres esta)
                // $('#tituloModal').html(
                //     '<i class="fas fa-edit me-2"></i>Editar: ' + numeroExp + ' - ' + propietario
                // );
                
                // Cambiar color del header del modal a advertencia (amarillo/naranja)
                $('#exampleModal .modal-header')
                    .removeClass('bg-primary')
                    .addClass('bg-warning text-dark');
                
                // Limpiar mensajes anteriores
                $('#mensajeRespuesta').addClass('d-none');
                
                // Abrir modal
                $('#exampleModal').modal('show');
                
                console.log('✓ Modal abierto en modo EDICIÓN');
                
            } else {
                console.error('Error:', response);
                alert('Error al cargar los datos del expediente');
            }
        },
        error: function(xhr, status, error) {
            console.error('Error AJAX:', error);
            console.error('Respuesta:', xhr.responseText);
            alert('Error de conexión al obtener los datos');
        }
    });
}

$(document).off('click', '.btnEliminarExpediente').on('click', '.btnEliminarExpediente', function(e) {
    e.preventDefault();
    e.stopPropagation();
    
    var idExpediente = $(this).data('id');
    var numeroExpediente = $(this).data('numero') || 'este expediente';
    
    if (!idExpediente || idExpediente === 0) {
        alert('Error: No se pudo obtener el ID del expediente');
        return;
    }
    
    // Usar SweetAlert2 si está disponible
    if (typeof Swal !== 'undefined') {
        Swal.fire({
            title: '¿Eliminar expediente?',
            text: "¿Está seguro de eliminar el expediente: " + numeroExpediente + "?",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Sí, eliminar',
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            if (result.isConfirmed) {
                eliminarExpediente(idExpediente);
            }
        });
    } else {
        // Confirmación nativa
        if (confirm('¿Está seguro de eliminar el expediente: ' + numeroExpediente + '?')) {
            eliminarExpediente(idExpediente);
        }
    }
});

$(document).off('click', '.btnVerExpediente').on('click', '.btnVerExpediente', function(e) {
    e.preventDefault();
    e.stopPropagation();
    var idExpediente = $(this).data('id');
    // Ajusta esta ruta según tu estructura
    window.location.href = 'index.php?ruta=detalle-expediente&id=' + idExpediente;
});

$(document).off('click', '.btnVerExpediente').on('click', '.btnVerExpediente', function(e) {
    e.preventDefault();
    e.stopPropagation();
    
    var idExpediente = $(this).data('id');
    
    console.log('=== VER EXPEDIENTE ===');
    console.log('ID del expediente:', idExpediente);
    
    if (!idExpediente || idExpediente === 0) {
        alert('Error: No se pudo obtener el ID del expediente');
        return;
    }
    
    // Redirigir a la página de detalle
    window.location.href = 'index.php?ruta=expediente_detalle&id=' + idExpediente;
});

// ===============================================
// CALCULAR TOTALES EN TIEMPO REAL
// ===============================================

function calcularTotalesPisos() {
    let totalNueva = 0;
    let totalExistente = 0;
    let totalDemolicion = 0;
    let totalAmpliacion = 0;
    let totalRemodelacion = 0;
    
    // Agrupar inputs por piso
    const pisosTotales = {};
    
    $('.area-input').each(function() {
        const idPiso = $(this).data('id-piso');
        const campo = $(this).data('campo');
        const valor = parseFloat($(this).val()) || 0;
        
        // Acumular por columna
        if (campo === 'area_nueva') totalNueva += valor;
        if (campo === 'area_existente') totalExistente += valor;
        if (campo === 'area_demolicion') totalDemolicion += valor;
        if (campo === 'area_ampliacion') totalAmpliacion += valor;
        if (campo === 'area_remodelacion') totalRemodelacion += valor;
        
        // Inicializar objeto del piso
        if (!pisosTotales[idPiso]) {
            pisosTotales[idPiso] = {
                nueva: 0,
                existente: 0,
                demolicion: 0,
                ampliacion: 0,
                remodelacion: 0
            };
        }
        
        // Guardar valores por tipo
        if (campo === 'area_nueva') pisosTotales[idPiso].nueva = valor;
        if (campo === 'area_existente') pisosTotales[idPiso].existente = valor;
        if (campo === 'area_demolicion') pisosTotales[idPiso].demolicion = valor;
        if (campo === 'area_ampliacion') pisosTotales[idPiso].ampliacion = valor;
        if (campo === 'area_remodelacion') pisosTotales[idPiso].remodelacion = valor;
    });
    
    // Actualizar totales por columna en la tabla
    $('#totalNueva').text(totalNueva.toFixed(2));
    $('#totalExistente').text(totalExistente.toFixed(2));
    $('#totalDemolicion').text(totalDemolicion.toFixed(2));
    $('#totalAmpliacion').text(totalAmpliacion.toFixed(2));
    $('#totalRemodelacion').text(totalRemodelacion.toFixed(2));
    
    // Calcular total general con la fórmula correcta
    const totalGeneral = totalNueva + totalExistente + totalAmpliacion - totalDemolicion + totalRemodelacion;
    $('#totalGeneral').text(totalGeneral.toFixed(2));
    
    // Actualizar totales por piso
    for (const idPiso in pisosTotales) {
        const piso = pisosTotales[idPiso];
        const totalPiso = piso.nueva + piso.existente + piso.ampliacion - piso.demolicion + piso.remodelacion;
        $(`.total-piso-${idPiso}`).text(totalPiso.toFixed(2));
    }
    
    // ACTUALIZAR LAS CARDS DE RESUMEN
    $('#cardNueva').text(totalNueva.toFixed(2));
    $('#cardExistente').text(totalExistente.toFixed(2));
    $('#cardDemolicion').text(totalDemolicion.toFixed(2));
    $('#cardAmpliacion').text(totalAmpliacion.toFixed(2));
    $('#cardTotal').text(totalGeneral.toFixed(2));
}

// ===============================================
// GUARDAR TODAS LAS ÁREAS
// ===============================================

function guardarTodasLasAreas() {
    const areas = [];
    
    // Agrupar áreas por piso
    const pisos = {};
    $('.area-input').each(function() {
        const idPiso = $(this).data('id-piso');
        const campo = $(this).data('campo');
        const valor = parseFloat($(this).val()) || 0;
        
        if (!pisos[idPiso]) {
            pisos[idPiso] = {
                id_piso: idPiso,
                area_nueva: 0,
                area_existente: 0,
                area_demolicion: 0,
                area_ampliacion: 0,
                area_remodelacion: 0
            };
        }
        
        pisos[idPiso][campo] = valor;
    });
    
    // Convertir a array
    for (const idPiso in pisos) {
        areas.push(pisos[idPiso]);
    }
    
    console.log('Áreas a guardar:', areas);
    
    if (areas.length === 0) {
        Swal.fire({
            icon: 'warning',
            title: 'Atención',
            text: 'No hay áreas para guardar'
        });
        return;
    }
    
    // Mostrar indicador de carga
    Swal.fire({
        title: 'Guardando...',
        text: 'Por favor espera',
        allowOutsideClick: false,
        showConfirmButton: false,
        didOpen: () => {
            Swal.showLoading();
        }
    });
    
    // Guardar cada piso
    let guardados = 0;
    let errores = 0;
    const totalAreas = areas.length;
    
    // Función para verificar si terminaron todas las peticiones
    function verificarFinalizacion() {
        if (guardados + errores === totalAreas) {
            if (errores === 0) {
                Swal.fire({
                    icon: 'success',
                    title: '¡Éxito!',
                    text: `Se guardaron las áreas de ${guardados} piso(s) correctamente`,
                    timer: 2000,
                    showConfirmButton: false
                }).then(() => {
                    // Recargar los pisos para actualizar las cards
                    cargarPisosGuardados();
                });
            } else {
                Swal.fire({
                    icon: 'warning',
                    title: 'Guardado parcial',
                    text: `Se guardaron ${guardados} pisos correctamente, ${errores} con error`,
                    confirmButtonText: 'OK'
                }).then(() => {
                    cargarPisosGuardados();
                });
            }
        }
    }
    
    areas.forEach((area, index) => {
        $.ajax({
            url: 'ajax/piso.ajax.php',
            method: 'POST',
            data: {
                accion: 'actualizarAreas',
                id_piso: area.id_piso,
                area_nueva: area.area_nueva,
                area_existente: area.area_existente,
                area_demolicion: area.area_demolicion,
                area_ampliacion: area.area_ampliacion,
                area_remodelacion: area.area_remodelacion
            },
            dataType: 'json',
            success: function(response) {
                console.log('Respuesta del servidor:', response);
                
                if (response.status === 'success') {
                    guardados++;
                } else {
                    console.error('Error en piso', area.id_piso, ':', response);
                    errores++;
                }
                
                verificarFinalizacion();
            },
            error: function(xhr, status, error) {
                console.error('Error AJAX:', error);
                console.error('Respuesta:', xhr.responseText);
                errores++;
                verificarFinalizacion();
            }
        });
    });
}