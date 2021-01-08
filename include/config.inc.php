<?php
#**********************************************************************************#


				#******************************************#
				#********** GLOBAL CONFIGURATION **********#
				#******************************************#
				
				/*
					Konstanten werden in PHP mittels der Funktion define() definiert.
					Konstanten besitzen im Gegensatz zu Variablen kein $-Präfix
					Üblicherweise werden Konstanten komplett GROSS geschrieben.
				*/
				
				
				#********** DATABASE CONFIGURATION **********#
				define("DB_SYSTEM",						"mysql");
				define("DB_HOST",							"localhost");
				define("DB_NAME",							"recpieapp");
				define("DB_USER",							"root");
				define("DB_PWD",							"");
				
				
				#********** FORMULAR CONFIGURATION **********#
				define("MIN_INPUT_LENGTH",				2);
				define("MAX_INPUT_LENGTH",				256);
				
				
				#********** IMAGE UPLOAD CONFIGURATION **********#
				define("IMAGE_MAX_WIDTH",				800);
				define("IMAGE_MAX_HEIGHT",				800);
				define("IMAGE_MAX_SIZE",				256*1024);
				define("IMAGE_ALLOWED_MIMETYPES",	array("image/jpg", "image/jpeg", "image/gif", "image/png"));
				
				
				#********** STANDARD PATHS CONFIGURATION **********#
				define("IMAGE_UPLOAD_PATH",			"uploadedImage/");
				define("AVATAR_DUMMY_PATH",			"../../css/images/avatar_dummy.png");
				define("MEDIA_DOWNLOADS_PATH",		"downloads/media/");
				define("CLASS_PATH",						"Class/");
				define("TRAIT_PATH",						"../../traits/");
				
				
				#********** DEBUGGING **********#
				define("DEBUG",							true);	// Debugging for main php document
				define("DEBUG_F",							true);	// Debugging for functions
				define("DEBUG_DB",						true);	// Debugging for db-functions
				define("DEBUG_C",							true);	// Debugging for classes
				define("DEBUG_CC",						true);	// Debugging for class constructors
				define("DEBUG_T",							true);	// Debugging for traits


#**********************************************************************************#
?>