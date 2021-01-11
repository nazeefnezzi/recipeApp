

<?php



        require_once('controller/index.Controller.php');
       


#******************************************************************************#

            #*******************************************#
            #***********VIEW - Index *******************#
            #*******************************************#

#******************************************************************************#


        

            



?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>recipeApp</title>

    <!-- bootstrap css bootswatch-->
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <!-- debug css-->
    <link rel="stylesheet" href="css/debug.css">
    
    <!-- bootstrap css bootswatch-->
    <link rel="stylesheet" href="css/own.css">
</head>
<body>

<header>
            <!-- Image and text -->
                <nav class="navbar navbar-dark bg-primary">
                <div class="container-fluid">
                    <a class="navbar-brand" href="<?= $_SERVER['SCRIPT_NAME'] ?>">
                    <img src="css/logo/logo.png" alt="" width="50" height="34" class="d-inline-block align-top">
                    recipeApp
                    </a> 
                    <span class="text-end"> 
                        <form class="form-inline my-2 my-lg-0" action="" method="POST">
                        <input type="hidden" name="searchform">

                        <input class="form-control mr-sm-2" type="text" name="recipe-search" placeholder="Search">
                        <input class="btn btn-secondary my-2 my-sm-0" type="submit" value="Search">
                        </form>
                    </span>
                </div>
                </nav>
</header>

<main class="own">


<hr><br>
<a href="create.php" class="btn btn-outline-info m-2">Create new recipe</a>
<a href="?action=atoz" class="btn btn-outline-success m-2 text-end">sort A-z</a>

<hr>

                <?= $message ?>

                <?php if( $allRecipiesObject == true ): ?>

                    <?php foreach( $allRecipiesObject AS $recipeObject ): ?>
                <?php $datetime = isoToEuDateTime( $recipeObject->getRec_date() ) ?>

                <div class="card m-4 owncard" style="max-width: 100%;">
                    <div class="row g-0">
                            <div class="col-md-4">
                            <img class="own-img" src="<?= $recipeObject->getRec_imagePath() ?>" alt="...">
                            </div>
                            <div class="col-md-8">
                            <div class="card-body">
                                <h5 class="card-title ownhead"><?= $recipeObject->getRec_title() ?> </h5>
                                <p><small class="text-muted">created on <?= $datetime['date']  ?> at <?= $datetime['time'] ?> </small><span><button class="btn btn-link ownclass">Read More</button></span></p>
                                <hr>
                                <p class="mb-2"> <strong>Description </strong></p>
                                <p class="card-text"><?= nl2br( $recipeObject->getRec_description() ) ?></p>
                                <p class="mb-2"> <strong>Contents </strong></p>
                                <p class="card-text"> <?= nl2br( $recipeObject->getRec_content() ) ?> </p>
                            </div>
                            </div>
                    </div>
                    
                </div>
                    
                <?php endforeach ?>
                <?php elseif( $searchRecipe == true ): ?>

                    <?php foreach( $searchResultArray AS $recipeArray ): ?>
                <?php $datetime = isoToEuDateTime( $recipeArray['rec_date'] ) ?>

                <div class="card m-4 owncard" style="max-width: 100%;">
                    <div class="row g-0">
                            <div class="col-md-4">
                            <img class="own-img" src="<?= $recipeArray['rec_imagePath'] ?>" alt="...">
                            </div>
                            <div class="col-md-8">
                            <div class="card-body">
                                <h5 class="card-title ownhead"><?= $recipeArray['rec_title'] ?> </h5> 
                                <p> <small class="text-muted">created on <?= $datetime['date']  ?> at <?= $datetime['time'] ?> </small> <span><button class="btn btn-link ownclass" >Read More</button></span> </p>
                                <hr>
                                <p class="mb-2"> <strong>Description </strong></p>
                                <p class="card-text"><?= nl2br( $recipeArray['rec_description'] ) ?></p>
                                <p class="mb-2"> <strong>Contents </strong></p>
                                <p class="card-text"><?= nl2br( $recipeArray['rec_content'] ) ?></p>
                                <p class="card-text"></p>
                            </div>
                            </div>
                    </div>
                    
                </div>
                    
                <?php endforeach ?>


                <?php endif ?>

                
                

</main>


<script src="js/main.js">
    
</script>
</body>
</html>