<?php require 'init.php.inc';?>

<?php

$PAGETITLE = "F2F | Welcome";

$SCRIPTSRC[] = "js/jquery.typeahead.min.js";
$SCRIPTSRC[] = "js/jquery-migrate-1.2.1.min.js";
$SCRIPTSRC[] = "js/jquery.ba-bbq.min.js";

$SCRIPTSRC[] = "js/datepicker.js";
$SCRIPTSRC[] = "js/round-buttons.js";
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
  			<ul class="nav navbar-nav navbar-right main-nav">
				<li ><a href="#" class="dropdown-toggle" data-toggle="dropdown"><?php echo localization("Language", "Langage"); ?><b class="caret"></b></a>
                	<ul class="dropdown-menu">
                      <li <?php if ($_SESSION['lang'] =='fr') echo 'class="active"';?>><a href="?lang=fr"><?php echo localization("French", "Français"); ?></a></li>
                      <li <?php if ($_SESSION['lang'] =='en') echo 'class="active"';?>><a href="?lang=en"><?php echo localization("English", "Anglais"); ?></a></li>
                      <!--<li><a href="#">German</a></li>-->
                    </ul>
                </li>
        
                <?php if ($user->is_loggedin()) echo '<li><a href="profile.php">Profile</a></li>' ; ?>       
                <li><?php echo $user->is_loggedin() ? '<a href="logout.php"> ' .localization("Logout", "Deconnection").'</a>' : '<a href="javascript:void(0)" data-toggle="modal" onclick="openLoginModal();">' .localization("Sign up/Login", "Inscription/Connection").'</a>'; ?></li>
               
           </ul>
      </div>
 	</div>
 </div>
 <div class="container">
 	<div class="row">
    	<div class="col-lg-12 col-sm-12 col-xs-12">
            <div class="punchLine">
                <p><?php echo localization("We make travelling with children easier","Vous faciliter le voyage en famille"); ?></p>
                <p class="smallPunchLine"><?php echo localization("Find all you need at destination", "Tout le nécessaire à l’arrivée"); ?></p>
            </div>
            <div class="formSubmission">
            <form name="search" action="results.php">
            <input name="locationid" type="hidden" />
			<label for="location">
				<div class="typeahead-container">
     			<span class="typeahead-query">		
     					<input name="location" type="text" placeholder="<?php echo localization("Where are you travelling to?", "Quelle est votre destination?"); ?>" autocomplete="off" />
     			</span>
     			</div>
			</label>
            <label>
            <input placeholder="<?php echo localization("Arrival","Arrivée"); ?>" type="text" name="arrival" id="datepickerArrival" value="">
            </label>
            <label>
            <input placeholder="<?php echo localization("Departure","Départ"); ?>" type="text" name="departure" id="datepickerDeparture" value="">
            </label>
            <label>
            <span class='round-button-cont' data-toggle="tooltip" data-placement="top" title="<?php echo localization("How many kids with age 0 to 2?", "Combien d'enfants entre 0 et 2 ans?"); ?>"><button type="button" class="round-button baby-button" ><span><span class="counter">0</span></span></button><span class="decrease"></span>
            <input name="babyno" type="hidden" value="0" /></span>            
            </label>
            <label>
            <span class='round-button-cont' data-toggle="tooltip" data-placement="top" title="<?php echo localization("How many kids with age 3 to 6?", "Combien d'enfants entre 3 et 6 ans?"); ?>"><button type="button" class="round-button older-baby-button" ><span><span class="counter">0</span></span></button><span class="decrease"></span>
            <input name="oldbabyno" type="hidden" value="0" /></span>
            </label>
            <label>
            <span class='round-button-cont rightmost-cont' data-toggle="tooltip" data-placement="top" title="<?php echo localization("How many kids older than 6?", "Combien d'enfants de plus de 6 ans?"); ?>"><button type="button" class="round-button boy-button" ><span><span class="counter">0</span></span></button><span class="decrease"></span>
            <input name="boyno" type="hidden" value="0" /></span>
            </label>                                    
            <label>
            <button class="btn btn-default" type="submit"><i class="glyphicon glyphicon-search"></i></button>
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
                        <em><?php echo localization("Borrow", "Voyagez"); ?></em>
                     </div>
                     <div class="bubble-text">
                        <span>
                            <p>
                                <?php echo localization(
								"All you need to worry about is to fit your family in your travel plans, for all the rest you can use our platform.",
								"Profitez simplement de vos vacances, pour tout le reste notre plateforme est là pour vous aider.");
								?>
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
                   <em><?php echo localization("Lend", "Louez"); ?></em>
                </div>
                <div class="bubble-text">
                	<span>
                      	<p>
							<?php echo localization(
                         	"Lend things you bought for your child till the new one arrives, make useless belongings useful for others.",
							"Mettre à la disposition de familles qui voyagent les affaires de vos enfants que vous n’utilisez plus."); 
							?>
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
                    <em><?php echo localization("Share", "Partagez"); ?></em>
                </div>
                <div class="bubble-text">
                    <span>
                        <p>
							<?php echo localization(
                            "Only a family can understand family's issues. Share your concerns and your experiences with other families.",
							"Seule une famille peut comprendre ce que vous vivez. Partager vos expériences et faites des rencontres inoubliables.");
							?>
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
    	<em><?php echo localization("Borrow", "Voyagez"); ?></em>
        </div>
    </div>
    <div class="col-lg-4 col-sm-8 col-xs-12" data-animation="fadeInDown">
    <div class="textContent">
    	<div class="innerContainer">
    	<p class="sectionText">
		<?php echo localization(
		"Did you ever find that planning vacations ever since you got children became very painful? Did you ever dream to not have to carry on all your children equipements while your are travelling? Our platform will connect you to local families so that you can borrow them at your destination place. You need to provide us with your travel planned date and location and we will connect you with local families willing to rent out their equipment according to your needs.",
		"Planifier vos vacances est devenu un cauchemar depuis que vous avez des enfants? N’avez-vous jamais rêvé d’alléger vos valises et ne pas avoir à transporter tout le matériel nécessaire à vos enfants? Notre plateforme vous mettra en relation avec les familles se trouvant sur votre lieu de vacances afin que vous puissiez simplement louer tous ce dont vous avez besoin sur place et profiter pleinement de vos vacances."); ?>
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
    	<p class="sectionText">
			<?php echo localization(
				"Is your garage full with your children equipements that you are not using but are not ready to give away yet? You canot sell them but you would be happy to free up your place? Our platform will connect you to families travelling at your destination so that you can rent your equipments and help them finding what they need for their vacations.",
				"Votre garage est prêt à déborder? Vous entassez les affaires de vos enfants? Vous ne pouvez pas encore les vendre mais seriez ravi de pouvoir faire un peu de place? Notre plateforme vous mettra en relation avec les familles voyageant près de chez vous afin  que vous puissiez leur louer vos affaires et les aider à profiter pleinement de leurs vacances."); 
			?>
		</p>
    </div>
    </div>
    
    </div>
    <div class="col-lg-3 col-sm-6 col-xs-12">
    	<div class="sectionHeaderRight hidden-xs">
    	<em><?php echo localization("Lend", "Louez"); ?></em>
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
    	<em><?php echo localization("Share", "Partagez"); ?></em>
        </div>
    </div>
    
    <div class="col-lg-4 col-sm-8 col-xs-12" data-animation="fadeInDown">
    	<div class="textContent">
        	<div class="innerContainer">
    	<p class="sectionText">
		<?php echo localization(
		"Are you worried about access to recreational or health facilities at your destination? Are you thinkining about what activities your children can do once you leave for your vacations? Why not asking another family? Our platform will connect you with families at your destination in order to find an answer for your concerns. Connect with another family and use their personal experience.",
		"Grâce à notre site vous allez accéder à des services proposés par d’autres familles qui seront ravis de vous aider. C’est aussi l'occasion de faire de nouvelles rencontres inoubliables et de découvrir votre destination de manière totalement différente.");
		?>
        </p>
	</div>
    </div>
      </div>
        
    </div>
</div>
</div>
</div>

<?php include 'login-modal.php.inc';?>

<?php include 'footer.php.inc';?>

</body>

<?php include 'endpage.php.inc';?>
<?php require 'destroy.php.inc';?>