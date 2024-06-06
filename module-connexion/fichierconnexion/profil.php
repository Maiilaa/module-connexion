<?php
session_start();
if (!isset($_SESSION["login"])) {
    header("Location: connexion.php");
    exit;
}

// Connect to database
$conn = mysqli_connect("localhost", "root", "", "moduleconnexion");
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Get user data
$login = $_SESSION["login"];
$sql = "SELECT * FROM utilisateurs WHERE login='$login'";
$result = mysqli_query($conn, $sql);
if (mysqli_num_rows($result) > 0) {
    $user_data = mysqli_fetch_assoc($result);
} else {
    echo "Erreur: utilisateur non trouvé.";
}

mysqli_close($conn);
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $prenom= $_POST["prenom"];
    $nom= $_POST["nom"];
    $password = $_POST["password"];
    $confirm_password = $_POST["confirm_password"];
    $conn = mysqli_connect("localhost", "root", "", "moduleconnexion");

    if ($password == $confirm_password) {
        // Update user data
        $sql = "UPDATE utilisateurs SET prenom='$prenom', nom='$nom', password='$password' WHERE login='$login'";
        if (mysqli_query($conn, $sql)) {
            echo "Modifications enregistrées.";
        } else {
            echo "Erreur: " . $sql . "<br>" . mysqli_error($conn);
        }
    } else {
        echo "Mot de passe et confirmation de mot de passe ne correspondent pas.";
    }
}






?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Page d'inscription</title>
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
    <h1>Modifier mes informations</h1>
        <form action="profil.php" method="post">
            <label for="login">Login</label>
            <input type="text" name="login" required/><br><br>
            <label for="password">Nouveau Password</label>
            <input type="password" name="password" required/><br><br>
            <label for="confirm_password">Confirm Password</label>
            <input type="password" name="confirm_password" required/><br><br>
            <button class="créer" type="submit">Modifier</button>
        </form>
    </main>
    <footer>
    </footer>
</body>
</html>
