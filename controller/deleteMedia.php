<?php
    require_once "./model/postDB.php";
    require_once "./model/DBConnection.php";
    use Blog\model\PostDB;
    use Blog\model\DBConnection;

    $idMedia = $_GET["idMedia"];

    if($idMedia != null){   
        $nomMedia = PostDB::GetMediaById($idMedia);
    
        unlink("./imgServ/" . $nomMedia[0]["nomMedia"]);
        
        PostDB::DeleteMediaById($idMedia);
    }
?>