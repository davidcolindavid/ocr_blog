<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8" />
        <title>Login</title>
        <link href="public/css/fonts.css" rel="stylesheet" />
        <link href="public/css/backend.css" rel="stylesheet" /> 
    </head>
    <body>
        <h1>Login</h1>
        <form id="login_form" action="login.php?action=loginAdmin" method="post">
            <input id="username" type="username" name="username" placeholder="Identifiant" />
            <input id="password" type="password" name="password" placeholder="Mot de passe" />
            <button type="submit" id="btn_post">Se connecter</button>
        </form>
    </body>
</html>