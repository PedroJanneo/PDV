<?php
require_once("../../conexao.php");

$nome = $_POST['nome'];
$email =$_POST["email"];
$cpf =$_POST["cpf"];
$tipo_pessoa =$_POST["tipo_pessoa"];
$endereco =$_POST["endereco"]; //forms --> variaveis criadas para o php --> banco de dados
$id = $_POST['id'];
$telefone = $_POST['telefone'];

$antigo = $_POST['antigo'];
$antigo2 = $_POST['antigo2'];


// EVIRTAR DUPLICIDADE EMAIL
if ($antigo2 != $email){

    $query_cons = $pdo->prepare("SELECT * FROM fornecedores WHERE email = :email");
    $query_cons ->bindValue(":email",$email);
    $query_cons->execute();
    $res_cons = $query_cons -> fetchAll(PDO::FETCH_ASSOC);

    if (@count($res_cons) >0){
        echo ' o email ja esta em uso!';
        exit();
        }
    }
    // EVITAR DUPLICIDADE cpf
if ($antigo != $cpf){
    $query_cons = $pdo->prepare("SELECT * FROM fornecedores WHERE cpf = :cpf");
    $query_cons ->bindValue(":cpf",$cpf);
    $query_cons->execute();
    $res_cons = $query_cons -> fetchAll(PDO::FETCH_ASSOC);

    if (@count($res_cons) >0){
    echo ' o cpf ja esta em uso!';
    exit();
} 
}
if ($id ==''){

    $res = $pdo->prepare("INSERT INTO fornecedores SET nome = :nome, email = :email, cpf = :cpf,telefone = :telefone,  tipo_pessoa = :tipo_pessoa, endereco = :endereco "); // usar 'prepare' pra formulario --> BAnco de dados
        // : parametros (apelido)
    $res->bindValue(":nome",$nome); // bindValue --> receber variavel e valor diretos
    $res->bindValue(":email",$email);
    $res->bindValue(":cpf",$cpf);
    $res->bindValue(":tipo_pessoa",$tipo_pessoa);
    $res->bindValue(":endereco",$endereco); 
    $res->bindValue(":telefone",$telefone); 
    $res->execute(); // --> conexão das variaves ao banco

    echo 'Salvo com Sucesso!';

} else {
    $res = $pdo->prepare("UPDATE fornecedores SET nome = :nome, email = :email, cpf = :cpf, telefone = :telefone,  tipo_pessoa = :tipo_pessoa, endereco = :endereco WHERE id = :id"); // usar 'prepare' pra formulario --> BAnco de dados
    $res->bindValue(":nome",$nome); // bindValue --> receber variavel e valor diretos
    $res->bindValue(":email",$email);
    $res->bindValue(":cpf",$cpf);
    $res->bindValue(":tipo_pessoa",$tipo_pessoa);
    $res->bindValue(":endereco",$endereco); 
    $res->bindValue(":telefone",$telefone); 
    $res->bindValue(":id",$id); 
    $res->execute(); // --> conexão das variaves ao banco
    echo 'Salvo com Sucesso!';
}
?>