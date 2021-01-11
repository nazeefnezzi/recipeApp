
<?php

        #************************************#
        #************* VIEW Create Page******#
        #************************************#

        require_once('controller/create.Controller.php');

 


?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>new recipie</title>


     <!-- bootstrap css bootswatch-->
     <link rel="stylesheet" href="css/bootstrap.min.css">
    <!-- debug css-->
    <link rel="stylesheet" href="css/debug.css">
    
    <!-- bootstrap css bootswatch-->
    <link rel="stylesheet" href="css/own.css">
</head>
<body class="bg-light">

<header>
            <!-- Image and text -->
                <nav class="navbar navbar-dark bg-primary">
                <div class="container-fluid">
                    <a class="navbar-brand" href="index.php">
                    <img src="css/logo/logo.png" alt="" width="50" height="34" class="d-inline-block align-top">
                    recipeApp
                    </a> 
                    <span class="text-end"> 
                        <h3 class="text-info">Add your Recipe </h3>
                    </span>
                </div>
                </nav>
</header>


      <form action="" class="ownform" method="POST" enctype="multipart/form-data" >
      
      <input type="hidden" name="newRecipeForm">
      

        <?php if($successMessage): ?>
        <div class="form-group">
        <span class="text-success"><strong><?= $successMessage ?></strong></span><br>
        <?php elseif($dbErrorMessage): ?>
        <span class="text-danger"><strong><?= $dbErrorMessage ?><strong></span><br>
        <?php endif ?>
        <span class="text-danger"><?= $errorTitle ?></span><br>
        <input class="form-control mb-3" type="text" name="title" placeholder="title of your recipe">
        
        <label for="exampleTextarea">contents</label>
        <span class="text-danger"><?= $errorContent ?></span><br>
        <textarea class="form-control mb-3" name="contant" rows="3" placeholder="incrediance"></textarea>
        
        <label for="exampleTextarea">description</label>
        <span class="text-danger"><?= $errorDescription ?></span><br>
        <textarea class="form-control mb-3" name="description"  rows="3" placeholder="description"></textarea>
        
        <label for="InputFile">Upload recipe Image file</label>
        <span class="text-danger"><?= $errorImageUpload ?></span><br>
        <input type="file" name="rec_image" class="form-control-file mt-2"  aria-describedby="fileHelp">
        <small id="fileHelp" class="form-text text-muted">Accepted format jpg/jpeg/png/gif. max-size 256kb, max-width/hight 800px </small>
        </div> <br>
        
        
        <input type="submit" class="btn btn-primary btn-lg" value="create">
        
   
    </form>  
        

        

    
</body>
</html>