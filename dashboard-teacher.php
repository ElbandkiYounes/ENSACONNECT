<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DashBoard Enseignant</title>
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
                        <a href="add-post.php">
                            <i class="uil uil-plus-circle"></i>
                            <h5>Ajouter Annonce</h5>
                        </a>
                    </li>
                    
                    
                </ul>
            </aside>
            <main>
                <h2>Gérer Annonces</h2>
                <?php 
                    session_start();
                    include('./connection.php');
                    $query = "SELECT * FROM annonce WHERE cin = '{$_SESSION['cin']}'";
                    $result = mysqli_query($conn,$query);
                    if(mysqli_num_rows($result)>0){
                        echo '<table>
                        <thead>
                            <tr>
                                <th>Titre</th>
                                <th>Type Annonce</th>
                                <th>Statut</th>
                                <th>Consulter</th>
                                <th>Modifier</th>
                                 
                            </tr>
                        </thead>
                        <tbody>';
                        while($row = mysqli_fetch_assoc($result))
                        {
                            $ID_annonce = $row['ID_annonce'];
                            echo '<tr>
                            <td>'.$row['Titre'] .'</td>
                            <td>'.$row['Type_annonce'].'</td>
                            <td>'.$row['Statut'].'</td>';
                            echo "<td><a href='./post.php?id={$ID_annonce}' class='btn sm'>Consulter</a></td>";
                            echo "<td><a href='./edit-post.php?id={$ID_annonce}' class='btn sm'>Modifier</a></td>";
                        }
                        echo '</tbody>
                            </table>';
                    }
                    else{
                        echo '<div class="alert_message error"><p>Auccun Annonce trouver</p></div>';
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