<?php 


                #***********************************#
				#********** CLASS Recipe **********#
				#***********************************#



        
        class Recipe {

            #***********attributes********#
            #*****************************#

            private $rec_id;
            private $rec_title;
            private $rec_content;
            private $rec_description;
            private $rec_imagePath;
            private $rec_date;

    #**************************************************************************#
            #**********************************#
            #**********Construction************#


            public function __construct( $rec_id=NULL, $rec_title=NULL,
                                         $rec_content=NULL, $rec_description=NULL,
                                         $rec_imagePath=NULL, $rec_date=NULL ) {


                            if( $rec_title )    $this->setRec_title($rec_title);
                            if( $rec_content )    $this->setRec_content($rec_content);
                            if( $rec_description )    $this->setRec_description($rec_description);
                            if( $rec_imagePath )    $this->setRec_imagePath($rec_imagePath);
                            if( $rec_date )    $this->setRec_date($rec_date);
                            if( $rec_id )    $this->setRec_id($rec_id);






                                         }



    #**************************************************************************#
    
                    #*****************************#
                    #**** getter and setter *****#


            #**********rec_id********#
            public function getRec_id() {
				return $this->rec_id;
			}
			public function setRec_id($value) {
				$this->rec_id = cleanString($value);
			}
            #**********rec_title********#
            public function getRec_title() {
				return $this->rec_title;
			}
			public function setRec_title($value) {
				$this->rec_title = cleanString($value);
			}
            #**********rec_content********#
            public function getRec_content() {
				return $this->rec_content;
			}
			public function setRec_content($value) {
				$this->rec_content = cleanString($value);
			}
            #**********rec_descr********#
            public function getRec_description() {
				return $this->rec_description;
			}
			public function setRec_description($value) {
				$this->rec_description = cleanString($value);
			}
            #**********rec_imagepath********#
            public function getRec_imagePath() {
				return $this->rec_imagePath;
			}
			public function setRec_imagePath($value) {
				$this->rec_imagePath = cleanString($value);
            }

            public function getRec_date() {
				return $this->rec_date;
			}
			public function setRec_date($value) {
				$this->rec_date = cleanString($value);
            }
            
            


    
    #**************************************************************************#
                    
                    #*******************************#
                    #********Methods****************#
                    #*******************************#

            // insert re4cipie data to db


            public function saveToDb($pdo) {

//if(DEBUG_C)			echo "<h3 class='debugClass'><b>Line " . __LINE__ .  "</b>: Aufruf " . __METHOD__ . "() (<i>" . basename(__FILE__) . "</i>)</h3>\r\n";

                //STEP1- SQL Statement
                $sql = "INSERT INTO recipes (rec_title, rec_content, rec_description, rec_imagePath)
                        VALUES(?,?,?,?)";

                $params = [ $this->getRec_title(),
                            $this->getRec_content(),
                            $this->getRec_description(),
                            $this->getRec_imagePath() ];

                // step2 prepare statement

                $statement = $pdo->prepare($sql);

                $statement->execute($params);
//if(DEBUG_C)			if($statement->errorInfo()[2]) echo "<p class='debugClass err'>" . $statement->errorInfo()[2] . "</p>\r\n";
                
                //data forward
                $rowCount = $statement->rowCount();
//if(DEBUG)	echo "<p class='debug'><b>Line " . __LINE__ . "</b>: \$rowCount: $rowCount <i>(" . basename(__FILE__) . ")</i></p>\r\n";

                if( !$rowCount ) {
                    //fehler
                    return false;
                }else {
                    //erfolg
                    $newRecId = $pdo->lastInsertId();
                    $this->setRec_id($newRecId);
                    return true;
                }


            


            }
    
    
    
            #***** fetch all data from db *********#

            public static function fetchAllRecipe($pdo) {
//if(DEBUG_C)			echo "<h3 class='debugClass'><b>Line " . __LINE__ .  "</b>: Aufruf " . __METHOD__ . "() (<i>" . basename(__FILE__) . "</i>)</h3>\r\n";

                $sql="SELECT * FROM recipes ORDER BY rec_date DESC";
                $params=NULL;

                $statement = $pdo->prepare($sql);
                
                $statement->execute($params);
//if(DEBUG_C)			if($statement->errorInfo()[2]) echo "<p class='debugClass err'><b>Line " . __LINE__ . "</b>: " . $statement->errorInfo()[2] . " <i>(" . basename(__FILE__) . ")</i></p>\r\n";														

                $recipeArray= NULL;

                while( $row = $statement->fetch(PDO::FETCH_ASSOC) ) {



                    $recipeArray[] = new Recipe($row['rec_id'],
                                                $row['rec_title'],
                                                $row['rec_content'],
                                                $row['rec_description'],
                                                $row['rec_imagePath'],
                                                $row['rec_date'] );
                
                
                
                
                                            }

                                //return array with all recipe objeckt 

                            
                                return $recipeArray;






            

        }



        // function for sorting

        public static function fetchSortedDb($pdo) {



                $sql = "SELECT * FROM recipes ORDER BY rec_title ASC";
                $params=NULL;

                $statement = $pdo->prepare($sql);
                
                $statement->execute($params);
//if(DEBUG_C)			if($statement->errorInfo()[2]) echo "<p class='debugClass err'><b>Line " . __LINE__ . "</b>: " . $statement->errorInfo()[2] . " <i>(" . basename(__FILE__) . ")</i></p>\r\n";														

                $recipeArray= NULL;

                while( $row = $statement->fetch(PDO::FETCH_ASSOC) ) {



                    $recipeArray[] = new Recipe($row['rec_id'],
                                                $row['rec_title'],
                                                $row['rec_content'],
                                                $row['rec_description'],
                                                $row['rec_imagePath'],
                                                $row['rec_date'] );
                
                
                
                
                                            }

                                //return array with all recipe objeckt 

                            
                                return $recipeArray;


                    }


    
    
    
#**************************************************************************#
} // object end







?>