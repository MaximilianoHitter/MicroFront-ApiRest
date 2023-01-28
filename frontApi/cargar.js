$(document).ready(function() {
    $('#error').hide();

    $('#enviar').click(function() {
        enviar_formulario();
    })
});

function cargar(response) {
    $('#nombre').val(response.nombre);
    $('#apellido').val(response.apellido);
}

function enviar_formulario() {
    var url = 'http://localhost/phpApi/alumnos';
    fetch(url, {
            method: 'POST', // or 'PUT'
            body: JSON.stringify({
                nombre: $('#nombre').val(),
                apellido: $('#apellido').val()
            }),
            headers: {
                'Content-Type': 'application/json'
            }
        }).then(res => res.json())
        .then(response => ver_respuesta(response));
}

function ver_respuesta(response) {
    if (response.success) {
        window.location.replace('http://localhost/frontApi/index.html');
    } else {
        $('#error').text(response.msg);
        $('#error').show();
    }
}