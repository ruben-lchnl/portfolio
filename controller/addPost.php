<?php
    require_once "./model/postDB.php";

    use Blog\model\DBConnection;

    $com = filter_input(INPUT_POST,"commentaire",FILTER_SANITIZE_STRING);
    
    if(isset($_FILES) && is_array($_FILES) && count($_FILES)>0){
        $files = $_FILES["img"];

        $totalSize = 0;

        // Boucle itérant sur chacun des fichiers
        for($i=0;$i<count($files['name']);$i++){

            $totalSize += $files["size"];

            //vérifie que la taille du fichier ne dépace pas 3Mo
            if($files["size"][$i] > 3000000){
                echo "<p>";
                echo "Votre fichier : ".$files["name"][$i]. " à une taille supérieur à 3Mo, Veuillez en choisir un plus petit";
                echo "</p>";
            }
            // vérifie que les fichier ont le bon type de données
            if($files["type"][$i] != "image/png" || $files["type"][$i] != "image/jpeg" || $files["type"][$i] != "image/gif"){
                echo "<p>";
                echo "Votre fichier : ".$files["name"][$i]. " n'est pas un fichier au format correct";
                echo "</p>";
            }


            // Affichage d’informations diverses
            echo '<p>';
            echo 'Fichier '.$files['name'][$i].' reçu';
            echo '<br>';
            echo 'Type '.$files['type'][$i];
            echo '<br>';
            echo 'Taille '.$files['size'][$i].' octets';
            // Nettoyage du nom de fichier
            $filesName = preg_replace('/[^a-z0-9\.\-]/i','',$files['name'][$i]);
            // Déplacement depuis le répertoire temporaire
            move_uploaded_file($files['tmp_name'][$i],'uploads/'.$filesName);
            // Si le type MIME correspond à une image, on l’affiche
            if(preg_match('/image/',$files['type'][$i])) {
                echo '<br><img src="uploads/'.$filesName.'">';
            }
            echo '</p>';
        }
        // vérifie que le total des tailes des fichiers ne dépassent pas 70Mo
        if($totalSize > 70000000){
            echo "<p>";
            echo "La totalité de vos fichier dépasse les 70Mo (". $totalSize ."Mo), veuillez racourcir cette somme.";
            echo "</p>";
        }
    }
?>