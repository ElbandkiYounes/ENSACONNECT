<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Post</title>
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

<!--======================END of NAV======================-->
<?php
include ('./connection.php');
$ID_annonce = $_GET["id"];
echo $ID_annonce;
$queryannonce ="SELECT * FROM annonce WHERE ID_annonce = '$ID_annonce'";
$resultannonce = mysqli_query($conn,$queryannonce);
if($rowannonce = mysqli_fetch_assoc($resultannonce)){
    $querylocal = "SELECT * FROM local WHERE ID_local = '{$rowannonce['ID_local']}'";
    $resultlocal = mysqli_query($conn,$querylocal);
    $rowlocal = mysqli_fetch_assoc($resultlocal);

    $queryuser = "SELECT * FROM utilisateur where cin = '{$rowannonce['cin']}'";
    $resultuser = mysqli_query($conn,$queryuser);
    $rowuser = mysqli_fetch_assoc($resultuser);

    echo '<section class="singlepost">
            <div class="container singlepost_container">
                <h2 class = "post_title one_post">' . $rowannonce['Titre'] . '</h2>
                <p class=" smc   ">' . $rowannonce["Type_annonce"] . '</p>';
                echo '<p  class=" smc    ">' . $rowlocal["Nom_local"] . '</p>';
                echo '<div class="post_author">
                        <div class="singlepost_author_info">
                            <h5>Publier Par : ' . $rowuser['nom'] . ' ' . $rowuser['prenom'] . '</h5>
                            <small>'.$rowannonce['Date_creation'].'</small>
                        </div>
                    </div>
                    <div class="singlepost_thumbnail">
                    <img src="uploads/' . $rowannonce['img'] . '" alt="">
                </div>';
                echo '<p class = "post_body one_post">' . $rowannonce['Contenu'] . '</p>
            </div>
        </section>';
}
?>
<!--====================END of posts====================-->

<footer>
    <div class="footer_copyright">
        <small>Copyright &copy;2024 Younes Elbandki && Mouad Id Karoum</small>
    </div>
</footer>

<!--====================END of footer====================-->
</body>
</html>
