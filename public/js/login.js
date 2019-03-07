class Formlogin {
    constructor() {
        this.username = document.querySelector('#username');
        this.password = document.querySelector('#password');
        this.errorMessage = document.querySelector('#error_login')
        self = this;

        this.login();
    }

    login() {
        // Clique sur sur le btn connexion
        document.querySelector('#btn_login').addEventListener('click', function (e) {
            // Si les champs username et password ne sont pas remplis
            if (self.username.value.trim().length === 0 || self.password.value.trim().length === 0) {
                e.preventDefault();
                // Signaler username si aucun caractere
                if (self.username.value.length === 0) {
                    self.username.style.border = "4px solid rgb(53, 234, 165)";
                    self.username.addEventListener("focus", function () {
                        self.username.style.border = "4px solid #ffffff";
                    }) 
                // Signaler password si aucun caractere
                } else if (self.password.value.length === 0) {
                    self.password.style.border = "4px solid rgb(53, 234, 165)";
                    self.password.addEventListener("click", function () {
                        self.password.style.border = "4px solid #ffff";
                    })
                }
            }
        })
    }
}

let formlogin = new Formlogin ()