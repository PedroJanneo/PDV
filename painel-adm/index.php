<?php
    @session_start();
	require_once('../conexao.php'); // usar o ../ quando for algo do diretorio anterior
    require_once('verificar-permissao.php');

	// variaveis
	$menu1 = 'home';
	$menu2 = 'usuarios';
    $menu3 = 'fornecedores';
    $menu4 = 'categorias';
    

    // recuperar dados
    $query = $pdo->query("SELECT * FROM usuarios WHERE id = '$_SESSION[id_usuario]' ");
    $res = $query -> fetchAll(PDO::FETCH_ASSOC);
    $nome_usu = $res[0]['nome'];
    $email_usu = $res[0]['email'];
    $senha_usu = $res[0]['senha'];
    $nivel_usu = $res[0]['nivel'];
    $cpf_usu = $res[0]['cpf'];
    $id_usu = $res[0]['id'];


    
    ?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Painel ADM</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-0evHe/X+R7YkIZDRvuzKMRqM+OrBnVFBL6DOitfPri4tjfHxaWutUpFmBp4vmVor" crossorigin="anonymous">

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-pprn3073KE6tl6bjs2QrFaJGz5/SUsLqktiwsUTF55Jfv3qYSDhgCecCxMW52nD2" crossorigin="anonymous">
    </script>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

    <link href="../vendor/DataTables/datatables.min.css" rel="stylesheet">

    <script src="../vendor/DataTables/datatables.min.js"></script>


    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="shortcut icon" href="../img/favicon.ico"/>
    <!-- a linha de cima mostra como coloca img na aba do site -->
</head>

<body>
    <nav class="navbar navbar-expand-lg bg-body-tertiary">
        <div class="container-fluid">
            <a class="navbar-brand" href="index.php">
            <img src="../img/logo.png" width="50">
            </a>
            
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false"
                aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page"
                            href="index.php?pagina=<?php echo $menu1?>">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="index.php?pagina=<?php echo $menu2?>">Usuarios</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="index.php?pagina=<?php echo $menu3?>">Fornecedores</a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown"
                            aria-expanded="false">
                            Produtos
                        </a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="index.php?pagina=<?php echo $menu4?>">Cadastro Categoria</a></li>

                        </ul>
                    </li>
                </ul>
                <div class="d-flex mx-2">
                    <img src="../img/icone-user.png" width="20%" height="20%">
                    <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                        data-bs-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false"
                        aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                    <div class="collapse navbar-collapse" id="navbarNavDropdown">
                        <ul class="navbar-nav">
                            <li class="nav-item dropdown">
                                <button class="btn dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                                    <?php echo $nome_usu ?>
                                </button>
                                <ul class="dropdown-menu dropdown-menu">
                                    <li><a class="dropdown-item" href="" data-bs-toggle='modal' data-bs-target="#modalPerfil">Editar perfil</a></li>
                                    <li>
                                        <hr class="dropdown-divider">
                                    </li>
                                    <!--aquele divisor das opções-->
                                    <li><a class="dropdown-item" href="../logout.php">Sair</a></li>
                                </ul>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </nav>
    <!--todo conteudo é apos o nav -->
    <div class="container-fluid mt-2">
        <?php
	 	if (@$_GET['pagina'] == $menu1){ // existe um get que recebe home?
			require_once($menu1.'.php'); // retorna isso

		} else if(@$_GET['pagina'] == $menu2){
			require_once($menu2.'.php');

        } else if(@$_GET['pagina'] == $menu3){
			require_once($menu3.'.php');

        } else if(@$_GET['pagina'] == $menu4){
			require_once($menu4.'.php');
            
		} else {
			require_once($menu1.'.php');
		}
	 	?>
    </div>

</body>

</html>
<div class="modal fase" tabindex="-1" id="modalPerfil">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Editar perfil</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form method="POST" id="form-perfil">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="exampleFormControlInput1" class="form-label">Nome</label>
                                <input type="text" class="form-control" id="nome-perfil" name="nome-perfil" placeholder="Nome"
                                    required="" value="<?php echo $nome_usu?>">
                            </div>
                        </div>
                        <div class="col-md-6">

                            <div class="mb-3">
                                <label for="exampleFormControlInput1" class="form-label">CPF</label>
                                <input type="text" class="form-control" id="cpf-perfil" name="cpf-perfil" placeholder="CPF"
                                    required="" value="<?php echo @$cpf_usu ?>">
                            </div>
                        </div>

                    </div>


                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="exampleFormControlInput1" class="form-label">Email</label>
                        <input type="email" class="form-control" id="email-perfil" name="email-perfil" placeholder="Email" required=""  value="<?php echo @$email_usu ?>">
                    </div>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="exampleFormControlInput1" class="form-label">Senha</label>
                        <input type="text" class="form-control" id="senha-perfil" name="senha-perfil" placeholder="Senha" required="" value="<?php echo @$senha_usu ?>">
                    </div>
                </div>

                <div align="center" id="msg-perfil">

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" id="btn-fechar"
                        data-bs-dismiss="modal">Fechar</button>
                    <button name="id-btn-perfil" id="btn-salvar-perfil" type="submit" class="btn btn-primary">Salvar</button>
                    <input name="id-perfil" type="hidden" value="<?php echo @$id_usu?>">
                    <input name="antigo-perfil" type="hidden" value="<?php echo @$cpf_usu?>">
                    <input name="antigo2-perfil" type="hidden" value="<?php echo @$email_usu?>">
                </div>
            </form>
        </div>
    </div>
</div>

 <!-- linha abaixo faz ligação com mascaras.js (para o cpf) -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.11/jquery.mask.min.js"></script> <!-- ligaçao o com o ajax-->

<script type="text/javascript" src="../vendor/js/mascaras.js"></script> <!-- ligação com o arquivo    -->

<!--AJAX PARA EDIÇÃO PERFIL -->
<script type="text/javascript">
$("#form-perfil").submit(function() {
     //variavel php
    event.preventDefault();
    var formData = new FormData(this);

    $.ajax({
        url: "editar-perfil.php",
        type: 'POST',
        data: formData,

        success: function(msg) {

            $('#msg').removeClass()

            if (msg.trim() == "Salvo com Sucesso!") {

                //$('#nome').val('');
                //$('#cpf').val('');
                $('#btn-fechar').click();
                // window.location = "index.php?pagina=" +
                //     pag;

            } else {

                $('#msg-perfil').addClass('text-danger')
            }

            $('#msg-perfil').text(msg)

        },

        cache: false,
        contentType: false,
        processData: false,
        xhr: function() { // Custom XMLHttpRequest
            var myXhr = $.ajaxSettings.xhr();
            if (myXhr.upload) { // Avalia se tem suporte a propriedade upload
                myXhr.upload.addEventListener('progress', function() {
                    /* faz alguma coisa durante o progresso do upload */
                }, false);
            }
            return myXhr;
        }
    });
});
</script>