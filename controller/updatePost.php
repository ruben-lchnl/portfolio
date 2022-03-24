<?php
    require_once "./model/postDB.php";

    use Blog\model\DBConnection;
    use Blog\model\PostDB;

    $idPost = $_GET["idPost"];
    $idPost!=null?$_GET["idPost"]:null;

    $com = filter_input(INPUT_POST,"commentaire",FILTER_SANITIZE_STRING);

    $mediaNames = [];

    if($idPost){
        $infos = PostDB::GetPostsById($idPost);
    }
    // si on ajout une/des images
    if(isset($_FILES) && $_FILES["img"]["name"][0] != null && is_array($_FILES) && count($_FILES)>0){
        $files = $_FILES["img"];

        $totalSize = 0;

        $valid = true;

        $dest = "./imgServ/";

        // Boucle itérant sur chacun des fichiers
        for($i=0;$i<count($files['name']);$i++){

            if($files["type"][$i] != "video/mp4"){
                $totalSize += $files["size"][$i];
            }

            //vérifie que la taille du fichier ne dépace pas 3Mo
            if($files["size"][$i] > 3000000 && $files["type"][$i] != "video/mp4"){
                echo "<p>";
                echo "Votre fichier : ".$files["name"][$i]. " à une taille supérieur à 3Mo, Veuillez en choisir un plus petit";
                echo "</p>";
                $valid = false;
            }

            // séparer l'extension du fichier avec son type en général pour récupérer le type
            $type = explode("/",$files["type"][$i]);

            // vérifie que les fichier ont le bon type de données
            if(strtolower($type[0]) == "image" || strtolower($type[0]) == "video" || strtolower($type[0]) == "audio"){
                
                // Affichage d’informations diverses
                echo '<p>';
                echo 'Fichier '.$files['name'][$i].' reçu';
                echo '<br>';
                echo 'Type '.$files['type'][$i];
                echo '<br>';
                echo 'Taille '.$files['size'][$i].' octets';

                $dest = $idPost. uniqid(). $files["name"][$i];

                $mediaNames += $dest;

                // Nettoyage du nom de fichier
                $filesName = preg_replace('/[^a-z0-9\.\-]/i','',$files['name'][$i]);

                // Déplacement depuis le répertoire temporaire si le fichier n'existe pas sinon renommer l'image
                if(file_exists("./imgServ/".$dest)){
                    // rennomage
                    echo "<p>";
                    echo "alert(veuillez réessayer)";
                    echo "</p>";
                    $valid = false;
                }else{
                    $correctlyMoved = move_uploaded_file($files['tmp_name'][$i],"./imgServ/".$dest);
                }

                // Si le type MIME correspond à une image, on l’affiche
                if(preg_match('/image/',$files['type'][$i])) {
                    echo '<br><img src="uploads/'.$filesName.'">';
                }
                echo '</p>';
            }else{
                echo "<p>";
                echo "Votre fichier : ".$files["name"][$i]. " n'est pas un fichier au format correct";
                echo "</p>";
                $valid = false;
            }

        }
        // vérifie que le total des tailes des fichiers ne dépassent pas 70Mo
        if($totalSize > 70000000){
            echo "<p>";
            echo "La totalité de vos fichier dépasse les 70Mo (". $totalSize ."Mo), veuillez racourcir cette somme.";
            echo "</p>";
            $valid = false;
        }

        // envoi dans la base de données seulement si tout les données sont conformes
        if($valid){
            try{
                $pdo = DBConnection::getConnection();

                $pdo->beginTransaction();

                for($i=0;$i<count($files['name']);$i++){
                    PostDB::AddNewMedia($files["type"][$i],$mediaNames[$i],$idPost);
                }

                $pdo->commit();
            }catch(\PDOException $e){
                $pdo->rollBack();

                var_dump($e);
            }
        }
    }
    // si on modifie le commentaires
    if($com != $infos[0]["commentaire"] && $com != null){
        try{
            $pdo = DBConnection::getConnection();

            $pdo->beginTransaction();

            PostDB::ModifyComm($idPost, $com);
            
            $pdo->commit();
        }catch(\PDOException $e){
            $pdo->rollBack();

            var_dump($e);
        }
    }