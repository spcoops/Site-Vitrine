<?php
//error_reporting(0);
include "config/config.php";

if(!INSTALADO){

echo "<script language='JavaScript'> window.location='instalar/index.php'; </script>";
exit();
}

$query = "SELECT COUNT(*) FROM veiculos";
$result = mysql_query($query);
$result = mysql_fetch_array($result);
$count = $result[0];

$query_c = "SELECT * FROM configuracoes where id=1";
$config = mysql_query($query_c);
$config = mysql_fetch_array($config);

$perpage = $config['perpage'];

$timestamp=time();
$timeout=time()-300;

$ip = $_SERVER['REMOTE_ADDR'];
$paginav = $_SERVER['SERVER_NAME'].$_SERVER ['REQUEST_URI'];

mysql_query("INSERT INTO useronline VALUES ('$timestamp','$ip','$paginav')");
mysql_query("DELETE FROM useronline WHERE timestamp<$timeout"); 
$result3=mysql_query("SELECT DISTINCT ip FROM useronline"); 

$usuarios = mysql_num_rows($result3);
if($usuarios == 1){
$usuarios = $usuarios. " pessoa online";
}else{
$usuarios = $usuarios. " pessoas online"; 
}
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title><?php echo $config['titulo'];?></title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link rel="shortcut icon" href="/favicon.ico" />
<script language='JavaScript' src='scripts/funcoes.js'></script>
<link href="magiczoom.css" rel="stylesheet" type="text/css" media="screen"/>
<script src="scripts/magiczoom.js" type="text/javascript"></script>
<script language="javascript" src="scripts/ajax_form.js" type="text/javascript"></script>
<script type="text/javascript" src="scripts/jquery.js"></script>
<script type="text/javascript" src="scripts/thickbox.js"></script>
<script src="SpryAssets/SpryValidationSelect.js" type="text/javascript"></script>
	<script type="text/javascript">
		
		function getValor(valor){

			$("#recebeValor").html("<option value='0'>Carregando...</option>");
			setTimeout(function(){
				$("#recebeValor").load("gatewayMARCAS.php",{id:valor})
			}, 2000);
		};
		function getValor2(valor){

			$("#recebeValor2").html("<option value='0'>Carregando...</option>");
			setTimeout(function(){
				$("#recebeValor2").load("gatewayMODELOS.php",{id:valor})
			}, 2000);
		};
    </script>
<?php
if(!$_GET['template']){
$query_lay = "SELECT * FROM templates where ativo='sim'";
}else{
$query_lay = "SELECT * FROM templates where id='$_GET[template]'";
}
$layout = mysql_query($query_lay);
$layout = mysql_fetch_array($layout);
?>
<style type="text/css">
body {
	background-color: #<?php echo $layout['cor_fundo'];?>;
	margin:0;
	padding:0;
    font: <?php echo $layout['tam_fonte'];?>px <?php echo $layout['tipo_fonte'];?>;
	background-image: url(templates/grey.gif);
}
.titulos {color:#<?php echo $layout['titulos'];?>; font-weight:bold;}

input { 
background-color: #<?php echo $layout['form_fundo'];?>; 
font: <?php echo $layout['tam_fonte'];?>px <?php echo $layout['tipo_fonte'];?>;
color: #<?php echo $layout['form_corfonte'];?>;
border:1px solid  #<?php echo $layout['form_borda'];?>;
padding:3px;
}
select { 
background-color: #<?php echo $layout['form_fundo'];?>; 
font: <?php echo $layout['tam_fonte'];?>px <?php echo $layout['tipo_fonte'];?>;
color: #<?php echo $layout['form_corfonte'];?>;
border:1px solid  #<?php echo $layout['form_borda'];?>;
padding:3px;
}
textarea { 
background-color: #<?php echo $layout['form_fundo'];?>; 
font: <?php echo $layout['tam_fonte'];?>px <?php echo $layout['tipo_fonte'];?>;
color: #<?php echo $layout['form_corfonte'];?>;
border:1px solid  #<?php echo $layout['form_borda'];?>;
}

.linha1{background-color:#<?php echo $layout['linha1'];?>;}
.linha2{background-color:#<?php echo $layout['linha2'];?>;}
.col_destaq{}
.lateral{background-color: #<?php echo $layout['fundo_menu'];?>; color: #<?php echo $layout['texto_menu'];?>;}
.menu_lateral{ font-weight:normal; color: #<?php echo $layout['link_menu'];?>; text-decoration:none;}
.menu_lateral:visited{ font-weight:normal; color: #<?php echo $layout['link_menu'];?>; text-decoration:none;}
.menu_lateral:hover{ font-weight:normal; color: #<?php echo $layout['linka_menu'];?>; text-decoration: <?php echo $layout['underline'];?>;}
.barra_sup{background-color: #<?php echo $layout['barra_superior'];?>; color:#<?php echo $layout['txt_barra_superior'];?>;}
.barra_rodape{background-color: #<?php echo $layout['rodape'];?>; color:#<?php echo $layout['cor_fonte'];?>;}
.conteudo{background-color: #<?php echo $layout['fundo_conteudo'];?>; color:#<?php echo $layout['cor_fonte'];?>;}
.destaques_tit{background-color: #<?php echo $layout['destaq_titulo'];?>; font-weight:bold;}
a{text-decoration:<?php if($layout['underline'] == "sim"){echo"underline";}else{echo"none";}?>; color:#<?php echo $layout['links'];?>;}
a:hover{color: #<?php echo $layout['linksa'];?>;}
.hint {font-family: <?php echo $layout['tipo_fonte'];?>; font-size: 10px; color: #990000; line-height: 14px }
.mostrar_titulo{background-color: #<?php echo $layout['mostrar_titulo'];?>; font-weight: bold; color: #<?php echo $layout['cor_fonte'];?>; font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 12px;}
.mostrar_auto{ border:#<?php echo $layout['info_borda'];?> solid 1px; background-color:#<?php echo $layout['info_fundo'];?>;}
.print{font-family: <?php echo $layout['tipo_fonte'];?>; font-size: <?php echo $layout['tam_fonte'];?>px; color: #FFFFFF; text-decoration: none; }
.barra_mostrar{background-color: #<?php echo $layout['barra_mostrar'];?>;}
.borda_destaq {
		background-color:#<?php echo $layout['col_destaq'];?>;
		border: dashed #CCCCCC 1px;
		cursor: pointer;
		width: 121px;
		height:170px;
		margin:2px;
		padding:1px;
        float: left;
		
}
.bordaoff {
        background-color:#<?php echo $layout['col_destaq'];?>;
		border: dashed #CCCCCC 1px;
		width: 121px;
		height:170px;
		margin:2px;
		padding:1px;
        float: left;

}
.table2 {
		background-color: #<?php echo $layout['col_destaqa'];?>;
		border: dashed #CCCCCC 1px;
		cursor: pointer;
		width: 121px;
		height:170px;
		margin:2px;
		padding:1px;
        float: left;

}

#button {
        width: 90%;
        padding: 0 0 1em 0;
        margin-bottom: 1em;
        font-family: <?php echo $layout['tipo_fonte'];?>;
                /*'Trebuchet MS', 'Lucida Grande', Verdana, Arial, sans-serif;*/
        font-size : <?php echo $layout['tam_fonte'];?>px;
        background-color: #<?php echo $layout['fundo_menu'];?>;
        color: #333;
        }

        #button ul {
                list-style: none;
                margin: 0;
                padding: 0;
                border: none;
                }

        #button li {
                border-top: 1px solid #<?php echo $layout['bnt_borda'];?>;
				border-bottom: 1px solid #<?php echo $layout['bnt_borda'];?>;
				border-left: 1px solid #<?php echo $layout['bnt_borda'];?>;
                border-right: 1px solid #<?php echo $layout['bnt_borda'];?>;
                margin-top: 2px;
                list-style: none;
                list-style-image: none;
                }

        #button li a {
                display: block;
                padding: 3px 5px 3px 0.5em;
                background-color: #<?php echo $layout['bnt_bg'];?>;
                color: #<?php echo $layout['link_menu'];?>;
                text-decoration: none;
                width: 100%;
                }

        html>body #button li a {
                width: auto;
                }

        #button li a:hover {
                border-left: 10px solid #<?php echo $layout['bnt_borda_ativa'];?>;
                border-right: 10px solid #<?php echo $layout['bnt_borda_ativa'];?>;
                background-color: #<?php echo $layout['bnt_bg_ativo'];?>;
                color: #<?php echo $layout['linka_menu'];?>;
                }

        #button li #active {
                border-left: 10px solid #<?php echo $layout['bnt_borda_ativa'];?>;
                border-right: 10px solid #<?php echo $layout['bnt_borda_ativa'];?>;
                background-color: #<?php echo $layout['bnt_bg_ativo'];?>;
                color: #<?php echo $layout['link_menu'];?>;
                }
.trans{opacity: 0.2;
       alpha(opacity = 20);
	  }
</style>
<script src="scripts/AC_RunActiveContent.js" type="text/javascript"></script>
<link href="SpryAssets/SpryValidationSelect.css" rel="stylesheet" type="text/css" />
<link href="thickbox.css" rel="stylesheet" type="text/css" />
</head>
<body>
<table width="1006" border="0" align="center" cellpadding="0" cellspacing="0">
  
  <tr>
    <td colspan="3" align="left" valign="top"><table width="100%" border="0" cellpadding="0" cellspacing="0">
        <tr align="left" valign="top" bgcolor="#<?php echo $layout['cor_topo'];?>">
          <td width="25%"><img src="templates/<?php echo $config['logo'];?>" width="250" height="100" />          </td>
          <td width="75%" align="center" valign="middle">
<?php
$query = "SELECT * FROM banner WHERE area='a' AND maxexib > 0 ORDER by RAND() LIMIT 1";
$consulta = mysql_query($query);
$area1 = mysql_fetch_array($consulta);

if($area1['maxexib'] != "99999999"){
$area1['maxexib'] -= 1;
$update = "UPDATE banner SET maxexib=$area1[maxexib] WHERE codigo='$area1[codigo]'";
mysql_query($update);
}

$area1['exibicoes'] += 1;
$update2 = "UPDATE banner SET exibicoes=$area1[exibicoes] WHERE codigo='$area1[codigo]'";
mysql_query($update2);

if($area1['tipo'] == "3"){
?>
<object classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=9,0,28,0" width="728" height="90">
      <param name="movie" value="banners/<?php echo $area1['grafico'];?>" />
      <param name="quality" value="high" />
      <embed src="banners/<?php echo $area1['grafico'];?>" quality="high" pluginspage="http://www.adobe.com/shockwave/download/download.cgi?P1_Prod_Version=ShockwaveFlash" type="application/x-shockwave-flash" width="728" height="90"></embed>
    </object>
<?php
}else{
?>
<a href="banner.php?id=<?php echo $area1['codigo'];?>" target="_blank"><img border="0" src="banners/<?php echo $area1['grafico'];?>" width="728" height="90"></a>
<?php } ?>          </td>
        </tr>
                <tr align="left" valign="top">
          <td colspan="2" bgcolor="#000000"><img src="design/blank.gif" width="1" height="1" /></td>
        </tr>

        <tr align="left" valign="top">
          <td height="30" colspan="2" align="right" valign="middle" class="barra_sup"><?php echo $usuarios; ?>&nbsp;<br />
          <b><?php echo $count?>          </b> ve&iacute;culos cadastrados&nbsp;</td>
        </tr>
        <tr align="left" valign="top">
          <td colspan="2" bgcolor="#000000"><img src="design/blank.gif" width="1" height="1" /></td>
        </tr>
    </table></td>
  </tr>
  <tr>
    <td colspan="3" align="left" valign="top" class="conteudo"></td>
  </tr>
  <tr>
    <td width="174" valign="top" class="lateral"><table width="100%" border="0" align="center" cellpadding="0" cellspacing="1">
      
      <tr>
        <td>
  <table width="174" border="0" align="center" cellpadding="0" cellspacing="0">
    <tr>
      <td><img src="templates/borda_top.gif" width="174" height="10" /></td>
        </tr>
    <tr>
      <td background="templates/borda_corpo.gif"><table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td align="center"><b>Navegação</b></td>
            </tr>
        <tr>
          <td align="center"><div id="button">
            <ul>
              <li><a href="index.php" class="menu_lateral">Principal</a></li>
<?php
$result = mysql_query("SELECT * FROM paginas WHERE ver='sim' ORDER BY idp DESC");
$total = mysql_num_rows($result);
if ($total>0) {
while( $linkm = mysql_fetch_array($result) )
{
?>
<li><a href="?pg=paginas&id=<?php echo $linkm['idp']; ?>" class="menu_lateral"><?php echo $linkm['titulo']; ?></a></li>
<?php
}
}
?>
                          <li><a href="?pg=estoque" class="menu_lateral">Nosso estoque</a></li>
                          <li><a href="?pg=noticias" class="menu_lateral">Noticias</a></li>
                          <li><a href="?pg=ipva" class="menu_lateral">IPVA/Multas</a></li>
                          <li><a href="?pg=simulador" class="menu_lateral">Simulador</a></li>
                          <li><a href="?pg=links" class="menu_lateral">Links uteis</a></li>
                          <li><a href="?pg=contatos" class="menu_lateral">Contatos</a></li>
                        </ul></div></td>
            </tr>
        
        </table></td>
        </tr>
    <tr>
      <td><img src="templates/borda_rodape.gif" width="174" height="10" /></td>
        </tr>
    </table><br />
  <table width="174" border="0" align="center" cellpadding="0" cellspacing="0">
    <tr>
      <td><img src="templates/borda_top.gif" width="174" height="10" /></td>
        </tr>
    <tr>
      <td background="templates/borda_corpo.gif"><table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td align="center"><b>Principais marcas</b></td>
            </tr>
        <?php
		include "pmarcas.php";
		 for ($n = 0; $n < count($mset); $n++) {
		 ?>
        <tr>
          <td align="center"><img src="marcas/<?php echo $mset[$n];?>" width="140" height="74" /></td>
            </tr>
        <?php } ?>
        </table></td>
        </tr>
    <tr>
      <td><img src="templates/borda_rodape.gif" width="174" height="10" /></td>
        </tr>
    </table></td>
        </tr>
    </table></td>
    <td valign="top" class="conteudo"><?
$pags = $_GET['pg'];
   if(@isset( $pags )){
   if (file_exists($pags.".php")) {
   		include($pags.".php");
   }else{
        include("aviso.php");
   }
   }else{
   		include('inicial.php');
   }
?></td>
    <td width="174" align="center" valign="top" class="lateral"><table width="100%" border="0" align="center" cellpadding="0" cellspacing="1">
      
      <tr>
        <td>
  <table width="174" border="0" align="center" cellpadding="0" cellspacing="0">
    <tr>
      <td><img src="templates/borda_top.gif" width="174" height="10" /></td>
        </tr>
    <tr>
      <td background="templates/borda_corpo.gif"><table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td align="center"><b>Pesquisas</b></td>
            </tr>
        <tr>
          <td align="center">
		  <div id="div_status_carregamento" align="center"></div>
		  <form action="?pg=estoque" method="post" name="busca"><table width="90%" border="0" align="center" cellpadding="2" cellspacing="2">
                <tr>
                  <td>Categoria</td>
                </tr>
                <tr>
                  <td><span id="spryselect1">
                    <select name="categoria" onchange="getValor(this.value, 0)" style='width:100%'>
                      <option value="" selected="selected">Selecione a categoria</option>
                      <?php
                  $sql1 = "SELECT * FROM categorias ORDER BY categ_id";
				  $rscateg = mysql_query($sql1);
                  while($row = mysql_fetch_array($rscateg))
                  {
                  echo "<option value=\"".$row['categ_id']."\">".$row['categoria']."\n  "; }
				  ?>
                    </select>
                    </span></td>
                </tr>
                <tr>
                  <td>Marca</td>
                </tr>
                <tr>
                  <td><span id="spryselect2">
                    <select name="recebeValor" id="recebeValor" style='width:100%' onchange="getValor2(this.value, 0)">
                      <option value="">Selecione a marca</option>
                    </select>
                    </span></td>
                </tr>
                <tr>
                  <td>Modelo</td>
                </tr>
                <tr>
                  <td><span id="spryselect3">
                    <select name='model' id="recebeValor2" style='width:100%'>
                      <option value="">Selecione o modelo</option>
                    </select>
                    </span></td>
                </tr>
                <tr>
                  <td>Condi&ccedil;&atilde;o</td>
                </tr>
                <tr>
                  <td><select name='condicao' style='width:100%' tabindex='6'>
                    <option value=''>Selecione a condição</option>
                    <option value='Novo'>Veículo novo</option>
                    <option value='Usado'>Veículo usado</option>
                  </select></td>
                </tr>
                <tr>
                  <td>Ano de fabricação</td>
                </tr>
                <tr>
                  <td><input name="ano" type="text" style="width:140px;" /></td>
                  </tr>
                <tr>
                  <td align="center"><input name="submit" type="submit" value="Buscar ve&iacute;culo" /></td>
                </tr>
                <tr>
                  <td align="center"><a href="#">Busca avan&ccedil;ada</a></td>
                </tr>
              </table>
          </form>                </td>
            </tr>
        
        </table></td>
        </tr>
    <tr>
      <td><img src="templates/borda_rodape.gif" width="174" height="10" /></td>
        </tr>
    </table><br />
  <table width="174" border="0" align="center" cellpadding="0" cellspacing="0">
    <tr>
      <td><img src="templates/borda_top.gif" width="174" height="10" /></td>
        </tr>
    <tr>
      <td background="templates/borda_corpo.gif"><table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td align="center"><b>Publicidades</b></td>
            </tr>
<?php
$result = mysql_query("SELECT * FROM banner WHERE area='c' AND maxexib > 0 ORDER BY RAND()");
$total = mysql_num_rows($result);
if ($total>0) {
while( $area3 = mysql_fetch_array($result) )
{
?>
        <tr>
          <td align="center">
<?php

if($area3['maxexib'] != "99999999"){

$area3['maxexib'] -= 1;
$update = "UPDATE banner SET maxexib=$area3[maxexib] WHERE codigo='$area3[codigo]'";
mysql_query($update);
}

$area3['exibicoes'] += 1;
$update2 = "UPDATE banner SET exibicoes=$area3[exibicoes] WHERE codigo='$area3[codigo]'";
mysql_query($update2);

if($area1['tipo'] == "3"){
?>
<object classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=9,0,28,0" width="163" height="70">
      <param name="movie" value="banners/<?php echo $area3['grafico'];?>" />
      <param name="quality" value="high" />
      <embed src="banners/<?php echo $area3['grafico'];?>" quality="high" pluginspage="http://www.adobe.com/shockwave/download/download.cgi?P1_Prod_Version=ShockwaveFlash" type="application/x-shockwave-flash" width="163" height="70"></embed>
    </object>
<?php
}else{
?>
<a href="banner.php?id=<?php echo $area3['codigo'];?>" target="_blank"><img border="0" src="banners/<?php echo $area3['grafico'];?>" width="160" height="70"></a>
<?php } ?>          </td>
            </tr>
<?php
}
}else{
?>
        <tr>
          <td align="center">&nbsp;</td>
            </tr>
<?php } ?>
        </table></td>
        </tr>
    <tr>
      <td><img src="templates/borda_rodape.gif" width="174" height="10" /></td>
        </tr>
    </table></td>
        </tr>
      
    </table></td>
  </tr>
  <tr>
    <td height="25" colspan="3" valign="top" class="lateral">&nbsp;</td>
  </tr>
          <tr align="left" valign="top">
          <td colspan="3" bgcolor="#000000"><img src="design/blank.gif" width="1" height="1" /></td>
        </tr>
  <tr class="barra_rodape">
    <td height="40" colspan="3" align="center" valign="middle"><table width="100%" border="0" cellspacing="1" cellpadding="1">
  <tr>
    <td align="center"> Copyright 2011 <?php echo $config['titulo'];?> - Todos os direitos reservados. </td>
  </tr>
</table></td>
  </tr>
</table>
<script type="text/javascript">
<!--
var spryselect1 = new Spry.Widget.ValidationSelect("spryselect1");
var spryselect2 = new Spry.Widget.ValidationSelect("spryselect2");
var spryselect3 = new Spry.Widget.ValidationSelect("spryselect3");
//-->
</script>
</body>
</html>