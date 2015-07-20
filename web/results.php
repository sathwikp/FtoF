<?php require 'init.php.inc';?>

<?php

$PAGETITLE = "F2F | Search Results";

$SCRIPTSRC[] = "js/jquery.tmpl.min.js";
$SCRIPTSRC[] = "js/jquery.typeahead.min.js";
$SCRIPTSRC[] = "js/jquery-migrate-1.2.1.min.js";
$SCRIPTSRC[] = "js/jquery.ba-bbq.min.js";

$SCRIPTSRC[] = "js/datepicker.js";
$SCRIPTSRC[] = "js/round-buttons.js";
$SCRIPTSRC[] = "js/results.js";
$SCRIPTSRC[] = "js/Click.js";

$SCRIPTS[] =
[
['id' => 'resultTpl', 'type' => 'text/x-jquery-tmpl'],
//'<li>
//<h3>${name}</h3>
//<div>${description}</div>
//<ul>
//{{each services}}
//<li>service ${$value}</li>
//{{/each}}
//</ul>
//</li>'

  '<li class="family_item background_white">'
. '		<div class="family_image" style="background-image:url(\'${picture}\');width:29.33%;opacity:0.8"><span/>'
. '		</div>'
. '		<div class="item_sell padded padded_half">'
. '			<div class="items_description">'
. '			<div class="family_like" style="float:left;background-color:#EA4A4A;height:50px;padding:7px;width:50px;border-radius:10%;">'
.'			<div class="likeImage like_inactive">'
.'				<a href="javascript:void(0);" data-id="${id}">'
.'				{{if wished}}'
.'				<img src="img/Heart_button_icon_active.png" class="img-responsive" />'
.'				{{else}}'
.'				<img src="img/Heart_button_icon.png" class="img-responsive" />'
.'				{{/if}}'
.'				</a>'
.'			</div>'
.'			<div style="margin-top: 48px;margin-left: -10px;text-align:right">'
. 				localization("Rating","Évaluation")
.'				<h3 style="color:#EA4A4A;text-align:right">${stars}/5</h3>'
.'			</div>'
.'		</div>'
. '				<h3 style="margin-top:22px;padding-left:78px;">'
. '					<a href="details.php?id=${id}&arrival=${arrival}&departure=${departure}" target="_blank">${name}</a> - <span style="font-size:14px;">${cityname}, ${countryname}</span>'
. '				</h3>'
. '				<br/>'
. '				<div class="item_amenities" style="margin-left: 70px;padding-top:14px;">'
. '                 {{each services}}'
. '					<div class="item_border">'
. '						<img src="${pic}" class="img-responsive icons" alt="${name}" title="${name}" />'
. '						${price_per_day}&#8364;/'
. 						localization("day","jour")
. '					</div>'
. '					{{/each}}'
. '				</div>'
. '			</div>'
. '		</div>'
. '	</li>'
];

?>

<?php include 'header.php.inc';?>


  <body class="search">
  
  	<div class="navbar navbar-inverse navbar-static-top">
        <div class="container">
            <a href="index.php" class="navbar-brand"><img src="img/F2F_word_blue.png" class="img-responsive"/><img src="img/beta.png" class="img-responsive" style="width:35px;margin-top:-86px;margin-left:-15px;"/></a>
                <button class="navbar-toggle" data-toggle="collapse" data-target=".navHeaderCollapse">
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
            <div class="collapse navbar-collapse navHeaderCollapse">
                <ul class="nav navbar-nav navbar-right">

                    <li><a href="index.php"><?php echo localization("Home", "Accueil"); ?></a></li>
                <?php if ($user->is_loggedin()) echo '<li><a href="profile.php">Profile</a></li>' ; ?>  
                <li><?php echo $user->is_loggedin() ? '<a href="logout.php"> ' .localization("Logout", "Deconnection").'</a>' : '<a href="javascript:void(0)" data-toggle="modal" onclick="openLoginModal();">' .localization("Sign up/Login", "Inscription/Connection").'</a>'; ?></li>
  
               </ul>
          </div>
        </div>
 	</div>
 	<form name="criteria">
	<input name="locationid" type="hidden" />
    <div class="formBar">
        <div class="container">
        	<div class="formSubmission">
			<label for="location">
				<div class="typeahead-container">
     			<span class="typeahead-query">		
     					<input name="location" type="search" placeholder="<?php echo localization("Where are you travelling to?", "Quelle est votre destination?"); ?>" autocomplete="off" >
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
            <span class='round-button-cont' data-toggle="tooltip" data-placement="top" title="<?php echo localization("How many kids with age 0 to 2?", "Combien d'enfants entre 0 et 2 ans?"); ?>">
			<button type="button" class="round-button baby-button" ><span><span class="counter">0</span></span></button><span class="decrease"></span>
            <input name="babyno" type="hidden" value="0" />
			</span>            
            </label>
			
            <label>
            <span class='round-button-cont' data-toggle="tooltip" data-placement="top" title="<?php echo localization("How many kids with age 3 to 6?", "Combien d'enfants entre 3 et 6 ans?"); ?>"><button type="button" class="round-button older-baby-button" ><span><span class="counter">0</span></span></button><span class="decrease"></span>
            <input name="oldbabyno" type="hidden" value="0" /></span>
            </label>
			
            <label>
            <span class='round-button-cont rightmost-cont' data-toggle="tooltip" data-placement="top" title="<?php echo localization("How many kids older than 6?", "Combien d'enfants de plus de 6 ans?"); ?>"><button type="button" class="round-button boy-button" ><span><span class="counter">0</span></span></button><span class="decrease"></span>
            <input name="boyno" type="hidden" value="0" /></span>
			
            </label>                                                           
            </div>
        </div>
    </div>
    <div class="background_gray">
    	<div class="container">
        	<div class="row">
            	<div class="filters_column col-sm-4 col-md-3 hidden-xs">
                    <div class="background_white">
                        <div class="hidden-xs">
                    		<div class="total_search_result">
                            	<p><span id='resultno'></span><?php echo localization(" search results", " Résultats"); ?></p>
                            </div>
                            <hr class="divider">
                        </div>
                        <div class="filter_padding">
                           	<div class="filters">
                            	<h4><?php echo localization("Services", "Services"); ?></h4>
                                	<div class="filters-wrapper">
     	<?php
     		foreach (ServiceType::GetTypes() as $key => $val) {
     			echo '<div class="checkMark">'
    				. '<label for="service__'.$key.'" class="filter"></label>'
      				. '<input type="checkbox" class="ui_checkbox" name="service__'.$key.'" value="'.$key.'"> <span class="ui_checkbox_target clr"></span><span>'. $val . '</span>'
					. '</div>'
					. '<br />';
     		}
     	 ?>                                	
                                    </div>
                                    <h4><?php echo localization("Languages", "Langue"); ?></h4>
                                	<div class="filters-wrapper">
                                		<div class="checkMark">
    									<label for="french" class="filter"></label>
      										<input type="checkbox" class="ui_checkbox" name="french" value="french"> <span class="ui_checkbox_target clr"></span>
											<span> <?php echo localization("French", "Français"); ?></span>
      									</div>
      									<br />
      									<div class="checkMark">
    									<label for="english" class="filter"></label>
      										<input type="checkbox" class="ui_checkbox" name="english" value="english"> <span class="ui_checkbox_target clr"></span>
											<span> <?php echo localization("English", "Anglais"); ?></span>
      									</div>
      									<br />     
      									<!--<div class="checkMark">
    									<label for="spanish" class="filter"></label>
      										<input type="checkbox" class="ui_checkbox" name="spanish" value="spanish"> <span class="ui_checkbox_target clr"></span>
											<span> Spanish </span>
      									</div>
      									<br />-->           									      									                                		
                                	</div>
							</div>
                            <hr class="divider">
						</div>
                    </div>
                </div>
                <div class="srp-list col-sm-8 col-md-9" >
                	<div class="row hidden-xs topmost_row"></div>
                    <div id="resultContainer">
                    	<ul id="resultList" style="padding-bottom:4px;">
						</ul>
					</div>
            </div>
        </div>
    </div>
    </form>
    
<?php include 'login-modal.php.inc';?>

<?php include 'footer.php.inc';?>

</body>

<?php include 'endpage.php.inc';?>

<?php require 'destroy.php.inc';?>