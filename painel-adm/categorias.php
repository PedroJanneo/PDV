<?php
$pag = 'categorias';
@session_start();
require_once('../conexao.php');
require_once('verificar-permissao.php');
?>


<a href="index.php?pagina=<?php echo $pag ?>&funcao=novo" type="button" class="btn btn-dark mt-2">NOVA CATEGORIA</a>
<div class='mt-4' style="margin-right:25px">
    <table id="example" class="table table-hover my-9 " style="width:100%">
        <?php
$query = $pdo->query("SELECT * FROM categorias ORDER BY id DESC ");
$res = $query -> fetchAll(PDO::FETCH_ASSOC);
$total_reg = @count($res);

if ($total_reg >0){?>
        <thead>
            <tr>
                <th>Name</th>
                <th>Produtos</th>
                <th>Foto</th>
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
                <td></td>
                <td> <img src="../img/categorias/<?php echo $res[$i]['foto'] ?>" width="40"></td>
                <td>
                    <a href="index.php?pagina=<?php echo $pag?>&funcao=editar&id=<?php echo $res[$i]['id']?>"
                        title="Editar Registro">
                        <i class="bi bi-pencil-square text-primary"></i>
                    </a>
                    <a href="index.php?pagina=<?php echo $pag?>&funcao=excluir&id=<?php echo $res[$i]['id']?>"
                        title="Excluir Registro">
                        <i class="bi bi-x-lg text-danger"></i>
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
    $query = $pdo->query("SELECT * FROM categorias WHERE id ='$_GET[id]'");
    $res = $query -> fetchAll(PDO::FETCH_ASSOC);
    $total_reg = @count($res);
    if($total_reg >0){
        $nome = $res[0]['nome'];
        $foto = $res[0]['foto'];
                     // em '' sempre dados do jeito que esta no mysql, em $ variavel no php/html

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

                    <div class="mb-3">
                        <label for="exampleFormControlInput1" class="form-label">Nome</label>
                        <input type="text" class="form-control" id="nome" name="nome" placeholder="Nome" required=""
                            value="<?php echo @$nome?>">
                    </div>

                    <div class="form-group">
                        <label>Imagem</label>
                        <input type="file" value="<?php echo @$foto ?>" class="form-control-file" id="imagem"
                            name="imagem" onChange="carregarImg();">
                    </div>

                    <div id="divImgConta" class="mt-5">
                        <?php if(@$foto != ""){ ?>
                        <img src="../img/categorias/<?php echo $foto2 ?>" width="200px%" id="target">
                        <?php  }else{ ?>
                        <img src="../img/categorias/sem-foto.jpg" width="200px%" id="target">
                        <?php } ?>
                    </div>


                </div>



                <div align="center" id="msg">

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" id="btn-fechar"
                        data-bs-dismiss="modal">Fechar</button>
                    <button name="salvar" id="btn-salvar" type="submit" class="btn btn-primary">Salvar</button>
                    <input name="id" type="hidden" value="<?php echo @$_GET['id']?>">

                    <input name="antigo" type="hidden" value="<?php echo @$nome?>">
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
                window.location = "index.php?pagina=" + pag;

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

<!--SCRIPT PARA CARREGAR IMAGEM -->
<script type="text/javascript">
function carregarImg() {

    var target = document.getElementById('target');
    var file = document.querySelector("input[type=file]").files[0];
    var reader = new FileReader();

    reader.onloadend = function() {
        target.src = reader.result;
    };

    if (file) {
        reader.readAsDataURL(file);


    } else {
        target.src = "";
    }
}
</script>