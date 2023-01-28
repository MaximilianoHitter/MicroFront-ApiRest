$(document).ready(function() {
    $('#error').hide();
    var url = 'http://localhost/phpApi/alumnos/' + id;
    fetch(url, {
            method: 'GET', // or 'PUT'
            headers: {
                'Content-Type': 'application/json'
            }
        }).then(res => res.json())
        .catch(error => console.error('Error:', error))
        .then(response => cargar(response));

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
            method: 'PUT', // or 'PUT'
            body: JSON.stringify({
                id: id,
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