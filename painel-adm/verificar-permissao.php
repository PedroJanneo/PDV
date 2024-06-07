<?php
// verificar permissao do usuario 
if ( @$_SESSION['nivel_usuario'] != 'Administrador'){
    echo "<script language='javascript'>window.location='../index.php'</script>";
}

?>