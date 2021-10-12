<?php
    // inclure la bd
    require "database.php";
    $id = null;
    if( !empty($_GET['id'])){
        $id = $_REQUEST['id'];
    }

    if( null==$id){
        header("Location: index.php");
    }

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
        
        if (empty($nom)){
            $nomError = 'SVP Entrez le non de la tache';
            $valid = false;
        }

        //validation du champ email vide et respct de la symptaxe email
        if (empty($status)){
            $emailError = 'SVP Entrez le status de la tache';
            $valid = false;
        }
        // update data
        if ($valid) {
            $pdo = Database::connect();
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $sql = "UPDATE taches set nom = ?, status = ? WHERE id = ?";
            $q = $pdo->prepare($sql);
            $q->execute(array($nom,$status,$id));
            Database::disconnect();
            header("Location: index.php");
        }
    }
    else {
        $pdo = Database::connect();
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $sql = "SELECT * FROM taches where id = ?";
        $q = $pdo->prepare($sql);
        $q->execute(array($id));
        $data = $q->fetch(PDO::FETCH_ASSOC);
        $nom = $data['nom'];
        $status = $data['status'];
       
        Database::disconnect();
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
        <h1>Modifier Tache</h1>
    </div>
    <br>
     <form class="form-horizontal" action="update.php?id=<?php echo $id?>" method="post">
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
            <button type="submit" class="btn btn-success">Modifier</button>
            <a class="btn btn-dark" href="index.php">Retour</a>
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