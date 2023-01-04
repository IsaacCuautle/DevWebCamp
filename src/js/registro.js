 (function() {
    let eventos = [];
    const eventosBoton = document.querySelectorAll('.evento__agregar');
    eventosBoton.forEach(boton => boton.addEventListener('click',selecionarEvento));

    function selecionarEvento({target}) {
        // Deshabilitar el evento
        e.target.disabled = true;
        eventos =[...eventos, {
            id: target.dataset.id,
            titulo: target.parentElement.querySelector('.evento__nombre').textContent.trim()
        }];
        console.log(eventos);
    }
 })();