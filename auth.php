<?php

    // Working directory of first executing file
    $cwd = dirname(__FILE__);

    // to be needed later | require_once $cwd."/assets/php/session.php";

    if(isset($_GET["confirm"])) {
        $confirm = $_GET["confirm"];
    } else {
        $confirm = "login";
    }

?>

<!DOCTYPE html>
<html lang="en">

    <head>

        <title>v0ltureDB</title>
        <meta charset="UTF-8">

        <!-- Bootstrap Rscs -->
        <link href="assets/bootstrap/bootstrap.min.css" rel="stylesheet">
        <script src="assets/bootstrap/jquery-2.2.4.min.js"></script>
        <script src="assets/bootstrap/bootstrap.min.js"></script>

    </head>

    <body class="container">

        <div class="row">

            <div class="col-md-6 col-md-offset-3" style="padding-top: 40px;">

                <?php if($confirm == "login"): ?>
                    <div class="panel panel-primary">

                        <div class="panel-heading">
                            <h3 class="panel-title">Login to a database</h3>
                        </div>

                        <div class="panel-body">

                            <form class="form-horizontal">

                                <fieldset>

                                    <div class="form-group">

                                        <label for="auth_username" class="col-lg-2 control-label">Username</label>
                                        
                                        <div class="col-lg-10">
                                            <input type="text" class="form-control" name="auth_username" id="auth_username" placeholder="" required>
                                        </div>

                                    </div>

                                    <div class="form-group">

                                        <label for="auth_password" class="col-lg-2 control-label">Password</label>
                                        
                                        <div class="col-lg-10">
                                            <input type="password" class="form-control" name="auth_password" id="auth_password" placeholder="" required>
                                        </div>

                                    </div>

                                    <div class="form-group">

                                        <label for="auth_host" class="col-lg-2 control-label">Host</label>
                                        
                                        <div class="col-lg-10">
                                            <input type="text" class="form-control" name="auth_host" id="auth_host" placeholder="localhost" required>
                                        </div>

                                    </div>

                                    <div class="form-group">
                                        
                                        <div class="col-lg-10 col-lg-offset-2">
                                        
                                            <button type="submit" class="btn btn-primary">Log In</button>
                                        
                                        </div>
                                    
                                    </div>

                                </fieldset>

                            </form>

                        </div>

                    </div>
                <?php endif; ?>

            </div>

        </div>

    </body>
</html>