$(document).ready(function() {
    $('#error').hide();
    $('#tabla').DataTable({
        "ajax": {
            "url": "http://localhost/phpApi/alumnos",
            "contentType": "application/json",
            "type": "GET",
            "async": true,
            "dataSrc": function(response) {
                var respuesta = [];
                for (var dato in response) {
                    var editar_y_borrar = '<a class="btn btn-success" href="edit.php?id=' + response[dato].id + '">Editar</a><button class="btn btn-danger" type="button" onclick="eliminar(' + response[dato].id + ')">Borrar</button>';
                    var e = [response[dato].id, response[dato].nombre, response[dato].apellido, editar_y_borrar];
                    /* e += '<tr>';
                    e += '<td>' + response[dato].id + '</td>';
                    e += '<td>' + response[dato].nombre + '</td>';
                    e += '<td>' + response[dato].apellido + '</td>';
                    e += '</tr>'; */
                    respuesta[dato] = e;
                }
                return respuesta;
            }
        }
    });
});

function eliminar(id) {
    var url = 'http://localhost/phpApi/alumnos';
    fetch(url, {
            method: 'DELETE', // or 'PUT'
            body: JSON.stringify({
                id: id
            }),
            headers: {
                'Content-Type': 'application/json'
            }
        }).then(res => res.json())
        .then(response => ver_respuesta(response));
}

function ver_respuesta(response) {
    if (response.sucess == 0) {
        $('#error').text(response.msg);
        $('#error').show();
    } else {
        $('#error').hide();
        $('#tabla').DataTable().ajax.reload();
    }
}