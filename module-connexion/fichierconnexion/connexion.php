<?php

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $login = $_POST["login"];
    $password = $_POST["password"];

    $conn = mysqli_connect("localhost", "root", "", "moduleconnexion");
    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }

   
    $sql = "SELECT * FROM utilisateurs WHERE login='$login' AND password='$password'";
    $result = mysqli_query($conn, $sql);
    if (mysqli_num_rows($result) > 0) {
        
        session_start();
        $_SESSION["login"] = $login;
        $_SESSION["message"] = "Vous êtes connecté.";
        header("Location: profil.php");
        exit;
    } else {
        echo "Erreur de connexion.";
    }

    mysqli_close($conn);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Page de connexion</title>
    <link rel="stylesheet" href="moduleconnexion.css">
</head>
<body>
    <header>
        <p class="headertitre"><a href="index.php">Accueil</a></p>
        <p class="headertitre"><a href="inscription.php">Inscription</a></p>
        <p class="headertitre"><a href="connexion.php">Connexion</a></p>
        <p class="headertitre"><a href="profil.php">Profil</a></p>
        <p class="headertitre"><a href="admin.php">Admin</a></p>
    </header>
    <main>
        <h1>Se connecter</h1>
        <?php
        if (isset($_SESSION["message"])) {
            echo "<p>" . $_SESSION["message"] . "</p>";
            unset($_SESSION["message"]);
        }
        ?>
        <form action="connexion.php" method="post">
            <label for="login">Login</label>
            <input type="text" name="login" required/><br><br>
            <label for="password">Password</label>
            <input type="password" name="password" required/><br><br>
            <button class="connexion" type="submit">Connexion</button>
        </form>
    </main>
    <footer>
    </footer>
</body>
</html>
