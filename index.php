

<?php



        require_once('include/classLoader.inc.php');
        require_once('include/config.inc.php');
        require_once('include/dateTimeBig.inc.php');
        require_once('include/db.inc.php');
        require_once('include/form.inc.php');



?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>recipeApp</title>

    <!-- bootstrap css (bootswatch)-->
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <!-- debug css)-->
    <link rel="stylesheet" href="css/debug.css">
    
    <!-- bootstrap css (bootswatch)-->
    <link rel="stylesheet" href="css/own.css">
</head>
<body>

<header>
            <!-- Image and text -->
                <nav class="navbar navbar-dark bg-primary">
                <div class="container-fluid">
                    <a class="navbar-brand" href="#">
                    <img src="css/logo/logo.png" alt="" width="50" height="34" class="d-inline-block align-top">
                    recipeApp
                    </a> 
                    <span class="text-end"> 
                        <form class="form-inline my-2 my-lg-0">
                        <input class="form-control mr-sm-2" type="text" placeholder="Search">
                        <input class="btn btn-secondary my-2 my-sm-0" type="submit" value="Search">
                        </form>
                    </span>
                </div>
                </nav>
</header>

<main class="own">


<hr><br>
<a href="#" class="btn btn-outline-info m-2">Create new recipe</a>
<a href="#" class="btn btn-outline-success m-2 text-end">sort A-z</a>

<hr>

                <div class="card m-4" style="max-width: 620px;">
                <div class="row g-0">
                    <div class="col-md-4">
                    <img class="own-img" src="..." alt="...">
                    </div>
                    <div class="col-md-8">
                    <div class="card-body">
                        <h5 class="card-title">Recipe title</h5>
                        <p class="card-text">Lorem ipsum dolor sit amet consectetur adipisicing elit. Eius, sapiente dolores nostrum labore explicabo modi laudantium tenetur necessitatibus hic fugit?</p>
                        <p class="card-text"><small class="text-muted">created on </small></p>
                    </div>
                    </div>
                </div>
                </div>

</main>
    
</body>
</html>