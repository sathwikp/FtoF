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
. '		<div class="family_image" style="background-image:url(\'img/F2F2.jpg\')">'
. '			<div class="family_like">'
. '				<div class="likeImage like_inactive">'
. '					<img src="img/like_inactive.png" class="img-responsive" />'
. '				</div>'
. '			</div>'
. '		</div>'
. '		<div class="item_sell padded git pull">'
. '			<div class="items_description">'
. '				<h3 class="hidden-xs">'
. '					<a href="details.php?id=${id}&arrival=${arrival}&departure=${departure}" >${name}</a>'
. '				</h3>'
. '				<span class="hidden-xs smallText">'
. '					Paris, France'
. '				</span>'
. '				<br/>'
. '				<span class="hidden-xs servicesNumber">'
. '					${services_no} service(s)'
. '				</span>'
. '				<div class="item_amenities">'
. '                 {{each services}}'
. '					<div class="item_border">'
. '						<img src="${pic}" class="img-responsive icons" alt="${name}" title="${name}" />'
. '						${price_per_day}&#8364;/day'
. '					</div>'
. '					{{/each}}'
. '				</div>'
. '				<div class="stars">'
. '					{{if stars >= 1}}'
. '					<img src="img/star.png" class="reponsive" />'
. '					{{/if}}'
. '					{{if stars >= 2}}'
. '					<img src="img/star.png" class="reponsive" />'
. '					{{/if}}'
. '					{{if stars >= 3}}'
. '					<img src="img/star.png" class="reponsive" />'
. '					{{/if}}'
. '					{{if stars >= 4}}'
. '					<img src="img/star.png" class="reponsive" />'
. '					{{/if}}'
. '					{{if stars >= 5}}'
. '					<img src="img/star.png" class="reponsive" />'
. '					{{/if}}'
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
            <a href="index.php" class="navbar-brand"><img src="img/F2F_word.png" class="img-responsive"/></a>
                <button class="navbar-toggle" data-toggle="collapse" data-target=".navHeaderCollapse">
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
            <div class="collapse navbar-collapse navHeaderCollapse">
                <ul class="nav navbar-nav navbar-right">
                    <li><a href=index.php">Home</a></li>
                    <li><a href="#">Signup/Login</a></li>
                    <li><a href="#">Connect</a></li>
                    <li><a href="#"><img src="img/Shopping_Cart_icon.png" class="img-responsive cart" /></a></li>
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
     					<input name="location" type="search" placeholder="Where are you travelling to?" autocomplete="off" >
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
            <button type="button" class="round-button baby-button" data-toggle="tooltip" data-placement="top" title="How many kids with age 0 to 2?"><span><span class="counter">0</span><span class="decrease"></span></span></button>
            <input name="babyno" type="hidden" value="0" />            
            </label>
            <label>
            <button type="button" class="round-button older-baby-button" data-toggle="tooltip" data-placement="top" title="How many kids with age 3 to 6?"><span><span class="counter">0</span><span class="decrease"></span></span></button>
            <input name="oldbabyno" type="hidden" value="0" />
            </label>
            <label>
            <button type="button" class="round-button boy-button" data-toggle="tooltip" data-placement="top" title="How many kids older than 6?"><span><span class="counter">0</span><span class="decrease"></span></span></button>
            <input name="boyno" type="hidden" value="0" />
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
                            	<p><span id='resultno'></span> search results</p>
                            </div>
                            <hr class="divider">
                        </div>
                        <div class="filter_padding">
                           	<div class="filters">
                            	<h4>Rental</h4>
                                	<div class="filters-wrapper">
     	<?php
     		foreach (ServiceType::GetTypes() as $key => $val) {
     			echo '' //'<div class="checkbox">'
    				. '<label for="service__'.$key.'" class="filter">'
      				. '<input type="checkbox" class="ui_checkbox" name="service__'.$key.'" value="'.$key.'"> <span class="ui_checkbox_target"></span>'. $val
    				. '</label>'
					. '<br />';
     		}
     	 ?>                                	
                                    </div>
							</div>
                            <hr class="divider">
						</div>
                    </div>
                </div>
                <div class="srp-list col-sm-8 col-md-9" >
                	<div class="row hidden-xs topmost_row"></div>
                    <div id="resultContainer">
                    	<ul id="resultList">
						</ul>
					</div>
            </div>
        </div>
    </div>
    </form>

<?php include 'footer.php.inc';?>

</body>

<?php include 'endpage.php.inc';?>

<?php require 'destroy.php.inc';?>