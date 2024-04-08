<?php
include 'bd/BD.php';
header('Access-Control-Allow-Origin: *');


//PETICIÓN O CONSULTA  DE TODOS LOS  REGISTROS O UNO  CON ID
if($_SERVER['REQUEST_METHOD']=='GET'){
    if(isset($_GET['id'])){
        $query="SELECT * FROM country_state_city WHERE id=".$_GET['id'];
        $resultado=metodoGet($query);
        echo json_encode($resultado->fetch(PDO::FETCH_ASSOC));
    }else{
        $query="SELECT * FROM country_state_city";
        $resultado=metodoGet($query);
        echo json_encode($resultado->fetchAll()); 
    }
    header("HTTP/1.1 200 OK");
    exit();
}

// PETICIÓN DE INSERCIÓN
if($_POST['METHOD']=='POST'){
    unset($_POST['METHOD']);
    $country=$_POST['country'];
    $state=$_POST['state'];
    $city=$_POST['city'];
    $query="INSERT INTO country_state_city(country,state,city) VALUES ('$country', '$state', '$city')";
    $queryAutoIncrement="SELECT MAX(id) as id FROM country_state_city";
    $resultado=metodoPost($query, $queryAutoIncrement);
    echo json_encode($resultado);
    header("HTTP/1.1 200 OK");
    exit();
}

//PETICIÓN DE ACTUALIZACIÓN
if($_POST['METHOD']=='PUT'){
    unset($_POST['METHOD']);
    $id=$_GET['id'];
    $country=$_POST['country'];
    $state=$_POST['state'];
    $city=$_POST['city'];
    $query="UPDATE country_state_city SET country='$country', state='$state', city='$city' WHERE id='$id'";
    $resultado=metodoPut($query);
    echo json_encode($resultado);
    header("HTTP/1.1 200 OK");
    exit();
}

// PETICIÓN DE BORRADO
if($_POST['METHOD']=='DELETE'){
    unset($_POST['METHOD']);
    $id=$_GET['id'];
    $query="DELETE FROM country_state_city WHERE id='$id'";
    $resultado=metodoDelete($query);
    echo json_encode($resultado);
    header("HTTP/1.1 200 OK");
    exit();
}
header("HTTP/1.1 400 Bad Request");
?>

