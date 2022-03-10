<?php
    require_once "./controller/addPost.php";
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
            <form action="#" method="POST" enctype="multipart/form-data">
                <div class="mb-3">
                    <label for="Textarea" class="form-label">Commentaire</label>
                    <textarea class="form-control" name="commentaire" id="Textarea" rows="3"></textarea>
                </div>
                <div class="mb-3">
                    <label for="formFileMultiple" class="form-label">Insérez média</label>
                    <input class="form-control" name="img[]" type="file" accept="image/*,audio/*,video/*" id="formFileMultiple" multiple>
                </div>
                <input class="btn btn-primary" type="submit" value="Envoi">
            </form>
        </div>
    </div>
</body>

</html>
<?php

?>