<?php

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">

    <link href="dist/css/bootstrap.min.css" rel="stylesheet">

    <link href="dist/fonts/fontawesome-free-5.15.4-web/css/all.css" rel="stylesheet">

    <title>Blog</title>
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
    </div>

    <section class="py-5 text-center container">
    <div class="row py-lg-5">
      <div class="col-lg-6 col-md-8 mx-auto">
      <img src="img/konodioda.jpg" class="bd-placeholder-img rounded-circle" width="140" height="140" xmlns="http://www.w3.org/2000/svg" role="img" preserveAspectRatio="xMidYMid slice" focusable="false"><title>Placeholder</title><rect width="100%" height="100%" fill="#777"/>
        <h1 class="fw-light">Mon blog</h1>
        <p class="lead text-muted">Ici contiendra surement des informations futures, consernant mes productions ect...<i class="fa fa-hard-hat"></i></p>
      </div>
    </div>
  </section>
  <div class="album py-5 bg-light">
    <div class="container">
    <?php
    require_once "./model/postDB.php";

    use Blog\model\PostDB;

    $allPosts = PostDB::SelectAllPost();

    

    // affichage de chaque posts
    for($i=0;$i<count($allPosts);$i++){
        $allMedia = PostDB::GetAllMediaByIdPosts($allPosts[$i]["idPost"]);

        echo '<div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 g-3">';
        echo '<div class="col">';
        echo '<div class="card shadow-sm">';
        // affichage de chaque media dans le post
        for($j=0;$j<count($allMedia);$j++){
          // séparer l'extension du fichier avec son type en général pour récupérer le type
          $type = explode("/",$allMedia[$j]["typeMedia"]);          

          // si c'est une vidéo le mettre dans la balise corréspondante
          if(strtolower($type[0]) == "video"){
            echo '<video width="320" height="240" controls autoplay loop>
            <source src="imgServ/'. $allMedia[$j]["nomMedia"] .'" type="video/mp4">
          La vidéo galère à s\'afficher
          </video>';
          }
          // si c'est une vidéo le mettre dans la balise corréspondante
          if(strtolower($type[0]) == "audio"){
            echo'<audio controls>
            <source src="imgServ/'. $allMedia[$j]["nomMedia"] .'" type="audio/ogg">
          L\'audio ne réponds pas
          </audio>';
          }
          // si c'est une vidéo le mettre dans la balise corréspondante
          if(strtolower($type[0]) == "image"){
            echo '<img src="imgServ/'. $allMedia[$j]["nomMedia"].'" class="bd-placeholder-img card-img-top" width="100%" height="225" xmlns="http://www.w3.org/2000/svg" role="img" aria-label="Placeholder: Thumbnail" preserveAspectRatio="xMidYMid slice" focusable="false"><title>Placeholder</title><rect width="100%" height="100%" fill="#55595c"/>';
          }
        }
        echo '<div class="card-body">';
        echo '<p class="card-text">'.$allPosts[$i]["commentaire"].'</p>';
        echo '<a href="index.php?nav=update&idPost='. $allPosts[$i]["idPost"].'" type="button" class="btn btn-secondary" data-bs-toggle="modal" data-bs-target="#deleteModal"><i class="fa fa-pen"></i></a>';
        echo '<a href="index.php?nav=delete&idPost='. $allPosts[$i]["idPost"].'"type="button" class="btn btn-danger"><i class="fa fa-trash"></i></a>';
        echo '<div class="d-flex justify-content-between align-items-center">';
        echo '<small class="text-muted">publié le '.$allPosts[$i]["creationDate"].'</small>';
        echo '</div>';
        echo '</div>';
        echo '</div>';
        echo '</div>';
        echo '</div>';
        
        // Modal de supprression
        echo '<div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">';
        echo '<div class="modal-dialog">';
        echo '<div class="modal-content">';
        echo '<div class="modal-header">';
        echo '<h5 class="modal-title" id="exampleModalLabel">Modal title</h5>';
        echo '<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>';
        echo '</div>';
        echo '<div class="modal-body">';
        echo '...';
        echo '</div>';
        echo '<div class="modal-footer">';
        echo '<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>';
        echo '<button type="button" class="btn btn-primary">Save changes</button>';
        echo '</div>';
        echo '</div>';
        echo '</div>';
        echo '</div>';
    }
    ?>
    </div>
  </div>
</body>
</html>