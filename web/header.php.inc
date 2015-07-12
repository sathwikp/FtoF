<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
    <title>Bootstrap | Welcome</title>
    <link rel="stylesheet" href="css/bootstrap.css" />
    <script src="js/jquery-2.1.4.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
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
  </head>
  <body>


