<?php
require_once "./model/postDB.php";
require_once "./model/DBConnection.php";
use Blog\model\PostDB;
use Blog\model\DBConnection;

$idPost = $_GET["idPost"];

if($idPost != null){
    try{
        // supprimer le ou les images du post
        $allImage = PostDB::GetAllImagesForDelete($idPost);

        foreach($allImage as $img){
            unlink("./imgServ/" . $img[0]);
        }

        // supprimer le post
        $pdo = DBConnection::getConnection();

        $pdo->beginTransaction();

        PostDB::DeletePostById($idPost);
        
        $pdo->commit();

        header("location: ./index.php");
    }catch(\PDOException $e){
        $pdo->rollBack();
        error_log($e);
    }
}

?>