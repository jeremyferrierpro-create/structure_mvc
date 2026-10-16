<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link
        rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/@picocss/pico@2/css/pico.min.css">
    <title><?= $title ?? "" ?></title>
</head>

<body>
    <main class=container-fluid>
        <h1>Ajouter un compte</h1>
        <form action="" method="post">
            <input type="text" name="firstname" placeholder="saisir le prénom">
            <input type="text" name="lastname" placeholder="saisir le nom">
            <input type="email" name="email" placeholder="saisir un email valide">
            <input type="password" name="password" placeholder="saisir le mot de passe">
            <input type="password" name="confirm-password" placeholder="confirmer le mot de passe">
            <input type="submit" value="Inscription" name="submit">
        </form>
        <p><?= $data["msg"] ?? "" ?></p>
    </main>
</body>

</html>
