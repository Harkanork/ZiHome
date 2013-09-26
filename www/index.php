<?
session_start();
include("./pages/head.php");
include("./pages/menu.php");
if(isset($_GET['page'])){
include("./pages/".$_GET['page'].".php");
} else {
include("./pages/plan.php");
}
?>
