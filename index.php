<?php
    
    $nav = empty($_GET["nav"]) ? "home" : $_GET["nav"];

    switch($nav){
        case "home":
            include("view/home.php");
        break;
        case "post":
            include("view/post.php");
        break;
        case "delete":
            include("controller/supprPost.php");
        break;
    }

?>