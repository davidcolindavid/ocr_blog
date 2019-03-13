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
              })
                .done(function(data, text, jqxhr) {
                    $('<div class="single_comment"></div>').prependTo('.container_comments').hide();
                    $('.container_comments').find(':first').prepend(jqxhr.responseText);
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