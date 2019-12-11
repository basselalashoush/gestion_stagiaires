<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Gestions Stagiaires</title>
        <link rel="icon" sizes="57x57" type="image/png" href="./assets/img/apple-icon-57x57.png">
        <link rel="stylesheet" href="./assets/css/bootstrap.min.css" />
        <link rel="stylesheet" href="assets/css/fontawesome-all.min.css" >
        <link rel="stylesheet" href="./assets/css/bootstrap-table.min.css" />
        <link rel="stylesheet" href="./assets/css/style.css" />
    </head>
    <body>
        <div class="container">
            <div class="row" id="header">
                <?php include("view/header.php");
                ?>
            </div>
            <div class="row" id="content-wrap">
                <div class="col-md-2" id="sidebar">
                    <?php include("view/menu.php"); ?>
                </div>
                <div class="col-md-10">
                    <?php
                    if (!isset($_REQUEST['uc']))
                        $uc = 'accueil';
                    else
                        $uc = $_REQUEST['uc'];
                    switch ($uc) {
                        case 'accueil' :
                            include("view/accueil.php");
                            break;
                        case 'formation' :
                            include 'controller/formationController.php';
                            break;
                        case 'stagiaire' :
                            include 'controller/StagiaireController.php';
                            break;
                        case 'formateur' :
                            include 'controller/formateurController.php';
                            break;
                    }
                    ?>
                </div>
            </div>
        </div>
        <div class="row" id="footer">
            <?php include("view/footer.php"); ?>
        </div>
    </body>
</html>

