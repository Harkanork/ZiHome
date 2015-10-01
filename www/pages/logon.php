<?
if(!(isset($_SESSION['auth']))) 
{
  include('./lib/mac_address.php');
  
  $query = "SELECT * FROM `auto-logon` WHERE macaddress = '".$macAddr."'";
  $req = @mysql_query ($query);
  $data = mysql_fetch_assoc ($req);
  if ($data)
  {
    $query = "SELECT * FROM `users` WHERE pseudo = '".$data['pseudo']."'";
    $req = @mysql_query ($query);
    $data = mysql_fetch_assoc ($req);
    if($data) 
    {
      $_SESSION['auth'] = $data['pseudo'];
      $_SESSION['niveau'] = $data['niveau'];
      echo "<meta http-equiv=\"refresh\" content=\"0; url=".$_SERVER['PHP_SELF']."\">";
    }
    mysql_close();
  }
}
if(isset($_SESSION['auth']))
{
  if(isset($_GET['logout']))
  {
    unset($_SESSION['auth']);
    unset($_SESSION['niveau']);
    echo "<meta http-equiv=\"refresh\" content=\"0; url=./index.php\">";
  }
  else
  {
    echo "<a href='./index.php?logout=logout'>D&eacute;connexion</a>";
  }
}
else
{
  if (isset($_POST['submit1']))
  {
    $message = NULL;
    if (empty($_POST['pseudo']))
    { 
      $message .= 'Vous avez oubli&eacute; le login. '; 
    }
    if (empty($_POST['pass']))
    { 
      $message .= 'Vous avez oubli&eacute; le mot de passe !'; 
    }
    if ($message == NULL)
    {
      $query = "SELECT * FROM `users` WHERE pseudo = '".$_POST['pseudo']."' AND pass = SHA1('".$_POST['pass']."')";
      $req = @mysql_query ($query);
      $data = mysql_fetch_assoc ($req);
      if ($data)
      {
        $_SESSION['auth'] = $data['pseudo'];
        $_SESSION['niveau'] = $data['niveau'];
        mysql_close();
        echo "<meta http-equiv=\"refresh\" content=\"0; url=".$_SERVER['PHP_SELF']."\">";
      }
      else
      {
        echo "<center>Erreur d'identification</center>";
        echo "<meta http-equiv=\"refresh\" content=\"4; url=".$_SERVER['PHP_SELF']."\">";
      }
    }
    else
    {
      echo "<p>".$message."</p>";
      echo "<meta http-equiv=\"refresh\" content=\"4; url=".$_SERVER['PHP_SELF']."\">";
    }
  }
  else
  {
    echo "<form method=\"POST\" action=\"".$_SERVER['PHP_SELF']."\" style=\"margin:0;padding=0;\">
          <input type=\"text\" name=\"pseudo\" size=\"12\" maxlength=\"40\" placeholder=\"Login\"/>
          <input type=\"password\" name=\"pass\" size=\"12\" maxlength=\"20\" placeholder=\"Mot de passe\"/>
          <input type=\"submit\" name=\"submit1\" value=\"Connexion\" class=\"input\"></form>";
  }
}
?>
