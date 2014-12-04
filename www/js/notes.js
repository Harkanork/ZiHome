(function ($) {
    var $tableau = $('#tableau');
    // Ajout d'une note
    $('#btn-addNote').click(function () {
        $tableau.append('<div class="postick" style="left:200px;top:200px;width:200px;z-index:'+zIndex+';position:absolute;" data-key="'+idsuiv+'"><div class="toolbar"><span class="delete" title="Fermer" data-key="'+idsuiv+'">x</span></div><div contenteditable class="editable"></div></div>');
        $.get('fonctions/gestion_notes.php',{
                  action : 'add',
                  z : zIndex,
                  id : idsuiv
        });
        zIndex ++;
        idsuiv ++;
        $(".postick").draggable({
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
            containment:"parent",
            cancel: '.editable',
            "zIndex": zIndex,
            "stack" : '.postick',
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
        $('.editable').blur( function () {
            $.get('fonctions/gestion_notes.php',{
                action  : 'sauv',
                text : $(this).html(),
                id : $(this).parent('.postick').attr('data-key')
            });
        });
    });

    // Suppression d'une note
    $('span.delete').live('click', function () {
        if (confirm('Etes vous sûr de vouloir supprimer cette note ?')) {
            var $this = $(this);
            $.get('fonctions/gestion_notes.php',{
                  action    : 'suppr',
                  id    : $this.attr('data-key')
            });
            $this.closest('.postick').fadeOut('slow', function () {
                $(this).remove();
            });
        }
    });

    // sauvegarde le texte d'un post-it lorsqu'on clique en dehors
    $('.editable').blur( function () {
            $.get('fonctions/gestion_notes.php',{
                action  : 'sauv',
                text : $(this).html(),
                id : $(this).parent('.postick').attr('data-key')
            });
    });

    $(document).ready(function () {
        $(".postick").draggable({
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
            containment:"parent",
            cancel: '.editable',
            "zIndex": zIndex,
            "stack" : '.postick',
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
    });

})(jQuery);