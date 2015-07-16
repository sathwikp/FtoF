<?php
require_once 'init.php.inc';

if(isset($_POST['btn-login']))
{
	$umail = $_POST['txt_uname_email'];
	$upass = $_POST['txt_password'];
		
	if($user->login($umail,$upass))
	{
		$user->redirect('index.php');
	}
	else
	{
		$error = localization("Wrong credentials!", "Identification incorrecte !");
	}	
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Login : cleartuts</title>
<link rel="stylesheet" href="bootstrap/css/bootstrap.min.css" type="text/css"  />
<link rel="stylesheet" href="style.css" type="text/css"  />
</head>
<body>
<div class="container">
    	<div class="form-container">
        <form method="post">
            <h2><?php echo localization("Sign in", "Connection"); ?>.</h2><hr />
            <?php
			if(isset($error))
			{
					 ?>
                     <div class="alert alert-danger">
                        <i class="glyphicon glyphicon-warning-sign"></i> &nbsp; <?php echo $error; ?> !
                     </div>
                     <?php
			}
			?>
            <div class="form-group">
            	<input type="text" class="form-control" name="txt_uname_email" placeholder="<?php echo localization("E-mail address", "Adresse mail"); ?>" required />
            </div>
            <div class="form-group">
            	<input type="password" class="form-control" name="txt_password" placeholder="<?php echo localization("Your Password", "Mot de passe"); ?>" required />
            </div>
            <div class="clearfix"></div><hr />
            <div class="form-group">
            	<button type="submit" name="btn-login" class="btn btn-block btn-primary">
                	<i class="glyphicon glyphicon-log-in"></i>&nbsp;<?php echo localization("SIGN IN", "CONNECTION"); ?>
                </button>
            </div>
            <br />
            <label><?php echo localization("Don't have account yet !", "Pas encore de compte !"); ?> <a href="sign-up.php"><?php echo localization("Sign Up", "Inscription"); ?></a></label>
        </form>
       </div>
</div>

</body>
</html>

<?php require_once 'destroy.php.inc'; ?>