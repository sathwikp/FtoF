<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
    <title><?php echo $PAGETITLE; ?></title>
    <!-- favicon -->
    <link rel="icon" type="image/png" href="img/F2F_short.png">
    <link rel="stylesheet" type="text/css" href="//fonts.googleapis.com/css?family=Open+Sans" />
    <link href='http://fonts.googleapis.com/css?family=Pacifico' rel='stylesheet' type='text/css'>
    <link href='http://fonts.googleapis.com/css?family=Indie+Flower' rel='stylesheet' type='text/css'>
    <!-- core bootstrap style guide -->
    <link rel="stylesheet" href="css/bootstrap.css" />
    <!-- animation style guide -->
    <link rel="stylesheet" href="css/animate.css" />
    <!-- Load jQuery UI CSS  -->
    <link rel="stylesheet" href="css/base/jquery-ui.min.css" />
    <link rel="stylesheet" href="css/jquery.typeahead.min.css" />
    <!-- custom style guide -->
    <link rel="stylesheet" href="css/main.css" /> 
	<link href="css/login-register.css" rel="stylesheet" />
    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
		<script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
		<script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
	<![endif]-->
    <script src="js/jquery-2.1.4.min.js"></script>
	<script src="js/jquery-ui.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/login-register.js" type="text/javascript"></script>

	<?php
		if (isset($SCRIPTSRC)) {
			foreach ($SCRIPTSRC as $src) {
				echo "<script src=\"".$src."\"></script>\n" ;
			}
		}
		if (isset($SCRIPTS)) {
			foreach ($SCRIPTS as $script) {
				if (is_array(list($attrs,$the_script) = $script))
					echo "<script ".implode(' ', array_map(function ($v, $k) { return $k . '="' . $v . '"'; }, $attrs, array_keys($attrs))).">\n". $the_script . "\n</script>\n" ;
				else
					echo "<script type=\"text/javascript\">\n". $script . "\n</script>\n" ;
			}
		}
		
	?>

<script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

  ga('create', 'UA-65203146-1', 'auto');
  ga('send', 'pageview');

</script>
  </head>

