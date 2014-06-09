<head>
<link rel="stylesheet" href="<?php echo base_url(); ?>css/styleTemplate.css" type="text/css">
<link rel="stylesheet" href="<?php echo base_url(); ?>css/styleGeneral.css" type="text/css">
<link rel="stylesheet" href="<?php echo base_url(); ?>css/view.css" type="text/css">
<link href="<?php echo base_url(); ?>css/css_recipes.css" rel="stylesheet" type="text/css">
</head>

<body>
<div id="body_box1">
	<h1>
		<center>
		<th style="width: 100%">
			<div style="border:none;background-color: #cccc99; margin-left: -20px; font-size:40px; margin-right: -60px; color: red"><center>
			<img style="vertical-align: center;" src="<?php echo base_url(); ?>css/images/thimthumb5.png" />
			</center></div>
		</th>
		</center>
	</h1>
	<table id="body_table" border="0">
		<td id="pagefield">
			<table border="0">	
				<div id="profileInfo">
						<h2><center onMouseOver="ddrivetip('Android 4.0( Ice Cream Sandwich ) and above', '', 310)"; onMouseOut="hideddrivetip()" 
							style="color:#a42125;">Screenshots
						</center></h2>
						<center><div >
							<img onMouseOver="ddrivetip('Login Page', '', 100)"; onMouseOut="hideddrivetip()" src="<?php echo base_url(); ?>css/images/signin.png" />
							<img onMouseOver="ddrivetip('Sign Up Page', '', 100)"; onMouseOut="hideddrivetip()" src="<?php echo base_url(); ?>css/images/signup.png" />
							<img onMouseOver="ddrivetip('Reserving a Slot', '', 110)"; onMouseOut="hideddrivetip()" src="<?php echo base_url(); ?>css/images/reserve.png" />
							<img onMouseOver="ddrivetip('List of Courses', '', 100)"; onMouseOut="hideddrivetip()" src="<?php echo base_url(); ?>css/images/upcoming.png" />
						</div>
						<h2>Tips:</h2>
						When reserving a course, the last reserved course is highlighted in yellow, unless there is a conflict with other reserved courses, in which case the courses are highlighted in red.<br /></center>
				</div>	
			</table>
		</td>
	</table>
</div>
</body>
<div id="dhtmltooltip"></div>
<script language="javascript" src="<?php echo base_url(); ?>js/tooltip.js" type="text/javascript"></script>