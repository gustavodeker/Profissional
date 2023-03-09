<?php 

$id = $_POST['id'];
$value = $_POST['value'];

$stmt = $db->prepare("UPDATE operadores SET operador_nome = :value WHERE id = :id");
$stmt->execute(['value' => $value, 'id' => $id]);


?>