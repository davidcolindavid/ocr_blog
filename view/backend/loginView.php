<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8" />
        <title>Page protégée par mot de passe</title>
    </head>
    <body>
        <h1>Login</h1>
        <form action="login.php?action=loginAdmin" method="post">
            <p>
            Identifiant:
            <input type="username" name="username" />
            Mot de passe:
            <input type="password" name="password" />
            <input type="submit" value="Se connecter" />
            </p>
        </form>
    </body>
</html>