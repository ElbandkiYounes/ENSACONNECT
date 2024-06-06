<?php
    $ID_annonce = $_GET['id'];
    include('./connection.php');
    session_start();
    echo $ID_annonce;
    $query = "UPDATE annonce SET Statut = 'Rejeté' WHERE ID_annonce ='$ID_annonce'";
    $result = mysqli_query($conn,$query);
    if(isset($result)){
       if($_SESSION['type_utilisateur']=='administrateur')
       header('location:dashboard-admin-high-manage-post.php');
       else
       header('location:dashboard-admin-low.php');
    }

?>