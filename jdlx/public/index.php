<!DOCTYPE html>
<html>
<!-- MEMO: update me with `git checkout gh-pages && git merge master && git push origin gh-pages` -->
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">


    <title>Bootstrap Material</title>

    <!-- Material Design fonts -->
    <link rel="stylesheet" href="http://fonts.googleapis.com/css?family=Roboto:300,400,500,700" type="text/css">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">

    <!-- Bootstrap -->
    <link href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" rel="stylesheet">

    <!-- Bootstrap Material Design -->
    <link href="vendor/bootstrap-material-design-master/dist/css/bootstrap-material-design.css" rel="stylesheet">
    <link href="vendor/bootstrap-material-design-master/dist/css/ripples.min.css" rel="stylesheet">


    <link href="//fezvrasta.github.io/snackbarjs/dist/snackbar.min.css" rel="stylesheet">
    <meta name="viewport" content="width=device-width, initial-scale=1">



    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">

    <link rel="stylesheet" href="asset/style.css">

</head>
<body>



<div class="">

    <!-- Navbar
  ================================================== -->
    <div>
        <div class="row">
            <div class="col-md-12">
                <?php include(__DIR__.'/partial/navbar.php'); ?>
            </div>
        </div>


        <div class="row">
            <div class="col-md-12" style="text-align:center">
                <h1 id="buttons">My Best Team</h1>
            </div>
        </div>




        <div class="container">
            <div class="row" style="padding:12px">
                    <a style="width:100%" href="http://www.mybestteam.dev/jdlx/view/inscription.php" class="btn btn-raised btn-primary">S'inscrire avec Gmail</a>
            </div>
        </div>





    <!-- Forms
  ================================================== -->
    <div class="">


        <div class="row">
            <div class="col-md-6">
                <div class="bs-component" style="padding: 20px">
                    <form class="form-horizontal"method="post" action="">
                        <fieldset>




                            <div class="form-group label-floating">
                                <label class="control-label" for="focusedInput2">Prénom</label>
                                <input class="form-control" id="focusedInput2" type="text">
                                <p class="help-block">You should really write something here</p>
                            </div>


                            <div class="form-group label-floating">
                                <label class="control-label" for="focusedInput2">Nom</label>
                                <input class="form-control" id="focusedInput2" type="text">
                                <p class="help-block">You should really write something here</p>
                            </div>

                            <div class="form-group label-floating">
                                <label class="control-label" for="focusedInput2">Email</label>
                                <input class="form-control" id="focusedInput2" type="text">
                                <p class="help-block">You should really write something here</p>
                            </div>



                            <div class="form-group">
                                <div class="col-md-12" style="text-align:center">
                                    <button type="submit" class="btn btn-raised btn-primary">Inscription</button>
                                </div>
                            </div>
                        </fieldset>
                    </form>
                </div>
            </div>

        </div>
    </div>

</div>


<script src="//code.jquery.com/jquery-1.10.2.min.js"></script>
<script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
<script>
    (function () {



    })();

</script>
<script src="vendor/bootstrap-material-design-master/dist/js/ripples.min.js"></script>
<script src="vendor/bootstrap-material-design-master/dist/js/material.min.js"></script>
<script src="//fezvrasta.github.io/snackbarjs/dist/snackbar.min.js"></script>


<script src="//cdnjs.cloudflare.com/ajax/libs/noUiSlider/6.2.0/jquery.nouislider.min.js"></script>
<script>
    $(function () {
        $.material.init();
        $(".shor").noUiSlider({
            start: 40,
            connect: "lower",
            range: {
                min: 0,
                max: 100
            }
        });

        $(".svert").noUiSlider({
            orientation: "vertical",
            start: 40,
            connect: "lower",
            range: {
                min: 0,
                max: 100
            }
        });
    });
</script>
</body>
</html>
