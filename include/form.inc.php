<?php
#**********************************************************************************#

				
				/**
				*
				*	Entschärft und säubert einen String, falls er einen Wert besitzt
				*	Falls der String keinen Wert besitzt (NULL, "", 0, false) wird er 
				*	1:1 zurückgegeben
				*
				*	@param String $value - Der zu entschärfende und zu bereinigende String
				*
				*	@return String 				- Originalwert oder der entschärfte und bereinigte String
				*
				*/
				function cleanString($value) {
if(DEBUG_F)		echo "<p class='debugCleanString'><b>Line " . __LINE__ . "</b>: Aufruf " . __FUNCTION__ . "('$value') <i>(" . basename(__FILE__) . ")</i></p>\r\n";	
					
					// htmlspecialchars() entschärft HTML-Steuerzeichen wie < > & ""
					// und ersetzt sie durch &lt;, &gt;, &amp;, &quot;
					// ENT_QUOTES | ENT_HTML5 ersetzt zusätzlich '' durch &apos;
					$value = htmlspecialchars( $value, ENT_QUOTES | ENT_HTML5 );
										
					// trim() entfernt am Anfang und am Ende eines Strings alle 
					// sog. Whitespaces (Leerzeichen, Tabulatoren, Zeilenumbrüche)
					$value = trim( $value );
					
					// Um später in der DB keine NULL-Werte mit Leerstrings zu überschreiben, 
					// werden hier Leerstrings zentral in echte NULL-Werte umgewandelt
					if( $value === "" ) {
						$value = NULL;
					}
					
					return $value;
				}


#**********************************************************************************#

				
				/**
				*
				*	Prüft einen String auf Leerstring, Mindest- und Maxmimallänge
				*
				*	@param String $value 									- Der zu prüfende String
				*	@param [Integer $minLength=MIN_INPUT_LENGTH] 	- Die erforderliche Mindestlänge
				*	@param [Integer $maxLength=MAX_INPUT_LENGTH] 	- Die erlaubte Maximallänge
				*
				*	@return String/NULL - Ein String bei Fehler, ansonsten NULL
				*	
				*/
				function checkInputString($value, $minLength=MIN_INPUT_LENGTH, $maxLength=MAX_INPUT_LENGTH) {
if(DEBUG_F)		echo "<p class='debugCheckInputString'><b>Line " . __LINE__ . "</b>: Aufruf " . __FUNCTION__ . "('$value [$minLength | $maxLength]') <i>(" . basename(__FILE__) . ")</i></p>\r\n";					
					
					$errorMessage = NULL;
					
					// Prüfen auf leeres Feld/Prüfen auf Leerstring
					if( !$value ) {
						// Fehlermeldung generieren
						$errorMessage = "Dies ist ein Pflichtfeld!";
						
					// Prüfen auf Mindestlänge	
					} elseif( mb_strlen($value) < $minLength ) {	
						// Fehlermeldung generieren
						$errorMessage = "Muss mindestens $minLength Zeichen lang sein!";
						
					// Prüfen auf Maximallänge	
					} elseif( mb_strlen($value) > $maxLength ) {
						// Fehlermeldung generieren
						$errorMessage = "Darf maximal $maxLength Zeichen lang sein!";
					}	
					
					// Fehlermeldung zurückgeben
					return $errorMessage;
					
				}


#**********************************************************************************#

				
				/**
				*
				*	Prüft eine Email-Adresse auf Leerstring und Validität
				*
				*	@param String $value - Die zu prüfende Email-Adresse
				*
				*	@return String/NULL - Ein String bei Fehler, ansonsten NULL
				*
				*/
				function checkEmail($value) {
if(DEBUG_F)		echo "<p class='debugCheckEmail'><b>Line " . __LINE__ . "</b>: Aufruf " . __FUNCTION__ . "('$value') <i>(" . basename(__FILE__) . ")</i></p>\r\n";					
					
					$errorMessage = NULL;
					
					// Prüfen auf leeres Feld/Prüfen auf Leerstring
					if( !$value ) {
						// Fehlermeldung generieren
						$errorMessage = "Dies ist ein Pflichtfeld!";
						
					// Email auf Validität prüfen	
					} elseif( !filter_var($value, FILTER_VALIDATE_EMAIL) ) {
						// Fehlermeldung generieren
						$errorMessage = "Dies ist keine gültige Email-Adresse!";
					}										
					
					// Fehlermeldung zurückgeben
					return $errorMessage;

				}


#**********************************************************************************#


				/**
				*
				*	Prüft ein hochgeladenes Bild auf MIME-Type, Datei- und Bildgröße
				*	Bereinigt den Dateinamen von Leerzeichen und Umlauten und wandelt ihn in Kleinbuchstaben um
				*	Speichert das erfolgreich geprüfte Bild unter dem bereinigten Dateinamen mit einem zufällig generierten Präfix
				*
				*	@param Array $uploadedImage											- Das in $_FILES enthaltene Array mit den Informationen zum hochgeladenen Bild
				*	@param [Int $maxWidth 				= IMAGE_MAX_WIDTH]			- Die maximal erlaubte Bildbreite in PX
				*	@param [Int $maxHeight 				= IMAGE_MAX_HEIGHT]			- Die maximal erlaubte Bildhöhe in PX
				*	@param [Int $maxSize 				= IMAGE_MAX_SIZE]				- Die maximal erlaubte Dateigröße in Bytes
				*	@param [Array $allowedMimeTypes 	= IMAGE_ALLOWED_MIMETYPES]	- Whitelist der erlaubten MIME-Types
				*	@param [String $uploadPath 		= IMAGE_UPLOAD_PATH]			- Das Speicherverzeichnis auf dem Server
				*
				*	@return Array { "imageError" => String/NULL 						- Fehlermeldung im Fehlerfall, 
				*						 "imagePath"  => String/NULL						- Der Speicherpfad auf dem Server im Erfolgsfall }
				*
				*/
				function imageUpload( 	$uploadedImage,
												$maxWidth				= IMAGE_MAX_WIDTH,
												$maxHeight				= IMAGE_MAX_HEIGHT,
												$maxSize					= IMAGE_MAX_SIZE,
												$allowedMimeTypes		= IMAGE_ALLOWED_MIMETYPES,
												$uploadPath				= IMAGE_UPLOAD_PATH
											) {
if(DEBUG_F)		echo "<p class='debugImageUpload'><b>Line " . __LINE__ . "</b>: Aufruf " . __FUNCTION__ . "() <i>(" . basename(__FILE__) . ")</i></p>\r\n";	
/*					
if(DEBUG_F)		echo "<pre class='debugImageUpload'><b>Line " . __LINE__ . "</b>: \r\n";					
if(DEBUG_F)		print_r($uploadedImage);					
if(DEBUG_F)		echo "</pre>\r\n";
*/
					/*
						Das Array $_FILES['avatar'] bzw. $uploadedImage enthält:
						Den Dateinamen [name]
						Den generierten (also ungeprüften) MIME-Type [type]
						Den temporären Pfad auf dem Server [tmp_name]
						Die Dateigröße in Bytes [size]
					*/
					
					
					#********** BILDINFORMATIONEN SAMMELN **********#
					
					// Dateiname
					$fileName = cleanString($uploadedImage['name']);
					// $fileName = "mein blöder Avatar's 03.png";
					// ggf. vorhandene Leerzeichen durch _ ersetzen
					$fileName = str_replace(" ", "_", $fileName);
					// Dateinamen in Kleinbuchstaben umwandeln
					$fileName = mb_strtolower($fileName);
					// Umlaute ersetzen
					$fileName = str_replace( array("ä","ö","ü","ß"), array("ae","oe","ue","ss"), $fileName );
					// Alle Sonderzeichen außer - _ und . löschen mittels Regular Expresssion
					// Alle Zeichen, die nicht a-z, 0-9 oder - sind, durch Leerstring ersetzen
					// Das ^ innerhalb von [] bedeutet eine Negierung des Musters entsprechend dem ! in PHP
					$fileName = preg_replace('/[^a-z0-9\-\_\.]/', "", $fileName);
					
					// zufälligen Dateinamen generieren
					$randomPrefix = rand(1,999999) . str_shuffle("abcdefghijklmnopqrstuvwxyz") . time();
					$fileTarget = $uploadPath . $randomPrefix . "_" . $fileName;
					
					// Dateigröße
					$fileSize = $uploadedImage['size'];
					
					// Temporärer Pfad auf dem Server
					$fileTemp = $uploadedImage['tmp_name'];
					
if(DEBUG_F)		echo "<p class='debugImageUpload'><b>Line " . __LINE__ . "</b>: \$fileName: $fileName <i>(" . basename(__FILE__) . ")</i></p>\r\n";
if(DEBUG_F)		echo "<p class='debugImageUpload'><b>Line " . __LINE__ . "</b>: \$fileSize: ". round($fileSize/1024, 2) . "kB <i>(" . basename(__FILE__) . ")</i></p>\r\n";
if(DEBUG_F)		echo "<p class='debugImageUpload'><b>Line " . __LINE__ . "</b>: \$fileTemp: $fileTemp <i>(" . basename(__FILE__) . ")</i></p>\r\n";
if(DEBUG_F)		echo "<p class='debugImageUpload'><b>Line " . __LINE__ . "</b>: \$fileTarget: $fileTarget <i>(" . basename(__FILE__) . ")</i></p>\r\n";
					
					// genauere Informationen zum Bild holen
					$imageData = @getimagesize($fileTemp);
/*
if(DEBUG_F)		echo "<pre class='debugImageUpload'><b>Line " . __LINE__ . "</b>: \r\n";					
if(DEBUG_F)		print_r($imageData);					
if(DEBUG_F)		echo "</pre>\r\n";					
*/					
					/*
						Die Funktion getimagesize() liefert bei gültigen Bildern ein Array zurück:
						Die Bildbreite in PX [0]
						Die Bildhöhe in PX [1]
						Einen für die HTML-Ausgabe vorbereiteten String für das IMG-Tag
						(width="480" height="532") [3]
						Die Anzahl der Bits pro Kanal ['bits']
						Die Anzahl der Farbkanäle (somit auch das Farbmodell: RGB=3, CMYK=4) ['channels']
						Den echten(!) MIME-Type ['mime']
					*/
					
					$imageWidth 	= $imageData[0];
					$imageHeight 	= $imageData[1];
					$imageMimeType = $imageData['mime'];
if(DEBUG_F)		echo "<p class='debugImageUpload'><b>Line " . __LINE__ . "</b>: \$imageWidth: $imageWidth px <i>(" . basename(__FILE__) . ")</i></p>\r\n";
if(DEBUG_F)		echo "<p class='debugImageUpload'><b>Line " . __LINE__ . "</b>: \$imageHeight: $imageHeight px <i>(" . basename(__FILE__) . ")</i></p>\r\n";
if(DEBUG_F)		echo "<p class='debugImageUpload'><b>Line " . __LINE__ . "</b>: \$imageMimeType: $imageMimeType <i>(" . basename(__FILE__) . ")</i></p>\r\n";
					
					
					#********** BILD PRÜFEN **********#
					
					// MIME-Type prüfen
					// Whitelist mit erlaubten Bildtypen
					// $allowedMimeTypes = array("image/jpg", "image/jpeg", "image/gif", "image/png");
					
					if( !in_array($imageMimeType, $allowedMimeTypes) ) {
						$errorMessage = "the image formate not allowed!";
						
					// Maximal erlaubte Bildhöhe	
					} elseif( $imageHeight > $maxHeight ) {
						$errorMessage = "max height $maxHeight Pixels";
						
					// Maximal erlaubte Bildbreite	
					} elseif( $imageWidth > $maxWidth ) {
						$errorMessage = "the maximum width $maxWidth Pixels";
						
					// Maximal erlaubte Dateigröße	
					} elseif( $fileSize > $maxSize ) {
						$errorMessage = "die maximum image file size " . round($maxSize/1024, 2) . "kB";
						
					// Wenn es keinen Fehler gab	
					} else {
						$errorMessage = NULL;
					}
					
					
					#********** ABSCHLIESSENDE BILDPRÜFUNG **********#
					if( $errorMessage ) {
						// Fehlerfall
if(DEBUG_F)			echo "<p class='debugImageUpload err'><b>Line " . __LINE__ . "</b>: $errorMessage <i>(" . basename(__FILE__) . ")</i></p>\r\n";
						// Im Fehlerfall den Zielpfad löschen
						$fileTarget	= NULL;
						
					} else {
						// Erfolgsfall
if(DEBUG_F)			echo "<p class='debugImageUpload ok'><b>Line " . __LINE__ . "</b>: Die Bildprüfung ergab keine Fehler. <i>(" . basename(__FILE__) . ")</i></p>\r\n";
						
						
						#********** BILD SPEICHERN **********#
						if( !@move_uploaded_file($fileTemp, $fileTarget) ) {
							// Fehlerfall
if(DEBUG_F)				echo "<p class='debugImageUpload err'><b>Line " . __LINE__ . "</b>: Fehler beim Speichern des Bildes auf dem Server! <i>(" . basename(__FILE__) . ")</i></p>\r\n";
							$errorMessage 	= "Fehler beim Speichern des Bildes! Bitte versuchen Sie es später noch einmal.";
							
						} else {
							// Erfolgsfall
if(DEBUG_F)				echo "<p class='debugImageUpload ok'><b>Line " . __LINE__ . "</b>: Bild wurde erfolgreich auf dem Server gespeichert. <i>(" . basename(__FILE__) . ")</i></p>\r\n";
							
						} // BILD SPEICHERN ENDE
						
					} // ABSCHLIESSENDE BILDPRÜFUNG ENDE
					
					
					#********** GGF. FEHLERMELDUNG UND BILDPFAD ZURÜCKGEBEN **********#
					return array("imageError"=>$errorMessage, "imagePath"=>$fileTarget);					
					
				}


#**********************************************************************************#
?>


















