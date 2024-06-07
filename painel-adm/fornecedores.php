<?php
$pag = 'fornecedores';
@session_start();
require_once('../conexao.php');
require_once('verificar-permissao.php');
?>


<a href="index.php?pagina=<?php echo $pag ?>&funcao=novo" type="button" class="btn btn-dark mt-2">NOVO FORNECEDOR</a>
<div class='mt-4' style="margin-right:25px">
    <table id="example" class="table table-hover my-9 " style="width:100%">
        <?php
$query = $pdo->query("SELECT * FROM fornecedores ORDER BY id DESC ");
$res = $query -> fetchAll(PDO::FETCH_ASSOC);
$total_reg = @count($res);

if ($total_reg >0){?>
        <thead>
            <tr>
                <th>Name</th>
                <th>Tipo pessoa</th>
                <th>CPF</th>
                <th>Email</th>
                <th>Telefone</th>
                <th>Ações</th>
            </tr>
        </thead>
        <tbody>
            <?php 
                for ($i=0; $i < $total_reg; $i++){
                    foreach ($res[$i] as $key => $value){

                    }
                
            ?>
            <tr>
                <td> <?php echo $res[$i]['nome'] ?></td>
                <td><?php echo $res[$i]['tipo_pessoa']?></td>
                <td><?php echo $res[$i]['cpf']?></td>
                <td><?php echo $res[$i]['email']?></td>
                <td><?php echo $res[$i]['telefone']?></td>
                <td>
                    <a href="index.php?pagina=<?php echo $pag?>&funcao=editar&id=<?php echo $res[$i]['id']?>"
                        title="Editar Registro">
                        <i class="bi bi-pencil-square text-primary"></i>
                    </a>
                    <a href="index.php?pagina=<?php echo $pag?>&funcao=excluir&id=<?php echo $res[$i]['id']?>"
                        title="Excluir Registro">
                        <i class="bi bi-x-lg text-danger"></i>
                    </a>

                    <a href="#"
                        onclick="mostrarDados('<?php echo $res[$i]['endereco'] ?>','<?php echo $res[$i]['nome'] ?>')"
                        title="Ver Endereço">
                        <i class="bi bi-house text-dark"></i>
                    </a>
                </td>


            </tr>
            <?php } ?>

        </tbody>
    </table>
    <?php } else{
            echo '<p>NÃO EXISTE DADOS PARA SER EXIBIDOS!</p>';
}?>
</div>

<?php
if(@$_GET['funcao'] == "editar"){
    $titulo_modal = 'Editar Registro';
    $query = $pdo->query("SELECT * FROM fornecedores WHERE id ='$_GET[id]'");
    $res = $query -> fetchAll(PDO::FETCH_ASSOC);
    $total_reg = @count($res);
    if($total_reg >0){
        $nome = $res[0]['nome'];
        $cpf = $res[0]['cpf'];
        $email = $res[0]['email'];
        $telefone = $res[0]['telefone'];
        $endereco = $res[0]['endereco'];
        $tipo_pessoa = $res[0]['tipo_pessoa']; // em '' sempre dados do jeito que esta no mysql, em $ variavel no php/html

    }   

} else {
    $titulo_modal = "Inserir Registro";
}
?>

<div class="modal fase" tabindex="-1" id="modalCadastrar">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><?php echo $titulo_modal?></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form method="POST" id="form">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="exampleFormControlInput1" class="form-label">Nome</label>
                                <input type="text" class="form-control" id="nome" name="nome" placeholder="Nome"
                                    required="" value="<?php echo @$nome?>">
                            </div>
                        </div>
                        <div class="col-md-6">

                            <div class="mb-3">
                                <label for="exampleFormControlInput1" class="form-label">CPF/CNPJ</label>
                                <input type="text" class="form-control" id="doc" name="cpf" placeholder="cpf/cnpj"
                                    value="<?php echo @$cpf?>" </div>
                            </div>

                        </div>


                    </div>

                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="exampleFormControlInput1" class="form-label">telefone</label>
                                    <input type="text" class="form-control" id="telefone" name="telefone"
                                        placeholder="telefone" required="" value="<?php echo @$telefone?>">
                                </div>
                            </div>
                            <div class="col-md-6">

                                <div class="mb-3">
                                    <label for="exampleFormControlInput1" class="form-label">tipo pessoa</label>
                                    <select class="form-select mt-1" aria-label="Default select example"
                                        name="tipo_pessoa">

                                        <option <?php if(@$tipo_pessoa == 'Fisica'){ ?> selected <?php } ?>
                                            value="Fisica">
                                            Fisica</option>

                                        <option <?php if(@$tipo_pessoa == 'Juridica'){ ?> selected <?php } ?>
                                            value="Juridica">
                                            Juridica
                                        </option>

                                    </select>
                                </div>

                            </div>


                        </div>


                    </div>

                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="exampleFormControlInput1" class="form-label">email</label>
                        <input type="email" class="form-control" id="email" name="email" placeholder="email" required=""
                            value="<?php echo @$email ?>">
                    </div>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="exampleFormControlInput1" class="form-label">endereço</label>
                        <input type="text" class="form-control" id="endereco" name="endereco"
                            placeholder="Rua X, numero X, bairro x" value="<?php echo @$endereco ?>">
                    </div>
                </div>


                <div align="center" id="msg">

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" id="btn-fechar"
                        data-bs-dismiss="modal">Fechar</button>
                    <button name="salvar" id="btn-salvar" type="submit" class="btn btn-primary">Salvar</button>
                    <input name="id" type="hidden" value="<?php echo @$_GET['id']?>">

                    <input name="antigo" type="hidden" value="<?php echo @$CPF?>">
                    <input name="antigo2" type="hidden" value="<?php echo @$email?>">
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fase" tabindex="-1" id="modalExcluir">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><?php echo $titulo_modal?></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form method="POST" id="form-excluir">
                <div class="modal-body">
                    <p>Deseja realmente excluir?</p>

                </div>
                <div align="center" id="msg-excluir">

                </div>



                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" id="btn-fechar"
                        data-bs-dismiss="modal">Fechar</button>
                    <button name="excluir" id="btn-excluir" type="submit" class="btn btn-danger">Excluir</button>


                </div>

                <input name="id" type="hidden" value="<?php echo @$_GET['id']?>">

        </div>
        </form>
    </div>
</div>


<div class="modal fase" tabindex="-1" id="modalDados">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Dados do Fornecedor</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body mb-4">

				<b>Nome: </b>
				<span id="nome-registro"></span>
				<hr>
				<b>Endereço: </b>
				<span id="endereco-registro"></span>
			</div> 


        </div>

    </div>
</div>


<?php 
if(@$_GET['funcao'] == "novo"){ ?>
<script type="text/javascript">
var myModal = new bootstrap.Modal(document.getElementById('modalCadastrar'), {
    backdrop: 'static'
});
myModal.show();
</script>
<?php } ?>

<?php 
if(@$_GET['funcao'] == "editar"){ ?>
<script type="text/javascript">
var myModal = new bootstrap.Modal(document.getElementById('modalCadastrar'), {
    backdrop: 'static'
});
myModal.show();
</script>
<?php } ?>

<?php
if(@$_GET['funcao'] == "excluir"){ ?>
<script type="text/javascript">
var myModal = new bootstrap.Modal(document.getElementById('modalExcluir'), {

});
myModal.show();
</script>
<?php } ?>

<!--AJAX PARA INSERÇÃO E EDIÇÃO DOS DADOS COM IMAGEM -->
<script type="text/javascript">
$("#form").submit(function() {
    var pag = "<?=$pag?>"; //variavel php
    event.preventDefault();
    var formData = new FormData(this);

    $.ajax({
        url: pag + "/inserir.php",
        type: 'POST',
        data: formData,

        success: function(msg) {

            $('#msg').removeClass()

            if (msg.trim() == "Salvo com Sucesso!") {

                //$('#nome').val('');
                //$('#cpf').val('');
                $('#btn-fechar').click();
                window.location = "index.php?pagina=" +
                    pag;

            } else {

                $('#msg').addClass('text-danger')
            }

            $('#msg').text(msg)

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

<!--AJAX PARA EXCLUIR DADOS  -->
<script type="text/javascript">
$("#form-excluir").submit(function() {
    var pag = "<?=$pag?>"; //variavel php
    event.preventDefault();
    var formData = new FormData(this);

    $.ajax({
        url: pag + "/excluir.php",
        type: 'POST',
        data: formData,

        success: function(msg) {

            $('#msg').removeClass()

            if (msg.trim() == "Excluido com Sucesso!") {

                //$('#nome').val('');
                //$('#cpf').val('');
                $('#btn-fechar').click();
                window.location = "index.php?pagina=" +
                    pag;

            } else {

                $('#msg-excluir').addClass('text-danger')
            }

            $('#msg-excluir').text(msg)

        },
        cache: false,
        contentType: false,
        processData: false,


    });
});
</script>

<script type="text/javascript">
$(document).ready(function() {
    $('#example').DataTable({
        "ordering": false
    });
});
</script>


<script type='text/javascript'>
function mostrarDados(endereco, nome) {
    event.preventDefault();

    $('#endereco-registro').text(endereco);
    $('#nome-registro').text(nome);

    var myModal = new bootstrap.Modal(document.getElementById('modalDados'), {

    });
    myModal.show();
}
</script>