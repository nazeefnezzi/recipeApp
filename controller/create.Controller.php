<?php




         /**
				*
				* 	@file 				Controller for Create-page (dashboeard.php)
				* 	@author 				Mohammed Naseef Panthappilan <eMail>
				* 	@copyright 			nazDev
				* 	@lastmodifydate 	11-01-2021
				*
				*/










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