<?php
    session_start();
    $type_utilisateur = $_SESSION['type_utilisateur'];
    if($type_utilisateur == 'enseignant'){
        header('location:dashboard-teacher.php');
    }
    elseif($type_utilisateur == 'chef_filiere'){
        header('location:dashboard-admin-low.php');
    }else{
        header('location:dashboard-admin-high-manage-post.php');
    }


?>