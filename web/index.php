<?php

$PAGETITLE = "F2F | Welcome";

$SCRIPTSRC[] = "js/jquery.typeahead.min.js";
$SCRIPTSRC[] = "js/jquery-migrate-1.2.1.min.js";
$SCRIPTSRC[] = "js/jquery.ba-bbq.min.js";

$SCRIPTSRC[] = "js/datepicker.js";
$SCRIPTSRC[] = "js/main.js";

?>

<?php include 'header.php.inc';?>

<body>

<div class="head-panel">

<div class="row">
 <div id="homeTop-row">
 <div class="overlayLight"></div>
 	<div class="navbar navbar-inverse navbar-static-top">
  	<div class="container">
  		<a href="index.php" class="navbar-brand"><img src="img/F2F_word.png" class="img-responsive"/></a>
            <button class="navbar-toggle" data-toggle="collapse" data-target=".navHeaderCollapse">
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
 		<div class="collapse navbar-collapse navHeaderCollapse">
  			<ul class="nav navbar-nav navbar-right">
				<li ><a href="home.html" class="dropdown-toggle" data-toggle="dropdown">English<b class="caret"></b></a>
                	<ul class="dropdown-menu">
                      <li><a href="#">French</a></li>
                      <li class="active"><a href="#">English</a></li>
                      <li><a href="#">German</a></li>
                    </ul>
                </li>
                <li><a href="#">Sign up/Login</a></li>
                <li><a href="#">Connect</a></li>
                <li><a href="home.html"><img src="img/Shopping_Cart_icon.png" class="img-responsive cart" /></a></li>
           </ul>
      </div>
 	</div>
 </div>
 <div class="container">
 	<div class="row">
    	<div class="col-lg-12 col-sm-12 col-xs-12">
            <div class="punchLine">
                <p>My Travel companion is my family</p>
            </div>
            <div class="formSubmission">
            <form name="search" action="results.php">
            <input name="locationid" type="hidden" />
			<label for="location">
				<div class="typeahead-container">
     			<span class="typeahead-query">		
     					<input name="location" type="text" placeholder="Where are you travelling to?" autocomplete="off" />
     			</span>
     			</div>
			</label>
            <label>
            <input placeholder="Arrival" type="text" name="arrival" id="datepickerArrival" value="">
            </label>
            <label>
            <input placeholder="Departure" type="text" name="departure" id="datepickerDeparture" value="">
            </label>
            <label>
            <button class="btn btn-default" type="submit"><i class="glyphicon glyphicon-search"></i></button>
            <!-- <input type="submit" name="submit" id="submit" value="Search"> -->
            </label>
            </form>
            </div>
        </div>
    </div>
 </div>
 </div>
</div>
<hr/>
<div class="row features">
	<div class="col-md-12">
    	<div class="col-lg-4 col-sm-6 col-xs-12 bubble">
            <div class="bubble-head" id="borrow-head">
     			<div class="inner-bubble">
                    <div class="bubble-header">
                        <em>Borrow</em>
                     </div>
                     <div class="bubble-text">
                        <span>
                            <p>
                                All you need to worry about is to fit your family in your travel plans, for all the rest you can use our platform.
                            </p>
                        </span>
                    </div>
                </div>
            </div>
        </div>
    	<div class="col-lg-4 col-sm-6 col-xs-12 bubble">
    	<div class="bubble-head" id="lend-head">
        	<div class="inner-bubble">
                <div class="bubble-header">
                   <em>Lend</em>
                </div>
                <div class="bubble-text">
                	<span>
                      	<p>
                         	Lend things you bought for your child till the new one arrives, make useless belongings useful for others.
                        </p>
                    </span>
                </div>
              </div>
        </div>
     </div>
     	<div class="col-lg-4 col-sm-12 col-xs-12 bubble">
     	<div class="bubble-head" id="share-head">
        	<div class="inner-bubble">
                <div class="bubble-header">
                    <em>Share</em>
                </div>
                <div class="bubble-text">
                    <span>
                        <p>
                            Only a family can understand family's issues. Share your concerns and your experiences with other families.
                        </p>
                    </span>
                </div>
              </div>
        </div>   
     </div>
    </div>
</div>
<hr/>
<div class="row">
<div id="borrow-section">
	<div class="overlayDark"></div>
	<div class="col-md-12">
    <div class="borrowSectionHeight">
    <div class="col-lg-3">
    </div>
    <div class="col-lg-3 col-sm-4 col-xs-12">
    	<div class="sectionHeader hidden-xs">
    	<em>Borrow</em>
        </div>
    </div>
    <div class="col-lg-4 col-sm-8 col-xs-12" data-animation="fadeInDown">
    <div class="textContent">
    	<div class="innerContainer">
        	<h4>Does planning your vacations look like this??</h4>
            
    	<p class="sectionText">
            Did you ever find that planning vacations ever since you got children became very painful? Did you ever dream to not have to carry on all your children equipements while your are travelling?<br/> 
Our platform will connect you to local families so that you can borrow them at your destination place. You need to provide us with your travel planned date and location and we will connect you with local families willing to rent out their equipment according to your needs.
		</p>
	</div>
    </div>
       </div> 
        </div>
    </div>
</div>
</div>

<div class="row">
<div id="lend-section">
	<div class="overlayLight"></div>
	<div class="col-md-12">
    <div class="col-lg-3">
    </div>
    <div class="col-lg-4 col-sm-6 col-xs-12"  data-animation="fadeInDown">
    <div class="textContent">
    	<div class="innerContainer">
        	<h4>Does your garage look like this??</h4>
            
    	<p class="sectionText">
Is your garage full with your children equipements that you are not using but are not ready to give away yet? You canot sell them but you would be happy to free up your place?<br/> 
Our platform will connect you to families travelling at your destination so that you can rent your equipments and help them finding what they need for their vacations.
		</p>
    </div>
    </div>
    
        </div>
        <div class="col-lg-3 col-sm-6 col-xs-12">
    	<div class="sectionHeaderRight hidden-xs">
    	<em>Lend</em>
        </div>
    </div>
    <div class="col-lg-2">
    	
    </div>
    </div>
</div>
</div>
<div class="row">
<div id="share-section">
	<div class="overlayDark"></div>
	<div class="col-md-12">
    <div class="col-lg-3">
    	
    </div>
    <div class="col-lg-3 col-sm-4 col-xs-12">
    	<div class="sectionHeader hidden-xs">
    	<em>Share</em>
        </div>
    </div>
    
    <div class="col-lg-4 col-sm-8 col-xs-12" data-animation="fadeInDown">
    	<div class="textContent">
        	<div class="innerContainer">
        	<h4>Do you have questions on your destination??</h4>
    	<p class="sectionText">
Are you worried about access to recreational or health facilities at your destination? Are you thinkining about what activities your children can do once you leave for your vacations?<br/> 
Why not asking another family?<br/> 
Our platform will connect you with families at your destination in order to find an answer for your concerns. Connect with another family and use their personal experience.
        </p>
	</div>
    </div>
      </div>
        
    </div>
</div>
</div>
</div>

<?php include 'footer.php.inc';?>

</body>

<?php include 'endpage.php.inc';?>