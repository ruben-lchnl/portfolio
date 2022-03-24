<?php
    
    $nav = empty($_GET["nav"]) ? "home" : $_GET["nav"];

    switch($nav){
        case "home":
            require_once "./controller/addPost.php";
            include("view/home.php");
        break;
        case "modify":
            require_once "controller/deleteMedia.php";
            require_once "controller/updatePost.php";
            include("view/home.php");
            break;
        case "post":
            include("view/post.php");
        break;
        case "delete":
            include("controller/supprPost.php");
        break;
        case "update":
            require_once "controller/updatePost.php";
            include_once("view/post.php");
        case "deleteMedia":
            require_once "controller/deleteMedia.php";
            require_once "controller/updatePost.php";
            include_once("view/post.php");
            break;
        break;
    }
?>