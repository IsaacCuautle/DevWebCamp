 import Swal from "sweetalert2";

 (function() {
    let eventos = [];
    const resumen = document.querySelector('#registro-resumen');
    if(resumen) {

        const eventosBoton = document.querySelectorAll('.evento__agregar');
        eventosBoton.forEach(boton => boton.addEventListener('click', selecionarEvento));

        const formularioRegistro = document.querySelector('#registro');
        formularioRegistro.addEventListener('submit',submitFormulario);

        mostrarEventos();

        function selecionarEvento({target}) {
            
            if(eventos.length < 5) {
                // Deshabilitar el evento
                target.disabled = true;
                eventos =[...eventos, {
                    id: target.dataset.id,
                    titulo: target.parentElement.querySelector('.evento__nombre').textContent.trim()
                }];
                mostrarEventos();
            } else {
                Swal.fire({
                    title: 'Error',
                    text: 'Maximo 5 Eventos por Registro',
                    icon: 'error',
                    confirmButtonText: 'OK'
                })
            }

        }

        function mostrarEventos() {

            // Limpiar el html
            LimpiarEventos();

            if(eventos.length > 0) {
                eventos.forEach(evento => {
                    const eventoDoom = document.createElement('DIV');
                    eventoDoom.classList.add('registro__evento');
                    
                    const titulo = document.createElement('H3');
                    titulo.classList.add('registro__nombre');
                    titulo.textContent = evento.titulo;

                    const botonEliminar = document.createElement('BUTTON');
                    botonEliminar.classList.add('registro__eliminar');
                    botonEliminar.innerHTML = '<i class="fa-solid fa-trash"></i>'
                    botonEliminar.onclick = function () {
                        eliminarEvento(evento.id);
                    }

                    // Renderizar en el html
                    eventoDoom.appendChild(titulo);
                    eventoDoom.appendChild(botonEliminar);
                    resumen.appendChild(eventoDoom);
                })
            } else {
                const noRegistros = document.createElement('P')
                noRegistros.textContent = 'No hay eventos añade hasta 5 de lado izquierdo';
                noRegistros.classList.add('registro__texto');
                resumen.appendChild(noRegistros);
            }
        }

        function LimpiarEventos() {
            while (resumen.firstChild) {
                resumen.removeChild(resumen.firstChild);
            }
        }

        function eliminarEvento(id) {
            eventos = eventos.filter(evento => evento.id != id);
            const botonAgregar = document.querySelector(`[data-id="${id}"]`);
            botonAgregar.disabled = false;
            mostrarEventos();
        }

         async function submitFormulario(e) {
            e.preventDefault();
            
            // Obtener el regalo
            const regaloId = document.querySelector('#regalo').value;
            const eventosId = eventos.map(evento => evento.id);

            if(eventosId.length === 0 || regaloId === '' ) {
                Swal.fire({
                    title: 'Error',
                    text: 'Debes seleccionar por lo menos un evento y un regalo',
                    icon: 'error',
                    confirmButtonText: 'OK'
                });
                return;
            }

            // Objeto de formdata
            const datos = new FormData() ;
            datos.append('eventos', eventosId);
            datos.append('regalo_id', regaloId);

            const url = '/finalizar-registro/conferencias';
            const respuesta =  await fetch(url, {
                method: 'POST',
                body: datos
            })
            
            const resultado = await respuesta.json()
            console.log(resultado);
        }
    }
 })();