<?php
/***************************************************
 * 	Page-tchat.php v0.1 - Discussionner.com ********
 ***************************************************/

 /**
 * Contactez support@discussionner.com pour demander un <key_authorization>
 */
$apikey_authorization = "<key_authorization>";


/**
 * un code de site à 3 caractères
 * exemple: o-xyz-...
 */
$pre = "xyz";


/**
 * Nom du site (logo)
 */
$title = "Nom-duSite";


/**
 * Autojoins (le dernier salon joint sera le salon par défaut).
 * Ne pas mettre le caractère "#".
 */
$channels = "quizz";
/**
 * ou
 * $channels = "salon1,salon2,salon3...";
 */


/**
 * Country code de l'IP
*/
$geoip_country = "00";
/**
 * ou 
 * $geoip_country = geoip_country_code_by_name($_SERVER['REMOTE_ADDR']);
 * 
 * // Ici les CI (côte d'ivoire) sont blacklistés
 * $ListBlacklistISO = array("CI");
 * if ( in_array($geoip_country, $ListBlacklistISO) ) {
 * 	echo "<html><body><h1>403 Forbidden</h1>
 * Request forbidden by administrative rules.
 * </body></html>";
 * 	exit;
 * }
 */


if ($_SERVER['REQUEST_METHOD'] === 'POST') {

	$nickname = $_POST['nick'];
	$age = $_POST['age'];
	$sex = $_POST['sex'][0];
	$location = $_POST['from'];
	$mdp = $_POST['mdp'];

}
else {

	$nickname = $_GET['nick'];
	$age = $_GET['age'];
	$sex = $_GET['sex'];
	$location = $_GET['from'];
	$mdp = $_GET['mdp'];

}


?><!doctype html>
<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
<meta charset="utf-8">
<title>Title du tchat</title>
<style>
html, body {
	margin: 0;
	width: 100%;
	height: 100%;
	overflow:hidden;
}
</style>
</head>

<body>
<?php

function enleverCaracteresSpeciaux($text) {
	$caracteres = ['À' => 'a', 'Á' => 'a', 'Â' => 'a', 'Ä' => 'a', 'à' => 'a', 'á' => 'a', 'ä' => 'a',
	'È' => 'e', 'É' => 'e', 'Ê' => 'e', 'Ë' => 'e', 'è' => 'e', 'é' => 'e', 'ê' => 'e', 'ë' => 'e',
	'Ì' => 'i', 'Í' => 'i', 'Î' => 'i', 'Ï' => 'i', 'ì' => 'i', 'í' => 'i', 'î' => 'i', 'ï' => 'i',
	'Ò' => 'o', 'Ó' => 'o', 'Ô' => 'o', 'Ö' => 'o', 'ò' => 'o', 'ó' => 'o', 'ô' => 'o', 'ö' => 'o',
	'Ù' => 'u', 'Ú' => 'u', 'Û' => 'u', 'Ü' => 'u', 'ù' => 'u', 'ú' => 'u', 'û' => 'u', 'ü' => 'u',
	'Œ' => 'oe', 'œ' => 'oe', ' ' => '_', '+' => '_'];
	 
	$chaine = $text;
	 
	 
	$resultat = str_replace(array_keys($caracteres), array_values($caracteres), $chaine);
	 
	return $resultat;
}

/**
 * On essaye de garder un ident unique pour les invités.
 * */
if (!isset($_COOKIE['ident']) || $_COOKIE['ident'] == '' ) {
	
	$username = substr(md5(uniqid(rand(1,5))), 0, 7); // génére un id unique de 7 caractères.
	$expire = 365*24*3600;
	setcookie("ident",$username,time()+$expire);

}
else {
	$username = $_COOKIE['ident'];	
}


/**
 * Remplace les caractères spéciaux dans le nick.
 */
$nickname = enleverCaracteresSpeciaux($nickname);



if ( $sex == "F" )
$sex = "F";
else if ( $sex == "H" )
$sex = "H";
else
$sex = "I";


/**
 * Construction de l'ident o-<pre>-<country|null><$username>
 * */
$ident = "o-".$pre."-".($geoip_country=="" ? "" : strtolower($geoip_country)).$username."";

$md5 = @file_get_contents('https://api.discussionner.com/external.php?module=md5_IRC_Applet&key_authorization='.$apikey_authorization.'&nickname='.$nickname.'&username='.$ident);

$construction_uri = "https://hirc.discussionner.com/?nick=".$nickname."&channels=&oChannels="+$channels+"&ident=".$ident."&id_connection=".$md5."&display=".$pseudo."&identify=".$mdp2md5."&realname=$age/$sex/".($geoip_country=="" ? "00" : strtolower($geoip_country))."&avatar=".$account_avatar."&domaine=".$_SERVER['HTTP_HOST']."&dm=".$title."";


if ( $age <= 11 ) {
	echo "Erreur âge, Veuillez sélectionner une valeur supérieure ou égale à 12";
} else { ?>
<iframe allow="geolocation; microphone; camera;" src="<?=$construction_uri;?>" height="100%" width="100%" frameborder="0"></iframe>
<?php } ?>

</body>
</html>