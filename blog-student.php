<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>
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
                <li><a class="btn danger" href="signin.php">Se Deconnecter</a></li>
                </li>
            </ul>
        </div>
    </nav>


    <!--======================END of NAV======================-->
    <section class="posts">
        <div class="container posts_container">

            <?php
            include('./connection.php');
            session_start();
            $cin = $_SESSION['cin'];
            $queryetudiant = "SELECT * FROM etudiant WHERE cin = '$cin'";
            $resultetudiant = mysqli_query($conn, $queryetudiant);
            $rowetudiant = mysqli_fetch_assoc($resultetudiant);
            $ID_niveau = $rowetudiant['ID_niveau'];
            $queryannonce = "SELECT * FROM annonce WHERE ID_niveau = '$ID_niveau' AND Statut = 'Accepté' ";
            $resultannonce = mysqli_query($conn, $queryannonce);

            
            $rows = [];
            while ($row = mysqli_fetch_assoc($resultannonce)) {
                $rows[] = $row;
            }

          
            $rows = array_reverse($rows);

            if (count($rows) > 0) {
                foreach ($rows as $row) {
                    $querylocal = "SELECT * FROM local WHERE ID_local = '{$row['ID_local']}'";
                    $resultlocal = mysqli_query($conn, $querylocal);
                    $rowlocal = mysqli_fetch_assoc($resultlocal);

                    $queryauthor = "SELECT * FROM utilisateur WHERE cin = '{$row["cin"]}'";
                    $resultauthor = mysqli_query($conn, $queryauthor);
                    $rowauthor = mysqli_fetch_assoc($resultauthor);

                    echo '
        <article class="post">
            <div class="post_thumbnail">
            <img src="uploads/' . $row['img'] . '" alt="">
            </div>
            <div class="post_info">
                <p class="category_button">' . $row["Type_annonce"] . '</p>
                <p class="category_button sm ">' . $rowlocal["Nom_local"] . '</p>
                <h3 class="post_title">' . $row["Titre"] . '</h3>
                <p class="post_body">' . $row["Contenu"] . '</p>
                <div class="post_author">
                    <div class="post_author_info">
                        <h5>Publier Par: ' . $rowauthor["nom"] . ' ' . $rowauthor["prenom"] . '</h5>
                        <small>'.$row['Date_creation'].'</small>
                    </div>
                </div>
            </div>
        </article>';
                }
            } else {
                echo '<div class="alert_message error"><p>Pas d\'annonce publiée</p></div>';
            }
            ?>


        </div>
    </section>
    <!--====================END of posts====================-->


    <footer>
        <div class="footer_copyright">
            <small>Copyright &copy;2024 Younes Elbandki && Mouad Id Karoum</small>
        </div>
    </footer>

    <!--====================END of footer====================-->
</body>

</html>
