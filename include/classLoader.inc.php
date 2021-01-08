<?php
#**********************************************************************************#


				function autoloadClasses( $name ) {
if(DEBUG_F)		echo "<p class='debugClassloader'><b>Line " . __LINE__ .  "</b>: Aufruf " . __FUNCTION__ . "('$name') <i>(" . basename(__FILE__) . ")</i></p>\r\n";	
					
					if( $name === "autoConstruct" ) {
						// Pfad zum Trait generieren
						// "traits/autoConstruct.trait.php"
						$filePath = TRAIT_PATH . "$name.trait.php";
						$trait = true;
						
					} else {
						// Kompletten Pfad zur Klassendatei generieren
						// "Class/Product.class.php"
						$filePath = CLASS_PATH . "$name.class.php";
					}
					
					
					// Prüfen, ob eine Klassendatei unter dem generierten Dateipfad existiert
					if( !file_exists($filePath) ) {
						// Fehlerfall
if(DEBUG_F)			echo "<p class='debugClassloader err'><b>Line " . __LINE__ . "</b>: FEHLER: Datei unter <i>'$filePath'</i> wurde nicht gefunden! <i>(" . basename(__FILE__) . ")</i></p>\r\n";				
						
					} else {
						// Erfolgsfall
						
						if( isset($trait) ) {
							// Trait
if(DEBUG_F)				echo "<p class='debugClassloader ok'><b>Line " . __LINE__ . "</b>: Trait <i>'$name'</i> wird eingebunden... <i>(" . basename(__FILE__) . ")</i></p>\r\n";				
							
						} else {
							// Class
if(DEBUG_F)				echo "<p class='debugClassloader ok'><b>Line " . __LINE__ . "</b>: Klasse <i>'$name'</i> wird eingebunden... <i>(" . basename(__FILE__) . ")</i></p>\r\n";											
						}
						
						// Klassendatei einbinden
						require_once($filePath);
					}
				}


#**********************************************************************************#
?>