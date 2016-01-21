var $tableau = $('#tableau');

function updateNoteProp(id)
{
    // Active la fonction de drag
    $("[name=postick_" + id + "]").draggable({
        cancel: '.editable',
        "zIndex": zIndex,
        "stack" : '.postick',
        grid:[10,10],
        containment: "#tableau",
        stop:function(e,ui) {
            var $this = $(this);
            $("#waiting").fadeIn();
            $.ajax({
                type: "GET",
                url:'fonctions/gestion_notes.php',
                data: {action  : 'deplace', y : parseInt($this.position().top), x : parseInt($this.position().left), id : $this.attr('data-key'), z : zIndex },
                success: function() {
                    $("#waiting").delay(300).fadeOut();
                }
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
            $("#waiting").fadeIn();
            $.ajax({
                type: "GET",
                url:'fonctions/gestion_notes.php',
                data: {action  : 'redim', w : parseInt(ui.size.width), id : $this.attr('data-key'), z : zIndex},
                success: function() {
                    $("#waiting").delay(300).fadeOut();
                }
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
            $("#waiting").fadeIn();
            $.ajax({
                type: "GET",
                url:'fonctions/gestion_notes.php',
                data : {action    : 'suppr', id    : $this.attr('data-key') },
                success : function () {
                    $("[name=postick_" + $this.attr('data-key') + "]").fadeOut('slow', function () {
                        $(this).remove();
                    });
                    $("#waiting").delay(300).fadeOut();
                }
            });
        });
    });
    
    // Sauvegarde le texte d'un post-it lorsqu'on clique en dehors
    $("[name=editable_" + id + "]").blur( function () {
        $("#waiting").fadeIn();
        $.ajax({
            type: "GET",
            url:'fonctions/gestion_notes.php',
            data : {action  : 'sauv', text : $(this).html(), id : $(this).parent('.postick').attr('data-key') },
            success: function() {
                $("#waiting").delay(300).fadeOut();
            }
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