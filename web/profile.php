<?php require 'init.php.inc';?>

<?php

if (!array_key_exists('id',$_GET) 
	//|| !array_key_exists('arrival',$_GET)
	//|| !array_key_exists('departure',$_GET) 
	) {
	redirect_to_home();
}
$id = intval($_GET['id']);
//$datespair = parse_and_validate_dates($_GET['arrival'], $_GET['departure']);
if (!($id > 0)
 //|| $datespair == FALSE
 ) { 
	redirect_to_home();
}

$PAGETITLE = "F2F | Update your profile";

//$SCRIPTSRC[] = "js/jquery.tmpl.min.js";

//$SCRIPTSRC[] = "js/Click.js";

$SCRIPTSRC[] = "js/jquery.ajaxfileupload.js";
$SCRIPTSRC[] = "js/jquery.jeditable.mini.js";
$SCRIPTSRC[] = "js/jquery.jeditable.ajaxupload.js";
$SCRIPTSRC[] = "js/profile.js";

?>

<?php include 'header.php.inc';?>

<?php
$qparams = [];
$sql = 	"select p.name, p.description, p.avatar, p.big_picture, l.name as location, l.countryname as country, l.region as region, count(*) as serviceno "
	. "from profile p, porref l, offered_service s "
	. "where p.location_id = l.id "
	. "and p.id = s.profile_id "
	. "and s.available = TRUE "
	. "and p.id = :id "
	//. "and period @> '["
	//. $arrival_date->format('Y-m-d').", "
	//. $departure_date->format('Y-m-d')."]'::daterange "
	. "group by p.name, p.description, p.avatar, p.big_picture, l.name, l.countryname, l.region ";

$qparams[":id"] = $id;
	
$q = $db->prepare($sql);
$q->execute($qparams);
if ($q->rowCount() == 0) {
	redirect_to_home();
}

$profile = $q->fetch(PDO::FETCH_ASSOC);

?>

  <body class="family">  
  	<div class="navbar navbar-inverse navbar-static-top">
        <div class="container">
            <a href="index.php" class="navbar-brand"><img src="img/F2F_word_blue.png" class="img-responsive"/></a>
                <button class="navbar-toggle" data-toggle="collapse" data-target=".navHeaderCollapse">
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
            <div class="collapse navbar-collapse navHeaderCollapse">
                <ul class="nav navbar-nav navbar-right">
                    <li><a href="index.php"><?php echo localization("Home", "Accueil"); ?></a></li>
                    <li><a href="#"><?php echo localization("Signup/Login", "Inscription/Connection"); ?></a></li>
               </ul>
          </div>
        </div>
 	</div>
 	<div>
	<div class="col-lg-1 col-sm-12 col-xs-12" style="background:#fff">
	</div>
	<div class="family-card-image col-lg-7 col-sm-12 col-xs-12 ajaxupload" style="background-image:url('img/profile/pics/<?php echo $profile['big_picture'];?>')">
	</div>
    <div class="col-lg-3 col-sm-12 col-xs-12" style="background:#fff;margin-top: 0%;border: 1px solid #E4CFCF;height: 520px;width:21%;">
    	<div class="col-lg-9 col-sm-3 col-xs-3" style="margin-top: 10%; text-align:center;">
					<span class="avatar-container ajaxupload" style="background-image:url('img/profile/avatars/<?php echo $profile['avatar'];?>')">
					</span>
				</div>
				<div class="family-highlight col-lg-12 col-sm-6 col-xs-6" style="
    margin-top: 25px; text-align:center;">
					<h2 style="text-align:center;" class="edit" id="name"><?php echo $profile['name']; ?></h2>
					<div class="font-color"><?php echo $profile['location'].' ('.$profile['region'].'), '.$profile['country']; ?></div>
					<div class="font-color"><span class="services"><?php echo $profile['serviceno']; ?></span> services</div>
				</div>
                
                <div class="family-highlight col-lg-12 col-sm-3 col-xs-3" style="
    margin-top: 38px;
">
                	<div class="sharing">
                    	<div class="likeFamily" data-profileid="<?php echo $id;?>">
                        		<?php if (isset($_SESSION['favourites'][$id]) && $_SESSION['favourites'][$id]) {
                        			echo '<span class="glyphicon glyphicon-heart wished"></span>';
                        		} else {
                        			echo '<span class="glyphicon glyphicon-heart"></span>';
                        		}
                        	?>
                            <span><?php echo localization("Save to Wish List", "Ajouter aux favorits"); ?></span>
                        </div>
                        <div class="shareSocialMedia">
<!-- AddToAny BEGIN -->
<div class="a2a_kit a2a_kit_size_20 a2a_default_style" style="margin: 0 auto; width: 100px;">
<a class="a2a_button_facebook"></a>
<a class="a2a_button_twitter"></a>
<a class="a2a_button_google_plus"></a>
<a class="a2a_dd" href="https://www.addtoany.com/share_save"></a>
</div>
<script  type="text/javascript" >
var a2a_config = a2a_config || {};
a2a_config.icon_color = "#888888";
</script>
<script type="text/javascript" src="//static.addtoany.com/menu/page.js"></script>
<!-- AddToAny END -->



                        </div>
                    </div>
                </div>
	</div>
    <div class="col-lg-1 col-sm-12 col-xs-12">
	</div>
	</div>
		
   		<div class="family-description" style="background-color:#ffffff;">
            <div class="container">
                <div class="row" style="border-bottom: 1px solid #E7DEDE;padding-bottom: 20px;">	
                    <div class="col-lg-10 col-sm-10 col-xs-10 family_description_box" style="padding-top:20px;">
                        <h3><?php echo localization("Family Description", "Details de la famille"); ?></h3>
                        <p class="font-color"><span class="edit_area" id="description"><?php echo $profile['description']; ?></span></p>
                    </div>
                </div>
            </div>
        </div>
        <div class="services-row">
        	<div class="container">
				<form name="serviceSelection" >
				<input type="hidden" name="id" value="<?php echo $id; ?>">
    <?php 


	{
	$qparams = [];
	$sql = 	"select service_type, available, period, price_fix, price_per_day, service_desc "
		. "from offered_service "
		. "where profile_id = :id ";
		//. "and period @> '["
		//. $arrival_date->format('Y-m-d').", "
		//. $departure_date->format('Y-m-d')."]'::daterange ";

	$qparams[":id"] = $id;
	
	$q = $db->prepare($sql);
	$q->execute($qparams);
	$i=0;
	while ($service = $q->fetch(PDO::FETCH_ASSOC)) {
			
			?>
            	<div class="row item-divider" style="<?php if ($i++%2==0) echo 'background-color: #F9F9F9;'; ?>border-bottom:none;" >
                	<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 Available">
                    	<div class="col-lg-2 col-md-2 col-sm-2 hidden-xs">
                        	<div class="items-section">
                                <div class="item_border">
                                    <img alt="" src="<?php echo ServiceType::GetPics()[$service['service_type']]; ?>" class="img-responsive items-sell"/>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-5 col-md-5 col-sm-6 col-xs-6">
                        	<h3><?php echo ServiceType::GetTypes()[$service['service_type']]; ?> </h3>
				<p class="font-color"><?php echo $service['service_desc'];?></p>
                        </div>
                        <div class="col-lg-2 col-md-2 col-sm-4 col-xs-4">
                                <label>
                                    <input placeholder="<?php echo localization("Arrival", "Arrivée"); ?>" type="text" name="arrival__<?php echo $service['service_type']; ?>" class="datepickerArrival" value="" >
                                </label>
                                <label>
                                    <input placeholder="<?php echo localization("Departure", "Départ"); ?>" type="text" name="departure__<?php echo $service['service_type']; ?>" class="datepickerDeparture" value="" >
                                </label>
                        </div>
                        <div class="col-lg-1 col-md-1 col-sm-3 col-xs-3">
                        	<div class="TotalPrice">
                        	    <div>
                        	    	<span class="service-price"> <?php echo $service['price_per_day'];?>&#8364;/<?php echo localization("day", "jour"); ?> </span>
                        	    </div>
                                <h3 class="service-price total-price">
                                    <span><?php //echo round(($departure_date->diff($arrival_date)->days+1) * $service['price_per_day'],2); ?></span>&#8364;
                                </h3>    
                            </div>                  	
                        </div>
                        <div class="col-lg-2 col-md-2 col-sm-4 col-xs-4">
                        	<label for="service__<?php echo $service['service_type']; ?>" class="filter"></label>
                        	<input type="checkbox" class="ui_checkbox" name="service__<?php echo $service['service_type']; ?>" value="<?php echo $service['service_type']; ?>" data-servicename="<?php echo ServiceType::GetTypes()[$service['service_type']]; ?>">

                            <a href="javascript:void(0);" class="add-to-cart"><img class="Add-cart" alt="" src="img/Add_icon.png" style="width:55px;margin-top:18px;margin-left:22px;" /></a>
                        	
                        </div>
                    </div>   
                  
                </div>                
            
            <?php

		}

	}
	?>
				</form>
		        <div class="row item-divider">

                </div>				
        	</div>
		</div>
			 
<?php include 'footer.php.inc';?>

</body>

<?php include 'endpage.php.inc';?>

<?php require 'destroy.php.inc';?>







