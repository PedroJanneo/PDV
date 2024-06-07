<?php
require_once("../../conexao.php");

$nome = $_POST['nome'];
$id = $_POST['id'];


$antigo = $_POST['antigo'];



// EVIRTAR DUPLICIDADE NOME DA CATEGORIA    
if ($antigo != $nome){

    $query_cons = $pdo->prepare("SELECT * FROM categorias WHERE nome = :nome");
    $query_cons ->bindValue(":nome",$nome);
    $query_cons->execute();
    $res_cons = $query_cons -> fetchAll(PDO::FETCH_ASSOC);

    if (@count($res_cons) >0){
        echo ' categoria ja esta cadastrada!';
        exit();
        }
    }

    
//SCRIPT PARA SUBIR FOTO NO BANCO
$nome_img = preg_replace('/[ -]+/' , '-' , @$_FILES['imagem']['name']);
$caminho = '../../img/categorias/' .$nome_img;
if (@$_FILES['imagem']['name'] == ""){
  $imagem = "sem-foto.jpg";
}else{
    $imagem = $nome_img;
}

$imagem_temp = @$_FILES['imagem']['tmp_name']; 
$ext = pathinfo($imagem, PATHINFO_EXTENSION);   
if($ext == 'png' or $ext == 'jpg' or $ext == 'jpeg' or $ext == 'gif'){ 
move_uploaded_file($imagem_temp, $caminho);
}else{
	echo 'Extensão de Imagem não permitida!';
	exit();
}

    
if ($id ==''){

    $res = $pdo->prepare("INSERT INTO categorias SET nome = :nome, foto = :foto"); // usar 'prepare' pra formulario --> BAnco de dados
        // : parametros (apelido)
    $res->bindValue(":nome",$nome); // bindValue --> receber variavel e valor diretos
    $res->bindValue(":foto",$imagem);
    $res->execute(); // --> conexão das variaves ao banco

    echo 'Salvo com Sucesso!';

} else {
    if($imagem != 'sem-foto.jpg'){
        $res = $pdo->prepare("UPDATE categorias SET nome = :nome, foto = :foto WHERE id = :id");
        $res->bindValue(":foto",$imagem);
    } else {
        $res = $pdo->prepare("UPDATE categorias SET nome = :nome WHERE id = :id");
    }
    
    $res->bindValue(":nome",$nome); // bindValue --> receber variavel e valor diretos
    $res->bindValue(":id",$id);
    $res->execute(); // --> conexão das variaves ao banco
    echo 'Salvo com Sucesso!';
}
?>