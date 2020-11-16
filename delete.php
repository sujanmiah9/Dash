<?php
include_once 'include/dbcon.php';

$action = $_GET['action'];
$id = "";
if(base64_decode($_GET['id'])){
    $id = (int) base64_decode($_GET['id']);
}
switch($action){
    case"brandDelete":
        $sql  = "DELETE FROM `add_brand` WHERE id = :id";
        $stmt = $db->prepare($sql);
        $stmt->bindParam(':id',$id, PDO::PARAM_STR);
        $stmt->execute();
        header('location: viewBrand.php');
    break;
    case"productDelete":
        $sql  = "DELETE FROM `add_product` WHERE id = :id";
        $stmt = $db->prepare($sql);
        $stmt->bindParam(':id',$id, PDO::PARAM_STR);
        $stmt->execute();
        header('location: viewProduct.php');
    break;
    case"cataDelete":
        $sql  = "DELETE FROM `catagories` WHERE id = :id";
        $stmt = $db->prepare($sql);
        $stmt->bindParam(':id',$id, PDO::PARAM_STR);
        $stmt->execute();
        header('location: viewCatagories.php');
    break;
}

?>