<?php
$pdo = null;
$host = "localhost";
$user = "root";
$password = "";
$bd = "testingdb";
//funcion conectar
function conectar(){
    try{
        $GLOBALS['pdo']=new PDO("mysql:host=".$GLOBALS['host'].";dbname=".$GLOBALS['bd']."", $GLOBALS['user'], $GLOBALS['password'],array(
            PDO::ATTR_DEFAULT_FETCH_MODE =>PDO::FETCH_ASSOC,
            PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8', 
        ));
        $GLOBALS['pdo']->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }catch (PDOException $e){
        print "Error!: No se pudo conectar a la bd ". $bd ."<br/>";
        print "\nError!: ".$e."<br/>";
        die();
    }
   
}
//funcion desconectar
function desconectar() {
    $GLOBALS['pdo']=null;
}
//Metodo  para obtener los registros
function metodoGet($query){
    try{
        conectar();
        $sentencia=$GLOBALS['pdo']->prepare($query);
        $sentencia->setFetchMode(PDO::FETCH_ASSOC);
        $sentencia->execute();
        desconectar();
        return $sentencia;
    }catch(Exception $e){
        die("Error: ".$e);
    }
}
//Metodo para  Insertar
function metodoPost($query, $queryAutoIncrement){
    try{
        conectar();
        $sentencia=$GLOBALS['pdo']->prepare($query);
        $sentencia->execute();
        $idAutoIncrement=metodoGet($queryAutoIncrement)->fetch(PDO::FETCH_ASSOC);
        $resultado=array_merge($idAutoIncrement, $_POST);
        $sentencia->closeCursor();
        desconectar();
        return $resultado;
    }catch(Exception $e){
        die("Error: ".$e);
    }
}
// Método para actualizar 
function metodoPut($query){
    try{
        conectar();
        $sentencia=$GLOBALS['pdo']->prepare($query);
        $sentencia->execute();
        $resultado=array_merge($_GET, $_POST);
        $sentencia->closeCursor();
        desconectar();
        return $resultado;
    }catch(Exception $e){
        die("Error: ".$e);
    }
}
//Método para Borrar
function metodoDelete($query){
    try{
        conectar();
        $sentencia=$GLOBALS['pdo']->prepare($query);
        $sentencia->execute();
        $sentencia->closeCursor();
        desconectar();
        return $_GET['id'];
    }catch(Exception $e){
        die("Error: ".$e);
    }
}
?>