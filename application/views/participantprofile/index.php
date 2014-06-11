<script src="<?php echo base_url(); ?>js/sha.js"></script>

<style>
	.mess{
		background: #FCFCF0;
	}
	.mer{
		display:none;
	}
	.red {
		color: red;
		font-size: 18px;
	}
	.alert-error {
	    color: #E74C3C;
	    border: 2px solid #E74C3C !important;
	    box-shadow: none;
	}
	.alert-error .input:focus{
	  border-color: #e74c3c;
	  -webkit-box-shadow: none;
	  -moz-box-shadow: none;
	  box-shadow: none;
	}
	.cap{
		text-transform: capitalize;
	}
</style>

<noscript>Please Enable javascript to view this Page Correctly.</noscript>


<script>
	$(document).ready(function() 
    { 
         $('.dateMe').datepicker({
		    todayBtn: "linked",
		    multidate: false,
		    format: "yyyy-mm-dd",
		    autoclose: true,
		    todayHighlight: true
		});
    } );
</script>

<script src="<?php echo base_url(); ?>js/script.js"></script> 

<script>
	$( document.body ).on( 'click', '.dropdown-menu li', function( event ) {
 
	   var $target = $( event.currentTarget );
	 
	   $target.closest( '.btn-group' )
	      .find( '[data-bind="label"]' ).text( $target.text() )
	         .end()
	      .children( '.dropdown-toggle' ).dropdown( 'toggle' );
	 
	   return false;
	 
		});

	function setOne(){
		var boxes = document.getElementById("checkers");
		hideIt( boxes.checked );	
	}

	function hideIt( num ){
		removeCol = document.getElementById('checkMe');
		if( num ) {
			document.getElementById('permProvince').style.display = 'none';
			document.getElementById('permCity').style.display = 'none';
			document.getElementById('permHouse').style.display = 'none';
			document.getElementById('permRegion').style.display = 'none';
			removeCol.removeAttribute('colspan');
			deleteMe('foreign_perm_tr');
		}
		else{
			document.getElementById('permHouse').removeAttribute('class');
			document.getElementById('permRegion').removeAttribute('class');
			document.getElementById('permProvince').removeAttribute('class');
			document.getElementById('permCity').removeAttribute('class');

			document.getElementById('permHouse').style.display = '';
			document.getElementById('permRegion').style.display = '';
			document.getElementById('permProvince').style.display = '';
			document.getElementById('permCity').style.display = '';
			removeCol.setAttribute('colspan',2);
		}
	}	
</script>

<script type="text/javascript">
	window.setTimeout("closeHelpDiv();", 2000);
	function closeHelpDiv(){
		document.getElementById("helpdiv").style.display=" none";
	}
</script>

</head>

<div class="span9" style="margin-left: -30px" id="bodyMe">
<?php
	foreach($emails as $email){
?>
	<input type="hidden" name="mails[]" value="<?php echo $email; ?>" />
<?php }?>

	<div class="content">

		<td id="pagefield">

		<div id="profileCont">

		<div id="err_dev" class="panel panel-danger" style="display:none">
		  <div class="panel-heading">Warning!</div>
		  <div class="panel-body">
		    <p id="notSeen" style="display:none">Your E-mail is already taken by another user.</p>
		    <p id="invalid" style="display:none">Please enter valid email.</p>
		  </div>
		</div>

		<div id="err_dev2" class="panel panel-danger" style="display:none">
		  <div class="panel-heading">Warning!</div>
		  <div class="panel-body">
		    <p id="date_invalid_univ" style="display:none">Start Date should be less than End Date in Colleges and Universities Attended</p>
		    <p id="date_invalid_emp" style="display:none">Start Date should be less than End Date in Emplyment History</p>
		  </div>
		</div>

		<?php if($message!='' && $error){?>
		<div class="panel panel-danger">
		  <div class="panel-heading">Warning!</div>
		  <div class="panel-body">
		    <p><?php echo $message; ?></p>
		  </div>
		</div>
		<?php }?>

		<?php if($message!='' && !$error){?>
		<div id="helpdiv" class="panel panel-info">
		  <div class="panel-heading">Successful!</div>
		  <div class="panel-body">
		    <p><?php echo $message; ?></p>
		  </div>
		</div>
		<?php }?>

		<?php
			switch($role){
				case 0:
					$profile_title = "Admin";
					break;
				case 1:
					$profile_title = "Manager";
					break;
				default:
					$profile_title = "Participant";
					break;
			}
		?>
		<h3 ><?php echo $profile_title." Profile"; ?></h3>
		<hr>
		<?php $this->load->helper('form');
			$class = array('class' => 'form-horizontal'); ?>
		<?php echo form_open('participantprofile/updateDetails',  $class);?>
		<h6>Personal Details<span class="red"> *</span></h6>
			<table class="table table-striped bord mess" style="background: #FCFCF0">
				<tbody>
					<?php
						$class=(form_error('lastName')!=='')?'alert-error':'';
						if($class=='') $class=(form_error('firstName')!=='')?'alert-error':'';
						if($class=='') $class=(form_error('middleName')!=='')?'alert-error':'';
					?>
					<tr class="<?php echo $class; ?>">
						<td>Name</td>
						<td colspan="2">
							<div class="btn-group btn-input clearfix">
							  <input name="lastName" placeholder="Last Name" type="text" class="<?php echo "cap input-medium ".$class; ?> " value="<?php if(!empty($last_name)) echo $last_name; ?>" />
							</div>
							<div class="btn-group btn-input clearfix">
							  <input name="firstName" placeholder="First Name" type="text" class="<?php echo "cap input-medium ".$class; ?> " value="<?php if(!empty($first_name)) echo $first_name; ?>" />
							</div>
							<div class="btn-group btn-input clearfix">
							  <input name="middleName" placeholder="Middle Name" type="text" class="<?php echo "cap input-medium ".$class; ?> " value="<?php if(!empty($middle_name)) echo $middle_name; ?>" />
							</div>
						</td>
					</tr>
					<tr class='<?php $class = (form_error('username') !== '') ? 'alert-error' : ''; echo $class;?>'>
						<td>User Name</td>
						<td><input class="<?php echo "input-large ".$class; ?>" type="text" id="username"name="username" value="<?php if(!empty($username)) echo $username?>" ></td>
					</tr>
					<tr class='<?php $class = (form_error('gender') !== '') ? 'alert-error' : ''; echo $class;?>'>
						<td>Gender</td>
						<td>
							<div class="btn-group btn-input clearfix">
							<?php $lists = array('Select One', 'Male', 'Female'); ?>
							  <select name="gender" class="<?php echo "select ".$class; ?>" >
							  	<?php foreach($lists as $list): ?>
							   		<option value="<?php echo $list; ?>" <?php if( !empty($gender) && $list==$gender){ ?>selected<?php }?> ><?php echo $list; ?></option>
								<?php endforeach; ?>
							  </select>
							</div>
						</td>
					</tr>
					<?php
						$class=(form_error('year_s')!=='')?'alert-error':'';
						if($class=='') $class=(form_error('month_s')!=='')?'alert-error':'';
						if($class=='') $class=(form_error('day_s')!=='')?'alert-error':'';
					?>
					<tr class='<?php echo $class;?>'>
						<td>Birthday</td>
						<td>
							<?php if(!empty($birth_year) && !empty($birth_month) && !empty($birth_date) ){ ?>
								<input type="hidden" id="yearMe" data-year="<?php echo $birth_year;  ?>" data-month="<?php echo $birth_month; ?>" data-date="<?php echo $birth_date; ?>">
							<?php }else {?>
								<input type="hidden" id="yearMe" data-year="null" data-month="null" data-date="null">
							<?php }?>	
							<div class="btn-group btn-input clearfix">
							  <select id="year_s" name="year_s" class="<?php echo "select ".$class; ?> "></select>
							</div>
							<div class="btn-group btn-input clearfix">
							  <select id="month_s" name="month_s" class="<?php echo "select ".$class; ?>" ></select>
							</div>
							<div class="btn-group btn-input clearfix">
							  <select id="day_s" name="day_s" class="<?php echo "select ".$class; ?>" > </select>
							</div>
							  <script language="javascript">
							  	var datum = document.getElementById('yearMe');
							  	var year = datum.getAttribute('data-year');
							  	var month = datum.getAttribute('data-month');
							  	var date = datum.getAttribute('data-date');
							  	if( year=="null" ) pop_years("year_s", "month_s", "day_s");
							  	else pop_years("year_s", "month_s", "day_s", year, month, date);
							  </script>
						</td>
					</tr>
					<tr class='<?php $class = (form_error('place') !== '') ? 'alert-error' : ''; echo $class;?>'>
						<td>Birth Place</td>
						<td><input class="<?php echo " cap input-large ".$class; ?>" type="text" name="place" <?php if(!empty($birthplace)){ ?> value="<?php echo $birthplace; ?>"<?php }?> ></td>
					</tr>
					<tr class='<?php $class = (form_error('countries_s') !== '') ? 'alert-error' : ''; echo $class;?>'>
						<td>County of Citizenship</td>
						<td>
							<?php if(!empty($country_citizen)){ ?>
								<input type="hidden" id="county_origin" name="county_origin" data-country="<?php echo $country_citizen; ?>">
							<?php } else{?>
								<input type="hidden" id="county_origin" name="county_origin" data-country="null">
							<?php }?>
							<div class="btn-group btn-input clearfix">
							  <select id="countries_s" name="countries_s" class="<?php echo "select ".$class; ?>"></select>
							  <script> 
							  	var datum = document.getElementById('county_origin');
							  	var country = datum.getAttribute('data-country');
							  	if( country == "null" ) pop_year("countries_s");
							  	else pop_year("countries_s", country);
							  </script>
							</div>
						</td>	
					</tr>
					<tr class='<?php $class = (form_error('relationship') !== '') ? 'alert-error' : ''; echo $class;?>'>
						<td>Civil Status</td>
						<td>
							<div class="btn-group btn-input clearfix">
							  <select class="<?php echo "select ".$class ?>" name="relationship" >
							  	<?php $rels = array('-- Relationship -- ', 'Single', 'In a Relationship', 'Engaged', "It's complicated", 'In an Open Relationship', 'Widowed', 'In a Domestic Partnership', 'In a Civil Union'); ?>
								<?php foreach($rels as $rel): ?>
							    <option value="<?php echo $rel; ?>" <?php if( !empty($civil_status) && $rel==$civil_status){ ?>selected="selected"<?php }?> ><?php echo $rel; ?></option>
								<?php endforeach; ?>
							  </select>
							</div>
						</td>
					</tr>
				</tbody>
			</table>
			
		<hr>
		<h6>Contact Details</h6>
			<table class="table table-striped bord mess" id="mobile">
				<tbody>
					<?php for($i=0;$i<$count_num;$i++){?>
					<tr <?php if($i==0){ ?>id="mobiles"<?php }else{ ?><?php echo "id=mob_".($i+1); }?> class='<?php $class = (form_error('mobileNum') !== '') ? 'alert-error' : ''; echo $class;?>'>
						<td width="250" id="mob">Mobile Number <?php if($i==0){ ?>(primary)<span class="red"> *</span><?php }?></td>
						<td width="200"><input onkeyup="javascript:backspacerUP(this,event);" onkeydown="javascript:backspacerDOWN(this,event);" class="<?php echo "input-medium ".$class; ?>" type="text" name="mobileNum[]" required value="<?php if(!empty($number[$i])) echo $number[$i];?>" ></td>
						<?php if($i==0){?><td><button onclick="addrow('mobile',0)" id="mobBut" type="button" class="btn btn-group btn-group-sm btn-inverse"><span id="plus_mob" class="glyphicon glyphicon-plus"></span> <span id="tit_mob" >Add Another</span></button></td><?php }else{?>
						<td><button id="mobBut" class="btn btn-group btn-group-sm btn-warning" type="button" onclick="javascript:deleteRows(<?php echo "mob_".($i+1); ?>);" ><span id="plus_mob" class="glyphicon glyphicon-remove"></span> <span id="tit_mob" >Remove</span></button></td>
						<?php }?>
					</tr>
					<?php }?>
					<?php for($i=0;$i<$count_numLine;$i++){?>
					<tr <?php if($i==0){ ?>id="landline"<?php }else{ ?><?php echo "id=land_".($i+1); ?><?php }?> class='<?php $class = (form_error('mobileNum') !== '') ? 'alert-error' : ''; echo $class;?>' >
						<td width="250" id="land">Landline Number <?php if($i==0){ ?>(primary)<?php }?></td>
						<td width="200"><input onkeyup="javascript:backspacerUP(this,event);" onkeydown="javascript:backspacerDOWN(this,event);" class="<?php echo "input-medium ".$class; ?>" type="text" name="landlineNum[]" value="<?php if(!empty($numberLine[$i])) echo $numberLine[$i]; ?>" ></td>
						<?php if($i==0){ ?><td><button onclick="addrow('mobile',1)" id="landbut" type="button" class="btn btn-group btn-group-sm btn-inverse"><span id="plus_land" class="glyphicon glyphicon-plus"></span><span id="tit_land">Add Another</span></button></td><?php }else{ ?>
						<td><button id="landbut" class="btn btn-group btn-group-sm btn-warning" type="button" onclick="javascript:deleteRows(<?php echo "land_".($i+1); ?>);" ><span id="plus_mob" class="glyphicon glyphicon-remove"></span> <span id="tit_mob" >Remove</span></button></td>
						<?php }?>
					</tr>
					<?php }?>
				</tbody>
			</table>


		<hr>	
		<h6>Student Housing<span class="red"> *</span></h6>
			<table class="table table-striped bord mess" id="met">
				<tbody>
					<tr>
						<th style="background: none repeat scroll 0% 0% #95a5a6; color: #FFF; text-align: center;" colspan="2">
							Present Address
						</th>
					</tr>
					<tr class='<?php $class = (form_error('houseType') !== '') ? 'alert-error' : ''; echo $class;?>'>
						<td width="35%">
							Housing Type
						</td>
						<td>
							<div class="btn-group btn-input clearfix">
							  <select class="<?php echo "select ".$class; ?>" name="houseType">
							  	<?php $homes = array('-- Choose your Housing Type --', 'U.P. Dormitory', 'Boarding House on Campus', 'Boarding House off Campus', 'Own House', 'Rented House', "Relative's/Guardian's House", 'Others'); ?>
								<?php foreach($homes as $home): ?>
									<?php 
									$true = false;
									if(!empty($housing_type) && $housing_type==$home) $true=true;
								?>
							    <option <?php echo set_select('houseType', $home, $true); ?> value="<?php echo $home ?>"<?php if(!empty($housing_type) && $housing_type==$home ){ ?>selected<?php }?> ><?php echo $home; ?></option>
								<?php endforeach; ?>
							  </select>
							</div>
						</td>
					</tr>
					<tr style="display: table-row;" class='<?php $class = (form_error('region_s') !== '') ? 'alert-error' : ''; echo $class;?>'>
						<td>
							Region
						</td>
						<td>
							<div class="btn-group btn-input clearfix">
							  <select class="<?php echo "select sel ".$class; ?>" id="region_s" name="region_s"></select>
							</div>
						</td>
					</tr>
					<tr id="pres_province" style="display: table-row;" class='<?php $class = (form_error('province_s') !== '') ? 'alert-error' : ''; echo $class;?>'>
						<td>
							Province/Chartered City
						</td>
						<td>
							<div class="btn-group btn-input clearfix">
							  <select class="<?php echo "select ".$class; ?>" id="province_s" name="province_s"></select>
							</div>
						</td>
					</tr>
					<tr id="pres_city" id="pres_province" style="display: table-row;" class='<?php $class = (form_error('municipality_s') !== '') ? 'alert-error' : ''; echo $class;?>'>
						<td>
							Municipality/Barangay
						</td>
						<td>
							<div class="btn-group btn-input clearfix">
							  <select class="<?php echo "select ".$class; ?>" id="municipality_s" name="municipality_s"></select>
							</div>
						</td>
					</tr>
					<?php if($address){ ?>
						<input type="hidden" id="present_add" name="present_add" data-region="<?php echo $region; ?>" data-province="<?php echo $province; ?>" data-city="<?php echo $city; ?>">
					<?php }else{?>
						<input type="hidden" id="present_add" name="present_add" data-region="null" >
					<?php }?>
					<script language="javascript">
						var datum = document.getElementById('present_add');
						var region = datum.getAttribute('data-region');
						var province = datum.getAttribute('data-province');
						var city = datum.getAttribute('data-city');
						if( region == "null" ) pop_region("region_s", "province_s", "municipality_s",1,"null", "null", "null");
						else pop_region("region_s", "province_s", "municipality_s", 1, region, province, city);
					</script>
					<tr id="permanent">
						<th style="background: none repeat scroll 0% 0% #95a5a6; color: #FFF; text-align: center;" colspan="2">
							Provincial/Permanent Address
						</th>
					</tr>
					<tr>
						<td colspan="2" id="checkMe">
							<input type="checkbox" name="samePresent" onClick="setOne()" id="checkers" <?php if(!empty($type) && $type){ ?>checked<?php }?>> Same as Present Address
						</td>
					</tr>
					<tr id="permHouse" class='<?php $class = (form_error('houseTypeSame') !== '') ? 'alert-error' : ''; echo $class;?>' <?php if(!empty($type) && $type){?>style="display: none;"<?php }else{?> style="display: table-row;"<?php }?> >
						<td>
							Housing Type
						</td>
						<td colspan="2">
							<div class="btn-group btn-input clearfix">
							  <select id="housetype" name="houseTypeSame" class="<?php echo "select ".$class; ?>">
							  	<?php $homes = array('-- Choose your Housing Type --', 'U.P. Dormitory', 'Boarding House on Campus', 'Boarding House off Campus', 'Own House', 'Rented House', "Relative's/Guardian's House", 'Others'); ?>
								<?php foreach($homes as $home): ?>
								<?php 
									$true = false;
									if(!empty($prov_housing_type) && $prov_housing_type==$home) $true=true;
								?>
							    <option <?php echo set_select('houseTypeSame', $home, $true); ?> value="<?php echo $home; ?>" <?php if(!empty($prov_housing_type) && $prov_housing_type==$home ){ ?>selected<?php }?> ><?php echo $home; ?></option>
								<?php endforeach; ?>
							  </select>
							</div>
						</td>
					</tr>
					<tr id="permRegion" class='<?php $class = (form_error('region_s2') !== '') ? 'alert-error' : ''; echo $class;?>' <?php if(!empty($type) && $type){?>style="display: none;"<?php }else{?> style="display: table-row;"<?php }?>>
						<td>
							Region
						</td>
						<td>
							<div class="btn-group btn-input clearfix">
							  <select class="<?php echo "select sel2 ".$class; ?>" id="region_s2" name="region_s2"></select>
							</div>
						</td>
					</tr>
					<tr id="permProvince" class='<?php $class = (form_error('province_s2') !== '') ? 'alert-error' : ''; echo $class;?>' <?php if((!empty($type) && $type)){?>style="display: none;"<?php }else{?> style="display: table-row;"<?php }?>>
						<td>
							Province/Chartered City
						</td>
						<td>
							<div class="btn-group btn-input clearfix">
							  <select class="<?php echo "select ".$class; ?>" id="province_s2" name="province_s2"></select>
							</div>
						</td>
					</tr>
					<tr id="permCity" class='<?php $class = (form_error('municipality_s2') !== '') ? 'alert-error' : ''; echo $class;?>' <?php if((!empty($type) && $type)){?>style="display: none;"<?php }else{?> style="display: table-row;"<?php }?>>
						<td>
							Municipality/Barangay
						</td>
						<td>
							<div class="btn-group btn-input clearfix">
							  <select class="<?php echo "select ".$class; ?>" id="municipality_s2" name="municipality_s2"></select>
							</div>
						</td>
					</tr>
					<?php if(!empty($prov_address) && $prov_address){ ?>
						<input type="hidden" id="provincial_add" name="provincial_add" data-region="<?php echo $prov_region; ?>" data-province="<?php if(!empty($prov_province)) echo $prov_province; ?>" data-city="<?php if(!empty($prov_city)) echo $prov_city; ?>">
					<?php }else{?>
						<input type="hidden" id="provincial_add" name="provincial_add" data-region="null" >
					<?php }?>

					<?php if(!empty($country)){ ?>
						<input type="hidden" id="prov_county_origin" data-cl='<?php $class = (form_error('foreign_perm') !== '') ? 'alert-error' : ''; echo $class;?>' name="prov_county_origin" data-country="<?php echo $country; ?>">
					<?php } else{?>
						<input type="hidden" id="prov_county_origin" name="prov_county_origin" data-country="null">
					<?php }?>

					<script language="javascript">
						var datum = document.getElementById('provincial_add');
						var datum1 = document.getElementById('prov_county_origin');
						var classes = datum1.getAttribute('data-cl');
					  	var country1 = datum1.getAttribute('data-country');

						var region = datum.getAttribute('data-region');
						var province = datum.getAttribute('data-province');
						var city = datum.getAttribute('data-city');

						if(region=="Foreign"){
							document.getElementById('permProvince').style.display = 'none';
							document.getElementById('permCity').style.display = 'none';
						}

						if( region == "null" || region==-1) pop_region("region_s2", "province_s2", "municipality_s2",0,"null","null","null");
						else {
							var table = document.getElementById('met');
							var tBody = table.tBodies[0];
							var oInp1,www,sss,ttt,h;
							h = document.createElement('div');
							h.setAttribute('class','btn-group btn-input clearfix');

							www = document.createElement('tr');
							sss = document.createElement('td');
							sss.innerHTML = "Country of Origin";
						 	ttt = document.createElement('td');

							oInp1 = document.createElement('select');
						  	oInp1.setAttribute('name', 'foreign_perm');
						  	oInp1.setAttribute('class', 'select '+classes);
						  	oInp1.setAttribute('id', 'countries_s2');

						  	h.appendChild(oInp1);
						  	ttt.appendChild(h);
						  	www.setAttribute('id', 'foreign_perm_tr');
						  	www.setAttribute('class', classes);
						  	//if( country1 == "null" ) www.setAttribute('style', 'display:none');
						  	www.appendChild(sss);
						  	www.appendChild(ttt);//pres_province
						  	tBody.insertBefore(www, tBody.lastChild);
						  	
						  	if( country1 == "null" || country1==-1) pop_year("countries_s2", "");
						  	else pop_year("countries_s2", country1);

							pop_region("region_s2", "province_s2", "municipality_s2",0, region, province, city);
						}	
					</script>
				</tbody>
			</table>
		<hr>

		<h6>Colleges and Universities Attended<span class="red"> *</span></h6>
		<table class="table table-striped bord mess" id="college">
			<thead>
				<tr style="background: none repeat scroll 0% 0% #95a5a6; color: #FFF; text-align: center;">
					<th>School</th>
					<th>Location</th>
					<th>Degreee Recived</th>
					<th>From</th>
					<th>To</th>
					<th><button type="button" onClick="addCollege('college')" class="btn btn-inverse"><span class="glyphicon glyphicon-plus"></span></button></th>
				</tr>
			</thead>
			<tbody>
				<?php for($i=0;$i<$count_col;$i++){?>
				<?php 
					$class = (form_error('inst['.$i.']') !== '') ? 'alert-error' : '';
					$class1 = (form_error('loc['.$i.']') !== '') ? 'alert-error' : '';
					$class2 = (form_error('degree['.$i.']') !== '') ? 'alert-error' : '';
					$class3 = (form_error('from['.$i.']') !== '') ? 'alert-error' : '';
					$class4 = (form_error('to['.$i.']') !== '') ? 'alert-error' : '';
					$all_class = '';
					if(!empty($class) || !empty($class1) || !empty($class2) || !empty($class3) || !empty($class4)) $all_class = 'alert-error';
				?>
				<tr class="<?php echo $all_class;?>">
					<td><input class="<?php echo " cap input-medium ".$class; ?>" placeholder="University of the Philippines" type="text" name="inst[]" value="<?php if(!empty($institute[$i])) echo $institute[$i]; ?>" ></td>
					<td><input class="<?php echo " cap input-medium ".$class1; ?>" placeholder="Quezon City" type="text" name="loc[]" value="<?php if(!empty($local[$i])) echo $local[$i]; ?>" ></td>
					<td><input class="<?php echo " cap input-medium ".$class2; ?>" type="text" placeholder="BS Computer Science" name="degree[]" value="<?php if(!empty($deg[$i])) echo $deg[$i]; ?>" ></td>
					<td><input id="<?php echo "from".$i; ?>" class="<?php echo "input-medium dateMe ".$class3; ?>" type="text" onclick="$(this).datepicker({ todayBtn: 'linked', multidate: false, format: 'yyyy-mm-dd', autoclose: true, todayHighlight: true});" readonly name="from[]" value="<?php if(!empty($from_date[$i])) echo $from_date[$i]; ?>" ></td>
					<td><input id="<?php echo "to".$i; ?>" class="<?php echo "input-medium dateMe ".$class4; ?>" type="text" onclick="$(this).datepicker({ todayBtn: 'linked', multidate: false, format: 'yyyy-mm-dd', autoclose: true, todayHighlight: true});" readonly name="to[]" value="<?php if(!empty($to_date[$i])) echo $to_date[$i]; ?>" ></td>
					<td><button onClick="javascript:del(this,'college')" type="button" class="btn btn-group btn-group-sm btn-warning"><span class="glyphicon glyphicon-remove"></span></button></td>
				</tr>
				<?php }?>
			</tbody>
		</table>

		<hr>

		<h6>Scholastic Honors or Awards Received</h6>
		<table class="table table-striped bord mess" id="awards">
			<thead>
				<tr style="background: none repeat scroll 0% 0% #95a5a6; color: #FFF; text-align: center;">
					<th>Award</th>
					<th>Institution</th>
					<th>Date</th>
					<th><button type="button" onClick="addCollege('awards')" class="btn btn-inverse"><span class="glyphicon glyphicon-plus"></span></button></th>
				</tr>
			</thead>
			<tbody>
				<?php for($i=0;$i<$count_awards;$i++){?>
				<?php 
					$class = (form_error('awards['.$i.']') !== '') ? 'alert-error' : '';
					$class1 = (form_error('inst_awards['.$i.']') !== '') ? 'alert-error' : '';
					$class2 = (form_error('date_awards['.$i.']') !== '') ? 'alert-error' : '';
					$all_class = '';
					if(!empty($class) || !empty($class1) || !empty($class2)) $all_class = 'alert-error';
				?>
				<tr class="<?php echo $all_class; ?>" > 
					<td><input class="<?php echo " cap input-large ".$class; ?>" type="text" value="<?php if(!empty($award[$i])) echo $award[$i]; ?>" name="awards[]"></td>
					<td><input class="<?php echo " cap input-large ".$class1; ?>" type="text" value="<?php if(!empty($institutions[$i])) echo $institutions[$i]; ?>" name="inst_awards[]"></td>
					<td><input class="<?php echo "input-medium dateMe ".$class2 ?>" type="text" readonly onclick="$(this).datepicker({ todayBtn: 'linked', multidate: false, format: 'yyyy-mm-dd', autoclose: true, todayHighlight: true});" value="<?php if(!empty($dateAwards[$i])) echo $dateAwards[$i]; ?>" name="date_awards[]"></td>
					<td><button onClick="javascript:del(this,'awards')" type="button" class="btn btn-group btn-group-sm btn-warning"><span class="glyphicon glyphicon-remove"></span></button></td>
				</tr>
				<?php }?>
			</tbody>
		</table>

		<hr>
		<?php $emp1=FALSE; ?>
		<h6>Employment History<span class="red"> *</span></h6>
		<table class="table bord mess" id="employee">
			<tbody>
			<?php $class = (form_error('employed_s') !== '') ? 'alert-error' : ''; ?>
				<tr colspan="7">
					<th style="background: none repeat scroll 0% 0% #95a5a6; color: #FFF; text-align: center;" colspan="7">
						Employment Status
					</th>
				</tr>
				<tr class="<?php echo $class; ?>">
					<td width="21%">
						<input type="radio" onClick="show_employ(empy,1)" name="employed_s" value="1" <?php if(!empty($emp)) $emp1=($emp==1)?TRUE:FALSE; echo set_radio('employed_s', '1', $emp1); ?> />
					</td>
					<td colspan="6">
						Employed
					</td>
				</tr>
				<tr class="<?php echo $class; ?>">
					<td width="21%">
						<input type="radio" onClick="show_employ(empy,2)" name="employed_s" value="2" <?php if(!empty($emp)) $emp1=($emp==2)?TRUE:FALSE; echo set_radio('employed_s', '2',$emp1); ?> />
					</td>
					<td colspan="6">
						Part Time
					</td>
				</tr>
				<tr class="<?php echo $class; ?>">
					<td width="21%">
						<input type="radio" onClick="show_employ(empy,3)" name="employed_s" value="3" <?php if(!empty($emp)) $emp1=($emp==3)?TRUE:FALSE; echo set_radio('employed_s', '3',$emp1); ?> />
					</td>
					<td colspan="6">
						Unemployed
					</td>
				</tr>

				</tbody>

				<tbody id="empy" <?php if(empty($emp) || $emp==3){ ?> style="display:none"<?php }?> >
				<tr style="background: none repeat scroll 0% 0% #95a5a6; color: #FFF; text-align: center;">
					<th>Name of Company</th>
					<th>Designation</th>
					<th>Industry</th>
					<th>From</th>
					<th>To</th>
					<th><button type="button" onClick="addCollege_2('employee')" class="btn btn-inverse"><span class="glyphicon glyphicon-plus"></span></button></th>
				</tr>
				<?php for($i=0;$i<$count_employ;$i++){?>
				<?php 
					$class = (form_error('companies['.$i.']') !== '') ? 'alert-error' : '';
					$class1 = (form_error('positions['.$i.']') !== '') ? 'alert-error' : '';
					$class2 = (form_error('industry_s['.$i.']') !== '') ? 'alert-error' : '';
					$class3 = (form_error('date_empStart['.$i.']') !== '') ? 'alert-error' : '';
					$class4 = (form_error('date_empEnd['.$i.']') !== '') ? 'alert-error' : '';
					$all_class = '';
					if(!empty($class) || !empty($class1) || !empty($class2) || !empty($class3) || !empty($class4) ) $all_class = 'alert-error';
				?>
				<tr class="<?php echo $all_class; ?>">
				<?php
					$industries = array('Select One','Advertising','Agriculture and Forestry', 'Automotive', 'Consultancy Services', 'Energy', 'Engineering', 'Fitness', 'Food and Related Products', 'Healthcare', 'Import and Export', 'Industrial Supply', 'Information Technology', 'Manufacturing', 'Retail', 'Security', 'Waste Management');
					$position_s = array('Select One','Entry/Junior Level', 'Intermediate Level', 'Senior Level', 'Lead Level');
				?>
					<td><input class="<?php echo " cap input-medium ".$class; ?>" type="text" value="<?php if(!empty($company_emp[$i])) echo $company_emp[$i]; ?>" name="companies[]"></td>
					<td>
					  <select id="testList" class="<?php echo "select input-medium sel ".$class1; ?>" name="positions[]">
					 	<?php foreach($position_s as $list): ?>
					   		<option value="<?php echo $list; ?>" data-title="This is item 1." data-content="Lots of stuff to say 1" <?php if( !empty($position_emp[$i]) && $list==$position_emp[$i]){ ?>selected<?php }?> > <?php echo $list; ?></option>
						<?php endforeach; ?>
					  </select>
					</td>
					<td>
					  <select name="industry_s[]" class="<?php echo "select input-medium ".$class2; ?>" >
					  	<?php foreach($industries as $list): ?>
					   		<option value="<?php echo $list; ?>" <?php if( !empty($industry[$i]) && $list==$industry[$i]){ ?>selected<?php }?> ><?php echo $list; ?></option>
						<?php endforeach; ?>
					  </select>
					</td>
					<td><input id="<?php echo "from_emp".$i; ?>" class="<?php echo "input-medium dateMe ".$class3; ?>" readonly type="text" onclick="$(this).datepicker({ todayBtn: 'linked', multidate: false, format: 'yyyy-mm-dd', autoclose: true, todayHighlight: true});" value="<?php if(!empty($start_emp[$i])) echo $start_emp[$i]; ?>" name="date_empStart[]"></td>
					<td><input id="<?php echo "to_emp".$i; ?>" class="<?php echo "input-medium dateMe ".$class4; ?>" readonly type="text" onclick="$(this).datepicker({ todayBtn: 'linked', multidate: false, format: 'yyyy-mm-dd', autoclose: true, todayHighlight: true});" value="<?php if(!empty($end_emp[$i])) echo $end_emp[$i]; ?>" name="date_empEnd[]"></td>
					<td><button onClick="javascript:del_2(this,'employee')" type="button" class="btn btn-group btn-group-sm btn-warning"><span class="glyphicon glyphicon-remove"></span></button></td>
				</tr>
				<?php }?>
				</div>
			</tbody>
		</table>
		
		<hr>
		<h6>Contact Emergency<span class="red"> *</span></h6>
		<table class="table table-striped bord mess" id="employee">
			<tbody>
				<?php $class=(form_error('fullName')!=='')?'alert-error':''; ?>
				<tr class="<?php echo $class; ?>">
					<td>Name</td>
					<td colspan="2">
						<div class="btn-group btn-input clearfix">
						  <input name="fullName" type="text" placeholder="Full Name" class="<?php echo " cap input-xlarge ".$class; ?> " value="<?php if(!empty($full_name)) echo $full_name; ?>" />
						</div>
					</td>
				</tr>
				<?php $class=(form_error('relation_to')!=='')?'alert-error':''; ?>
				<tr class="<?php echo $class; ?>">
					<td>Relationship</td>
					<?php $relation_tos = array('Select One','Parent', 'Guardian', 'Sibling'); ?>
					<td colspan="2">
						<div class="btn-group btn-input clearfix">
							<select name="relation_to" class="<?php echo "select ".$class; ?>" >
							  	<?php foreach($relation_tos as $list): ?>
							   		<option value="<?php echo $list; ?>" <?php if( !empty($relationships) && $list==$relationships){ ?>selected<?php }?> ><?php echo $list; ?></option>
								<?php endforeach; ?>
							</select>
						</div>
					</td>
				</tr>
				<?php $class=(form_error('mobile_other')!=='')?'alert-error':''; ?>
				<tr class="<?php echo $class; ?>">
					<td>Mobile Number</td>
					<td colspan="2">
						<div class="btn-group btn-input clearfix">
						  <input name="mobile_other" type="text" onkeyup="javascript:backspacerUP(this,event);" onkeydown="javascript:backspacerDOWN(this,event);" class="<?php echo " cap input-medium ".$class; ?> " value="<?php if(!empty($mobile_to)) echo $mobile_to; ?>" />
						</div>
					</td>
				</tr>
				<?php $class=(form_error('landline_other')!=='')?'alert-error':''; ?>
				<tr class="<?php echo $class; ?>">
					<td>Landline Number(Optional)</td>
					<td colspan="2">
						<div class="btn-group btn-input clearfix">
						  <input name="landline_other" type="text" onkeyup="javascript:backspacerUP(this,event);" onkeydown="javascript:backspacerDOWN(this,event);" class="<?php echo " cap input-medium ".$class; ?> " value="<?php if(!empty($landline_to)) echo $landline_to; ?>" />
						</div>
					</td>
				</tr>
				<?php $class=(form_error('email_other')!=='')?'alert-error':''; ?>
				<tr class="<?php echo $class; ?>">
					<td>E-mail Address</td>
					<td colspan="2">
						<div class="btn-group btn-input clearfix">
						  <input name="email_other" type="text" placeholder="email@gmail.com" class="<?php echo "input-xlarge ".$class; ?> " value="<?php if(!empty($email_to)) echo $email_to; ?>" />
						</div>
					</td>
				</tr>
				<?php $class=(form_error('address_other')!=='')?'alert-error':''; ?>
				<tr class="<?php echo $class; ?>">
					<td>Address</td>
					<td colspan="2">
						<div class="btn-group btn-input clearfix">
						  <input name="address_other" type="text" placeholder="Paco, Manila" class="<?php echo "cap input-xlarge ".$class; ?> " value="<?php if(!empty($address_to)) echo $address_to; ?>" />
						</div>
					</td>
				</tr>
			</tbody>
		</table>

		<hr>
		<br/>
		<input type='hidden' name='course_id' value='<?php echo $course_id;?>' />
		<center><button type='submit' class="btn btn-success btn-large" onClick="return checkDate()" name = 'submit'/>SUBMIT<i class="glyphicon glyphicon-send"></i></button></center><br/>
	
		</div>
		
								
		</td>

		<?php echo form_close();?>
</div>
</div>

<script type="text/javascript">
	var count = 1;

	function addCollege(new_id){
		var table = document.getElementById(new_id);
		var rows = table.getElementsByTagName("tbody")[0].getElementsByTagName("tr").length;

		if (!table) return;
		var tBody = table.tBodies[0];
		newRow = table.rows[1].cloneNode(true);
		var inputs = newRow.getElementsByTagName('input');

		for (var i=0, iLen=inputs.length; i<iLen; i++) {
		    inputs[i].value = '';
		    if(i==3) inputs[i].setAttribute('id', 'from'+rows);
		    else if(i==4) inputs[i].setAttribute('id', 'to'+rows);
		}
		tBody.insertBefore(newRow, tBody.lastChild);
		$('.dateMe').click();
	}

	function addCollege_2(new_id){
		var table = document.getElementById(new_id);
		var rows = table.getElementsByTagName("tbody")[1].getElementsByTagName("tr").length;

		if (!table) return;
		var tBody = table.tBodies[1];
		newRow = table.rows[5].cloneNode(true);
		var inputs = newRow.getElementsByTagName('input');

		for (var i=0, iLen=inputs.length; i<iLen; i++) {
		    inputs[i].value = '';
		    if(i==1) inputs[i].setAttribute('id', 'from_emp'+(rows-1));
		    else if(i==2) inputs[i].setAttribute('id', 'to_emp'+(rows-1));
		}
		tBody.insertBefore(newRow, tBody.lastChild);
		$('.dateMe').click();
	}

	function show_employ(empy,val){
		var table = document.getElementById('empy');
		if(val==1 || val==2) table.style.display = '';
		else table.style.display = 'none';
	}

    function addrow(text,num) {
        var table = document.getElementById(text);
		if (!table) return;

		var string, newRow, but, plus, tit, n;
		var tBody = table.tBodies[0];
		if(!num){			
			string = document.getElementById('landline');
			newRow = setButtons(table,'mobBut', 'mobiles', 'mob', 'plus_mob', 'tit_mob', 'Mobile', 0);			
		} else {
			string = tBody.lastChild;
			newRow = setButtons(table,'landbut', 'landline', 'land', 'plus_land', 'tit_land', 'Landline', 1);
		}

		if(!num){
			var inp = document.getElementById('mob');
			inp.innerHTML = 'Mobile Number (primary) <span class="red">*</span>';
		} else {
			var inp = document.getElementById('land');
			inp.innerHTML = 'Landline Number (primary)';
		}

		  // Now get the inputs and modify their names 
		var inputs = newRow.getElementsByTagName('input');

		for (var i=0, iLen=inputs.length; i<iLen; i++) {
		    inputs[i].value = ''
		}

		  // Add the new row to the tBody (required for IE)
		tBody.insertBefore(newRow, string);
		count++;
    }

    function CheckBrowser(){
	    if(navigator.userAgent.match(/Android/i)!=null||
	        navigator.userAgent.match(/BlackBerry/i)!=null||
	        navigator.userAgent.match(/iPhone|iPad|iPod/i)!=null||
	        navigator.userAgent.match(/Nokia/i)!=null||
	        navigator.userAgent.match(/Opera M/i)!=null||
	        navigator.userAgent.match(/Chrome/i)!=null)
	        {
	            return 'OTHER';
	    }else{
	            return 'IE';
	    }
	}

	function setButtons(table, button_id, tr_id, tr_change, span_icon_id, title_id, title, num){
		var inp = document.getElementById(tr_change);
		inp.innerHTML = title+' Number';				

		but = document.getElementById(button_id);
		n = document.getElementById(tr_id);
		n.setAttribute('id', tr_change+'_'+count);
		but.setAttribute('class','btn btn-group btn-group-sm btn-warning');
		if(CheckBrowser()=='IE'){
	        but.setAttribute("onclick",'javascript:deleteRows('+tr_change+'_'+count+');');
	    }else{
	        but.setAttribute('onclick','javascript:deleteRows('+tr_change+'_'+count+');');
	    }

	    plus = document.getElementById(span_icon_id);
		plus.setAttribute('class','glyphicon glyphicon-remove');
		tit = document.getElementById(title_id);
		tit.innerHTML = 'Remove';

		var newRow = document.getElementById(tr_change+'_'+count).cloneNode(true);;
		if(!num) newRow = table.rows[0].cloneNode(true);

		but.setAttribute('class','btn btn-group btn-group-sm btn-inverse');
		plus.setAttribute('class','glyphicon glyphicon-plus');
		tit.innerHTML = 'Add Another';
		if(CheckBrowser()=='IE'){
	        but.setAttribute("onclick", 'javascript:addrow("mobile",'+num+');');
	    }else{
	        but.setAttribute('onclick','javascript:addrow("mobile",'+num+');');
	    }					

	    n = document.getElementById(tr_change+'_'+count);
		n.setAttribute('id', tr_id);
		return newRow;
	}

    function deleteRows(row)
	{		
	    document.getElementById('mobile').deleteRow(row.rowIndex);
	}

	function validateForm(name)
	{
		var x = document.getElementById(name).value;
		var atpos = x.indexOf("@");
		var dotpos = x.lastIndexOf(".");
		if (atpos<1 || dotpos<atpos+2 || dotpos+2>=x.length){
		  return false;
		}
		return true;
	}

	function checkDate(){
		var rows = document.getElementById('college').getElementsByTagName("tbody")[0].getElementsByTagName("tr").length;
		var err = 1; var err2 = 1; var err3 = 1;

		for(var i=0;i<rows;i++){
			var startDate = new Date($('#from'+i).val());
			var endDate = new Date($('#to'+i).val());

			if (startDate > endDate){
				document.getElementById('date_invalid_emp').style.display = 'none';
				document.getElementById('date_invalid_univ').style.display = '';
				document.getElementById('err_dev2').style.display = '';
			    err = 0;
			    break;
			}
		}

		if(document.getElementById('empy').style.display != 'none') if(!checkDate_emp()) err2 = 0;

		var err3 = 0; var err4 = 0;
		var name = document.getElementById('username').value;

		if(!validateForm('username')){
			document.getElementById('invalid').style.display = '';
			document.getElementById('notSeen').style.display = 'none';
			document.getElementById('err_dev').style.display = '';
			err3 = 1;
		}
		else{
			document.getElementById('invalid').style.display = 'none';
			document.getElementById('notSeen').style.display = 'none';
			document.getElementById('err_dev').style.display = 'none';
			err3 = 0;
		}

		if(!err3){
			if(checkExist(name)){
				document.getElementById('notSeen').style.display = '';
				document.getElementById('err_dev').style.display = '';
				err4 = 1;
			}else{
				document.getElementById('notSeen').style.display = 'none';
				document.getElementById('err_dev').style.display = 'none';
				err4 = 0;
			}
		}
		
		var mess = false;
		if(!err3 && !err4) mess = true;

		if(!err || !err2 || !mess) return false;
		else return true;
	}

	function checkDate_emp(){
		var rows = document.getElementById('employee').getElementsByTagName("tbody")[1].getElementsByTagName("tr").length;

		for(var i=0;i<rows;i++){
			var startDate = new Date($('#from_emp'+i).val());
			var endDate = new Date($('#to_emp'+i).val());

			if (startDate > endDate){
			    document.getElementById('date_invalid_emp').style.display = '';
				document.getElementById('err_dev2').style.display = '';
			    return false;
			}
		}
		return true;
	}

	function checkMail(){
		var err = 0; var err2 = 0;
		var name = document.getElementById('username').value;

		if(!validateForm('username')){
			document.getElementById('invalid').style.display = '';
			document.getElementById('notSeen').style.display = 'none';
			document.getElementById('err_dev').style.display = '';
			err = 1;
		}
		else{
			document.getElementById('invalid').style.display = 'none';
			document.getElementById('notSeen').style.display = 'none';
			document.getElementById('err_dev').style.display = 'none';
			err = 0;
		}

		if(!err){
			if(checkExist(name)){
				document.getElementById('notSeen').style.display = '';
				document.getElementById('err_dev').style.display = '';
				err2 = 1;
			}else{
				document.getElementById('notSeen').style.display = 'none';
				document.getElementById('err_dev').style.display = 'none';
				err2 = 0;
			}
		}

		var mess = false;
		if(!err && !err2) mess = true;
		else return mess;
	}

	function checkExist(compare){
		var boxes = bodyMe.getElementsByTagName("input");
		for( i = 0; i < boxes.length; i++ ){
			myType = boxes[i].getAttribute("type");
			myvalue = boxes[i].value;
			if( myType == "hidden" ) {
				if(compare.trim()==myvalue.trim()) return true;
			}	
		}
		return false;
	}

	function del(row, title)
	{		
	    var rows = document.getElementById(title).getElementsByTagName("tbody")[0].getElementsByTagName("tr").length;
	    var i=row.parentNode.parentNode.rowIndex;
	    if(rows > 1) document.getElementById(title).deleteRow(i);
	}

	function del_2(row, title)
	{		
	    var rows = document.getElementById(title).getElementsByTagName("tbody")[1].getElementsByTagName("tr").length;
	    var i=row.parentNode.parentNode.rowIndex;
	    if(rows > 2) document.getElementById(title).deleteRow(i);
	}

	$('body').on('change', '.sel2', function(){
		var selectedRegionIndex = document.getElementById( 'region_s2' ).selectedIndex;
		var string = '';
		if( selectedRegionIndex == 18 ){
		  string = 'none';
		}

		document.getElementById('permProvince').style.display = string;
		document.getElementById('permCity').style.display = string;

		if( selectedRegionIndex != 18 ){
			deleteMe('foreign_perm_tr');
			return;
		}

		var table = document.getElementById('met');
		var tBody = table.tBodies[0];
		var oInp1,www,sss,ttt,h;
		h = document.createElement('div');
		h.setAttribute('class','btn-group btn-input clearfix');

		www = document.createElement('tr');
		sss = document.createElement('td');
		sss.innerHTML = "Country of Origin";
	 	ttt = document.createElement('td');

		oInp1 = document.createElement('select');
	  	oInp1.setAttribute('name', 'foreign_perm');
	  	oInp1.setAttribute('class', 'select');
	  	oInp1.setAttribute('id', 'countries_s2');

	  	h.appendChild(oInp1);
	  	ttt.appendChild(h);
	  	www.setAttribute('id', 'foreign_perm_tr');
	  	www.appendChild(sss);
	  	www.appendChild(ttt);//pres_province
	  	tBody.insertBefore(www, tBody.lastChild);
	  	pop_year("countries_s2");
	});

	function deleteMe(tr_id){
		var row = document.getElementById(tr_id);
		document.getElementById('met').deleteRow(row.rowIndex);
		document.getElementById('permProvince').removeAttribute('style');
		document.getElementById('permProvince').setAttribute('class', 'mer');

		document.getElementById('permCity').removeAttribute('style');
		document.getElementById('permCity').setAttribute('class', 'mer');

		document.getElementById('permHouse').removeAttribute('style');
		document.getElementById('permHouse').setAttribute('class', 'mer');

		document.getElementById('permRegion').removeAttribute('style');
		document.getElementById('permRegion').setAttribute('class', 'mer');
	}
</script>


<script>
<!-- //This script is based on the javascript code of Roman Feldblum (web.developer@programmer.net) -->
<!-- //Original script : http://javascript.internet.com/forms/format-phone-number.html -->
<!-- //Original script is revised by Eralper Yilmaz (http://www.eralper.com) -->
<!-- //Revised script : http://www.kodyaz.com/content/HowToAutoFormatTelephoneNumber.aspx -->

var zChar = new Array(' ', '(', ')', ' ', '.');
var maxphonelength = 14;
var phonevalue1;
var phonevalue2;
var cursorposition;

function ParseForNumber1(object){
	phonevalue1 = ParseChar(object.value, zChar);
}
function ParseForNumber2(object){
	phonevalue2 = ParseChar(object.value, zChar);
}

function backspacerUP(object,e) { 
	if(e){ 
		e = e 
	} else {
		e = window.event 
	} 
	if(e.which){ 
		var keycode = e.which 
	} else {
		var keycode = e.keyCode 
	}

	ParseForNumber1(object)

	if(keycode >= 48){
		ValidatePhone(object)
	}
}

function backspacerDOWN(object,e) { 
	if(e){ 
		e = e 
	} else {
		e = window.event 
	} 
	if(e.which){ 
		var keycode = e.which 
	} else {
		var keycode = e.keyCode 
	}
	ParseForNumber2(object)
} 

function GetCursorPosition(){
    
	var t1 = phonevalue1;
	var t2 = phonevalue2;
	var bool = false
    for (i=0; i<t1.length; i++)
    {
    	if (t1.substring(i,1) != t2.substring(i,1)) {
    		if(!bool) {
    			cursorposition=i
    			bool=true
    		}
    	}
    }
}

function ValidatePhone(object){
	
	var p = phonevalue1
	
	p = p.replace(/[^\d]*/gi,"")

	if (p.length < 3) {
		object.value=p
	} else if(p.length==3){
		pp=p;
		d4=p.indexOf('(')
		d5=p.indexOf(')')
		if(d4==-1){
			pp="("+pp;
		}
		if(d5==-1){
			pp=pp+")";
		}
		object.value = pp;
	} else if(p.length>3 && p.length < 7){
		p ="(" + p;	
		l30=p.length;
		p30=p.substring(0,4);
		p30=p30+")"

		p31=p.substring(4,l30);
		pp=p30+p31;

		object.value = pp;	
		
	} else if(p.length >= 7){
		p ="(" + p;	
		l30=p.length;
		p30=p.substring(0,4);
		p30=p30+")"
		
		p31=p.substring(4,l30);
		pp=p30+p31;
		
		l40 = pp.length;
		p40 = pp.substring(0,8);
		p40 = p40 + "-"
		
		p41 = pp.substring(8,l40);
		ppp = p40 + p41;
		
		object.value = ppp.substring(0, maxphonelength);
	}
	
	GetCursorPosition()
	
	if(cursorposition >= 0){
		if (cursorposition == 0) {
			cursorposition = 2
		} else if (cursorposition <= 2) {
			cursorposition = cursorposition + 1
		} else if (cursorposition <= 5) {
			cursorposition = cursorposition + 2
		} else if (cursorposition == 6) {
			cursorposition = cursorposition + 2
		} else if (cursorposition == 7) {
			cursorposition = cursorposition + 4
			e1=object.value.indexOf(')')
			e2=object.value.indexOf('-')
			if (e1>-1 && e2>-1){
				if (e2-e1 == 4) {
					cursorposition = cursorposition - 1
				}
			}
		} else if (cursorposition < 11) {
			cursorposition = cursorposition + 3
		} else if (cursorposition == 11) {
			cursorposition = cursorposition + 1
		} else if (cursorposition >= 12) {
			cursorposition = cursorposition
		}

        var txtRange = object.createTextRange();
        txtRange.moveStart( "character", cursorposition);
		txtRange.moveEnd( "character", cursorposition - object.value.length);
        txtRange.select();
    }

}


function ParseChar(sStr, sChar)
{
    if (sChar.length == null) 
    {
        zChar = new Array(sChar);
    }
    else zChar = sChar;
    
    for (i=0; i<zChar.length; i++)
    {
        sNewStr = "";
    
        var iStart = 0;
        var iEnd = sStr.indexOf(sChar[i]);
    
        while (iEnd != -1)
        {
            sNewStr += sStr.substring(iStart, iEnd);
            iStart = iEnd + 1;
            iEnd = sStr.indexOf(sChar[i], iStart);
        }
        sNewStr += sStr.substring(sStr.lastIndexOf(sChar[i]) + 1, sStr.length);
        
        sStr = sNewStr;
    }
    
    return sNewStr;
}

</script>

<script>
    $(function() {
	    var tooltips = $( "[title]" ).tooltip();
	    $(document)(function() {
	    	tooltips.tooltip( "open" );
	    })
    });   
</script>


<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <!-- Include all compiled plugins (below), or include individual files as needed -->