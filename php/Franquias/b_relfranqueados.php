<?php
//require_once('../connect/sessao.php');
//session_start();

//include("web_control/funcao_php/mascaras.php");

//$name = $_SESSION["ss_name"];
//$tipo = $_SESSION["ss_tipo"];
/*if (($name=="") && ($tipo!="a") && ($tipo!="d")){
	session_unregister($_SESSION['name']);
	session_destroy();
	echo "<meta http-equiv=\"refresh\" content=\"0; url= http://www.webcontrolempresas.com.br/franquias/erro/index.php\";>";
	die;
}*/

$comando = "SELECT
			  f.id, f.usuario, f.fantasia, f.cidade, f.uf, f.fone1,
			  f.cel01socio, f.nom01socio, Date_Format(f.data_abertura, '%d/%m/%Y') AS data_abertura, 
			  Date_Format(f.data_apoio, '%d/%m/%Y') AS data_apoio, 
			  Date_Format(f.dt_cad, '%d/%m/%Y') AS dt_cad, f.cpfcnpj, g.nome AS gerente
			FROM
			  franquia f LEFT JOIN
			  gerente g ON f.id_gerente = g.id
			WHERE
			  f.tipo = 'b' AND
			  f.classificacao <> 'J'
			ORDER BY
			  f.fantasia";
$res = mysql_query ($comando, $con);
$linhas = mysql_num_rows ($res);
$linhas1 = $linhas+3;
if ($linhas == "0")
{
	echo "<table width=\"100%\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\">
			<tr height=\"20\">
			<td align=\"center\" width=\"100%\">Nenhuma franquia cadastrada!</td></tr></table>";
}
else
{
	echo "<table width=\"100%\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\" class=\"bodyText\">
	 		<tr>
				<td colspan=\"9\" height=\"1\" bgcolor=\"#999999\"></td>
			</tr>
			<tr height=\"20\" class=\"titulo\">
				<td align=\"center\">Cod</td>
				<td align=\"center\">Nome da Franquia</td>
				<td align=\"left\">CPF/CNPJ</td>
				<td align=\"left\">Telefone</td>
				<td align=\"center\">Cidade</td>				
				<td align=\"center\">UF</td>
				<td align=\"center\">Gerente</td>
				<td align=\"center\">Dt Cadastro</td>
				<td align=\"center\">Inauguracao</td>
				<td align=\"center\">Apoio</td>
			</tr>";
	for ($a=1; $a<=$linhas; $a++)
	{
		$matriz = mysql_fetch_array($res);
		$id = $matriz['id'];
		$usuario = $matriz['usuario'];
		$cpfcnpj = $matriz['cpfcnpj'];
		$razao = $matriz['fantasia'];
		$cidade = $matriz['cidade'];
		$uf = $matriz['uf'];
		$fone1 = $matriz['fone1'];
		$dt_cad = $matriz['dt_cad'];
		$gerente = $matriz['gerente'];
		$data_abertura = $matriz['data_abertura'];
		$data_apoio = $matriz['data_apoio'];
		$cel01socio = $matriz['cel01socio'];
		$nom01socio = $matriz['nom01socio'];
		$string = $razao;
		$limite = 55;
		$sizeName = strlen($string);
		//
		$string0 = $nom01socio;
		$limite0 = 25;
		$sizeName0 = strlen($string0);
		echo "<tr height=\"22\"";
		if (($a%2) == 0) {
			echo "bgcolor=\"#E5E5E5\">";
		} else {
			echo ">";
		}
		echo "<td align=\"center\">$usuario</td>
	  	      	<td align=\"left\">&nbsp;<a href=\"painel.php?pagina1=Franquias/b_altfranqueado.php&id=$id\" onMouseOver=\"window.status='Alterar franqueado'; return true\"><font color=\"#0000ff\">";
		for($num=0;$num<$limite;$num++) {
			print($string[$num]);
		}
		if($sizeName>$limite){echo"...";}
		echo "</font></a></td>
		<td align=\"left\">";

		if(strlen($cpfcnpj) == "11")echo mascaraCpf($cpfcnpj);
		else echo mascaraCnpj($cpfcnpj);

		echo "</td>
				<td align=\"left\">$fone1</td>
				<td align=\"center\">$cidade</td>			
				<td align=\"center\">$uf</td>
				<td align=\"center\">$gerente</td>
				<td align=\"center\">$dt_cad</td>
				<td align=\"center\">";
		if ($data_abertura > 0) echo "$data_abertura</td>";
		else echo " </td>";
		echo "<td>";
		if ($data_apoio > 0) echo "$data_apoio</td>";
		else echo " </td>";
		echo "	</tr>";
	}
	$a = $a - 1;
	echo "<tr class=\"subtitulodireita\">
				<td></td>
				<td colspan=\"7\">Número de total de franqueados habilitados</td>
				<td><strong>$a&nbsp;&nbsp;</strong></td>
				<td></td>
			</tr>
			<tr>
				<td colspan=\"9\" height=\"1\" bgcolor=\"#666666\"></td>
			</tr>
		</table>";
}
$res = mysql_close ($con);
?>
<br>
<center>
	<input name="button" type="button" class="botao3d" onClick="javascript: history.back();" value="Voltar" />
</center>