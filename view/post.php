<?php
    var_dump($infos);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link href="dist/css/bootstrap.min.css" rel="stylesheet">

    <link href="dist/fonts/fontawesome-free-5.15.4-web/css/all.css" rel="stylesheet">

    <title>Post</title>
</head>

<body>
    <div class="b-example-divider"></div>

    <div class="container">
        <header class="d-flex flex-wrap align-items-center justify-content-center justify-content-md-between py-3 mb-4 border-bottom">

            <ul class="nav col-6 col-md-auto mb-2 justify-content-center mb-md-0">
            <li><a href="./index.php?nav=home" class="nav-link px-2 link-secondary"><i class="fas fa-home"></i> Home</a></li>
            <li><a href="./index.php?nav=post" class="nav-link px-2 link-dark"><i class="fas fa-pen"></i> Post</a></li>
            </ul>

        </header>
    </div class="row g-5">
        <div class="col-md-7 col-lg-8">
            <form action="<?php 
                if($infos == null){
                    echo "index.php";
                }else{
                    echo "index.php?nav=modify&idPost=" . $infos[0]["idPost"];
                }      
            ?>"method="POST" enctype="multipart/form-data">
                <div class="mb-3">
                    <label for="Textarea" class="form-label">Commentaire</label>
                    <textarea class="form-control" name="commentaire" id="Textarea" rows="3"><?= $infos[0]["commentaire"] ?></textarea>
                </div>
                <?php
                    if($infos !== null){
                        echo "<div>";
                        foreach($infos as $info){
                            // séparer l'extension du fichier avec son type en général pour récupérer le type
                            $type = explode("/",$info["typeMedia"]);

                            // si c'est une vidéo le mettre dans la balise corréspondante
                            if(strtolower($type[0]) == "video"){
                                echo '<video width="320" height="240" controls>
                                <source src="imgServ/'. $info["nomMedia"] .'" type="video/mp4">
                            La vidéo galère à s\'afficher
                            </video>';
                            }
                            // si c'est une vidéo le mettre dans la balise corréspondante
                            if(strtolower($type[0]) == "audio"){
                                echo'<audio controls>
                                <source src="imgServ/'. $info["nomMedia"] .'" type="audio/ogg">
                            L\'audio ne réponds pas
                            </audio>';
                            }
                            // si c'est une vidéo le mettre dans la balise corréspondante
                            if(strtolower($type[0]) == "image"){
                                echo '<img src="imgServ/'. $info["nomMedia"].'" class="bd-placeholder-img card-img-top" width="100%" height="225" xmlns="http://www.w3.org/2000/svg" role="img" aria-label="Placeholder: Thumbnail" preserveAspectRatio="xMidYMid slice" focusable="false"><title>Placeholder</title><rect width="100%" height="100%" fill="#55595c"/>';
                            }
                            echo '<a href="index.php?nav=deleteMedia&idMedia='. $info["idMedia"] .'&idPost='.$info["idPost"].'" type="button" class="btn btn-danger"><i class="fa fa-trash"></i></a>';
                            echo '<br>';
                        }
                        echo '</div>';
                    }
                ?>
                <div class="mb-3">
                    <label for="formFileMultiple" class="form-label">Insérez média</label>
                    <input class="form-control" name="img[]" type="file" accept="image/*,audio/*,video/*" id="formFileMultiple" <?= $infos["nomMedia"] ?> multiple>
                </div>
                <input class="btn btn-primary" type="submit" value="Envoi">
            </form>
        </div>
    </div>
</body>

</html>
<?php

?>