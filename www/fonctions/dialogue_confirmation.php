<script>
var gAskConfirmURL;

function askConfirmDeletion(pURL) {
  gAskConfirmURL = pURL;
  gAskConfirmFct = "";
  $("#dialog-confirm").dialog("open");
}

function askConfirmDeletion2(pFct) {
  gAskConfirmURL = "";
  gAskConfirmFct = pFct;
  $("#dialog-confirm").dialog("open");
}

$(function() 
{
  $( "#dialog-confirm" ).dialog(
  {
    resizable: false,
    height:180,
    width:400,
    autoOpen: false,
    modal: true,
    zIndex: 300,
    buttons: 
    {
      "Oui": function() 
      {
        $( this ).dialog( "close" );
        if (gAskConfirmURL != "")
        {
          window.location.href = gAskConfirmURL;
        }
        else
        {
          gAskConfirmFct();
        }
      },
      "Non": function() 
      {
        $( this ).dialog( "close" );
      }
    }
  });
});
</script>
<div id="dialog-confirm" title="Confirmation" style="display:none;">
Confirmez-vous la suppression?
</div>