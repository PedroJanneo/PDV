<?php
require_once("../../conexao.php");

$nome = $_POST['nome'];
$email = $_POST["email"];
$senha = $_POST["senha"];
$cpf = $_POST['cpf'];
$nivel = $_POST["nivel"]; 
$id = $_POST['id'];

if ($id ==''){
$res = $pdo->prepare("INSERT INTO usuarios SET nome = :nome,   email = :email, cpf = :cpf, nivel = :nivel, senha = :senha "); 
$res->bindValue(":nome",$nome);
$res->bindValue(":email",$email);
$res->bindValue(":senha",$senha);
$res->bindValue(":nivel",$nivel);
$res->bindValue(":cpf",$cpf);
$res->execute();
    
    echo 'Salvo com Sucesso!';
} else {
$res = $pdo->prepare("UPDATE usuarios SET nome = :nome, email = :email, cpf = :cpf, nivel = :nivel, senha = :senha WHERE id = :id");
$res->bindValue(":nome",$nome);
$res->bindValue(":email",$email);
$res->bindValue(":senha",$senha);
$res->bindValue(":nivel",$nivel);
$res->bindValue(":cpf",$cpf);
$res->bindValue(":id",$id);
$res->execute();
    
echo 'Atualizado com Sucesso!';
}
?>