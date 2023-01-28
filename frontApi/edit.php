<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://code.jquery.com/jquery-3.6.3.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.6.3/dist/jquery.min.js"></script>
    <link href="https://cdn.datatables.net/1.13.1/css/jquery.dataTables.min.css">
    <script src="https://cdn.datatables.net/1.13.1/js/jquery.dataTables.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>
    <title>Edit</title>
</head>

<body>
    <div class="alert alert-warning" role="alert" id="error">
        
    </div>
    <?php
    if (isset($_GET) && isset($_GET['id'])) {
    ?>
        <h1>Formulario de edicion de datos</h1>
        <form >
            <div class="form-group" style="width:250px;">
                <label for="nombre">Nombre</label>
                <input type="text" class="form-control" id="nombre">
            </div>
            <div class="form-group" style="width:250px;">
                <label for="apellido">Apellido</label>
                <input type="text" class="form-control" id="apellido">
            </div>
            <br>
            <button type="button" class="btn btn-primary" id="enviar">Enviar</button>
        </form>
        <script>
            <?php echo "var id=" . $_GET['id']; ?>
        </script>
    <?php
    }
    ?>
    <br>
    <a class="btn btn-secondary" href="index.html">Volver</a>
</body>
<script src="edit.js"></script>