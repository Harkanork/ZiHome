<?
include("./pages/connexion.php");
include("./config/conf_zibase.php");
include("./lib/zibase.php");
$zibase = new ZiBase($ipzibase);

// Calcul de la largeur
$query = "SELECT max( `width` + `left` ) AS width FROM `plan`";
$res_query = mysql_query($query, $link);
if (mysql_numrows($res_query) > 0){
    $width = mysql_result($res_query,0,"width") + 2;
}

// Calcul de la hauteur
$query = "SELECT max( `height` + `top` ) AS height FROM `plan`";
$res_query = mysql_query($query, $link);
if (mysql_numrows($res_query) > 0){
    $height = mysql_result($res_query,0,"height") + 2;
}

// Recuperation de la largeur des icones
$query = "SELECT * FROM paramettres WHERE libelle = 'largeur icones'";
$res_query = mysql_query($query, $link);
if (mysql_numrows($res_query) > 0)
{
  $data = mysql_fetch_assoc($res_query);
  $widthIcones = $data['value'];
  $labelOffset = max($widthIcones - 30, $widthIcones / 2);
}
else
{
  $widthIcones = 60;
  $labelOffset = 30;
}

// Recuperation de la hauteur des icones
$query = "SELECT * FROM paramettres WHERE libelle = 'hauteur icones'";
$res_query = mysql_query($query, $link);
$data = mysql_fetch_assoc($res_query);
$heightIcones = $data['value'];

// Recuperation de la hauteur des icones
$query = "SELECT * FROM paramettres WHERE id = 6";
$res_query = mysql_query($query, $link);
$data = mysql_fetch_assoc($res_query);
$showAllNames = false;
if ($data['value'] == 'true')
{
  $showAllNames = true;
}

$weather = simplexml_load_file("http://wxdata.weather.com/wxdata/weather/local/".$meteo_ville."?cc=*&unit=m");
if(file_exists("img/plan/nuit.png")) {
$soleil_jour = date_create_from_format('h:i a Y-m-d', $weather->loc->sunr." ".date('Y-m-d'));
$soleil_nuit = date_create_from_format('h:i a Y-m-d', $weather->loc->suns." ".date('Y-m-d'));
$now = date_create_from_format('h:i a Y-m-d', date('h:i a Y-m-d'));
if($now<$soleil_nuit && $now>$soleil_jour) { $soleil = "jour";} else { $soleil = "nuit"; }
} else {
$soleil = "jour";
}

?>
<div id="centerplan" style="text-align: center;margin: 15px;">
<div id="plan" style="position: relative;padding: 15px;margin: auto;height: <? echo $height; ?>px;width: <? echo $width; ?>px;background-color: #ffffff;background-Position: center center;background:url(img/plan/<? echo $soleil; ?>.png);">
    <?
    $query = "SELECT * FROM plan";
    $req = mysql_query($query, $link) or die('Erreur SQL !<br>'.$sql.'<br>'.mysql_error());
    while ($data = mysql_fetch_assoc($req))
    {
        $query1 = "SELECT * FROM peripheriques WHERE periph = 'temperature' AND id_plan = '".$data['id']."'";
        $req1 = mysql_query($query1, $link) or die('Erreur SQL !<br>'.$sql.'<br>'.mysql_error());
        $data3 = mysql_fetch_assoc($req1);
        $query2 = "SELECT * FROM peripheriques WHERE periph = 'actioneur' AND id_plan = '".$data['id']."'";
        $req2 = mysql_query($query2, $link) or die('Erreur SQL !<br>'.$sql.'<br>'.mysql_error());
        $data4 = mysql_fetch_assoc($req2);
        $query3 = "SELECT * FROM peripheriques WHERE periph = 'conso' AND id_plan = '".$data['id']."'";
        $req3 = mysql_query($query3, $link) or die('Erreur SQL !<br>'.$sql.'<br>'.mysql_error());
        $data5 = mysql_fetch_assoc($req3);
        $query5 = "SELECT * FROM scenarios WHERE id_plan = '".$data['id']."'";
        $req5 = mysql_query($query5, $link) or die('Erreur SQL !<br>'.$sql.'<br>'.mysql_error());
        $data7 = mysql_fetch_assoc($req5);
        $query11 = "SELECT * FROM video WHERE id_plan = '".$data['id']."'";
        $req11 = mysql_query($query11, $link) or die('Erreur SQL !<br>'.$sql.'<br>'.mysql_error());
        $data11 = mysql_fetch_assoc($req11);
        $query12 = "SELECT * FROM peripheriques WHERE periph = 'vent' AND id_plan = '".$data['id']."'";
        $req12 = mysql_query($query12, $link) or die('Erreur SQL !<br>'.$sql.'<br>'.mysql_error());
        $data12 = mysql_fetch_assoc($req12);

        if($data3 == null && ($data4 == null || (!(isset($_SESSION['auth'])))) && $data5 == null && $data7 == null && $data11 == null && $data12 == null) {
        ?>
            <div style="background-color: #fff;background:url(../img/plan/<? echo $data['id']; ?>.jpg);background-size:<? echo $data['width']; ?>px <? echo $data['height']; ?>px;background-repeat:no-repeat;width: <? echo $data['width']; ?>px;height: <? echo $data['height']; ?>px;top: <? echo $data['top']; ?>px;left: <? echo $data['left']; ?>px;border: solid <? echo $data['border']; ?>px #777;position: absolute;z-index: <? echo $data['id']; ?>;color: black;font-size: 20px;text-align: <? echo $data['text-align']; ?>;<? echo $data['supplementaire']; ?>;">
        <?
            if ($showAllNames and $data['show-libelle'])
            {
              echo '<div style="line-height: '. $data['line-height'] . 'px;">'.$data['libelle'].'</div>';
            }
            echo '</div>'; 
          } else { ?>
            <a href="javascript:showPopup('custom<? echo $data['id']; ?>');"><div style="background-color: #fff;background:url(../img/plan/<? echo $data['id']; ?>.jpg);background-size:<? echo $data['width']; ?>px <? echo $data['height']; ?>px;background-repeat:no-repeat;width: <? echo $data['width']; ?>px;height: <? echo $data['height']; ?>px;top: <? echo $data['top']; ?>px;left: <? echo $data['left']; ?>px;border: solid <? echo $data['border']; ?>px #777;position: absolute;z-index: <? echo $data['id']; ?>;color: black;font-size: 20px;text-align: <? echo $data['text-align']; ?>;<? echo $data['supplementaire']; ?>;">
            <?
            if ($showAllNames and $data['show-libelle'])
            {
              echo '<div style="line-height: '. $data['line-height'] . 'px;">'.$data['libelle'].'</div>';
            }
            $query4 = "SELECT * FROM peripheriques WHERE periph = 'capteur' AND id_plan = '".$data['id']."' AND icone ='1'";
            $req4 = mysql_query($query4, $link) or die('Erreur SQL !<br>'.$sql.'<br>'.mysql_error());
            while($data6 = mysql_fetch_assoc($req4)) {
                if($data6['protocol'] == 6) {
                  $protocol = true;
                } else {
                    $protocol = false;
                }
                if($protocol == true) {
                    $value = $zibase->getState(substr($data6['id'], 1), $protocol);
                } else {
                    $value = $zibase->getState($data6['id'], $protocol);
                }
                if($value == "1") {
                    $ic = "c";
                } else {
                    $ic = "g";
                }
                echo "<img src=\"./img/icones/".$icone.$ic."_".$data6['logo']."\" width=\"".$widthIcones."\" heigth=\"".$heightIcones."\" style=\"position:absolute;top:".$data6['top']."px;left:".$data6['left']."px;border-style:none;\">";
            }
            $query6 = "SELECT * FROM peripheriques WHERE periph = 'actioneur' AND id_plan = '".$data['id']."' AND icone ='1'";
            $req6 = mysql_query($query6, $link) or die('Erreur SQL !<br>'.$sql.'<br>'.mysql_error());
            while($data8 = mysql_fetch_assoc($req6)) {
                if($data8['protocol'] == 6) {
                    $protocol = true;
                } else {
                    $protocol = false;
                }
                $value = $zibase->getState($data8['id'], $protocol);
                if($value == 1) {
                    $ic = "c";
                } else {
                    $ic = "g";
                }
                echo "<img src=\"./img/icones/".$icone.$ic."_".$data8['logo']."\" width=\"".$widthIcones."\" heigth=\"".$heightIcones."\" style=\"position:absolute;top:".$data8['top']."px;left:".$data8['left']."px;border-style:none;\">";
            }
            $query7 = "SELECT * FROM peripheriques WHERE periph = 'temperature' AND id_plan = '".$data['id']."' AND icone ='1'";
            $req7 = mysql_query($query7, $link) or die('Erreur SQL !<br>'.$sql.'<br>'.mysql_error());
            while($data9 = mysql_fetch_assoc($req7)) {
                $query0 = "SELECT * FROM `temperature_".$data9['nom']."` ORDER BY `date` DESC LIMIT 1";
                $req0 = mysql_query($query0, $link) or die('Erreur SQL !<br>'.$sql.'<br>'.mysql_error());
                if ($req0 && mysql_numrows($req0) > 0)
                {
                  $data0 = mysql_fetch_assoc($req0);
                  $temperature=$data0['temp'];
                  $hygro=$data0['hygro'];
                }
                else
                {
                  $temperature = ""; 
                  $hygro = ""; 
                }
                echo "<div style=\"position:absolute;top:".$data9['top']."px;left:".$data9['left']."px;border-style:none;\"><img src=\"./img/icones/".$icone."c_".$data9['logo']."\" width=\"".$widthIcones."\" heigth=\"".$heightIcones."\" style=\"position:absolute;top:0px;left:0px;border-style:none;\">";
                echo "<img src=\"./img/icones/".$icone."AndroidNumberYellow.png\" width=\"50\" style=\"position:absolute;top:0px;left:".$labelOffset."px;border-style:none;\"><span style=\"position:absolute;top:3px;left:".($labelOffset+6)."px;font-size:12px;font-weight:bold;border-style:none;\">".$temperature."&deg;</span>";
                if ($data9[show_value2])
                {
                  echo "<img src=\"./img/icones/".$icone."AndroidNumberOther.png\" width=\"50\" style=\"position:absolute;top:".($heightIcones - 22)."px;left:".$labelOffset."px;border-style:none;\"><span style=\"position:absolute;top:".($heightIcones - 19)."px;left:".($labelOffset+6)."px;font-size:12px;font-weight:bold;border-style:none;\">".$hygro."%</span>";
                }
                echo "</div>";
            }
            $query7 = "SELECT * FROM peripheriques WHERE periph = 'conso' AND id_plan = '".$data['id']."' AND icone ='1'";
            $req7 = mysql_query($query7, $link) or die('Erreur SQL !<br>'.$sql.'<br>'.mysql_error());
            while($data9 = mysql_fetch_assoc($req7)) {
              $query0 = "SELECT * FROM `conso_".$data9['nom']."` ORDER BY `date` DESC LIMIT 1";
              $req0 = mysql_query($query0, $link) or die('Erreur SQL !<br>'.$sql.'<br>'.mysql_error());
              if ($req0 && mysql_numrows($req0) > 0)
              {
                $data0 = mysql_fetch_assoc($req0);            
                $temperature=$data0['conso'];
              }
              else
              {
                $temperature = "";
              }
              echo "<div style=\"position:absolute;top:".$data9['top']."px;left:".$data9['left']."px;border-style:none;\"><img src=\"./img/icones/".$icone."c_".$data9['logo']."\" width=\"".$widthIcones."\" heigth=\"".$heightIcones."\" style=\"position:absolute;top:0px;left:0px;border-style:none;\"><img src=\"./img/icones/".$icone."AndroidNumberYellow.png\" width=\"50\" style=\"position:absolute;top:0px;left:".$labelOffset."px;border-style:none;\"><span style=\"position:absolute;top:3px;left:".($labelOffset+6)."px;font-size:12px;font-weight:bold;border-style:none;\">".$temperature."</span></div>";
            }
            $query7 = "SELECT * FROM peripheriques WHERE periph = 'vent' AND id_plan = '".$data['id']."' AND icone ='1'";
            $req7 = mysql_query($query7, $link) or die('Erreur SQL !<br>'.$sql.'<br>'.mysql_error());
            while($data9 = mysql_fetch_assoc($req7)) {
              $query0 = "SELECT * FROM `vent_".$data9['nom']."` ORDER BY `date` DESC LIMIT 1";
              $req0 = mysql_query($query0, $link) or die('Erreur SQL !<br>'.$sql.'<br>'.mysql_error());
              if ($req0 && mysql_numrows($req0) > 0)
              {
                $data0 = mysql_fetch_assoc($req0);
                $temperature=$data0['vitesse']/10;
              }
              else
              {
                $temperature = "";
              }
              echo "<div style=\"position:absolute;top:".$data9['top']."px;left:".$data9['left']."px;border-style:none;\"><img src=\"./img/icones/".$icone."c_".$data9['logo']."\" width=\"".$widthIcones."\" heigth=\"".$heightIcones."\" style=\"position:absolute;top:0px;left:0px;border-style:none;\"><img src=\"./img/icones/".$icone."AndroidNumberYellow.png\" width=\"50\" style=\"position:absolute;top:0px;left:".$labelOffset."px;border-style:none;\"><span style=\"position:absolute;top:3px;left:".($labelOffset+6)."px;font-size:12px;font-weight:bold;border-style:none;\">".$temperature."</span></div>";
            }
            ?>
        </div></a>
    <script type="text/javascript">
        $(document).ready(function() {
            $("#tabs-<? echo $data['id']; ?>").tabs();
        });
    </script>
    <div id="custom<? echo $data['id']; ?>" style="position: fixed;display: none;left: 50%;top: 50%;z-index: 2000;padding: 10px;width:640px;max-height:90%;background-color: #EEEEEE;font-size: 12px;line-height: 16px;color: #202020;border : 3px outset #555555;">
        <div id="tabs-<? echo $data['id']; ?>" class="ui-tabs ui-widget ui-widget-content ui-corner-all">
            <ul class="ui-tabs-nav ui-helper-reset ui-helper-clearfix ui-widget-header ui-corner-all" style="width: 640px;">
                <?
                if(!($data3 == null)){
                ?>
                <li class="ui-state-default ui-corner-top"><a href="#tabs-<? echo $data['id']; ?>-1">Temperature</a></li>
                <?
                }
                if((!($data4 == null)) && isset($_SESSION['auth'])){
                ?>
                <li class="ui-state-default ui-corner-top"><a href="#tabs-<? echo $data['id']; ?>-2">Actionneur</a></li>
                <? 
                } 
                if(!($data5 == null)){
                ?>
                <li class="ui-state-default ui-corner-top"><a href="#tabs-<? echo $data['id']; ?>-3">Conso-Elec</a></li>
                <?
                }
                if((!($data7 == null)) && (isset($_SESSION['auth']))){
                ?>
                <li class="ui-state-default ui-corner-top"><a href="#tabs-<? echo $data['id']; ?>-4">Scenario</a></li>
                <?
                }
                if((!($data11 == null)) && (isset($_SESSION['auth']))){
                ?>
                <li class="ui-state-default ui-corner-top"><a href="#tabs-<? echo $data['id']; ?>-5">Video</a></li>
                <?
                }
                ?>

            </ul>
            <?
            if(!($data3 == null)){
            ?>
            <div id="tabs-<? echo $data['id']; ?>-1" class="ui-tabs-panel ui-widget-content ui-corner-bottom" style="overflow:auto;max-height:600px;">
                <?
                $query1 = "SELECT * FROM peripheriques WHERE periph = 'temperature' AND id_plan = '".$data['id']."'";
                $req1 = mysql_query($query1, $link) or die('Erreur SQL !<br>'.$sql.'<br>'.mysql_error());
                while($periph = mysql_fetch_assoc($req1)) {
                $width = "640px";
                $height = "340px";
                include("./fonctions/temperature_graph_jour.php");
                }
                ?>
            </div>
            <?
            }
            if(isset($_SESSION['auth']))
            {
            if(!($data4 == null)){
            $query2 = "SELECT * FROM peripheriques WHERE periph = 'actioneur' AND id_plan = '".$data['id']."'";
            $req2 = mysql_query($query2, $link) or die('Erreur SQL !<br>'.$sql.'<br>'.mysql_error());
            ?>
            <div id="tabs-<? echo $data['id']; ?>-2" class="ui-tabs-panel ui-widget-content ui-corner-bottom ui-tabs-hide" style="overflow:auto;max-height:600px;">
                <?
                while($periph = mysql_fetch_assoc($req2)) {
                echo "<div id=\"actionneur\">";
                include("./fonctions/actioneur.php");
                echo "</div>";
                }
                ?> 
            </div>
            <?
            }
            }
            if((!($data7 == null)) && (isset($_SESSION['auth']))){
            ?>
            <div id="tabs-<? echo $data['id']; ?>-4" class="ui-tabs-panel ui-widget-content ui-corner-bottom ui-tabs-hide" style="overflow:auto;max-height:600px;">
                <?
                $query5 = "SELECT * FROM scenarios WHERE id_plan = '".$data['id']."'";
                $req5 = mysql_query($query5, $link) or die('Erreur SQL !<br>'.$sql.'<br>'.mysql_error());
                while($periph = mysql_fetch_assoc($req5)) {
                echo "<div id=\"actionneur\">";
                include("./fonctions/scenario.php");
                echo "</div>";
                }
                }
                if((!($data11 == null)) && (isset($_SESSION['auth']))){
                ?>
                <div id="tabs-<? echo $data['id']; ?>-5" class="ui-tabs-panel ui-widget-content ui-corner-bottom ui-tabs-hide" style="overflow:auto;max-height:600px;">
                <?
                $query11 = "SELECT * FROM video WHERE id_plan = '".$data['id']."'";
                $req11 = mysql_query($query11, $link) or die('Erreur SQL !<br>'.$sql.'<br>'.mysql_error());
                while($periph = mysql_fetch_assoc($req11)) {
                $width="640";
                $height="340";
                include("./fonctions/video.php");
                }
                echo "</div>";
                }
                if(!($data5 == null)){
                ?>
                <div id="tabs-<? echo $data['id']; ?>-3" class="ui-tabs-panel ui-widget-content ui-corner-bottom ui-tabs-hide" style="overflow:auto;max-height:600px;">
                    <?
                    $query1 = "SELECT * FROM peripheriques WHERE periph = 'conso' AND id_plan = '".$data['id']."'";
                    $req1 = mysql_query($query1, $link) or die('Erreur SQL !<br>'.$sql.'<br>'.mysql_error());
                    while($periph = mysql_fetch_assoc($req1)) {
                    $width = "640px";
                    $height = "340px";
                    include("./fonctions/conso_elec_graph_mois.php");
                    }
                    ?>
                </div>
                <?
                }
                ?>
            </div>
        </div>
        <? 
        }
        } ?>
    </div>
    </div>
    <script src="./js/highcharts.js"></script>

