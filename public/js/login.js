$('#login_form').on('submit', function(e) {
    e.preventDefault();
    let formElt = $(this);
    let url = formElt.attr('action');
    let username = document.querySelector('#username');
    let password = document.querySelector('#password');

    // Si les champs username et password ne sont pas remplis
    if (username.value.trim().length === 0 || password.value.trim().length === 0) {
        // Signaler username si aucun caractere
        if (username.value.length === 0) {
            username.style.border = "4px solid rgb(53, 234, 165)";
            username.addEventListener("focus", function () {
                username.style.border = "4px solid #ffffff";
            }) 
        // Signaler password si aucun caractere
        } else if (password.value.length === 0) {
            password.style.border = "4px solid rgb(53, 234, 165)";
            password.addEventListener("focus", function () {
                password.style.border = "4px solid #ffff";
            })
        }
    } else {
        $.ajax({
            type: "POST",
            url: url,
            data: formElt.serializeArray(),
            success: function(response) {
                if(response=="success")
                {
                    window.location.href="admin.php";
                }
                else
                {
                    $('#error_login').slideDown();
                    $('#error_login').delay(2000).slideUp();
                }
            },
                
        })
    }
});