<!--INDEX PRINCIPAL ESTELAR-->
<?php 
include("includes/Mobile_Detect.php");
?>
<!DOCTYPE>
<html>
<head>
<meta charset="iso-8859-1" />
<title>Estelar Construction</title>
<?php 
$detect=new Mobile_Detect();
if($detect->isMobile()||$detect->isTablet())
{?>
<link href="css/estelar_mobile.css" rel="stylesheet" type="text/css">
<?php }
else
{?>
<link href="css/estelar.css" rel="stylesheet" type="text/css">
<?php	
}?>

</head>

<body>
<div id="holderindex">
<div id="centralindex">
<div id="imagen_estelar">
</div>
<div style="clear:both"></div>
<div id="acceso_usuario">
<form name="login_user" method="post" action="verify/">
	<br>
    <table align="center">
    	<tr><td class="negra2">User</td><td><input type="text" name="user" id="user"></td></tr>
        <tr><td class="negra2">Password</td><td><input type="password" name="pass" id="pass"></td></tr>
    </table>
    <br>
    <table align="center">
    	<tr><td><input type="button" value="Sign In" id="btnacceso" onClick="user_validation()"></td></tr>
    </table>
</form>
</div>
</div><!--central-->
</div><!--holder-->
</body>
<script type="text/javascript" src="scripts/estelar.js"></script>
</html>