var $tableau = $('#tableau');

function updateNoteProp(id)
{
    // Active la fonction de drag
    $("[name=postick_" + id + "]").draggable({
        cancel: '.editable',
        "zIndex": zIndex,
        "stack" : '.postick',
        stop:function(e,ui) {
            var $this = $(this);
            $.get('fonctions/gestion_notes.php',{
                action  : 'deplace',
                y : parseInt($this.position().top),
                x : parseInt($this.position().left),
                id : $this.attr('data-key'),
                z : zIndex
            });
            zIndex++;
        }
    }).resizable({
        cancel: '.editable',
        minHeight: 60,
        minWidth: 120,
        "zIndex": zIndex,
        "stack" : '.postick',
        handles: "e, w",
        stop:function(e,ui) {
            var $this = $(this);
            $.get('fonctions/gestion_notes.php',{
                action  : 'redim',
                w : parseInt(ui.size.width),
                id : $this.attr('data-key'),
                z : zIndex
            });
            zIndex++;
        }
    });
    
    // Suppression d'une note
    $("[name=delete_" + id + "]").on('click', function (event) 
    {
        var $this = $(this);
        askConfirmDeletion2(function ()
        {
            $.get('fonctions/gestion_notes.php',{
                  action    : 'suppr',
                  id    : $this.attr('data-key')
            });
            $("[name=postick_" + $this.attr('data-key') + "]").fadeOut('slow', function () {
                $(this).remove();
            });
        });
    });
    
    // Sauvegarde le texte d'un post-it lorsqu'on clique en dehors
    $("[name=editable_" + id + "]").blur( function () {
        $.get('fonctions/gestion_notes.php',{
            action  : 'sauv',
            text : $(this).html(),
            id : $(this).parent('.postick').attr('data-key')
        });
    });
}

function addNote(id, x, y, z, width, text)
{
    $text = '<div class="postick" name="postick_' + id + '" style="left:' + x + 'px;top:' + y + 'px;width:' + width + 'px;z-index:'+zIndex+';position:absolute;" data-key="' + id + '">';
    $text = $text + '<div class="toolbar" name="toolbar_' + id + '"><span class="delete" name="delete_' + id + '" title="Fermer" data-key="' + id + '">x</span></div>';
    $text = $text + '<div contenteditable class="editable" name="editable_' + id + '">' + text + '</div></div>';
    
    $tableau.append($text);
    $.get('fonctions/gestion_notes.php',
    {
        action : 'add',
        z : z,
        id : id
    });
    
    updateNoteProp(id);
    
    if (zIndex <= z)
    {
      zIndex = z + 1;
    }
    if (idsuiv <= id)
    {
      idsuiv = id + 1;
    }
}

(function ($) 
{
    // Ajout d'une note
    $('#btn-addNote').click(function () 
    {
      addNote(idsuiv, 200, 200, zIndex, 160, "");
    });
})(jQuery);