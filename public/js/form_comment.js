class FormComment {
    constructor() {
        this.author = document.querySelector('#author');
        this.comment = document.querySelector('#comment');
        self = this;

        this.send();
    }

    send() {
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
}

if ($('.comment_form').length) {
    let formComment = new FormComment ()
}
