<?php require 'init.php.inc';?>

<?php

if (!array_key_exists('id',$_GET) || !array_key_exists('arrival',$_GET)  || !array_key_exists('departure',$_GET) ) {
	redirect_to_home();
}
$id = intval($_GET['id']);
$datespair = parse_and_validate_dates($_GET['arrival'], $_GET['departure']);
if (!($id > 0) || $datespair == FALSE) { 
	redirect_to_home();
}

list($arrival_date, $departure_date) = $datespair;

$PAGETITLE = "F2F | Services Detail";

//$SCRIPTSRC[] = "js/jquery.tmpl.min.js";

$SCRIPTSRC[] = "js/Click.js";
$SCRIPTSRC[] = "js/details.js";

?>

<?php include 'header.php.inc';?>

<?php
$qparams = [];
$sql = 	"select p.name, p.description, p.avatar, p.big_picture, l.name as location, l.countryname as country, l.region as region, count(*) as serviceno "
	. "from profile p, porref_nearest l, offered_service s "
	. "where p.location_id = l.id "
	. "and p.id = s.profile_id "
	. "and s.available = TRUE "
	. "and p.id = :id "
	. "and period @> '["
	. $arrival_date->format('Y-m-d').", "
	. $departure_date->format('Y-m-d')."]'::daterange "
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
            <a href="index.php" class="navbar-brand"><img src="img/F2F_word_blue.png" class="img-responsive"/><img src="img/beta.png" class="img-responsive" style="width:35px;margin-top:-86px;margin-left:-15px;/></a>
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
 	<div>
	<div class="col-lg-1 col-sm-12 col-xs-12" style="background:#fff">
	</div>
	<div class="family-card-image col-lg-7 col-sm-12 col-xs-12" style="background-image:url('<?php echo $profile['big_picture'];?>')">
	</div>
    <div class="col-lg-3 col-sm-12 col-xs-12" style="background:#fff;margin-top: 0%;border: 1px solid #E4CFCF;height: 520px;width:21%;">
    	<div class="col-lg-9 col-sm-3 col-xs-3" style="margin-top: 10%; text-align:center;">
					<span class="avatar-container" style="background-image:url('<?php echo $profile['avatar'];?>')">
					</span>
				</div>
				<div class="family-highlight col-lg-12 col-sm-6 col-xs-6" style="
    margin-top: 25px; text-align:center;">
					<h2 style="text-align:center;"><?php echo $profile['name']; ?></h2>
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
                        <p class="font-color"><?php echo $profile['description']; ?></p>
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
		. "where profile_id = :id "
		. "and period @> '["
		. $arrival_date->format('Y-m-d').", "
		. $departure_date->format('Y-m-d')."]'::daterange ";

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
                                    <input placeholder="<?php echo localization("Arrival", "Arrivée"); ?>" type="text" name="arrival__<?php echo $service['service_type']; ?>" class="datepickerArrival" value="<?php echo $arrival_date->format(__DATEFORMAT); ?>" data-mindate="<?php echo $arrival_date->format(__DATEFORMAT); ?>" data-maxdate="<?php echo $departure_date->format(__DATEFORMAT); ?>" data-price="<?php echo $service['price_per_day'];?>">
                                </label>
                                <label>
                                    <input placeholder="<?php echo localization("Departure", "Départ"); ?>" type="text" name="departure__<?php echo $service['service_type']; ?>" class="datepickerDeparture" value="<?php echo $departure_date->format(__DATEFORMAT); ?>" data-mindate="<?php echo $arrival_date->format(__DATEFORMAT); ?>" data-maxdate="<?php echo $departure_date->format(__DATEFORMAT); ?>" data-price="<?php echo $service['price_per_day'];?>">
                                </label>
                        </div>
                        <div class="col-lg-1 col-md-1 col-sm-3 col-xs-3">
                        	<div class="TotalPrice">
                        	    <div>
                        	    	<span class="service-price"> <?php echo $service['price_per_day'];?>&#8364;/<?php echo localization("day", "jour"); ?> </span>
                        	    </div>
                                <h3 class="service-price total-price">
                                    <span><?php echo round(($departure_date->diff($arrival_date)->days+1) * $service['price_per_day'],2); ?></span>&#8364;
                                </h3>    
                            </div>                  	
                        </div>
                        <div class="col-lg-2 col-md-2 col-sm-4 col-xs-4">
                        	<label for="service__<?php echo $service['service_type']; ?>" class="filter"></label>
                        	<input type="checkbox" class="ui_checkbox" name="service__<?php echo $service['service_type']; ?>" value="<?php echo $service['service_type']; ?>" data-servicename="<?php echo ServiceType::GetTypes()[$service['service_type']]; ?>">

                            <a href="javascript:void(0);" class="add-to-cart"><img class="Add-cart" alt="" src="img/Add_icon.png" style="width:55px;margin-top:18px;margin-left:22px;" /></a>
                        	
                        </div>
                    </div>   
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 AddedToCart">
                    	<div class="col-lg-2 col-md-2 col-sm-2 hidden-xs">
                        	<div class="items-section">
                                <div class="item_border">
                                   <img alt="" src="<?php echo ServiceType::GetPics()[$service['service_type']]; ?>" class="img-responsive items-sell"/>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-5 col-md-5 col-sm-6 col-xs-6">
                        	<h3><?php echo ServiceType::GetTypes()[$service['service_type']]; ?> <?php echo localization("added to cart", "ajouté(s) au panier"); ?></h3>
                        </div>
                        <div class="col-lg-2 col-md-2 col-sm-4 col-xs-4">
                        	
                        </div>
                        <div class="col-lg-1 col-md-1 col-sm-3 col-xs-3">
                        	<div class="TotalPrice"> 
                                <h3 class="service-price total-price">
                                    <span><?php echo round(($departure_date->diff($arrival_date)->days+1) * $service['price_per_day'],2); ?></span>&#8364;
                                </h3>  
                            </div>                   	
                        </div>
                        <div class="col-lg-2 col-md-2 col-sm-4 col-xs-4">
                        	<a href="javascript:void(0);" class="remove-from-cart"><img class="Remove-cart" alt="" src="img/Cross_icon.png" /></a>
                        </div>
                    </div>                    
                </div>                
            
            <?php

		}

	}
	?>
				</form>
		        <div class="row item-divider">

		        <div class="Total-price">
		        <div class="col-lg-7 col-md-2 col-sm-4 col-xs-4" ></div>
                	<div class="col-lg-3 col-md-2 col-sm-4 col-xs-4">
                    	<h3 class="TotalAmountLabel" style="display: inline;color: #16becf;"><?php echo localization("Total Amount", "Montant total"); ?>: </h3>
                        <h3 id="Amount" style="margin-left:14px"><span>0</span>&#8364;</h3>
                    </div>
                    <div class="col-lg-1 col-md-2 col-sm-4 col-xs-4">
                    	<button type="button" class="btn" id="modalBtn"><?php echo localization("Book Now", "Réserver"); ?></button>

                    </div>
                    <div class="col-lg-1 col-md-2 col-sm-4 col-xs-4">
                    	
                    </div>
                   </div> 
                </div>				
        	</div>
		</div>

		
    <?php 


	{
	$qparams = [];
	$sql = 	"select p.name, r.id_reviewer, r.review, r.rating, to_char(r.date, 'FMDay, FMDDth FMMonth HH24:MI:SS') as datetime "
		. "from reviews r, profile p "
		. "where r.id_reviewed = :id "
		. "and r.id_reviewer = p.id ";

	$qparams[":id"] = $id;
	
	$q = $db->prepare($sql);
	$q->execute($qparams);
	?>		
		
		<div class="reviews-row">
        	<div class="container">
            	<div class="row family_description_box">
                	<div class="reviews container col-lg-12 col-sm-12 col-xs-12">
						<h3><?php echo $q->rowCount(); ?> <?php echo localization("Reviews", "Avis"); ?></h3>
                    </div>
    <?php
    	while ($review = $q->fetch(PDO::FETCH_ASSOC)) {
			
	?>
                
                    <div class="col-lg-8 col-sm-12 col-xs-12 review-user">
                    	<div class="col-lg-2 col-sm-2 col-xs-2 user-icon-div">
                    		<img class="user-icon" alt="" src="img/Profile_user_icon.png" />
                            <div class="font-color"><?php echo $review['name']; ?></div>
                        </div>
                        <div class="col-lg-10 col-sm-10 col-xs-10 review-byuser"> 
                        	<div class="font-color"><?php echo $review['review']; ?></div> 
                            <div  class="font-color"><?php echo $review['datetime']; ?></div>  
                        </div>
                    </div>
    <?php
    	}
    }
			
	?>                                  
                </div>
            </div>
        </div>

            <div id="Success" class="modal fade" role="dialog">
            	<div class="modal-dialog">
                	<div class="modal-content" style="padding:30px;">
                    <h3><?php echo localization("Congratulations!",
                    "Bravo!"); ?></h3>
                    <h4><?php echo localization("Your booking has been done successfully.",
                    "Votre réservation a été confirmée."); ?></h4>
                    </div> 
            	</div>
			</div>
			
            <div id="SendMail" class="modal fade" role="dialog">
            	<div class="modal-dialog">
                	<div class="modal-content">
                       <form accept-charset="UTF-8" name="mailform">
                    	<div class="modal-header">
                        	<button type="button" class="close" data-dismiss="modal">×</button>
                        	<?php echo localization("Finalize booking", "Confirmer la réservation"); ?>             
                        </div>
        				<div class="modal-body">
          						<p>
									<?php echo localization("You selected the following services:",
									"Récapitulatif de votre commande:"); ?>
								</p>          						
          						<ul id="selectedServices" class="list-group">
								</ul>
          						<p>
									<?php echo localization("In order to confirm your booking, please complete this form.",
									"Afin de finaliser la transaction, veuillez remplir le formulaire ci-dessous."); ?>
								</p>
          						<p>
									<?php echo localization("Your details will be sent to the family, who will contact you to follow up.",
									"Vos coordonnées seront transmisent à la famille pour qu'ils puissent vous contacter."); ?>									
								</p>
          						<p>
                                 <label for="first_name"><?php echo localization("Enter your first name","Prénom"); ?>*:</label>
            						<input id="first_name" name="first_name" type="text" value="" class="input-large input-block" placeholder="<?php echo localization("Enter your first name", "Entrez votre prénom"); ?>">
          						
                                 <label for="last_name<?php echo localization("Enter your last name", "Nom"); ?>*:</label>
            						<input id="last_name" name="last_name" type="text" value="" class="input-large input-block" placeholder="<?php echo localization("Enter your last name", "Entrez votre nom"); ?>">
          						
                                 <label for="email_from"><?php echo localization("Enter your e-mail address", "Mail adresse"); ?>*:</label>
            						<input id="email_from" name="email_from" type="email" multiple pattern="^([\w+-.%]+@[\w-.]+\.[A-Za-z]{2,4},*[\W]*)+$" value="" class="input-large input-block" placeholder="<?php echo localization("Enter your e-mail address", "Entrez votre adresse mail"); ?>">
          						
                                 <label for="phone_number"><?php echo localization("Enter your phone number", "Numéro de téléphone"); ?>:</label>
            						<input id="phone_number" name="phone_number" type="text" value="" class="input-large input-block" placeholder="<?php echo localization("Enter your phone number", "Entrez votre téléphone"); ?>">
          						
          				  			<label for="comments"><?php echo localization("Additional comments","Commentaires"); ?>:</label>
           							 <textarea id="comments" name="comments" rows="3" placeholder="<?php echo localization("Please enter your comments here!", "Entrez vos commentaires ici !"); ?>"></textarea>
          						</p>
          						<span class="share-error"></span>
        					</div>
                     <div class="modal-footer">
                         <input class="btn btn-primary" name="commit" type="submit" value="<?php echo localization("Book", "Réserver"); ?>">
                     </div>
                     
                     </div>
                      </form>
                </div>
             
            </div>
	</div>

<?php include 'login-modal.php.inc';?>			 
			 
<?php include 'footer.php.inc';?>

</body>

<?php include 'endpage.php.inc';?>

<?php require 'destroy.php.inc';?>







