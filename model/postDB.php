<?php
    namespace blog\model;

    use Blog\model\DBConnection;

    include_once "./DBConnection.php";

    class PostDB{
        public function AddNewPost($commentaire, $dateAjout){
            $db = DBConnection::getConnection();

            $sql = "INSERT INTO `post`(`commentaire`,`creationDate`) VALUES (:comm,:creaDate)";
            $req = $db->prepare($sql);
            $req->execute([
                ":comm" => $commentaire,
                ":creaDate" => $dateAjout
            ]);
        }
    }
?>