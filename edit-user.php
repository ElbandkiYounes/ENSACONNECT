<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modifier Utilisateur</title>
    <!-- Custom styles -->
    <link rel="stylesheet" href="style.css">
    <!-- Icon Scout CDN -->
    <link rel="stylesheet" href="https://unicons.iconscout.com/release/v4.0.0/css/line.css">
    <!-- Google font -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
</head>

<body>
    <nav>
            <div class="container nav_container">
                <a href="signin.php" class="nav_logo">ENSACONNECT</a>
                <ul class="nav_items">
                    <li class="nav_profile">
                        <li><a class="btn" href="dashboardSwitcher.php">DashBorad</a></li>
                    </li>
                </ul>
            </div>
    </nav>
    <section class="form_section">
        <div class="container form_section_container">
            <h2>Modifier Utilisateur</h2>
            <?php
            // Database connection
            include 'connection.php';

            if (isset($_GET['cin'])) {
                $cin = trim($_GET['cin']);
                $query = "SELECT * FROM utilisateur WHERE cin = ?";
                $stmt = mysqli_prepare($conn, $query);
                mysqli_stmt_bind_param($stmt, "s", $cin);
                mysqli_stmt_execute($stmt);
                $result = mysqli_stmt_get_result($stmt);
                $row = mysqli_fetch_assoc($result);
                $nom = htmlspecialchars($row['nom']);
                $prenom = htmlspecialchars($row['prenom']);
                $email = htmlspecialchars($row['email']);
            }

            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $nom = htmlspecialchars(trim($_POST['nom']));
                $prenom = htmlspecialchars(trim($_POST['prenom']));
                $email = htmlspecialchars(trim($_POST['email']));
                $mot_de_passe = trim($_POST['mot_de_passe']);

                if (empty($nom) || empty($prenom) || empty($mot_de_passe)) {
                    echo '<div class="alert_message error"><p>Veuillez remplir tous les champs</p></div>';
                } else {
                    $query = "SELECT * FROM utilisateur WHERE email = ? AND cin != ?";
                    $stmt = mysqli_prepare($conn, $query);
                    mysqli_stmt_bind_param($stmt, "ss", $email, $cin);
                    mysqli_stmt_execute($stmt);
                    $result = mysqli_stmt_get_result($stmt);
                    if (mysqli_num_rows($result) > 0) {
                        echo '<div class="alert_message error"><p>L\'email existe déjà dans la base de données</p></div>';
                    } else {
                        if (!empty($email)) {
                            $hashed_password = password_hash($mot_de_passe, PASSWORD_DEFAULT);
                            $query = "UPDATE utilisateur SET nom = ?, prenom = ?, email = ?, mot_de_passe = ? WHERE cin = ?";
                            $stmt = mysqli_prepare($conn, $query);
                            mysqli_stmt_bind_param($stmt, "sssss", $nom, $prenom, $email, $hashed_password, $cin);
                        } else {
                            $query = "UPDATE utilisateur SET nom = ?, prenom = ? WHERE cin = ?";
                            $stmt = mysqli_prepare($conn, $query);
                            mysqli_stmt_bind_param($stmt, "sss", $nom, $prenom, $cin);
                        }

                        if (mysqli_stmt_execute($stmt)) {
                            echo '<div class="alert_message success"><p>Mise à jour réussie</p></div>';
                            header("Refresh: 2; URL=dashboard-admin-high-manage-user.php");
                            exit();
                        } else {
                            echo '<div class="alert_message error"><p>Erreur de base de données</p></div>';
                        }
                    }
                }
            }
            ?>
            <form action="" method="post" enctype="multipart/form-data">
                <input type="text" value="<?php echo $nom; ?>" name="nom" placeholder="Nom">
                <input type="text" value="<?php echo $prenom; ?>" name="prenom" placeholder="Prénom">
                <input type="email" value="<?php echo $email; ?>" name="email" placeholder="Email">
                <input type="password" placeholder="Nouveau mot de passe" name="mot_de_passe">
                <button type="submit" class="btn">Modifier</button>
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