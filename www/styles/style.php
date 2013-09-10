<?php
header('content-type: text/css');
ob_start('ob_gzhandler');
header('Cache-Control: max-age=31536000, must-revalidate');
include("../pages/connexion.php");
$query = "SELECT * FROM plan";
$req = mysql_query($query, $link) or die('Erreur SQL !<br>'.$sql.'<br>'.mysql_error());
while ($data = mysql_fetch_assoc($req))
{
?>
#piece<? echo $data['id']; ?>{
background-color: #fff;
width: <? echo $data['width']; ?>px;
height: <? echo $data['height']; ?>px;
top: <? echo $data['top']; ?>px;
left: <? echo $data['left']; ?>px;
line-height: <? echo $data['line-height']; ?>px;
border: solid <? echo $data['border']; ?>px #CCC;
position: absolute;
z-index: <? echo $data['id']; ?>;
color: black;
font-size: 20px;
text-align: <? echo $data['text-align']; ?>;
vertical-align: middle;
}

#custom<? echo $data['id']; ?>{
     position: fixed;
     display: none;
     left: 50%;
     top: 50%;
     z-index: 2000;
     padding: 10px;
     width: 640px;
     background-color: #EEEEEE;
     font-size: 12px;
     line-height: 16px;
     color: #202020;
     border : 3px outset #555555;
}


<? } ?>

a {
text-decoration:none;
}

<?
$query = "SELECT max( `width` + `left` ) AS width FROM `plan`";
$res_query = mysql_query($query, $link);
if(mysql_numrows($res_query) > 0){
$width = mysql_result($res_query,0,"width") + 2;
}
$query = "SELECT max( `height` + `top` ) AS height FROM `plan`";
$res_query = mysql_query($query, $link);
if(mysql_numrows($res_query) > 0){
$height = mysql_result($res_query,0,"height") + 2;
}
?>

#plan{
position: absolute;
padding: 15px;
margin: 15px;
height: <? echo $height; ?>px;
width: <? echo $width; ?>px;
}

#affichebouton{
position: relative; 
left: 140px;
}

#grayBack
{
     position: fixed;
     top: 0;
     left: 0;
     width: 100%;
     height: 100%;
     background-color: black;
     z-index: 1999;
     opacity: 0.5;
}

#actionneur{
width: 640px; 
height: 100px; 
margin: 0 auto;
}

.button.green {
	background: -webkit-linear-gradient(top,  rgba(170,212,79,1) 0%,rgba(116,185,49,1) 90%,rgba(106,173,45,1) 95%,rgba(96,157,41,1) 100%);
	background: -moz-linear-gradient(top,  rgba(170,212,79,1) 0%,rgba(116,185,49,1) 90%,rgba(106,173,45,1) 95%,rgba(96,157,41,1) 100%);
	background: -o-linear-gradient(top,  rgba(170,212,79,1) 0%,rgba(116,185,49,1) 90%,rgba(106,173,45,1) 95%,rgba(96,157,41,1) 100%);
	background: -ms-linear-gradient(top,  rgba(170,212,79,1) 0%,rgba(116,185,49,1) 90%,rgba(106,173,45,1) 95%,rgba(96,157,41,1) 100%);
	background: linear-gradient(top,  rgba(170,212,79,1) 0%,rgba(116,185,49,1) 90%,rgba(106,173,45,1) 95%,rgba(96,157,41,1) 100%);
	filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#aad44f', endColorstr='#609d29',GradientType=0 );
	border:1px solid #5b8821;
	padding: 5px 36px;
}

.button.red {
	background: -webkit-linear-gradient(top,  rgba(248,114,136,1) 0%,rgba(243,71,85,1) 90%,rgba(225,65,77,1) 95%,rgba(206,59,70,1) 100%);
	background: -moz-linear-gradient(top,  rgba(248,114,136,1) 0%,rgba(243,71,85,1) 90%,rgba(225,65,77,1) 95%,rgba(206,59,70,1) 100%);
	background: -o-linear-gradient(top,  rgba(248,114,136,1) 0%,rgba(243,71,85,1) 90%,rgba(225,65,77,1) 95%,rgba(206,59,70,1) 100%);
	background: -ms-linear-gradient(top,  rgba(248,114,136,1) 0%,rgba(243,71,85,1) 90%,rgba(225,65,77,1) 95%,rgba(206,59,70,1) 100%);
	background: linear-gradient(top,  rgba(248,114,136,1) 0%,rgba(243,71,85,1) 90%,rgba(225,65,77,1) 95%,rgba(206,59,70,1) 100%);
	filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#f87288', endColorstr='#ce3b46',GradientType=0 );
	border:1px solid #b0333e;
	padding: 5px 36px;
}

.button img { 
	float:left;
	width:33px;
	height:33px;
}

.button {
	width:138px;
	height:33px;
	font-size:13px;
	font-weight:bold;
	line-height:33px;
	color:#fff;
	text-shadow:0px 1px 0px rgba(0,0,0,.2);
	-webkit-border-radius:3px;
	-moz-border-radius:3px;
	border-radius:3px;
	-webkit-box-shadow:
		inset 0px 1px 0px rgba(255,255,255,.5),
		0px 1px 2px rgba(0,0,0,.3);
	-moz-box-shadow:
		inset 0px 1px 0px rgba(255,255,255,.5),
		0px 1px 2px rgba(0,0,0,.3);
	box-shadow:
		inset 0px 1px 0px rgba(255,255,255,.5),
		0px 1px 2px rgba(0,0,0,.3);
}

ul { 
margin: 0; 
padding: 0; 
float: left; 
list-style: none; 
height: 30px;
border-bottom: 
1px solid #666; 
border-left: 
1px solid #666; 
width: 640px; 
}

ul li { 
float: left; 
margin: 0; 
padding: 0; 
height: 29px; 
line-height: 29px;
border: 
1px solid #666; 
border-left: none; 
margin-bottom: -1px;
overflow: hidden; 
position: relative; 
background: #ddd; 
}

ul li a { 
text-decoration: none; 
color: #888; 
display: block; 
font-family: "Trebuchet MS"; 
font-size: 14px; 
padding: 0 20px; 
}

ul li a:hover { 
background: #ccc; 
color: #666; 
}

.ui-tabs .ui-tabs-nav li.ui-state-active { 
cursor: text; 
color: #666;
border-bottom: 1px solid #fff; 
}

.ui-tabs .ui-tabs-nav li.ui-tabs-selected a { 
position: relative;
background: #fff; 
}

.ui-tabs .ui-tabs-nav li a, .ui-tabs.ui-tabs-collapsible .ui-tabs-nav li.ui-tabs-selected a {
cursor: pointer; 
}

.ui-tabs .ui-tabs-panel { 
display: block; 
border: 1px solid #666; 
border-top: none; 
overflow: hidden; 
clear: both; 
float: left; 
background: #fff; 
margin: 0; 
width:100%
height:100%
padding-bottom: 10px
font-family: "Trebuchet MS"; 
font-size: 14px; 
}

.ui-tabs .ui-tabs-hide { 
display: none; 
}


