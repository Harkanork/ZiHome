<?
// script de base qui structure les vues personnalisables

// on initialise l'API Zibase
include("./lib/zibase.php");
$zibase = new ZiBase($ipzibase);

// vérification que le script est bien appelé dans le but d'afficher une vue personnalisée
if (isset($_GET['vue'])) { 
    $vue = (int)$_GET['vue']; // récupère le numéro de vue personnalisée
    ?>
    <script>
    var vue=<? echo $vue ?>;
    </script>
    <?
    
    // on va chercher les infos concernant la vue demandée dans la bdd (libellé = nom de la page, grid=proprietés d'accrochage)
    $query = 'SELECT * FROM vues WHERE id='.$vue;  
    $req = mysql_query($query, $link) or die('Erreur SQL !<br>'.$sql.'<br>'.mysql_error());
    while ($data_vue = mysql_fetch_assoc($req)) {
        $libelle=$data_vue['libelle'];
        $grid=$data_vue['grid'];
    }
    if ((!(isset($grid)))OR($grid=="")) {
        $grid="10";
    }
    switch ($grid) {
        case "false" :
            $grid_array="false";
            $grid_value=0;
            break;

        default:
            $grid_array="[".$grid.",".$grid."]";
            $grid_value=$grid;
            break;
    }
    echo "<script>var grid_array = ".$grid_array."; var grid_value = ".$grid_value." </script>";

    // Affichage du titre de la page et des scripts nécessaires
    ?> <title><? echo $libelle ?></title>
    <script src="./js/highstock.js"></script>
    <script src="./config/conf_highstock.js"></script>
    <script src="./js/highcharts.js"></script>
    <script src="./js/highcharts-more.js"></script>
    <script src="./js/modules/data.js"></script>
    <script src="./config/conf_highcharts.js"></script>
    <script src="./js/modules/exporting.js"></script> 
    <script src="./js/ajax_vues.js"></script>
    <?
        
    // Cadre de base de cette partie de la page
    ?><div id="global" class="vue">
    <div id="fond_vue"></div><?
    $java_insertion="";
    $tableau_elements=array();
        
    // -----------------------------------------------------------------------------
    // Gestion des cadres et des rapports (équiv mode plan)
    // -----------------------------------------------------------------------------
    // Calcul de la largeur max et hauteur max
    $query = "SELECT max( `width` + `left` ) AS width, max( `height` + `top` ) AS height FROM `vues_elements` WHERE `vue_id`= '".$vue."' AND `type`= 'cadre'";
    $res_query = mysql_query($query, $link);
    if (mysql_numrows($res_query) > 0){
        $width = mysql_result($res_query,0,"width") + 2;
        $height = mysql_result($res_query,0,"height") + 2;
    }

    // Recuperation de la largeur des icones
    $query = "SELECT * FROM paramettres WHERE libelle = 'largeur icones'";
    $res_query = mysql_query($query, $link);
    if (mysql_numrows($res_query) > 0) {
        $data = mysql_fetch_assoc($res_query);
        $widthIcones = $data['value'];
        $labelOffsetLeft = max($widthIcones - 30, $widthIcones / 2);
    } else {
        $widthIcones = 60;
        $labelOffsetLeft = 30;
    }

    // Recuperation de la hauteur des icones
    $query = "SELECT * FROM paramettres WHERE libelle = 'hauteur icones'";
    $res_query = mysql_query($query, $link);
    if (mysql_numrows($res_query) > 0) {
        $data = mysql_fetch_assoc($res_query);
        $heightIcones = $data['value'];
    } else {
        $heightIcones = 60;
    }
    if ($heightIcones < 40) {
        $labelWidth = 30;
        $labelOffsetTop = $heightIcones - 13;
        $labelFontSize = 8;
        $labelFontOffsetTop = 1;
        $labelFontOffsetLeft = 3; 
    } else {
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
    if ($data['value'] == 'true') {
        $showAllNames = true;
    }

    // infos meteo
    $weather = simplexml_load_file("http://wxdata.weather.com/wxdata/weather/local/".$meteo_ville."?cc=*&unit=m");
    if(file_exists("img/plan/nuit.png")) {
        $soleil_jour = date_create_from_format('h:i a Y-m-d', $weather->loc->sunr." ".date('Y-m-d'));
        $soleil_nuit = date_create_from_format('h:i a Y-m-d', $weather->loc->suns." ".date('Y-m-d'));
        $now = date_create_from_format('h:i a Y-m-d', date('h:i a Y-m-d'));
        if ($now < $soleil_nuit && $now > $soleil_jour) { 
            $soleil = "jour";  
        } else { 
            $soleil = "nuit";  
        }
    } else {
        $soleil = "jour";
    }

    // affichage des stickers et textes dynamiques
    include("./fonctions/dynaInfo.php");
    generateDynInfo($vue, "#global", $soleil);

    // On récupère tous les éléments de cette vue pour lequel l'utilisateur a des droits
    if(isset($_SESSION['auth'])) {
        $auth=$_SESSION['auth'];
    } else {
        $auth="default";
    }
    $i=0;
    $query3 = "SELECT * FROM vues_elements WHERE (user = '".$auth."' OR user ='') AND vue_id = '".$vue."'";
    $req3 = mysql_query($query3, $link) or die('Erreur SQL !<br>'.$sql.'<br>'.mysql_error());
    while ($vues_elements = mysql_fetch_assoc($req3)) {
        $elem_id = $vues_elements['id'];
        $type = $vues_elements['type'];
        $user=$vues_elements['user'];
        $width = $vues_elements['width'];
        $height = $vues_elements['height'];
        $left = $vues_elements['left'];
        $top = $vues_elements['top'];
        $zindex= $vues_elements['zindex'];
        $libelle = $vues_elements['libelle'];
        $affich_libelle = $vues_elements['affich_libelle'];
        $url = $vues_elements['url'];
        $peripherique = $vues_elements['peripherique'];
        $font = $vues_elements['font'];
        $color = $vues_elements['color'];
        ($vues_elements['size']==0)?$size=12:$size=$vues_elements['size'];
        ($vues_elements['bold']==1)?$bold=true:$bold=false;
        ($vues_elements['italic']==1)?$italic=true:$italic=false;
        $border = $vues_elements['border'];
        $option = $vues_elements['option'];
        $condition = $vues_elements['condition'];

        $graphique = $vues_elements['graphique']; // remarque : champ 'graphique' inutile à priori
        $peri=$peripherique; // temp
        if ($font=='') { $font="Arial, Helvetica";} // temp   

        $tableau_elements[$elem_id]=[$elem_id,$condition,$type,$user,$width,$height,$left,$top,$zindex,$libelle,$affich_libelle,$url,$peripherique,$font,$color,$size,$bold,$italic,$border,$option,$condition];

        $i++;
    }

    ?>
</div>

    <div id="dialog_elements_modifier" title="Modification" style="display:none;"></div>
    <div id="list_icone" title="Choix de l'icone" style="display:none;"></div>
    <div id="dialog_elements_ajouter" title="Ajouter un élément" style="display:none;"></div>
    <div id="dialog_vues_ajouter" title="Créer une vue personnalisée" style="display:none;"></div>
    <div id="waiting"></div>

    <?
    // script pour fonctionnement ajax :
    ?>
    <script>
    <? // initialisation des variables ?>
    var heightIcones=<? echo $heightIcones ?>;
    var widthIcones=<? echo $widthIcones ?>;
    var labelFontSize=<? echo $labelFontSize ?>;
    var icone=<? echo $icone ?>;
    var labelWidth=<? echo $labelWidth ?>;
    var labelOffsetLeft=<? echo $labelOffsetLeft ?>;
    var labelOffsetTop=<? echo $labelOffsetTop ?>;
    var labelFontOffsetTop=<? echo $labelFontOffsetTop ?>;
    var labelFontOffsetLeft=<? echo $labelFontOffsetLeft ?>;
    var showAllNames=<? if ($showAllNames) { echo 'true';} else { echo 'false';} ?>;
    var tableau_elements=new Array();
    <?    
    foreach ($tableau_elements as $element) {
        echo "tableau_elements[".$element[0]."] = ['".$element[0]."','".$element[1]."','".$element[2]."','".$element[3]."','".$element[4]."','".$element[5]."','".$element[6]."','".$element[7]."','".$element[8]."','".$element[9]."','".$element[10]."','".$element[11]."','".$element[12]."','".$element[13]."','".$element[14]."','".$element[15]."','".$element[16]."','".$element[17]."','".$element[18]."','".$element[19]."','".$element[20]."'];\r\n";
    }
    ?>

    // affichage des éléments en prenant en compte la condition
    afficher_elements(tableau_elements,true);



    // vérication que les zindex ne s'emballent pas trop à force de les remettre au premier plan, et remise en arrière plan des cadres
    
    if ($.zindexmax(".vues_elements")>1997) { // seuil critique d'après CSS actuel du menu, on pourra le remonter si besoin
        verification_zindex(vue);
    }

    </script>
    <?
}
?>