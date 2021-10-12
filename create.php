
<?php
    // enregistrer les donnes dans la base de donnee
    require  'database.php';

    if ( !empty($_POST)){
        // les erreurs de validation
        $nomError = null;
        $statusError = null;

        // les valeurs du champ du formulaire
        $nom = $_POST['nom'];
        $status = $_POST['status'];
        

        // validation des champs
        // validation du champs name
       
        $valid = true;
        $pd = Database::connect();
         $nom1= $pd->prepare("select * from taches where nom=?");
        $nom1->execute(array($nom));
        $nomExist=$nom1->rowCount();
        if (empty($nom)){
            $nomError = 'SVP Entrez le non de la tache';
            $valid = false;
        }elseif ($nomExist == 1) {
            $nomError = 'cette tache est deja dans la base';
            $valid = false;
        }

        //validation du champ email vide et respct de la symptaxe email
        if (empty($status)){
            $emailError = 'SVP Entrez le status de la tache';
            $valid = false;
        }

        // validation du champs mobile
       

        // enserssion des valeurs dans la base de donnée
        if ($valid){
            // connexion bd
            $pdo = Database::connect();
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $sql = "INSERT INTO taches (nom, status) values(?, ?)";
            $q = $pdo->prepare($sql);
            $q->execute(array($nom, $status));
            Database::disconnect();
            header("Location: index.php");
        }
    }

?>

<!doctype html>
<html lang="en">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <title>Create Data!</title>
     <style type="text/css">
        span{
            color: red;
        }
    </style>
</head>
<body>
<!--<h1>Hello, world!</h1>-->
<!--<button type="button" class="btn btn-primary">Primary</button>-->
<br><br>
<div class="container">
    <div class="row">
        <h1>Ajouter Tache</h1>
    </div>
    <br>
    <form class="form-horizontal" action="create.php" method="post">

        <div class="form-group <?php echo !empty($nomError)?'error':'';?>">
            <label class="control-label">Nom Tache</label>
            <div class="form-group">
                <input class="form-control" name="nom" type="text"  placeholder="Nom Tache" value="<?php echo !empty($nom)?$nom:'';?>" style="width: 500px">
                <?php if (!empty($nomError)): ?>
                    <span class="help-inline"><?php echo $nomError;?></span>
                <?php endif; ?>
            </div>
        </div>

        <div class="form-group <?php echo !empty($statusError)?'error':'';?>">
            <label class="control-label">Status</label>
            <div class="form-group">
                <select class="form-control" name="status" value="<?php echo !empty($status)?$status:'';?>" style="width: 500px">
                            <option value="En cours">En cours </option>
                            <option value="Terminer">Terminer</option>
                            <option value="En attente">En attente</option>
                        </select>
                <?php if (!empty($statusError)): ?>
                    <span class="help-inline"><?php echo $statusError;?></span>
                <?php endif; ?>
            </div>
        </div>


        <div class="form-actions">
            <button type="submit" class="btn btn-success">Create</button>
            <a class="btn btn-dark" href="index.php">Back</a>
        </div>
    </form>
</div> <!-- /container -->

<!-- Optional JavaScript -->
<!-- jQuery first, then Popper.js, then Bootstrap JS -->
<script src="js/jquery-3.3.1.slim.min.js" ></script>
<script src="js/popper.min.js"></script>
<script src="js/bootstrap.min.js"></script>
</body>
</html>