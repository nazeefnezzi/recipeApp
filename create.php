
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
        $errorImageUpload = NULL;
        $dbError= false;



            #*******************************************************#
			#********** FORMULARVERARBEITUNG NEW RECIPE ************#
            #*******************************************************#
            
        if( isset( $_POST['newRecipeForm'] ) ) {
if(DEBUG)		echo "<p class='debug hint'>Line <b>" . __LINE__ . "</b>: Formular 'New recipe' wurde abgeschickt... <i>(" . basename(__FILE__) . ")</i></p>";	
           

                // step-2
                $recipe->setRec_title( $_POST['title'] );
                $recipe->setRec_content( $_POST['contant'] );
                $recipe->setRec_description( $_POST['description'] );


                // Schritt 3 FORM: value validation

                $errorTitle = checkInputString($recipe->getRec_title(), 3);
                $errorContent = checkInputString($recipe->getRec_content(), 4, 65000);
                $errorDescription = checkInputString($recipe->getRec_description(), 4, 65000);

                if( $errorTitle OR $errorContent OR $errorDescription ) {
if(DEBUG)				echo "<p class='debug err'><b>Line " . __LINE__ . "</b>: Das Formular enthält noch Fehler! <i>(" . basename(__FILE__) . ")</i></p>\r\n";
  
                } else {
                    //erfolgfall
if(DEBUG)				echo "<p class='debug ok'><b>Line " . __LINE__ . "</b>: Das Formular ist formal fehlerfrei ... <i>(" . basename(__FILE__) . ")</i></p>\r\n";
                    // image upload
                    if( $_FILES['rec_image']['tmp_name'] != "" ) {
if(DEBUG)				echo "<p class='debug hint'>Line <b>" . __LINE__ . "</b>: Bild Upload aktiv... <i>(" . basename(__FILE__) . ")</i></p>";
 
                        $imageUploadResultArray = imageUpload($_FILES['rec_image']);

// if(DEBUG)	echo "<pre class='debug'>Line <b>" . __LINE__ . "</b> <i>(" . basename(__FILE__) . ")</i>:<br>\r\n";					
// if(DEBUG)	print_r($imageUploadResultArray);					
// if(DEBUG)	echo "</pre>";

                    if( $imageUploadResultArray['imageError'] ) {
                        $errorImageUpload = $imageUploadResultArray['imageError'];
                    } else {
                        $rec_ImagePath = $imageUploadResultArray['imagePath'];
                        $recipe->setRec_imagePath($rec_ImagePath);
                    }



                    } else {

 if(DEBUG)				echo "<p class='debug'>Line <b>" . __LINE__ . "</b>: there is no image uploaded. <i>(" . basename(__FILE__) . ")</i></p>";
                       
                    } //image upload

                
                // final form validation 
                if( $errorImageUpload ) {
if(DEBUG)				echo "<p class='debug err'>Line <b>" . __LINE__ . "</b>: Formular enthält noch Fehler (Imageupload)! <i>(" . basename(__FILE__) . ")</i></p>";
                   
                }else {

if(DEBUG)				echo "<p class='debug ok'>Line <b>" . __LINE__ . "</b>: Formular ist fehlerfrei. recipieintrag wird in DB gespeichert... <i>(" . basename(__FILE__) . ")</i></p>";
                   

                        #**************new recipie Savo to db********#
                        $pdo = dbConnect('recpieapp');
                        
                       // $recipe->saveToDb($pdo);

                       #**** transaction start *****#
                       if( !$pdo->beginTransaction() ) {
if(DEBUG)						echo "<p class='debug err'><b>Line " . __LINE__ . "</b>: FEHLER beim Starten der Transaction! <i>(" . basename(__FILE__) . ")</i></p>\r\n";				

                         

                       }else {
                           //success
if(DEBUG)						echo "<p class='debug ok'><b>Line " . __LINE__ . "</b>: Transaction erfolgreich gestartet. <i>(" . basename(__FILE__) . ")</i></p>\r\n";									
                          #******* recipue anlegen *******#

                          if( !$recipe->saveToDb($pdo) ) {
if(DEBUG)								echo "<p class='debug err'><b>Line " . __LINE__ . "</b>: FEHLER bei der Simulation des Schreibens des Nwe recipie-Datensatzes! <i>(" . basename(__FILE__) . ")</i></p>\r\n";

                                $dbError = true;
                          }else {
                              // success
if(DEBUG)								echo "<p class='debug ok'><b>Line " . __LINE__ . "</b>: Schreiben des new recipe-Datensatzes erfolgreich simuliert mit 'ID " . $recipe->getRec_id() . "'. <i>(" . basename(__FILE__) . ")</i></p>\r\n";



                          } // calling save to db function

                          if( $dbError ) {
                              // feheler
if(DEBUG)							echo "<p class='debug err'><b>Line " . __LINE__ . "</b>: FEHLER bei der Simulation des Schreibvorgangs in die DB! <i>(" . basename(__FILE__) . ")</i></p>\r\n";				

                             $dbErrorMessage = "there is some error please try agin later";

                             #********** ROLLBACK DURCHFÜHREN **********#

                             if( !$pdo->rollback() ) {
                                 // feher
if(DEBUG)								echo "<p class='debug err'><b>Line " . __LINE__ . "</b>: FEHLER beim Durchführen des Rollbacks! <i>(" . basename(__FILE__) . ")</i></p>\r\n";				
                              
                             }else {
                                 //suces
if(DEBUG)								echo "<p class='debug ok'><b>Line " . __LINE__ . "</b>: Rollback erfolgreich durchgeführt. <i>(" . basename(__FILE__) . ")</i></p>\r\n";										

                             }
                         

                            }else {
 if(DEBUG)							echo "<p class='debug ok'><b>Line " . __LINE__ . "</b>: Schreibvorgang wurde erfolgreich simuliert. <i>(" . basename(__FILE__) . ")</i></p>\r\n";				



                                // commit
                                if( !$pdo->commit() ) {
                                    //fehler fall
if(DEBUG)								echo "<p class='debug err'><b>Line " . __LINE__ . "</b>: FEHLER beim Durchführen des Commits! <i>(" . basename(__FILE__) . ")</i></p>\r\n";				
                                    $dbErrorMessage = "there is some error please try again later";



                                }else {
                                    //success

if(DEBUG)								echo "<p class='debug ok'><b>Line " . __LINE__ . "</b>: Commit erfolgreich durchgeführt. <i>(" . basename(__FILE__) . ")</i></p>\r\n";											
                                   
                                    $successMessage= "new recipie successfully inserted";

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


     <!-- bootstrap css (bootswatch)-->
     <link rel="stylesheet" href="css/bootstrap.min.css">
    <!-- debug css)-->
    <link rel="stylesheet" href="css/debug.css">
    
    <!-- bootstrap css (bootswatch)-->
    <link rel="stylesheet" href="css/own.css">
</head>
<body>

      <form action="" class="ownform" method="POST" enctype="multipart/form-data" >
      <input type="hidden" name="newRecipeForm">
      

        <div class="form-group">
        
        <input class="form-control mb-3" type="text" name="title" placeholder="title of your recipe">
        
        <label for="exampleTextarea">contents</label>
        <textarea class="form-control mb-3" name="contant" rows="3" placeholder="incrediance"></textarea>
        
        <label for="exampleTextarea">description</label>
        <textarea class="form-control mb-3" name="description"  rows="3" placeholder="description"></textarea>
        
        <label for="InputFile">Upload recipe Image file</label>
        <input type="file" name="rec_image" class="form-control-file mt-2"  aria-describedby="fileHelp">
        <small id="fileHelp" class="form-text text-muted">Accepted format jpg/jpeg/png/gif. max-size 256kb </small>
        </div>
        
        
        <input type="submit" class="btn btn-primary btn-lg" value="create">
        
   
    </form>  
        

        

    
</body>
</html>