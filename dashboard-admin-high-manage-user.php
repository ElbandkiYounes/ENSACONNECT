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
<?php
if (isset($_GET['cin'])) {
    include('connection.php');

    $cin = $_GET['cin'];

    // Sélectionner le type de l'utilisateur
    $query = "SELECT type_utilisateur FROM utilisateur WHERE cin = ?";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "s", $cin);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    // Vérifier s'il y a des résultats
    if (mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        $type_utilisateur = $row['type_utilisateur'];

        // Supprimer l'utilisateur de la table utilisateur
        $query = "DELETE FROM utilisateur WHERE cin = ?";
        $stmt = mysqli_prepare($conn, $query);
        mysqli_stmt_bind_param($stmt, "s", $cin);
        mysqli_stmt_execute($stmt);

        // Supprimer l'utilisateur de la table correspondante à son type
        $query = "DELETE FROM $type_utilisateur WHERE cin = ?";
        $stmt = mysqli_prepare($conn, $query);
        mysqli_stmt_bind_param($stmt, "s", $cin);
        mysqli_stmt_execute($stmt);
    }
}
?>
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
                        <a href="dashboard-admin-high-manage-post.php">
                            <i class="uil uil-clipboard-notes"></i>
                            <h5>Gérer Les Annonces</h5>
                        </a>
                    </li>
                    <li>
                        <a href="dashboard-admin-high-manage-user.php" class="active">
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
                <h2>Gérer Utilisateur</h2>
                <?php
include('connection.php');
$query = "SELECT * FROM utilisateur WHERE type_utilisateur <> 'administrateur'";
$result = mysqli_query($conn, $query);
if (mysqli_num_rows($result) > 0) {
    
    $rows = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $rows[] = $row;
    }

    
    $rows = array_reverse($rows);

   
    echo '<table>
                <thead>
                    <tr>
                        <th>CIN</th>
                        <th>Nom</th>
                        <th>Prénom</th>
                        <th>Type</th>
                        <th>Modifier</th>
                        <th>Supprimer</th>
                    </tr>
                </thead>
                <tbody>';

    
    foreach ($rows as $row) {
        $cin = $row['cin'];
        echo '<tr>
                        <td>' . $row['cin'] . '</td>
                        <td>' . $row['nom'] . '</td>
                        <td>' . $row['prenom'] . '</td>
                        <td>' . $row['type_utilisateur'] . '</td>
                        <td><a href="edit-user.php?cin=' . $cin . '" class="btn sm">Modifier</a></td>';
        if ($row['type_utilisateur'] != 'administrateur') {
            echo '<td><a href="dashboard-admin-high-manage-user.php?cin=' . $cin . '" class="btn sm danger"  name="supprimer">Supprimer</a></td>
                            </tr>';
        }
    }

    echo '</tbody>
            </table>';
} else {
    echo '<div class="alert_message error"><p>Aucun utilisateur trouvé</p></div>';
}
?>

            </main>


        </div>

    </section>
    <footer>
        <div class="footer_copyright">
            <small>Copyright &copy;2024 Younes Elbandki && Mouad Id Karoum</small>
        </div>
    </footer>


</body>