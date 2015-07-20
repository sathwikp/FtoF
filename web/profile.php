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
$sql = 	"select p.name, p.description, p.avatar, p.big_picture, p.location_id "
	. "from profile p "
	. "where p.id = :id ";
	//. "and period @> '["
	//. $arrival_date->format('Y-m-d').", "
	//. $departure_date->format('Y-m-d')."]'::daterange "


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
            <a href="index.php" class="navbar-brand"><img src="img/F2F_word_blue.png" class="img-responsive"/><img src="img/beta.png" class="img-responsive" style="width:35px;margin-top:-86px;margin-left:-15px;"/></a>
                <button class="navbar-toggle" data-toggle="collapse" data-target=".navHeaderCollapse">
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
            <div class="collapse navbar-collapse navHeaderCollapse">
                <ul class="nav navbar-nav navbar-right">
                    <li><a href="index.php"><?php echo localization("Home", "Accueil"); ?></a></li>         <?php if ($user->is_loggedin()) echo '<li><a href="profile.php">Profile</a></li>' ; ?>  
                    <li><?php echo $user->is_loggedin() ? '<a href="logout.php"> ' .localization("Logout", "Deconnection").'</a>' : '<a href="javascript:void(0)" data-toggle="modal" onclick="openLoginModal();">' .localization("Sign up/Login", "Inscription/Connection").'</a>'; ?></li>
               </ul>
          </div>
        </div>
 	</div>
 	<div>
	<div class="col-lg-1 col-sm-12 col-xs-12" style="background:#fff">
	</div>
	<div class="family-card-image col-lg-7 col-sm-12 col-xs-12" style="background-image:url('img/profile/pics/<?php echo $profile['big_picture'];?>')">
		<p style="margin-top: 11%;text-align:center;font-weight: bold;color: #fff;"><?php echo localization("Please email us your family picture at family2family.email@gmail.com.", "Family2Family est encore en version Beta pour changer votre photo de profil, merci de nous envoyer un mail à family2family.email@gmail.com"); ?></p>
	</div>
    <div class="col-lg-3 col-sm-12 col-xs-12" style="background:#fff;margin-top: 0%;border: 1px solid #E4CFCF;height: 520px;width:21%;">
    	<div class="col-lg-9 col-sm-3 col-xs-3" style="margin-top: 10%; text-align:center;">
					<span class="avatar-container" style="background-image:url('img/profile/avatars/<?php echo $profile['avatar'];?>')">
					
					</span>
				</div>
				<div class="family-highlight col-lg-12 col-sm-6 col-xs-6" style="
    margin-top: 25px; text-align:center;">
					<h2 style="text-align:center;" class="edit" id="name"><?php echo $profile['name']; ?></h2>
					<div class="font-color"><select  class="form-control" id="locationSelect">
					<option <?php echo $profile['location_id'] ? '' : 'selected' ; ?> disabled>Choose a location</option>
<?php
{
$sql = 	"select id, name "
	. "from porref_nearest "
	. "where countrycode = 'FR' "
	. "and locationtype = 'C' "
	. "order by name ASC ";
	//. "and period @> '["
	//. $arrival_date->format('Y-m-d').", "
	//. $departure_date->format('Y-m-d')."]'::daterange "


	
$q = $db->prepare($sql);
$q->execute();

while($loc = $q->fetch(PDO::FETCH_ASSOC)) {
	$selected = ($loc['id']==$profile['location_id'])?'selected':'';
	echo '<option value="'.$loc['id'].'" '.$selected.'>'.$loc['name'].'</option>';
}


}

?>					
					</select></div>
					
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
                        <p class="font-color"><div class="edit_area" id="description"><?php echo $profile['description']; ?></div></p>
                    </div>
                </div>
            </div>
        </div>
        <a name="service-list" />
        <div class="service-update-row">
        	<div class="container">
    <?php 


	{
	$qparams = [];
	$sql = 	"select ctid, service_type, available, to_char(lower(period),'MM/DD/YYYY') as from, to_char(upper(period),'MM/DD/YYYY') as to, price_fix, price_per_day, service_desc "
		. "from offered_service "
		. "where profile_id = :id "
		. "order by service_type, period ";
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
                		<form  action="editservice.php" method="post">
                		<input type="hidden" name="ctid" value="<?php echo $service['ctid']; ?>">
						<div class="form-inline">
						<label>
						<select class="form-control" name="type">
							<?php
							foreach(ServiceType::GetTypes() as $k => $v) {
								$selected = ($k==$service['service_type']) ? 'selected' : '';
								echo '<option value="'.$k.'" '.$selected.'>'.$v.'</option>';
							}
							?>
						</select>
						</label>
						 <label>
                        <input placeholder="<?php echo localization("Available from", "Disponible du"); ?>" type="text" name="from" class="datepicker form-control" value="<?php echo $service['from']; ?>" >
                        </label>
                        <label>
                        <input placeholder="<?php echo localization("Until", "Jusqu'à"); ?>" type="text" name="to" class="datepicker form-control" value="<?php echo $service['to']; ?>">
                        </label>
						<label>
						<div class="input-group">
						<input name="price" placeholder="<?php echo localization("Price per day", "Prix par jour"); ?>" type="text" value="<?php echo $service['price_per_day']; ?>" class="form-control" style="width:70px">
						<span class="input-group-addon">&euro;/day</span>
						</div>
						</label>
						<label>
						<input type="submit" value="Save" class="form-control">
						</label>
						</div>
						<div class="form-inline">
						<textarea class="form-control" rows="3" style="width:700px" name="desc" placeholder="<?php echo localization("Add a brief description about the service you are providing", "Add a brief description about the service you are providing"); ?>"><?php echo $service['service_desc'];?></textarea>
												
						<label>
						<a class="btn btn-default" href="delservice.php?ctid=<?php echo $service['ctid']; ?>">Delete</a>
						</label>
						
						</div>
						</form>
                    </div>   
                  
                </div>                
            
            <?php

		}

	}
	?>
				
		        <div class="row item-divider" style="text-align:right">
					<a class="btn btn-default" href="addservice.php">Add service</a>
                </div>				
        	</div>
		</div>
			 
<?php include 'footer.php.inc';?>

</body>

<?php include 'endpage.php.inc';?>

<?php require 'destroy.php.inc';?>







