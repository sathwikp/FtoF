<?php require 'init.php.inc';?>

<?php

if (!$user->is_loggedin()) {
	redirect_to_home();
}
$id = intval($_SESSION['user_session']);
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
                    <li><?php echo $user->is_loggedin() ? '<a href="logout.php"> ' .localization("Logout", "Deconnection").'</a>' : '<a href="javascript:void(0)" data-toggle="modal" onclick="openLoginModal();">' .localization("Sign up/Login", "Inscription/Connection").'</a>'; ?></li>
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
            	<div class="row item-divider" style="<?php if ($i++%2==0) echo 'background-color: #F9F9F9;'; ?>border-bottom:none;text-align:center" >
                	<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
						<label>
						<select name="type__<?php echo $i; ?>">
							<?php
							foreach(ServiceType::GetTypes() as $k => $v) {
								$selected = ($k==$service['service_type']) ? 'selected' : '';
								echo '<option value="'.$k.'" '.$selected.'>'.$v.'</option>';
							}
							?>
						</select>
						</label>
						 <label>
                        <input placeholder="<?php echo localization("Available from", "Disponible du"); ?>" type="text" name="from__<?php echo $i; ?>" class="datepickerFrom" value="" >
                        </label>
                        <label>
                        <input placeholder="<?php echo localization("Until", "Jusqu'à"); ?>" type="text" name="to__<?php echo $i; ?>" class="datepickerTo" value="">
                        </label>
						<label>
						<input name="price__<?php echo $i; ?>" placeholder="<?php echo localization("Price per day", "Prix par jour"); ?>" type="text">
						</label>
						
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







