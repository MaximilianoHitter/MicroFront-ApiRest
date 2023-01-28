<?php
 
require 'vendor/mikecao/flight/flight/Flight.php';

Flight::register('db', 'PDO', array('mysql:host=localhost;dbname=phpapi', 'root', ''));

//obtiene los datos de la db
Flight::route('GET /alumnos', function () {
    $sentencia = Flight::db()->prepare("SELECT * FROM alumnos");
    $sentencia->execute();
    $datos=$sentencia->fetchAll();
    
    Flight::json($datos);
});

//recepciona datos por post y los inserta
Flight::route('POST /alumnos', function(){
    $nombre=(Flight::request()->data->nombre);
    $apellido=(Flight::request()->data->apellido);
    if(isset($nombre) && $nombre != null && isset($apellido) && $apellido != null){
        //comprobar si ya no existe alguien con esos datos 
        $datos_busqueda = Flight::db()->prepare("SELECT * FROM alumnos WHERE nombre = '$nombre' AND apellido = '$apellido'");
        $datos_busqueda->execute();
        $datos_encontrados = $datos_busqueda->fetchAll();
        if(count($datos_encontrados) <= 0){
            $sql = "INSERT INTO alumnos VALUES (null, ?, ?)";
            $sentencia = Flight::db()->prepare($sql);
            $sentencia->bindParam(1, $nombre);
            $sentencia->bindParam(2, $apellido);
            $sentencia->execute();
            $datos=['success'=>1, 'msg'=>'Se ha insertado en la db'];
            Flight::json($datos);
        }else{
            $datos=['success'=>0, 'msg'=>'Ya existe un registro con esas credenciales'];
            Flight::json($datos);
        }
    }else{
        $datos=['success'=>0, 'msg'=>'No se han capturado los datos'];
        Flight::json($datos);
    }

});

//borrar un registro 
Flight::route('DELETE /alumnos', function(){
    $id=(Flight::request()->data->id);
    if(isset($id) && $id != null){
        //comprobar si existe alguien con esos datos 
        $datos_busqueda = Flight::db()->prepare("SELECT * FROM alumnos WHERE id = $id");
        $datos_busqueda->execute();
        $datos_encontrados = $datos_busqueda->fetchAll();
        if(count($datos_encontrados) > 0){
            $sql = "DELETE FROM alumnos WHERE id = ?";
            $borrado = Flight::db()->prepare($sql);
            $borrado->bindParam(1, $datos_encontrados[0]['id']);
            $borrado->execute();
            $string = "Se ha eliminado a ".ucfirst($datos_encontrados[0]['nombre']).' '.ucfirst($datos_encontrados[0]['apellido']). ' de los alumnos';
            $response=['success'=>1, 'msg'=>$string];
            Flight::json($response);
        }else{
            $response=['success'=>0, 'msg'=>'No se ha encontrado dicho id'];
            Flight::json($response);
        }
    }else{
        $datos=['success'=>0, 'msg'=>'No se han capturado los datos'];
        Flight::json($datos);
    }
});

//actualizar registro 
Flight::route('PUT /alumnos', function(){
    $id=(Flight::request()->data->id);
    $nombre=(Flight::request()->data->nombre);
    $apellido=(Flight::request()->data->apellido);
    $valido_datos = true;
    $datos = Flight::request()->data;
    foreach ($datos as $key => $value) {
        if($value == null || $value == ''){
            $valido_datos = false;
        }
    }
    if($valido_datos){
        //buscar si existe el registro 
        $datos = buscar_por_id($id);
        if(count($datos) > 0){
            $sql = "UPDATE alumnos SET nombre = ?, apellido = ? WHERE id=?";
            $update = Flight::db()->prepare($sql);
            $update->bindParam(1, $nombre);
            $update->bindParam(2, $apellido);
            $update->bindParam(3, $id);
            $update->execute();
            $response=['success'=>1, 'msg'=>'Se ha modificado con exito'];
            Flight::json($response);
        }else{
            $response=['success'=>0, 'msg'=>'No se ha encontrado dicho id'];
            Flight::json($response); 
        }
    }else{
        $response=['success'=>0, 'msg'=>'Todos los datos son necesarios'];
        Flight::json($response);
    }
});

//mostrar info del id pasado como parametro
Flight::route('GET /alumnos/@id', function($id){
    echo $id;
    $datos = buscar_por_id($id);
    print_r($datos);
    if(count($datos) > 0){
        $response = array('success'=> 1, 'id'=>$datos[0]['id'], 'nombre'=>$datos[0]['nombre'], 'apellido'=>$datos[0]['apellido']);
        Flight::json($response);
    }else{
        $response=['error'=>'No se ha encontrado dicho id'];
        Flight::json($response); 
    }
});

function buscar_por_id($id){
    $sentencia = Flight::db()->prepare("SELECT * FROM alumnos WHERE id = $id");
    $sentencia->execute();
    $datos=$sentencia->fetchAll();
    return $datos;
}

Flight::start();
