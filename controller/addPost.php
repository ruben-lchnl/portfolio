<?php
    require_once "./model/postDB.php";

    use Blog\model\DBConnection;
use blog\model\PostDB;

    $com = filter_input(INPUT_POST,"commentaire",FILTER_SANITIZE_STRING);
    
    if(isset($_FILES) && is_array($_FILES) && count($_FILES)>0){
        $files = $_FILES["img"];

        $totalSize = 0;

        $valid = true;

        $dest = "./imgServ/";

        // Boucle itérant sur chacun des fichiers
        for($i=0;$i<count($files['name']);$i++){

            $totalSize += $files["size"][$i];

            //vérifie que la taille du fichier ne dépace pas 3Mo
            if($files["size"][$i] > 3000000){
                echo "<p>";
                echo "Votre fichier : ".$files["name"][$i]. " à une taille supérieur à 3Mo, Veuillez en choisir un plus petit";
                echo "</p>";
                $valid = false;
            }
            // vérifie que les fichier ont le bon type de données
            if($files["type"][$i] == "image/png" || $files["type"][$i] == "image/jpeg" || $files["type"][$i] == "image/gif"){
                
                // Affichage d’informations diverses
                echo '<p>';
                echo 'Fichier '.$files['name'][$i].' reçu';
                echo '<br>';
                echo 'Type '.$files['type'][$i];
                echo '<br>';
                echo 'Taille '.$files['size'][$i].' octets';

                $dest = $files["name"][$i];

                // Nettoyage du nom de fichier
                $filesName = preg_replace('/[^a-z0-9\.\-]/i','',$files['name'][$i]);

                // Déplacement depuis le répertoire temporaire si le fichier n'existe pas sinon renommer l'image
                if(file_exists("./imgServ/".$dest)){
                    // rennomage
                    echo "<p>";
                    echo "alert(Le Fichier ".$files["name"][$i] . "existe déjà, veuillez le renomer et réessayer)";
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

                PostDB::AddNewPost($com);
                $idPost = PostDB::getLastIdPosts();
                for($i=0;$i<count($files['name']);$i++){
                    PostDB::AddNewMedia($files["type"][$i],$files["name"][$i],$idPost[0][0]);
                }

                $pdo->commit();
            }catch(\PDOException $e){
                $pdo->rollBack();

                var_dump($e);
            }
        }
    }
?>