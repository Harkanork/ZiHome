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
  $labelOffsetLeft = max($widthIcones - 30, $widthIcones / 2);
}
else
{
  $widthIcones = 60;
  $labelOffsetLeft = 30;
}

// Recuperation de la hauteur des icones
$query = "SELECT * FROM paramettres WHERE libelle = 'hauteur icones'";
$res_query = mysql_query($query, $link);
$data = mysql_fetch_assoc($res_query);
if (mysql_numrows($res_query) > 0)
{
  $heightIcones = $data['value'];
}
else
{
  $heightIcones = 60;
}

if ($heightIcones < 40)
{
  $labelWidth = 30;
  $labelOffsetTop = $heightIcones - 13;
  $labelFontSize = 8;
  $labelFontOffsetTop = 1;
  $labelFontOffsetLeft = 3; 
}
else
{
  $labelWidth = 50;
  $labelOffsetTop = $heightIcones - 22; 
  $labelFontSize = 12;
  $labelFontOffsetTop = 3;
  $labelFontOffsetLeft = 6;
}

// Recuperation de la hauteur des icones
$query = "SELECT * FROM paramettres WHERE id = 6";
$res_query = mysql_query($query, $link);
$data = mysql_fetch_assoc($res_query);
$showAllNames = false;
if ($data['value'] == 'true')
{
  $showAllNames = true;
}
$image_fond = "";
if(file_exists("img/plan/jour.png")) {
  $image_fond = "img/plan/jour.png";
}
$weather = simplexml_load_file("http://wxdata.weather.com/wxdata/weather/local/".$meteo_ville."?cc=*&unit=m");
if(file_exists("img/plan/nuit.png")) {
  $soleil_jour = date_create_from_format('h:i a Y-m-d', $weather->loc->sunr." ".date('Y-m-d'));
  $soleil_nuit = date_create_from_format('h:i a Y-m-d', $weather->loc->suns." ".date('Y-m-d'));
  $now = date_create_from_format('h:i a Y-m-d', date('h:i a Y-m-d'));
  if($now<$soleil_nuit && $now>$soleil_jour) 
  { 
    $soleil = "jour"; 
    $image_fond = "img/plan/jour.png"; 
  } 
  else 
  { 
    $soleil = "nuit"; 
    $image_fond = "img/plan/nuit.png"; 
  }
} else {
  $soleil = "jour";
}

// METEO
$meteoIcon = $weather->cc->icon;

// default values
$meteoIconShow = true;
$meteoIconFolder = "colorful";
$meteoIconLeft = 10;
$meteoIconTop = 10;
$meteoIconWidth = 50;
$meteoIconHeight = 50;

// Read values from the database
$query = "SELECT * FROM paramettres WHERE id >= 11 and id <= 16";
$req = mysql_query($query, $link) or die('Erreur SQL !<br>'.$sql.'<br>'.mysql_error());
while ($data = mysql_fetch_assoc($req))
{
  switch ($data['id'])
  {
    case 11:
    {
      if ($data['value'] == "true")
      {
        $meteoIconShow = true;
      }
      else
      {
        $meteoIconShow = false;
      }
      break;
    }
    case 12:
    {
      $meteoIconFolder = $data['value'];
      break;
    }
    case 13:
    {
      $meteoIconWidth = $data['value']; 
      break;
    }
    case 14:
    {
      $meteoIconHeight = $data['value'];
      break;
    }
    case 15:
    {
      $meteoIconLeft = $data['value'];
      break;
    }
    case 16:
    {
      $meteoIconTop = $data['value'];
      break;
    }                       
  }
}

?>
<div id="centerplan" style="text-align: center;margin: 15px;">
<div id="plan" style="position: relative;padding: 15px;margin: auto;height: <? echo $height; ?>px;width: <? echo $width; ?>px;background-color: #ffffff;background-Position: center center;background:url(<? echo $image_fond; ?>);">
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
        $query13 = "SELECT * FROM peripheriques WHERE periph = 'pluie' AND id_plan = '".$data['id']."'";
        $req13 = mysql_query($query13, $link) or die('Erreur SQL !<br>'.$sql.'<br>'.mysql_error());
        $data13 = mysql_fetch_assoc($req13);
        $query14 = "SELECT * FROM peripheriques WHERE periph = 'luminosite' AND id_plan = '".$data['id']."'";
        $req14 = mysql_query($query14, $link) or die('Erreur SQL !<br>'.$sql.'<br>'.mysql_error());
        $data14 = mysql_fetch_assoc($req14);
        $img = "";
        if(file_exists("./img/plan/".$data['id'].".jpg")) {
          $img = "./img/plan/".$data['id'].".jpg";
        }

        if($data3 == null && $data4 == null && $data5 == null && $data7 == null && $data11 == null && $data12 == null && $data13 == null && $data14 == null) {
        ?>
            <div style="background-color: #fff;background:url(<? echo $img; ?>);background-size:<? echo $data['width']; ?>px <? echo $data['height']; ?>px;background-repeat:no-repeat;width: <? echo $data['width']; ?>px;height: <? echo $data['height']; ?>px;top: <? echo $data['top']; ?>px;left: <? echo $data['left']; ?>px;border: solid <? echo $data['border']; ?>px #777;position: absolute;z-index: <? echo $data['id']; ?>;color: black;font-size: 20px;text-align: <? echo $data['text-align']; ?>;<? echo $data['supplementaire']; ?>;">
        <?
            if ($showAllNames and $data['show-libelle'])
            {
              echo '<div style="line-height: '. $data['line-height'] . 'px;">'.$data['libelle'].'</div>';
            }
            echo '</div>'; 
          } else { ?>
            <a href="javascript:showPopup('custom<? echo $data['id']; ?>');"><div style="background-color: #fff;background:url(<? echo $img; ?>);background-size:<? echo $data['width']; ?>px <? echo $data['height']; ?>px;background-repeat:no-repeat;width: <? echo $data['width']; ?>px;height: <? echo $data['height']; ?>px;top: <? echo $data['top']; ?>px;left: <? echo $data['left']; ?>px;border: solid <? echo $data['border']; ?>px #777;position: absolute;z-index: <? echo $data['id']; ?>;color: black;font-size: 20px;text-align: <? echo $data['text-align']; ?>;<? echo $data['supplementaire']; ?>;">
            <?
            if ($showAllNames and $data['show-libelle'])
            {
              echo '<div style="line-height: '. $data['line-height'] . 'px;">'.$data['libelle'].'</div>';
            }
// ----- Capteur            
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
                if ($data6['texte'])
                {
                  if($data6['libelle'] == ""){
                    $nom = $data6['nom'];
                  } else {
                    $nom = $data6['libelle'];
                  }        
                  echo "<div style=\"position:absolute;top:".($data6['top'] + $heightIcones)."px;left:". ($data6['left'] - 10)."px;width:".($widthIcones + 20)."px;padding:2px;font-size:".$labelFontSize."px;font-weight:bold;font-family:sans-serif;border-style:none;background-color:rgba(255, 255, 255, 0.7);text-align:center;\">".$nom."</div>";          
                }                                
            }
// ----- Actionneur            
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
                if ($data8['texte'])
                {
                  if($data8['libelle'] == ""){
                    $nom = $data8['nom'];
                  } else {
                    $nom = $data8['libelle'];
                  }        
                  echo "<div style=\"position:absolute;top:".($data8['top'] + $heightIcones)."px;left:". ($data8['left'] - 10)."px;width:".($widthIcones + 20)."px;padding:2px;font-size:".$labelFontSize."px;font-weight:bold;font-family:sans-serif;border-style:none;background-color:rgba(255, 255, 255, 0.7);text-align:center;\">".$nom."</div>";          
                }                
            }
// ----- Temperature            
            $query7 = "SELECT * FROM peripheriques WHERE periph = 'temperature' AND id_plan = '".$data['id']."' AND icone ='1'";
            $req7 = mysql_query($query7, $link) or die('Erreur SQL !<br>'.$sql.'<br>'.mysql_error());
            while($data9 = mysql_fetch_assoc($req7)) 
            {
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
                echo "<img src=\"./img/icones/".$icone."AndroidNumberYellow.png\" width=\"".$labelWidth."\" style=\"position:absolute;top:0px;left:".$labelOffsetLeft."px;border-style:none;\"><span style=\"position:absolute;top:".$labelFontOffsetTop."px;left:".($labelOffsetLeft + $labelFontOffsetLeft)."px;font-size:".$labelFontSize."px;font-weight:bold;border-style:none;\">".$temperature."&deg;</span>";
                if ($data9['show_value2'])
                {
                  echo "<img src=\"./img/icones/".$icone."AndroidNumberOther.png\" width=\"".$labelWidth."\" style=\"position:absolute;top:".$labelOffsetTop."px;left:".$labelOffsetLeft."px;border-style:none;\"><span style=\"position:absolute;top:".($labelOffsetTop + $labelFontOffsetTop)."px;left:".($labelOffsetLeft + $labelFontOffsetLeft)."px;font-size:".$labelFontSize."px;font-weight:bold;border-style:none;\">".$hygro."%</span>";
                }
                echo "</div>";

                if ($data9['texte'])
                {
                  if($data9['libelle'] == ""){
                    $nom = $data9['nom'];
                  } else {
                    $nom = $data9['libelle'];
                  }        
                  echo "<div style=\"position:absolute;top:".($data9['top'] + $heightIcones)."px;left:". ($data9['left'] - 10)."px;width:".($widthIcones + 20)."px;padding:2px;font-size:".$labelFontSize."px;font-weight:bold;font-family:sans-serif;border-style:none;background-color:rgba(255, 255, 255, 0.7);text-align:center;\">".$nom."</div>";          
                }
                
            }
// ----- Conso electrique            
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
              echo "<div style=\"position:absolute;top:".$data9['top']."px;left:".$data9['left']."px;border-style:none;\"><img src=\"./img/icones/".$icone."c_".$data9['logo']."\" width=\"".$widthIcones."\" heigth=\"".$heightIcones."\" style=\"position:absolute;top:0px;left:0px;border-style:none;\">";
              echo "<img src=\"./img/icones/".$icone."AndroidNumberYellow.png\" width=\"".$labelWidth."\" style=\"position:absolute;top:0px;left:".$labelOffsetLeft."px;border-style:none;\"><span style=\"position:absolute;top:".$labelFontOffsetTop."px;left:".($labelOffsetLeft + $labelFontOffsetLeft)."px;font-size:".$labelFontSize."px;font-weight:bold;border-style:none;\">".$temperature."</span></div>";
              if ($data9['texte'])
              {
                if($data9['libelle'] == ""){
                  $nom = $data9['nom'];
                } else {
                  $nom = $data9['libelle'];
                }        
                echo "<div style=\"position:absolute;top:".($data9['top'] + $heightIcones)."px;left:". ($data9['left'] - 10)."px;width:".($widthIcones + 20)."px;padding:2px;font-size:".$labelFontSize."px;font-weight:bold;font-family:sans-serif;border-style:none;background-color:rgba(255, 255, 255, 0.7);text-align:center;\">".$nom."</div>";          
              }              
            }
// ----- Vent            
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
              echo "<div style=\"position:absolute;top:".$data9['top']."px;left:".$data9['left']."px;border-style:none;\"><img src=\"./img/icones/".$icone."c_".$data9['logo']."\" width=\"".$widthIcones."\" heigth=\"".$heightIcones."\" style=\"position:absolute;top:0px;left:0px;border-style:none;\">";
              echo "<img src=\"./img/icones/".$icone."AndroidNumberYellow.png\" width=\"".$labelWidth."\" style=\"position:absolute;top:0px;left:".$labelOffsetLeft."px;border-style:none;\"><span style=\"position:absolute;top:".$labelFontOffsetTop."px;left:".($labelOffsetLeft + $labelFontOffsetLeft)."px;font-size:".$labelFontSize."px;font-weight:bold;border-style:none;\">".$temperature."</span></div>";
              if ($data9['texte'])
              {
                if($data9['libelle'] == ""){
                  $nom = $data9['nom'];
                } else {
                  $nom = $data9['libelle'];
                }        
                echo "<div style=\"position:absolute;top:".($data9['top'] + $heightIcones)."px;left:". ($data9['left'] - 10)."px;width:".($widthIcones + 20)."px;padding:2px;font-size:".$labelFontSize."px;font-weight:bold;font-family:sans-serif;border-style:none;background-color:rgba(255, 255, 255, 0.7);text-align:center;\">".$nom."</div>";          
              }              
            }
// ----- Pluie            
            $query7 = "SELECT * FROM peripheriques WHERE periph = 'pluie' AND id_plan = '".$data['id']."' AND icone ='1'";
            $req7 = mysql_query($query7, $link) or die('Erreur SQL !<br>'.$sql.'<br>'.mysql_error());
            while($data9 = mysql_fetch_assoc($req7)) {
              $query0 = "SELECT * FROM `pluie_".$data9['nom']."` ORDER BY `date` DESC LIMIT 1";
              $req0 = mysql_query($query0, $link) or die('Erreur SQL !<br>'.$sql.'<br>'.mysql_error());
              if ($req0 && mysql_numrows($req0) > 0)
              {
                $data0 = mysql_fetch_assoc($req0);
                $valeur=$data0['pluie'];
              }
              else
              {
                $valeur = "";
              }
              echo "<div style=\"position:absolute;top:".$data9['top']."px;left:".$data9['left']."px;border-style:none;\"><img src=\"./img/icones/".$icone."c_".$data9['logo']."\" width=\"".$widthIcones."\" heigth=\"".$heightIcones."\" style=\"position:absolute;top:0px;left:0px;border-style:none;\">";
              echo "<img src=\"./img/icones/".$icone."AndroidNumberYellow.png\" width=\"".$labelWidth."\" style=\"position:absolute;top:0px;left:".$labelOffsetLeft."px;border-style:none;\"><span style=\"position:absolute;top:".$labelFontOffsetTop."px;left:".($labelOffsetLeft + $labelFontOffsetLeft)."px;font-size:".$labelFontSize."px;font-weight:bold;border-style:none;\">".$valeur."</span></div>";
              if ($data9['texte'])
              {
                if($data9['libelle'] == ""){
                  $nom = $data9['nom'];
                } else {
                  $nom = $data9['libelle'];
                }        
                echo "<div style=\"position:absolute;top:".($data9['top'] + $heightIcones)."px;left:". ($data9['left'] - 10)."px;width:".($widthIcones + 20)."px;padding:2px;font-size:".$labelFontSize."px;font-weight:bold;font-family:sans-serif;border-style:none;background-color:rgba(255, 255, 255, 0.7);text-align:center;\">".$nom."</div>";          
              }              
            }
// ----- Luminosite            
            $query7 = "SELECT * FROM peripheriques WHERE periph = 'luminosite' AND id_plan = '".$data['id']."' AND icone ='1'";
            $req7 = mysql_query($query7, $link) or die('Erreur SQL !<br>'.$sql.'<br>'.mysql_error());
            while($data9 = mysql_fetch_assoc($req7)) {
              $query0 = "SELECT * FROM `luminosite_".$data9['nom']."` ORDER BY `date` DESC LIMIT 1";
              $req0 = mysql_query($query0, $link) or die('Erreur SQL !<br>'.$sql.'<br>'.mysql_error());
              if ($req0 && mysql_numrows($req0) > 0)
              {
                $data0 = mysql_fetch_assoc($req0);
                $valeur=$data0['lum'];
              }
              else
              {
                $valeur = "";
              }
              echo "<div style=\"position:absolute;top:".$data9['top']."px;left:".$data9['left']."px;border-style:none;\"><img src=\"./img/icones/".$icone."c_".$data9['logo']."\" width=\"".$widthIcones."\" heigth=\"".$heightIcones."\" style=\"position:absolute;top:0px;left:0px;border-style:none;\">";
              echo "<img src=\"./img/icones/".$icone."AndroidNumberYellow.png\" width=\"".$labelWidth."\" style=\"position:absolute;top:0px;left:".$labelOffsetLeft."px;border-style:none;\"><span style=\"position:absolute;top:".$labelFontOffsetTop."px;left:".($labelOffsetLeft + $labelFontOffsetLeft)."px;font-size:".$labelFontSize."px;font-weight:bold;border-style:none;\">".$valeur."</span></div>";
              if ($data9['texte'])
              {
                if($data9['libelle'] == ""){
                  $nom = $data9['nom'];
                } else {
                  $nom = $data9['libelle'];
                }        
                echo "<div style=\"position:absolute;top:".($data9['top'] + $heightIcones)."px;left:". ($data9['left'] - 10)."px;width:".($widthIcones + 20)."px;padding:2px;font-size:".$labelFontSize."px;font-weight:bold;font-family:sans-serif;border-style:none;background-color:rgba(255, 255, 255, 0.7);text-align:center;\">".$nom."</div>";          
              }              
            }
            ?>
        </div></a>
    <? 
      if ($meteoIconShow)
      {
        echo '<img src="./img/meteo/' . $meteoIconFolder . '/' . $meteoIcon . '.png" style="position:absolute;top:' . $meteoIconTop . 'px;left:' . $meteoIconLeft . 'px;';
        if ($meteoIconHeight)
        {
          echo 'height:' . $meteoIconHeight . 'px;';
        }
        if ($meteoIconWidth)
        {
          echo 'width:' . $meteoIconWidth . 'px;';
        }
        echo 'z-index:0"/>';
      } 
    ?> 
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
                <li class="ui-state-default ui-corner-top"><a href="#tabs-<? echo $data['id']; ?>-1">Temp&eacute;rature</a></li>
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
                <li class="ui-state-default ui-corner-top"><a href="#tabs-<? echo $data['id']; ?>-4">Sc&eacute;nario</a></li>
                <?
                }
                if((!($data11 == null)) && (isset($_SESSION['auth']))){
                ?>
                <li class="ui-state-default ui-corner-top"><a href="#tabs-<? echo $data['id']; ?>-5">Vid&eacute;o</a></li>
                <?
                }
                if ($data12 != null){
                ?>
                <li class="ui-state-default ui-corner-top"><a href="#tabs-<? echo $data['id']; ?>-6">Vent</a></li>
                <?
                }
                if ($data13 != null){
                ?>
                <li class="ui-state-default ui-corner-top"><a href="#tabs-<? echo $data['id']; ?>-7">Pr&eacute;cipitation</a></li>
                <?
                }                                 
                if ($data14 != null){
                ?>
                <li class="ui-state-default ui-corner-top"><a href="#tabs-<? echo $data['id']; ?>-8">Luminosit&eacute;</a></li>
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
            if(!($data12 == null)){
              ?>
              <div id="tabs-<? echo $data['id']; ?>-6" class="ui-tabs-panel ui-widget-content ui-corner-bottom" style="overflow:auto;max-height:600px;">
                <?
                $query1 = "SELECT * FROM peripheriques WHERE periph = 'vent' AND id_plan = '".$data['id']."'";
                $req1 = mysql_query($query1, $link) or die('Erreur SQL !<br>'.$sql.'<br>'.mysql_error());
                while($periph = mysql_fetch_assoc($req1)) {
                  $width = "640px";
                  $height = "340px";
                  include("./fonctions/vent_graph_jour.php");
                }
                ?>
              </div>
              <?
            }
            if(!($data13 == null)){
              ?>
              <div id="tabs-<? echo $data['id']; ?>-7" class="ui-tabs-panel ui-widget-content ui-corner-bottom" style="overflow:auto;max-height:600px;">
                <?
                $query1 = "SELECT * FROM peripheriques WHERE periph = 'pluie' AND id_plan = '".$data['id']."'";
                $req1 = mysql_query($query1, $link) or die('Erreur SQL !<br>'.$sql.'<br>'.mysql_error());
                while($periph = mysql_fetch_assoc($req1)) {
                  $width = "640px";
                  $height = "340px";
                  include("./fonctions/pluie_graph_global.php");
                }
                ?>
              </div>
              <?
            }            
            if(!($data14 == null)){
              ?>
              <div id="tabs-<? echo $data['id']; ?>-8" class="ui-tabs-panel ui-widget-content ui-corner-bottom" style="overflow:auto;max-height:600px;">
                <?
                $query1 = "SELECT * FROM peripheriques WHERE periph = 'luminosite' AND id_plan = '".$data['id']."'";
                $req1 = mysql_query($query1, $link) or die('Erreur SQL !<br>'.$sql.'<br>'.mysql_error());
                while($periph = mysql_fetch_assoc($req1)) {
                  $width = "640px";
                  $height = "340px";
                  include("./fonctions/luminosite_graph_jour.php");
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
               	echo "</div>"; 
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
      }
      ?>
    </div>
  </div> 
      
        
  <script>

    // Fonctions utilitaires
    var gTemperature = new Object();
    function temperature(nom)
    {
      return gTemperature[nom]; 
    }
    
    var gHygrometrie = new Object();
    function hygrometrie(nom)
    {
      return gHygrometrie[nom]; 
    }

    var gLuminosite = new Object();
    function luminosite(nom)
    {
      return gLuminosite[nom]; 
    }
    
    var gVitesseVent = new Object();
    function vitesseVent(nom)
    {
      return gVitesseVent[nom]; 
    }

    var gDirectionVent = new Object();
    function directionVent(nom)
    {
      return gDirectionVent[nom]; 
    }
    
    var gActionneur = new Object();
    function actionneur(nom)
    {
      return gActionneur[nom]; 
    }
       
    var gConsoElec = new Object();
    function consoElec(nom)
    {
      return gConsoElec[nom]; 
    }
        
    var gCapteur = new Object();
    function capteur(nom)
    {
      return gCapteur[nom]; 
    }
                  
    function nuit()
    {
      return <? 
      if ($soleil == "nuit") 
      {
        echo "true";
      } 
      else 
      {
        echo "false";
      } 
      ?>;
    }    

    function jour()
    {
      return <? 
      if ($soleil == "jour") 
      {
        echo "true";
      } 
      else 
      {
        echo "false";
      } 
      ?>;
    } 
    
    <?
    // Construction des tableaux issues des capteurs de temperature
    $query = "SELECT * FROM peripheriques WHERE periph = 'temperature'";
    $req = mysql_query($query, $link) or die('Erreur SQL !<br>'.$sql.'<br>'.mysql_error());
    while ($periph = mysql_fetch_assoc($req))
    {
      $query0 = "SELECT * FROM `temperature_".$periph['nom']."` ORDER BY `date` DESC LIMIT 1";
      $req0 = mysql_query($query0, $link) or die('Erreur SQL !<br>'.$sql.'<br>'.mysql_error());
      while ($value0 = mysql_fetch_assoc($req0))
      {
        echo 'gTemperature["' . $periph['nom'] . '"] = ' . $value0['temp'] . ';';
        echo 'gHygrometrie["' . $periph['nom'] . '"] = ' . $value0['hygro'] . ';';
      } 
    }
    ?>
    
    <?
    // Construction des tableaux issues des capteurs de vent
    $query = "SELECT * FROM peripheriques WHERE periph = 'vent'";
    $req = mysql_query($query, $link) or die('Erreur SQL !<br>'.$sql.'<br>'.mysql_error());
    while ($periph = mysql_fetch_assoc($req))
    {
      $query0 = "SELECT * FROM `vent_".$periph['nom']."` ORDER BY `date` DESC LIMIT 1";
      $req0 = mysql_query($query0, $link) or die('Erreur SQL !<br>'.$sql.'<br>'.mysql_error());
      while ($value0 = mysql_fetch_assoc($req0))
      {
        echo 'gDirectionVent["' . $periph['nom'] . '"] = "' . $value0['direction'] . '";';
        echo 'gVitesseVent["' . $periph['nom'] . '"] = ' . $value0['vitesse'] . ';';
      } 
    }
    ?>
    
    <?
    // Construction des tableaux issues des capteurs de consommation electrique
    $query = "SELECT * FROM peripheriques WHERE periph = 'conso'";
    $req = mysql_query($query, $link) or die('Erreur SQL !<br>'.$sql.'<br>'.mysql_error());
    while ($periph = mysql_fetch_assoc($req))
    {
      $query0 = "SELECT * FROM `conso_".$periph['nom']."` ORDER BY `date` DESC LIMIT 1";
      $req0 = mysql_query($query0, $link) or die('Erreur SQL !<br>'.$sql.'<br>'.mysql_error());
      while ($value0 = mysql_fetch_assoc($req0))
      {
        echo 'gConsoElec["' . $periph['nom'] . '"] = "' . $value0['conso'] . '";';
      } 
    }
    ?>
   
    <?
    // Construction des tableaux issues des capteurs de luminosite
    $query = "SELECT * FROM peripheriques WHERE periph = 'luminosite'";
    $req = mysql_query($query, $link) or die('Erreur SQL !<br>'.$sql.'<br>'.mysql_error());
    while ($periph = mysql_fetch_assoc($req))
    {
      $query0 = "SELECT * FROM `luminosite_".$periph['nom']."` ORDER BY `date` DESC LIMIT 1";
      $req0 = mysql_query($query0, $link) or die('Erreur SQL !<br>'.$sql.'<br>'.mysql_error());
      while ($value0 = mysql_fetch_assoc($req0))
      {
        echo 'gLuminosite["' . $periph['nom'] . '"] = "' . $value0['lum'] . '";';
      } 
    }
    ?>
            
    <?
    // Construction des tableaux issues des actionneurs
    $query = "SELECT * FROM peripheriques WHERE periph = 'actioneur'";
    $req = mysql_query($query, $link) or die('Erreur SQL !<br>'.$sql.'<br>'.mysql_error());
    while ($periph = mysql_fetch_assoc($req))
    {
      if ($periph['protocol'] == 6) 
      {
          $protocol = true;
      } 
      else 
      {
          $protocol = false;
      }
      echo 'gActionneur["' . $periph['nom'] . '"] = ' . $zibase->getState($periph['id'], $protocol) . ';';
    }
    ?>
    
    <?
    // Construction des tableaux issues des actionneurs
    $query = "SELECT * FROM peripheriques WHERE periph = 'capteur'";
    $req = mysql_query($query, $link) or die('Erreur SQL !<br>'.$sql.'<br>'.mysql_error());
    while ($periph = mysql_fetch_assoc($req))
    {
      if ($periph['protocol'] == 6) 
      {
          $protocol = true;
      } 
      else 
      {
          $protocol = false;
      }
      if($protocol == true) 
      {
        echo 'gCapteur["' . $periph['nom'] . '"] = ' . $zibase->getState(substr($periph['id'], 1), $protocol) . ';';
      }
      else
      {
        echo 'gCapteur["' . $periph['nom'] . '"] = ' . $zibase->getState($periph['id'], $protocol) . ';';
      }
    }
    ?>
                    
    <?        
    // Creation des stickers
    $queryStickers = "SELECT * FROM stickers";
    $reqStickers = mysql_query($queryStickers, $link) or die('Erreur SQL !<br>'.$sql.'<br>'.mysql_error());
    while ($sticker = mysql_fetch_assoc($reqStickers)) {
      if ($sticker['condition'] != "")
      {
        echo 'if ('.$sticker['condition'].')';
      }
      echo ' { $( "#plan" ).append( "';        
      echo '<img src=\"./img/stickers/' . $sticker['fichier'] . '\" style=\"position:absolute;top:' . $sticker['top'] . 'px;left:' . $sticker['left'] . 'px;';
      if ($sticker['height'])
      {
        echo 'height:' . $sticker['height'] . 'px;';
      }
      if ( $sticker['width'])
      {
        echo 'width:' . $sticker['width'] . 'px;';
      }
      echo 'z-index:' . $sticker['id'] . '\"/>';
      echo '");}';
    ?>
    
    <?       
    }
    ?>
  </script>

<script src="./js/highcharts.js"></script>
<script src="./config/conf_highcharts.js"></script>