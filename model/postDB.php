<?php
    namespace Blog\model;

    use Blog\model\DBConnection;

    include_once "./model/DBConnection.php";

    $id = 0;

    class PostDB{
        public static function AddNewPost($commentaire){
            $db = DBConnection::getConnection();

            $sql = "INSERT INTO `post`(`commentaire`,`creationDate`) VALUES (:comm,:creaDate)";
            $req = $db->prepare($sql);
            $req->execute([
                ":comm" => $commentaire,
                ":creaDate" => date("Y-m-d H:i:s")
            ]);
        }

        public static function getLastIdPosts()
        {
            $db = DBConnection::getConnection();
            $sql = "SELECT LAST_INSERT_ID()";
            $q = $db->prepare($sql);
            $q->execute();
            $result = $q->fetchAll();
            return $result;
        }

        public static function AddNewMedia($type,$nom,$id){
            $db = DBConnection::getConnection();

            $sql = "INSERT INTO `media`(`typeMedia`,`nomMedia`,`creationDate`,`idPost`) VALUES (:typeMedia,:nom,:creaDate,:idPost)";
            $req = $db->prepare($sql);
            $req->execute([
                ":typeMedia" => $type,
                ":nom" => $nom,
                ":creaDate" => date("Y-m-d H:i:s"),
                ":idPost" => $id
            ]);
        }

        public static function SelectAllPost(){
            $db = DBConnection::getConnection();

            $sql = "SELECT * FROM `post` ORDER BY `creationDate` DESC, `modificationDate` DESC";
            $q = $db->prepare($sql);
            $q->execute();
            $result = $q->fetchAll();
            return $result;
        }

        public static function GetAllMediaByIdPosts($idPost){
            $db = DBConnection::getConnection();

            $sql = "SELECT * FROM `media` WHERE idPost=:idPost ORDER BY `creationDate` DESC, `modificationDate` DESC";
            $q = $db->prepare($sql);
            $q->execute([
                ":idPost" => $idPost
            ]);
            $result = $q->fetchAll();
            return $result;
        }

        public static function GetMediaById($idMedia){
            $db = DBConnection::getConnection();

            $sql = "SELECT `nomMedia` FROM `media` WHERE idMedia=:idMedia";
            $q = $db->prepare($sql);
            $q->execute([
                ":idMedia" => $idMedia
            ]);
            $result = $q->fetchAll();
            return $result;
        }

        public static function DeletePostById($idPost){
            $db = DBConnection::getConnection();

            $sql = "DELETE FROM `post` WHERE idPost=:idPost";
            $q = $db->prepare($sql);
            $q->execute([
                ":idPost" => $idPost
            ]);
        }

        public static function AddMedia($type,$nom,$id){
            $db = DBConnection::getConnection();

            $sql = "INSERT INTO `media`(`typeMedia`,`nomMedia`,`modificationDate`,`idPost`) VALUES (:typeMedia,:nom,:modifyDate,:idPost)";
            $req = $db->prepare($sql);
            $req->execute([
                ":typeMedia" => $type,
                ":nom" => $nom,
                ":modifyDate" => date("Y-m-d H:i:s"),
                ":idPost" => $id
            ]);
        }

        public static function ModifyComm($idPost, $newCom){
            $db = DBConnection::getConnection();

            $sql = "UPDATE `post`SET commentaire = :commentaire WHERE idPost=:idPost";
            $q = $db->prepare($sql);
            $q->execute([
                ":commentaire" => $newCom,
                ":idPost" => $idPost
            ]);
        }

        public static function DeleteMediaById($idMedia){
            $db = DBConnection::getConnection();

            $sql = "DELETE FROM `media` WHERE idMedia=:idMedia";
            $q = $db->prepare($sql);
            $q->execute([
                ":idMedia" => $idMedia
            ]);
        }

        public static function GetAllImagesForDelete($idPost){
            $db = DBConnection::getConnection();

            $sql = "SELECT `nomMedia` FROM `media` WHERE idPost=:idPost";
            $q = $db->prepare($sql);
            $q->execute([
                ":idPost" => $idPost
            ]);
            $result = $q->fetchAll();
            return $result;
        }

        public static function GetPostsById($idPost){
            $db = DBConnection::getConnection();

            $sql = "SELECT p.idPost,m.nomMedia,p.commentaire,m.idMedia,m.typeMedia FROM post AS p INNER JOIN media AS m ON p.idPost=m.idPost WHERE p.idPost=:idPost";
            $q = $db->prepare($sql);
            $q->execute([
                ":idPost" => $idPost
            ]);
            $result = $q->fetchAll();
            return $result;
        }
    }
?>