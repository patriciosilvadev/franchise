<?php
require "connect/sessao.php";

if ( $class == 'J' )
	$nome_classe = "Franqueado Junior";
elseif ( $class == 'X' )
	$nome_classe = "Micro Franqueado";
	
$go		   = $_POST['go'];
$codigo    = $_POST['codigo'];
$protocolo = $_POST['protocolo'];

if (empty($go)) {
?>
<script language="javascript">
//fun��o para aceitar somente numeros em determinados campos
function mascara(o,f){
    v_obj=o
    v_fun=f
    setTimeout("execmascara()",1)
}

function execmascara(){
    v_obj.value=v_fun(v_obj.value)
}
function soNumeros(v){
    return v.replace(/\D/g,"")
}
</script>

<br><br><br>
<table width=70% align="center">
  <tr>
    <td colspan="3" align="center" class="titulo">REGISTRO GERAL DE OCORR&Ecirc;NCIAS ( <?=$nome_classe?> )</td>
  </tr>
  <tr>
    <td class="subtitulodireita">&nbsp;</td>
    <td colspan="2" class="campoesquerda">&nbsp;</td>
  </tr>
  <form method="post" action="<?php $_SERVER['PHP_SELF']; ?>" >
  <tr>
    <td class="subtitulodireita" width="50%">C&oacute;digo do cliente</td>
    <td class="campoesquerda" width="40%">
       <input type="text" name="codigo" id="codigo" size="10" maxlength="6" onKeyPress="mascara(this,soNumeros)" />
	   <input type="hidden" name="go" value="ingressar" >
	</td>
    <td width="10%" class="campoesquerda"><input type="submit" value=" Enviar Consulta" name="enviar" /></td>
  </tr>
  </form>
  <tr>
    <td class="subtitulodireita">&nbsp;</td>
    <td colspan="2" class="campoesquerda">&nbsp;</td>
  </tr>
  <form method="get" action="painel.php" >
  <tr>
    <td class="subtitulodireita">Protocolo</td>
    <td class="campoesquerda">
	  <input type="text" name="protocolo" id="protocolo" size="10" maxlength="8" onKeyPress="mascara(this,soNumeros)" />
      <input type="hidden" name="pagina1" value="franqueado_jr/ocorrencia_mensagem.php" />
    </td>
    <td class="campoesquerda"><input type="submit" value=" Enviar Consulta" name="enviar" /></td>
  </tr>
  </form>
  <tr>
    <td class="subtitulodireita">Franquia MASTER</td>
    <td colspan="2" class="campoesquerda"><?php echo $nome_franquia_master; ?></td>
  </tr>
  <tr>
    <td class="subtitulodireita"><?=$nome_classe?></td>
    <td colspan="2" class="campoesquerda"><?php echo $nome_franquia; ?></td>
  </tr>
  <tr>
    <td colspan="3" class="titulo">&nbsp;</td>
  </tr>
  <tr align="right">
    <td colspan="3">&nbsp;</td>
  </tr>
</table>

<?php
} // if go=null

if ($go=='ingressar') {
	if (($tipo == "a") || ($tipo == "c")) {
		$sql = "select MID(a.logon,1,LOCATE('S', a.logon) - 1) as logon, b.id_franquia, b.codloja from logon a
				inner join cadastro b on a.codloja=b.codloja
				where MID(logon,1,LOCATE('S', logon) - 1)='$codigo'";
	} else {
		$sql = "select MID(a.logon,1,LOCATE('S', a.logon) - 1) as logon, b.id_franquia, b.codloja from logon a
				inner join cadastro b on a.codloja=b.codloja
				where MID(logon,1,LOCATE('S', logon) - 1)='$codigo' and b.id_franquia='$id_franquia_master' and b.id_franquia_jr='$id_franquia'";		
	}
	$resulta = mysql_query($sql,$con);
	$linha = mysql_num_rows($resulta);
	if ($linha == 0) {
		print"<script>alert(\"Cliente n�o existe ou nao pertence a sua Franquia!\");history.go(-1)</script>";
	} else {
		$matriz = mysql_fetch_array($resulta); 
		$codloja = $matriz['codloja'];
		echo "<meta http-equiv=\"refresh\" content=\"0; url= painel.php?pagina1=franqueado_jr/ocorrencia_mensagens.php&codloja=$codloja\";>";
	}
}
?>