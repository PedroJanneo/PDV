<?php
require_once("../conexao.php");

$nome = $_POST['nome-perfil'];
$email =$_POST["email-perfil"];
$CPF =$_POST["cpf-perfil"];
$senha =$_POST["senha-perfil"]; //forms --> variaveis criadas para o php --> banco de dados
$id = $_POST['id-perfil'];

$antigo = $_POST['antigo-perfil'];
$antigo2 = $_POST['antigo2-perfil'];


// EVIRTAR DUPLICIDADE EMAIL
if ($antigo2 != $email){

    $query_cons = $pdo->prepare("SELECT * FROM usuarios WHERE email = :email");
    $query_cons ->bindValue(":email",$email);
    $query_cons->execute();
    $res_cons = $query_cons -> fetchAll(PDO::FETCH_ASSOC);

    if (@count($res_cons) >0){
        echo ' o email ja esta em uso!';
        exit();
        }
    }
    // EVITAR DUPLICIDADE CPF
if ($antigo != $CPF){
    $query_cons = $pdo->prepare("SELECT * FROM usuarios WHERE CPF = :CPF");
    $query_cons ->bindValue(":CPF",$CPF);
    $query_cons->execute();
    $res_cons = $query_cons -> fetchAll(PDO::FETCH_ASSOC);

    if (@count($res_cons) >0){
    echo ' o CPF ja esta em uso!';
    exit();
} 
}

    $res = $pdo->prepare("UPDATE usuarios SET nome = :nome, email = :email, CPF = :CPF, senha = :senha WHERE id = :id"); // usar 'prepare' pra formulario --> BAnco de dados
    $res->bindValue(":nome",$nome); // bindValue --> receber variavel e valor diretos
    $res->bindValue(":email",$email);
    $res->bindValue(":CPF",$CPF);
    $res->bindValue(":senha",$senha);
    $res->bindValue(":id",$id);
    $res->execute(); // --> conexão das variaves ao banco
    echo 'Salvo com Sucesso!';

?>