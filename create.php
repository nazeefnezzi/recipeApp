
<?php

        #************************************#
        #************* configuratrion********#
        #************************************#

        require_once('include/classLoader.inc.php');
        require_once('include/config.inc.php');
        require_once('include/dateTimeBig.inc.php');
        require_once('include/db.inc.php');
        require_once('include/form.inc.php');


        #**********Include classes***************#

        require_once('Class/Recipe.class.php');

        
        // empty objct intilize
        $recipe = new Recipe();

        $title= NULL;
        $content= NULL;
        $description= NULL;
        $image= NULL;
        $errorTitle=NULL;
        $errorContent= NULL;
        $errorDescription=NULL;
        $errorImageUpload = NULL;
        $dbError= false;
        $dbErrorMessage=NULL;
        $successMessage=NULL;
        



            #*******************************************************#
			#********** FORMULARVERARBEITUNG NEW RECIPE ************#
            #*******************************************************#
            
        if( isset( $_POST['newRecipeForm'] ) ) {
           

                // step-2
                $recipe->setRec_title( $_POST['title'] );
                $recipe->setRec_content( $_POST['contant'] );
                $recipe->setRec_description( $_POST['description'] );


                // Schritt 3 FORM: value validation

                $errorTitle = checkInputString($recipe->getRec_title(), 3);
                $errorContent = checkInputString($recipe->getRec_content(), 4, 65000);
                $errorDescription = checkInputString($recipe->getRec_description(), 4, 65000);

                if( $errorTitle OR $errorContent OR $errorDescription ) {
  
                } else {
                    //erfolgfall
//if(DEBUG)				echo "<p class='debug ok'><b>Line " . __LINE__ . "</b>: Das Formular ist formal fehlerfrei ... <i>(" . basename(__FILE__) . ")</i></p>\r\n";
                    // image upload
                    if( $_FILES['rec_image']['tmp_name'] != "" ) {
//if(DEBUG)				echo "<p class='debug hint'>Line <b>" . __LINE__ . "</b>: Bild Upload aktiv... <i>(" . basename(__FILE__) . ")</i></p>";
 
                        $imageUploadResultArray = imageUpload($_FILES['rec_image']);



                    if( $imageUploadResultArray['imageError'] ) {
                        $errorImageUpload = $imageUploadResultArray['imageError'];
                    } else {
                        $rec_ImagePath = $imageUploadResultArray['imagePath'];
                        $recipe->setRec_imagePath($rec_ImagePath);
                    }



                    } else {

 //if(DEBUG)				echo "<p class='debug'>Line <b>" . __LINE__ . "</b>: there is no image uploaded. <i>(" . basename(__FILE__) . ")</i></p>";
                       
                    } //image upload

                
                // final form validation 
                if( $errorImageUpload ) {
                   
                }else {

                   

                        #**************new recipie Savo to db********#
                        $pdo = dbConnect('recpieapp');
                        
                       // $recipe->saveToDb($pdo);

                       #**** transaction start *****#
                       if( !$pdo->beginTransaction() ) {

                         

                       }else {
                           //success
                          #******* recipue anlegen *******#

                          if( !$recipe->saveToDb($pdo) ) {

                                $dbError = true;
                          }else {
                              // success



                          } // calling save to db function

                          if( $dbError ) {
                              // feheler

                             $dbErrorMessage = "there is some error please try agin later";

                             #********** ROLLBACK DURCHFÜHREN **********#

                             if( !$pdo->rollback() ) {
                                 // feher
                              
                             }else {
                                 //suces

                             }
                         

                            }else {



                                // commit
                                if( !$pdo->commit() ) {
                                    //fehler fall
                                    $dbErrorMessage = "there is some error please try again later";



                                }else {
                                    //success

                                   
                                    $successMessage= "new recipie successfully inserted";

                                    $recipe = new Recipe();

                                } //commit

                            } // rollback

                        } // transaction


                    } //error checking 2



                } //error checking-1
                

        }// formular newe recipe end










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