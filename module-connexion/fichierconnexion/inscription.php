
<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "moduleconnexion";

// Créer une connexion
$conn = new mysqli($servername, $username, $password, $dbname);

// Vérifier la connexion
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $login = $_POST["login"];
    $prenom = $_POST["prenom"];
    $nom = $_POST["nom"];
    $password = $_POST["password"];
    $confirm_password = $_POST["confirm_password"];

    if ($password == $confirm_password) {
        $password_hashed = password_hash($password, PASSWORD_DEFAULT);

        // Utiliser une requête préparée pour insérer les données
        $stmt = $conn->prepare("INSERT INTO utilisateurs (login, prenom, nom, password) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssss", $login, $prenom, $nom, $password_hashed);

        if ($stmt->execute()) {
            header("Location: connexion.php");
            exit;
        } else {
            echo "Erreur: " . $stmt->error;
        }

        $stmt->close();
    } else {
        echo "Mot de passe et confirmation de mot de passe ne correspondent pas.";
    }
}

$conn->close();
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
    <h1>Créer un compte</h1>
        <form action="inscription.php" method="post">
            <label for="prenom">Prénom</label>
            <input type="text" name="prenom" required/><br><br>
            <label for="nom">Nom</label>
            <input type="text" name="nom" required/><br><br>
            <label for="login">Login</label>
            <input type="text" name="login" required/><br><br>
            <label for="password">Password</label>
            <input type="password" name="password" required/><br><br>
            <label for="confirm_password">Confirm Password</label>
            <input type="password" name="confirm_password" required/><br><br>
            <button class="créer" type="submit">Créer</button>
        </form>
    </main>
    <footer>
    </footer>
</body>
</html>

