<table width="550">
	<tr>
		<td width="100%" align="right" class="pageName">Itens Enviados <img src="../img/MailSend.gif" alt="Itens Enviados"></td>
	</tr>
</table>
<?php
//seleciona a tabela
$sql = mysql_query("select a.id, b.razaosoc, a.assunto, DATE_FORMAT(a.data,'%d/%m/%Y %h:%i') as data, a.lido 
from correio_franquia a
inner join franquia b on a.franquia=b.id
where a.nome=$id_franquia
order by a.data desc", $con);
$linhas = mysql_num_rows ($sql);
//caso n�o retorne linhas de emails
if ($linhas == "0") {
	echo "<table width=\"550\" border=\"0\" >
			<tr>
			  <td class=\"total\" width=\"150\">De:</td>
			  <td class=\"total\" width=\"300\">Assunto:</td>
			  <td class=\"total\" width=\"100\">Recebido:</td>
			</tr>
			<tr>
				<td class=\"titulo\" colspan=\"3\">Esta pasta est&aacute; vazia</td>
			</tr>
		  </table>";
} else {
//lista os recados para esse cliente
echo "<table border=\"0\">
	<tr>
	  <td class=\"total\"></td>
	  <td class=\"total\"></td>
	  <td class=\"total\" width=\"150\">Para:</td>
	  <td class=\"total\" width=\"300\">Assunto:</td>
	  <td class=\"total\" width=\"100\">Enviado:</td>
	  <form id=\"form1\" name=\"form1\" method=\"post\" action=\"area_restrita/d_exc_email_sel.php\">
	</tr>";

while ($coluna = mysql_fetch_array($sql)){
	$id = $coluna['id'];
	$nome = $coluna['razaosoc'];
	$assunto = $coluna['assunto'];
	$data = $coluna['data'];
	$lido = $coluna['lido'];
echo "<tr>
		<td class=\"subtitulopequeno\"><input name=\"selected[]\" type=\"checkbox\" value=\"$id\" /></td>
		<td class=\"subtitulopequeno\">";
	if ($lido==0) echo "<img src=\"../../images/aaMsgNaoLida.gif\"></td>";
	else echo "<img src=\"../../images/aaMsgLida.gif\"></td>";
	echo "<td class=\"campoesquerda\">$nome</td>
		<td class=\"subtitulopequeno\"><a href=\"painel.php?pagina1=area_restrita/d_email.php&mail=area_restrita/d_ler_email.php&id=$id\">
		  $assunto
		</a></td>
		<td class=\"subtitulopequeno\">$data</td>
	</tr>";
 } //termina o while
echo "	<tr>
	  <td class=\"titulo\" colspan=\"5\">&nbsp;</td>
	</tr>
	<tr>
		<td colspan=\"5\" align=\"right\" height=\"23\">
		<input type=\"submit\" value=\"Excluir emails selecionados\" class=\"botao3d\" />
		<a href=\"javascript:if (confirm ('Tem certeza que deseja excluir todos os emails?')) window.open('area_restrita/d_exc_email_td.php','_self');\" onMouseOver=\"window.status='excluir todo'; return true\"><span class=\"botao3d\">Excluir todos os emails</span></a>
		</form>
		</td>
	</tr>
</table>";
} //termina o if
$res = mysql_close ($con);
?>