<?php
    namespace blog\model;

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

        public function AddNewMedia(){
            $db = DBConnection::getConnection();

            $id = "SELECT LAST_INSERT_ID()";

            //PDO::lastInsertId()

            $sql = "INSERT INTO `media`(`commentaire`,`creationDate`) VALUES (:comm,:creaDate)";
            $req = $db->prepare($sql);
            //$req->execute([
            //    ":comm" => $commentaire,
            //    ":creaDate" => $dateAjout
            //]);
        }
    }
?>