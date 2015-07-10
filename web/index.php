<?php

$dbopts = parse_url(getenv('DATABASE_URL'));

$dsn = 'pgsql:'
    . 'host='.$dbopts["host"].';'
    . 'dbname='.ltrim($dbopts["path"],'/').';'
    . 'user='.$dbopts["user"].';'
    . 'port='.$dbopts["port"].';'
    . 'sslmode=require;'
    . 'password='.$dbopts["pass"];
try
{
	$db = new PDO($dsn);
}
catch(PDOException $pe)
{
	die('Connection error, because: ' .$pe->getMessage());
}

?>
<html lang="en">
  <head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
    <title>Bootstrap | Welcome</title>
    <link rel="stylesheet" href="css/bootstrap.css" />
    <script src="js/vendor/modernizr.js"></script>
  </head>
  <body>
  <div class="navbar navbar-inverse navbar-static-top">
  	<div class="container">
  		<a href="index.html" class="navbar-brand">BikeRock</a>
            <button class="navbar-toggle" data-toggle="collapse" data-target=".navHeaderCollapse">
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
 		<div class="collapse navbar-collapse navHeaderCollapse">
  			<ul class="nav navbar-nav navbar-left">
				<li class=active><a href="index.html">Home</a></li>
                <li><a href="index.html">About</a></li>
                <li><a href="index.html">Contact</a></li>
                <li><a href="index.html">Find us</a></li>
                <li class="dropdown"><a href="index.html" class="dropdown-toggle" data-toggle="dropdown">Social Media <b class="caret"></b></a>
                    <ul class="dropdown-menu">
                      <li><a href="#">First link in dropdown</a></li>
                      <li class="active"><a href="#">Active link in dropdown</a></li>
                    </ul>
        		</li>
           </ul>
      </div>
 	</div>
 </div>
<div class="container">
<div class="row">
	<div class="col-md-8">
   	 <div class="jumbotron">
     		<h2>
        	Welcome to bikerocks.com
       	   </h2>
           <p>
        RandomText is a tool designers and developers can use to quickly grab dummy text in either Lorem Ipsum or Gibberish format.

There are a number of features that make RandomText a little different from other Lorem Ipsum dummy text generators you may find around the web...</p>

			<div id="moreinformation" class="modal fade" role="dialog">
            	<div class="modal-dialog">
                	<div class="modal-content">
                    	<div class="modal-header">
                        	<h3>a Modal here</h3>             
                        </div>
                        <div class="modal-body">
                        	<p>RandomText is a tool designers and developers can use to quickly grab dummy text in either Lorem Ipsum or Gibberish format</p>
                        </div>
                        <div class="modal-footer">
                        	<a class="btn btn-primary" data-dismiss="modal">close</a>
                        </div>
                    </div>
                </div>
             
            </div>
			<a class="btn btn-info" href="#moreinformation" data-toggle="modal">Find out more!</a>
		</div>
     </div>
    <div class="col-xs-4">
    	<img src="D:\Userfiles\spadyana\Downloads\bicycle.png" class="img-responsive"/>       
            
    </div>
</div>
<hr/>
<div class="row">
	<div class="col-md-12">
    <h3 data-tooltip class="has-tip" title="This is a h3 element!">What the desciption is</h3>
     <p>RandomText is a tool designers and developers can use to quickly grab dummy text in either Lorem Ipsum or Gibberish format.

There are a number of features that make RandomText a little different from other Lorem Ipsum dummy text generators you may find around the web...</p>
    </div>
</div>
<hr/>
<div class="row">
	<div class="col-md-12">
    <h3>Our top bikes</h3>
    <div class="col-lg-3 col-sm-4 col-xs-6">
    	<img src="D:\Userfiles\spadyana\Downloads\bicycle.png" class="img-responsive"/>
    </div>
       <div class="col-lg-3 col-sm-4 col-xs-6"><img src="D:\Userfiles\spadyana\Downloads\bicycle.png" class="img-responsive"/></div>
         <div class="col-lg-3 col-sm-4 col-xs-6">
        <img src="D:\Userfiles\spadyana\Downloads\bicycle.png" class="img-responsive"/></div>
         <div class="col-lg-3 col-sm-4 col-xs-6">
        <img src="D:\Userfiles\spadyana\Downloads\bicycle.png" class="img-responsive"/></div>
        
        <p>RandomText is a tool designers and developers can use to quickly grab dummy text in either Lorem Ipsum or Gibberish format.
There are a number of features that make RandomText a little different from other Lorem Ipsum dummy text generators you may find around the web...</p>
    </div>

</div>
<hr/>
<div class="row">
	<div class="col-md-12">
    <h3>More info on bikes here!!</h3>
    
        <p>RandomText is a tool designers and developers can use to quickly grab dummy text in either Lorem Ipsum or Gibberish format.
There are a number of features that make RandomText a little different from other Lorem Ipsum dummy text generators you may find around the web...</p>
    </div>
</div>
</div>
    <div class="navbar navbar-default navbar-fixed-bottom">
    	<div class="container">
        	<p class="navbar-text pull-left">Site built on Bootstrap 3</p>
            <a class="navbar-btn btn-danger btn pull-right" href="http://youtube.com">Subscribe</a>
        </div>
    </div>
    <script src="http://code.jquery.com/jquery-1.11.2.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script>
      $(document).foundation();
    </script>
  </body>
</html>


<?php

$db=null;

?>