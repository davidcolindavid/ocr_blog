// verifier et ajouter un commentaire
class FormComment {
    constructor() {
        this.author = document.querySelector('#author');
        this.comment = document.querySelector('#comment');
        self = this;

        this.check();
        this.send();
    }

    check() {
        // Clique sur sur le btn envoyer
        document.querySelector('#btn_send').addEventListener('click', function (e) {
            // Si les champs author et comment ne sont pas remplis
            if (self.author.value.trim().length === 0 || self.comment.value.trim().length === 0) {
                e.preventDefault();
                // Signaler author si aucun caractere
                if (self.author.value.length === 0) {
                    self.author.style.border = "4px dotted #000000";
                    self.author.addEventListener("focus", function () {
                        self.author.style.border = "4px solid #000000";
                    }) 
                // Signaler comment si aucun caractere
                } else if (self.comment.value.length === 0) {
                    self.comment.style.border = "4px dotted #000000";
                    self.comment.addEventListener("click", function () {
                        self.comment.style.border = "4px solid #000000";
                    })
                }
            }
        })
    }

    send() {
        $(".container_comment_form").on('submit', '.comment_form', function(e) {
            e.preventDefault();
            let form = $(this);
            let url = form.attr('action');
            
            $.ajax({
                type: "POST",
                url: url,
                data: form.serializeArray(),
                dataType: 'JSON',
            })
                .done(function(data, text, jqxhr) {
                    $('<div class="single_comment"></div>').prependTo('.container_comments').hide();
                    // Ajoute la row contenant l'auteur et le bouton signaler
                    $('.container_comments').find(':first').append('<div class="row"></row>');
                    $('.container_comments').find(':first .row').append('<div class="col-7 comment_details">' + data[1] + ', ' + data[2] + '</div>');
                    $('.container_comments').find(':first .row').append('<form class="col-5 col_report" action="index.php?action=reportComment&amp;id=' + data[0] + '&amp;postId=' + data[4] + '" method="post"></form>');
                    $('.container_comments').find(':first form').append('<button type="submit" class="btn_report">Signaler</button>');
                    // Ajoute la row contenant le message
                    $('.container_comments').find(':first').append('<div class="row"></row>');
                    $('.container_comments').find(':first .row:eq(1)').append('<div class="col-12"><div class="comment_sent">' + data[3] + '</div></div>');

                    $('.container_comments').find(':first').slideDown()
                    $(".comment_form")[0].reset()
                    
                })
        });
    }
}

if ($('.comment_form').length) {
    let formComment = new FormComment ()
}


// signaler un commentaire
$(".container_comments").on('submit', '.col_report', function(e) {
    e.preventDefault();
    let form = $(this);
    let url = form.attr('action');
    
    $.ajax({
        type: "POST",
        url: url,
        data: form.serializeArray(),
        success: function() {
            form.find(':first').fadeOut(100);
        },
      })
});
