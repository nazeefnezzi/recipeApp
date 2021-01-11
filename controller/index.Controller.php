<?php


        /**
				*
				* 	@file 				Controller for index-page (dashboeard.php)
				* 	@author 				Mohammed Naseef Panthappilan <eMail>
				* 	@copyright 			nazDev
				* 	@lastmodifydate 	11-01-2021
				*
				*/




                require_once('include/classLoader.inc.php');
                require_once('include/config.inc.php');
                require_once('include/dateTimeBig.inc.php');
                require_once('include/db.inc.php');
                require_once('include/form.inc.php');
        
                #********** class include **************#
        
                require_once('Class/Recipe.class.php');
        
                #********* initail db connection ****#
                $pdo = dbConnect('recpieapp');
        
        
                #*****************************************************************************#
                            # variable initialise
        
                            $message = NULL;
                            $searchRecipe = false;
        
                            // calling the empty recipie object
                            $recipe = new Recipe();
        
        
                #*****************************************************************************#
                            // Displaying all recipy
        
                
                
        
                            if( $searchRecipe == false ) {
        
                                $allRecipiesObject = Recipe::fetchAllRecipe($pdo);
                                $searchRecipe = false;
        
                            }
                            #**************url params***********#
        
                            if( isset( $_GET['action'] ) ) {
        
        
                                $action = cleanString( $_GET['action'] );
        
        
                                if( $action == "atoz" ) {
        
                                    $allRecipiesObject = Recipe::fetchSortedDb($pdo);
        
                                }
                            
        
        
                        }
        
        
        
                #*****************************************************************************#
                
        
        
                #*****************************************************************************#
        
        
                            #*********************************#
                            #******* Search form *************#
                            #*********************************#
        
        
                            if( isset( $_POST['searchform'] ) ){
        
        
                            $searchItem = cleanString($_POST['recipe-search']);
                         
                            $sql="SELECT * FROM recipes WHERE rec_title = :ph_searchitem";
                            $params = array( "ph_searchitem" => $searchItem );
        
                            
                            $statement = $pdo->prepare($sql);
        
                            $statement->execute($params);
                        
                            $searchResultArray = $statement->fetchAll();
        
        // if(DEBUG)	echo "<pre class='debug'>Line <b>" . __LINE__ . "</b> <i>(" . basename(__FILE__) . ")</i>:<br>\r\n";					
        // if(DEBUG)	print_r($searchResultArray);					
        // if(DEBUG)	echo "</pre>";
        
        
        
                                if( $searchResultArray == NULL ) {
        // if(DEBUG)		echo "<p class='debug hint'>Line <b>" . __LINE__ . "</b>:  searCH RESULT NULL <i>(" . basename(__FILE__) . ")</i></p>";
                                    
                                    $message = "<h5 class='text-warning'>Sorry!, Searched recipe could not found</h5>";
                                   
        
                                } else {
                                    
                                    
        // if(DEBUG)		echo "<p class='debug hint'>Line <b>" . __LINE__ . "</b>:  searCH RESULT is  <i>(" . basename(__FILE__) . ")</i></p>";
        
                                    $message = "<h5 class='text-success'> your searched result..</h5>";
                                    
                                    $searchRecipe = true;
                                    $allRecipiesObject = false;
        
                                }
            
        
        }
        
        
        #******************************************************************************#
        
        
                








?>