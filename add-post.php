<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ajouter Annonce</title>
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
            <h2>Ajouter Annonce</h2>
            <?php
            include('connection.php');
            session_start();
            $ID_filiere = "";
            $cin = $_SESSION['cin'];
            $type_utilisateur = $_SESSION['type_utilisateur'];
            $titre = $_POST['titre'] ?? '';
            $contenu = $_POST['contenu'] ?? '';
            $ID_niveau = $_POST['niveau'] ?? '';
            $queryniveau = "SELECT * FROM  niveau WHERE ID_niveau = '$ID_niveau'";
            $resultniveau = mysqli_query($conn, $queryniveau);
            $rowniveau = mysqli_fetch_assoc($resultniveau);
            $type_annonce = $_POST['type_annonce'] ?? '';
            $ID_local = $_POST['local'] ?? '';

            if ($type_utilisateur == 'enseignant' || $type_utilisateur == 'chef_filiere') {
                $queryfiliere = "SELECT * FROM $type_utilisateur WHERE cin = '{$cin}'";
                $resultfiliere = mysqli_query($conn, $queryfiliere);
                $rowfiliere = mysqli_fetch_assoc($resultfiliere);
                $ID_filiere = $rowfiliere['ID_filiere'];
                $ID_filiere_de_niveau = isset($rowniveau['ID_filiere']) ? $rowniveau['ID_filiere'] : '';

                if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                    if (empty($cin) || empty($type_utilisateur) || empty($type_annonce) || empty($contenu) || empty($titre) || empty($ID_niveau) || empty($ID_local) || empty($_FILES["file"]["name"])) {
                        echo '<div class="alert_message error">
                                    <p>Veuillez remplir tous les champs.</p>
                                </div>';
                    } elseif ($ID_filiere != $ID_filiere_de_niveau) {
                        echo '<div class="alert_message error">
                                    <p>Veuillez choisir un niveau qui correspond à la filière choisie.</p>
                                </div>';
                    } else {
                        $statut = 'En Attente';
                        $imageName = addImage();
                        $query = "INSERT INTO annonce(cin,Type_utilisateur,Type_annonce,Contenu,img,Titre,ID_filiere,ID_niveau,Statut,Id_local) VALUES('$cin','$type_utilisateur','$type_annonce','$contenu','$imageName','$titre','$ID_filiere','$ID_niveau','$statut','$ID_local')";

                        $result = mysqli_query($conn, $query);
                        echo '<div class="alert_message success"><p>Annonce ajouté avec succès.</p></div>';
                    }
                }
            } else {
                $ID_filiere = $_POST['filiere'] ?? '';
                $ID_filiere_de_niveau = isset($rowniveau['ID_filiere']) ? $rowniveau['ID_filiere'] : '';
                if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                    if (empty($cin) || empty($type_utilisateur) || empty($type_annonce) || empty($contenu) || empty($titre) || empty($ID_niveau) || empty($ID_local) || empty($ID_filiere)) {
                        echo '<div class="alert_message error">
                                    <p>Veuillez remplir tous les champs</p>
                                </div>';
                    } elseif ($ID_filiere != $ID_filiere_de_niveau) {
                        echo '<div class="alert_message error">
                                    <p>Veuillez choisir un niveau qui correspond à la filière choisie.</p>
                                </div>';
                    } else {
                        $statut = 'Accepté';
                        $imageName = addImage();
                        $query = "INSERT INTO annonce(cin,Type_utilisateur,Type_annonce,Contenu,img,Titre,ID_filiere,ID_niveau,Statut,Id_local) VALUES('$cin','$type_utilisateur','$type_annonce','$contenu','$imageName','$titre','$ID_filiere','$ID_niveau','$statut','$ID_local')";
                        $result = mysqli_query($conn, $query);
                        echo '<div class="alert_message success"><p>Annonce ajouté avec succès</p></div>';
                    }
                }
            }
            function addImage()
            {
                $filename = $_FILES["file"]["name"];
                $tempname = $_FILES["file"]["tmp_name"];
                $newfilename = uniqid() . "-" . $filename;
                move_uploaded_file($tempname, 'uploads/' . $newfilename);
                return $newfilename;
            }



            ?>


            <form action="" method="post" enctype="multipart/form-data">
                <input type="text" placeholder="Titre" name="titre" maxlength="17">
                <textarea rows="10" placeholder="Contenu" name="contenu" id=""></textarea>
                <select name="filiere" id="FiliereSelection" onchange="adminNiveauSelection()" style="display: none;">
                    <option value="">Choisir une filiere</option>
                    <?php
                    $query = "SELECT * FROM filiere";
                    $result  = mysqli_query($conn, $query);
                    while ($rows = mysqli_fetch_assoc($result)) {
                        echo "<option value=\"{$rows['ID_filiere']}\">{$rows['Nom_filiere']}</option>";
                    }
                    ?>
                </select>
                <select name="niveau" id="NiveauSelection">
                    <option value="">Choisir un niveau</option>
                    <?php
                    $query = "SELECT * FROM niveau";
                    $result  = mysqli_query($conn, $query);
                    while ($rows = mysqli_fetch_assoc($result)) {
                        echo "<option value=\"{$rows['ID_niveau']}\">{$rows['Libelle_niveau']}</option>";
                    }
                    ?>
                </select>
                <select name="type_annonce" id="AnnonceSelection">
                    <option value="">Choisir le type d'annonce</option>
                    <option value="Annonce de cours">Annonce de cours</option>
                    <option value="Rattrapage">Rattrapage</option>
                    <option value="Changement horaire">Changement d'horaire</option>
                </select>
                <select name="local" id="LocalSelection">
                    <option value="">Choisir un local</option>
                    <?php
                    $query = "SELECT * FROM local";
                    $result  = mysqli_query($conn, $query);
                    while ($row = mysqli_fetch_assoc($result)) {
                        echo '<option value="' . $row['ID_local'] . '">' . $row['Nom_local'] . '</option>';
                    }
                    ?>
                </select>
                <input type="file" name="file">
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
        <?php
        echo "var type_utilisateur = '$type_utilisateur';";
        ?>

        function adminChooseFilierEnable() {
            if (type_utilisateur == 'administrateur') {
                var filiereSelection = document.getElementById("FiliereSelection");
                filiereSelection.style.display = "block";
            }

        }
        window.onload = adminChooseFilierEnable();
    </script>
</body>

</html>