<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modifier Annonce</title>
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
            <h2>Modifier Annonce</h2>
            <?php
                include('connection.php');
                $ID_annonce = $_GET['id'];
                $queryannonce = "SELECT * FROM annonce WHERE ID_annonce = '$ID_annonce'";
                $resultannonce = mysqli_query($conn,$queryannonce);
                $rowannonce = mysqli_fetch_assoc($resultannonce);
                $ID_filiere = $rowannonce['ID_filiere'];
            ?>




            <?php
                include('connection.php');
                session_start();
                $ID_annonce = $_GET['id'];
                $ID_filiere ="";
                $cin = $_SESSION['cin'];
                $type_utilisateur = $_SESSION['type_utilisateur'];
                $titre = $_POST['titre'] ?? '';
                $contenu = $_POST['contenu'] ?? '';
                $type_annonce = $_POST['type_annonce'] ?? '';
                $ID_niveau = $_POST['niveau'] ?? '' ;
                $queryniveau = "SELECT * FROM  niveau WHERE ID_niveau = '$ID_niveau'";
                $resultniveau = mysqli_query($conn,$queryniveau);
                $rowniveau = mysqli_fetch_assoc($resultniveau);
                
                $ID_local = $_POST['local'] ?? '';
                
                if($type_utilisateur == 'enseignant'){
                    $queryfiliere = "SELECT * FROM $type_utilisateur WHERE cin = '{$cin}'";
                    $resultfiliere = mysqli_query($conn,$queryfiliere);
                    $rowfiliere = mysqli_fetch_assoc($resultfiliere);
                    $ID_filiere = $rowfiliere['ID_filiere'];
                    $ID_filiere_de_niveau = isset($rowniveau['ID_filiere']) ? $rowniveau['ID_filiere'] : '';
                    
                    if ($_SERVER['REQUEST_METHOD'] === 'POST'){
                        if (empty($cin) || empty($type_utilisateur) || empty($type_annonce) || empty($contenu) || empty($titre) || empty($ID_niveau) || empty($ID_local)){
                            echo '<div class="alert_message error">
                                    <p>Veuillez remplir tous les champs</p>
                                </div>';
                        }
                        elseif($ID_filiere != $ID_filiere_de_niveau){
                            echo '<div class="alert_message error">
                                    <p>Veuillez choisir un niveau qui correspond à la filière choisie.</p>
                                </div>';

                        }else{
                            $statut ='En Attente';
                            $query = "UPDATE annonce SET  Type_annonce = '$type_annonce' , Contenu = '$contenu' , Titre = '$titre' , ID_niveau = '$ID_niveau' , Statut = '$statut' , Id_local = '$ID_local' WHERE ID_annonce = '$ID_annonce'";
                            $result = mysqli_query($conn,$query);
                            
                            echo '<div class="alert_message success"><p>Annonce modifié avec succès. Redirection en cours...</p></div>';
                            header("Refresh: 2; URL=dashboard-teacher.php");
                            exit();
                        }
                    }
                    
                }
                else{
                    $ID_filiere = $_POST['filiere'] ?? '';
                    $ID_filiere_de_niveau = isset($rowniveau['ID_filiere']) ? $rowniveau['ID_filiere'] : '';
                    if ($_SERVER['REQUEST_METHOD'] === 'POST'){
                        if (empty($cin) || empty($type_utilisateur) || empty($type_annonce) || empty($contenu) || empty($titre) || empty($ID_niveau) || empty($ID_local) || empty($ID_filiere)){
                            echo '<div class="alert_message error">
                                    <p>Veuillez remplir tous les champs</p>
                                </div>';
                        }elseif($ID_filiere != $ID_filiere_de_niveau){
                            echo '<div class="alert_message error">
                                    <p>Veuillez choisir un niveau qui correspond à la filière choisie.</p>
                                </div>';

                        }else{
                            $statut ='Accepté';
                            $query = "UPDATE annonce SET  Type_annonce = '$type_annonce' , Contenu = '$contenu' , Titre = '$titre' , ID_niveau = '$ID_niveau' , Statut = '$statut' , ID_local = '$ID_local' , ID_filiere = '$ID_filiere' WHERE ID_annonce = '$ID_annonce'";
                            $result = mysqli_query($conn,$query);
                            echo '<div class="alert_message success"><p>Annonce modifié avec succès. Redirection en cours...</p></div>';
                            header("Refresh: 2; URL=dashboard-admin-high-manage-post.php");
                            exit();
                        }
                    }
                }
            ?>
            
            
            <form action="" method="post" enctype="multipart/form-data">
                <input type="text" placeholder="Titre" name="titre" maxlength="20" value="<?php if(isset($_GET['id'])) echo $rowannonce['Titre'];?>">
                <textarea rows="10" placeholder="Contenu" name="contenu"><?php if(isset($_GET['id'])) echo $rowannonce['Contenu'];?></textarea>
                <select name="filiere" id="FiliereSelection" onchange="adminNiveauSelection()" style="display: none;">
                <option value="">Choisir une filiere</option>
                <?php
                    $query = "SELECT * FROM filiere";
                    $result  = mysqli_query($conn,$query);
                    while($rows = mysqli_fetch_assoc($result)){
                        if(isset($_GET['id']) && $rowannonce['ID_filiere'] == $rows['ID_filiere'])
                        echo "<option selected value=\"{$rows['ID_filiere']}\">{$rows['Nom_filiere']}</option>";
                        else
                        echo "<option value=\"{$rows['ID_filiere']}\">{$rows['Nom_filiere']}</option>";
                    }
                ?>
                </select>
                <select name="niveau" id="NiveauSelection">
                    <option value="">Choisir un niveau</option>
                    <?php
                    $query = "SELECT * FROM niveau";
                    $result  = mysqli_query($conn,$query);
                    while($rows = mysqli_fetch_assoc($result)){
                        if(isset($_GET['id']) && $rowannonce['ID_niveau'] == $rows['ID_niveau'])
                        echo "<option selected value=\"{$rows['ID_niveau']}\">{$rows['Libelle_niveau']}</option>";
                        else
                        echo "<option value=\"{$rows['ID_niveau']}\">{$rows['Libelle_niveau']}</option>";
                    }
                ?>
                </select>
                <select name="type_annonce" id="AnnonceSelection">
                    <option value="">Choisir le type d'annonce</option>
                    <?php
                    if(isset($_GET['id']) && $rowannonce['Type_annonce'] == 'Annonce de cours'){
                        echo "<option selected value=\"Annonce de cours\">Annonce de cours</option>";
                        echo "<option  value=\"Rattrapage\">Rattrapage</option>";
                        echo "<option  value=\"Changement horaire\">Changement horaire</option>";

                    }
                    if(isset($_GET['id']) && $rowannonce['Type_annonce'] == 'Rattrapage'){
                        echo "<option  value=\"Annonce de cours\">Annonce de cours</option>";
                        echo "<option selected value=\"Rattrapage\">Rattrapage</option>";
                        echo "<option  value=\"Changement horaire\">Changement horaire</option>";

                    }
                    
                    if(isset($_GET['id']) && $rowannonce['Type_annonce'] == 'Changement horaire'){
                        echo "<option  value=\"Annonce de cours\">Annonce de cours</option>";
                        echo "<option  value=\"Rattrapage\">Rattrapage</option>";
                        echo "<option selected value=\"Changement horaire\">Changement horaire</option>";

                    }
                    
                    ?>

                </select>
                <select name="local" id="LocalSelection" >
                    <option value="">Choisir un local</option>
                    <?php
                         $query = "SELECT * FROM local";
                         $result  = mysqli_query($conn,$query);
                         while($row = mysqli_fetch_assoc($result)){
                             echo '<option value="'.$row['ID_local'].'"';
                             if(isset($_GET['id']) && $rowannonce['ID_local'] == $row['ID_local'] ) 
                             echo ' selected>'.$row['Nom_local'].'</option>';
                             else 
                             echo '>'.$row['Nom_local'].'</option>';
                         }
                    ?>
                </select>
                <button type="submit" class="btn">Modifier</button>  
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
        function adminChooseFilierEnable(){
            if(type_utilisateur == 'administrateur')
            var filiereSelection = document.getElementById("FiliereSelection");
            filiereSelection.style.display="block";
        }
        window.onload = adminChooseFilierEnable();
        
    </script>
</body>
</html>