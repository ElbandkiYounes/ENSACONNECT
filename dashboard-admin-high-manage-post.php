<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DashBoard Administration</title>
    <!--Custom styles-->
    <link rel="stylesheet" href="style.css">
    <!--Icon Scout CDN-->
    <link rel="stylesheet" href="https://unicons.iconscout.com/release/v4.0.0/css/line.css">
    <!--Google font-->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
</head>
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

    <section class="dashboard">
        <div class="container dashboard_container">
            <aside>
                <ul>
                    <li>
                        <a href="dashboard-admin-high-manage-post.php" class="active">
                            <i class="uil uil-clipboard-notes"></i>
                            <h5>Gérer Les Annonces</h5>
                        </a>
                    </li>
                    <li>
                        <a href="dashboard-admin-high-manage-user.php" >
                            <i class="uil uil-users-alt"></i>
                            <h5>Gérer Les Utilisateur</h5>
                        </a>
                    </li>
                    <li>
                        <a href="add-post.php">
                            <i class="uil uil-plus-circle"></i>
                            <h5>Ajouter Annonce</h5>
                        </a>
                    </li>
                    <li>
                        <a href="add-user.php">
                            <i class="uil uil-user-plus"></i>
                            <h5>Ajouter Utilisateur</h5>
                        </a>
                    </li>
                    
                </ul>
            </aside>
            <main>
                <h2>Gérer Annonces</h2>
                <?php 
include('./connection.php');
$query = "SELECT * FROM annonce";
$result = mysqli_query($conn,$query);
if(mysqli_num_rows($result) > 0){
    // Fetch all rows into an array
    $rows = [];
    while($row = mysqli_fetch_assoc($result)) {
        $rows[] = $row;
    }

    // Reverse the array
    $rows = array_reverse($rows);

    // Output the table
    echo '<table>
        <thead>
            <tr>
                <th>Nom Utilisateur</th>
                <th>Filier</th>
                <th>Type Annonce</th>
                <th>Statut</th>
                <th>Consulter</th>
                <th>Accepter</th>
                <th>Rejeter</th>
                <th>Modifier</th>
            </tr>
        </thead>
        <tbody>';

    // Iterate through the reversed array
    foreach($rows as $row) {
        $queryfiliere = "SELECT * FROM filiere WHERE ID_filiere = '{$row["ID_filiere"]}'";
        $resultfiliere = mysqli_query($conn,$queryfiliere);
        $rowfiliere =  mysqli_fetch_assoc($resultfiliere) ;
        
        $queryuser = "SELECT * FROM utilisateur WHERE cin = '{$row["cin"]}'";
        $resultuser = mysqli_query($conn,$queryuser);
        $rowuser =  mysqli_fetch_assoc($resultuser);
        $ID_annonce = $row['ID_annonce'];
        echo '<tr>
            <td>'.$rowuser['nom'] .'</td>
            <td>'.$rowfiliere['Nom_filiere'].'</td>
            <td>'.$row['Type_annonce'].'</td>
            <td>'.$row['Statut'].'</td>';
        echo "<td><a href='./post.php?id={$ID_annonce}' class='btn sm'>Consulter</a></td>";
        echo "<td><a href='./accepter-post.php?id={$ID_annonce}'class='btn sm'>Accepter</a></td>";
        echo"<td><a href='./rejeter-post.php?id={$ID_annonce}' class='btn sm danger'>Rejeter</a></td>";
        echo "<td><a href='./edit-post.php?id={$ID_annonce}' class='btn sm'>Modifier</a></td>";
    }

    echo '</tbody></table>';
}
else{
    echo '<div class="alert_message error"><p>Aucun utilisateur trouvé</p></div>';
}
?>

            </main>
        </div>
    </section>
    <footer>
        <div class="footer_copyright">
            <small>Copyright &copy;2024 Younes Elbandki && Moad Id Karoum</small>
        </div>
    </footer>

    
</body>