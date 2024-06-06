<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ajouter Utilisateur</title>
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
            <ul class="nav_items">
                <li class="nav_profile">
                <li><a class="btn" href="dashboardSwitcher.php">DashBorad</a></li>
                </li>
            </ul>
        </div>
    </nav>
    <section class="form_section">
        <div class="container form_section_container">
            <h2>Ajouter Utilisateur</h2>
            <?php
            include('connection.php');

            function isValidPassword($password)
            {
                return strlen($password) >= 8 && preg_match('/[a-zA-Z]/', $password) && preg_match('/\d/', $password);
            }

            $queryFiliere = "SELECT ID_filiere, Nom_filiere FROM filiere";
            $resultFiliere = mysqli_query($conn, $queryFiliere);

            $queryNiveau = "SELECT ID_niveau, Libelle_niveau FROM niveau";
            $resultNiveau = mysqli_query($conn, $queryNiveau);

            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $cin = strtoupper($_POST['cin']) ?? '';
                $nom = $_POST['nom'] ?? '';
                $prenom = $_POST['prenom'] ?? '';
                $email = $_POST['email'] ?? '';
                $pwd = password_hash($_POST['mot_de_passe'], PASSWORD_DEFAULT) ?? '';
                $type_utilisateur = $_POST['type_utilisateur'] ?? '';
                $filiere = isset($_POST['filiere']) ? $_POST['filiere'] : '';
                $niveau = isset($_POST['niveau']) ? $_POST['niveau'] : '';
                $state = 1;
                if ($type_utilisateur == 'etudiant' && empty($niveau)) {
                    echo '<div class="alert_message error"><p>Veuillez remplir tous les champs</p></div>';
                    $state = 0;
                } else if ($type_utilisateur == 'etudiant' && !empty($niveau)) {
                    $query = "SELECT ID_filiere FROM niveau WHERE ID_niveau = '$niveau' ";
                    $result = mysqli_query($conn, $query);
                    $row = mysqli_fetch_assoc($result);
                    if ($row["ID_filiere"] != $filiere) {
                        echo '<div class="alert_message error"><p>Le niveau et la filière ne correspondent pas</p></div>';
                        $state = 0;
                    } else if (!isValidPassword($_POST['mot_de_passe']) && $type_utilisateur == 'etudiant') {
                        echo '<div class="alert_message error"><p>Le mot de passe doit contenir au moins 8 caractères, une lettre et un chiffre</p></div>';
                        $state = 0;
                    }
                } else if (empty($cin) || empty($nom) || empty($prenom) || empty($email) || empty($pwd) || empty($type_utilisateur) || empty($filiere)) {
                    echo '<div class="alert_message error"><p>Veuillez remplir tous les champs</p></div>';
                    $state = 0;
                } else if (!isValidPassword($_POST['mot_de_passe'])) {
                    echo '<div class="alert_message error"><p>Le mot de passe doit avoir au moins 8 caractères et contenir à la fois des lettres et des chiffres.</p></div>';
                    $state = 0;
                }
                if ($state) {
                    try {
                        $query = "INSERT INTO utilisateur (cin, nom, prenom, email, mot_de_passe, type_utilisateur) VALUES ('$cin', '$nom', '$prenom', '$email', '$pwd', '$type_utilisateur')";
                        $result = mysqli_query($conn, $query);

                        switch ($type_utilisateur) {
                            case 'etudiant':
                                $query = "INSERT INTO etudiant(cin, ID_filiere,ID_niveau) VALUES ('$cin', '$filiere','$niveau')";
                                mysqli_query($conn, $query);
                                echo '<div class="alert_message success"><p>Utilisateur ajouté avec succès</p></div>';
                                break;
                            case 'enseignant':
                                $query = "INSERT INTO enseignant(cin, ID_filiere) VALUES ('$cin', '$filiere')";
                                mysqli_query($conn, $query);
                                echo '<div class="alert_message success"><p>Utilisateur ajouté avec succès</p></div>';
                                break;
                            case 'chef_filiere':
                                $query = "INSERT INTO chef_filiere(cin, ID_filiere) VALUES ('$cin', '$filiere')";
                                mysqli_query($conn, $query);
                                echo '<div class="alert_message success"><p>Utilisateur ajouté avec succès</p></div>';
                                break;
                        }
                    } catch (Exception $e) {
                        $error_message = $e->getMessage();
                        if (str_contains($error_message, 'utilisateur.PRIMARY')) {
                            echo '<div class="alert_message error"><p>CIN déjà utilisé</p></div>';
                        } else if (str_contains($error_message, 'utilisateur.email')) {
                            echo '<div class="alert_message error"><p>Email déjà utilisé</p></div>';
                        } else {
                            echo '<div class="alert_message error"><p>Erreur de base de données</p></div>';
                        }
                    }
                }
            }
            ?>

            <form action="" method="post" enctype="multipart/form-data">
                <input type="text" placeholder="CIN" name="cin">
                <input type="text" placeholder="Nom" name="nom">
                <input type="text" placeholder="Prenom" name="prenom">
                <input type="email" placeholder="Email" name="email">
                <input type="password" name="mot_de_passe" placeholder="Mot de passe">
                <select name="type_utilisateur" id="type_utilisateur" onchange="toggleFiliereSelection()">
                    <option value="">Choisir type d'utilisateur</option>
                    <option value="enseignant">Enseignant</option>
                    <option value="etudiant">Etudiant</option>
                    <option value="chef_filiere">Chef de filiere</option>
                </select>
                <select name="filiere" id="singleFiliereSelection" style="display: none;" onchange="toggleFiliereSelection()">
                    <option value="">Choisir une filiere</option>
                    <?php while ($rowFiliere = mysqli_fetch_assoc($resultFiliere)) { ?>
                        <option value="<?php echo $rowFiliere['ID_filiere']; ?>"><?php echo $rowFiliere['Nom_filiere']; ?></option>
                    <?php } ?>
                </select>
                <select name="niveau" id="singleNiveauSelection" style="display: none;">
                    <option value="">Choisir un niveau</option>
                    <?php while ($rowNiveau = mysqli_fetch_assoc($resultNiveau)) { ?>
                        <option value="<?php echo $rowNiveau['ID_niveau']; ?>"><?php echo $rowNiveau['Libelle_niveau']; ?></option>
                    <?php } ?>
                </select>
                <button type="submit" class="btn">Ajouter</button>
            </form>
        </div>
    </section>
    <footer>
        <div class="footer_copyright">
            <small>Copyright &copy;2024 Younes Elbandki && Moad Id Karoum</small>
        </div>
    </footer>

    <script>
        function toggleFiliereSelection() {
            var userType = document.getElementById("type_utilisateur").value;
            var singleFiliereSelection = document.getElementById("singleFiliereSelection");
            var singleNiveauSelection = document.getElementById("singleNiveauSelection");

            if (userType === "etudiant") {
                singleNiveauSelection.style.display = "block";
                singleFiliereSelection.style.display = "block";
            } else {
                singleNiveauSelection.style.display = "none";
                singleFiliereSelection.style.display = "block";
            }

        }
    </script>
</body>

</html>