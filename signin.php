<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Se Connecter</title>
    <!--Custom styles-->
    <link rel="stylesheet" href="style.css">
    <!--Icon Scout CDN-->
    <link rel="stylesheet" href="https://unicons.iconscout.com/release/v4.0.0/css/line.css">
    <!--Google font-->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
</head>

<body>
<nav>
        <div class="container nav_container">
            <a href="signin.php" class="nav_logo">ENSACONNECT</a>
            
        </div>
</nav>
    <section class="form_section">
        <div class="container form_section_container">
            <h2>Authentification</h2>
            <?php
            include('connection.php');
            if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                $cin = strtoupper($_POST['cin']) ?? '';

                $pwd = $_POST['mot_de_passe'] ?? '';
                if (empty($pwd) && empty($cin)) {
                    echo '<div class="alert_message error"><p>Veuillez saisir votre cin et mot de passe</p></div>';
                } else if (empty(($cin)) && !empty($pwd)) {
                    echo '<div class="alert_message error"><p>Veuillez saisir votre cin</p></div>';
                } else if (empty($pwd) && !empty($cin)) {
                    echo '<div class="alert_message error"><p>Veuillez saisir votre mot de passe</p></div>';
                } else {
                    $query = "SELECT * FROM utilisateur WHERE cin = '$cin'";
                    $result = mysqli_query($conn, $query);
                    if (mysqli_num_rows($result) > 0) {
                        $row = mysqli_fetch_assoc($result);
                        if (password_verify($pwd, $row['mot_de_passe']) || $pwd == $row['mot_de_passe']) {
                            session_start();
                            $_SESSION['cin'] = $cin;
                            $_SESSION['email'] = $row['email'];
                            $_SESSION['nom'] = $row['nom'];
                            $_SESSION['prenom'] = $row['prenom'];
                            $_SESSION['type_utilisateur'] = $row['type_utilisateur'];
                            echo '<div class="alert_message success"><p>Authentification réussie. Redirection en cours...</p></div>';
                            switch ($_SESSION['type_utilisateur']) {
                                case 'administrateur':
                                    header("Refresh: 2; URL=dashboard-admin-high-manage-post.php");
                                    break;
                                case 'chef_filiere':
                                    header("Refresh: 2; URL=dashboard-admin-low.php");
                                    break;
                                case 'enseignant':
                                    header("Refresh: 2; URL=dashboard-teacher.php");
                                    break;
                                    //Added By Younes
                                case 'etudiant':
                                    header("Refresh: 2; URL=blog-student.php");
                                    break;
                                    //End
                                default:
                                    header("error: unknown");
                            }
                            exit();
                        } else {
                            echo '<div class="alert_message error"><p>Mot de passe incorrect</p></div>';
                        }
                    } else if (mysqli_num_rows($result) == 0) {
                        echo '<div class="alert_message error"><p>cin incorrect</p></div>';
                    }
                }
            }
            ?>

            <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
                <input type="text" placeholder="cin" name="cin">
                <input type="password" placeholder="mot de pass" name="mot_de_passe" id="">
                <button type="submit" class="btn">
                    Se Connecter</button>
                <small>Si vous n'avez pas de compte, vous pouvez contacter l'administration pour obtenir de l'aide.</small>
            </form>
        </div>
    </section>
    <footer>
        <div class="footer_copyright">
            <small>Copyright &copy;2024 Younes Elbandki && Moad Id Karoum</small>
        </div>
    </footer>
</body>

</html>