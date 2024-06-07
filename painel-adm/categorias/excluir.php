<?php

require_once("../../conexao.php");
$id = $_POST['id'];
$query_cons = $pdo->query("DELETE FROM categorias WHERE id = '$id'");

echo "Excluido com Sucesso!";
   
?>