<?php
include '../config.php';

$id = $_POST['id'];
$tipo = $_POST['tipo_acesso'];
$status = $_POST['status'];
$data = $_POST['data_expiracao'];

$stmt = $conn->prepare("UPDATE empresas SET tipo_acesso=?, status=?, data_expiracao=? WHERE id=?");
$stmt->bind_param("sssi", $tipo, $status, $data, $id);

$stmt->execute();

header("Location: clientes.php?msg=ok");