<head>
<style>
	.panel {
	  margin-bottom: 20px;
	  background-color: #fff;
	  border: 1px solid transparent;
	  border-radius: 4px;
	  -webkit-box-shadow: 0 1px 1px rgba(0, 0, 0, .05);
	          box-shadow: 0 1px 1px rgba(0, 0, 0, .05);
	}
	.panel-body {
	  padding: 15px;
	  border-bottom: 1px solid #bdc3c7;
	}
	.panel-heading {
	  padding: 10px 15px;
	  border-bottom: 1px solid transparent;
	  border-top-left-radius: 3px;
	  border-top-right-radius: 3px;
	}
	.panel-success {
	  border-color: #2ecc71;
	}
	.panel-success > .panel-heading {
	  color: white;
	  background-color: #2ecc71;
	  border-color: #2ecc71;
	}
	.panel-success > .panel-heading + .panel-collapse .panel-body {
	  border-top-color: #d6e9c6;
	}
	.panel-success > .panel-footer + .panel-collapse .panel-body {
	  border-bottom-color: #d6e9c6;
	}
</style>
</head>

<body>
	<div style="height: 108px; margin-left: -10px; width: 100%; background-color: #5e0000; background-image: url('<?php echo base_url('css/images/strip.png'); ?>');">
		<table style="border-collapse: collapse; margin-top: -3px;" >
			<tr>				
				<td style="width: 180px">
					<img src="<?php echo base_url('css/images/pic.png'); ?>" style="margin-top: -1px;"/> 
				</td>
			</tr>
		</table>
	</div>

<div
	style="
	margin-top: 10px;
	margin-bottom: 20px;
	  background-color: #fff;
	  border: 1px solid transparent;
	  border-radius: 4px;
	  -webkit-box-shadow: 0 1px 1px rgba(0, 0, 0, .05);
	          box-shadow: 0 1px 1px rgba(0, 0, 0, .05);
	border-color: #2ecc71;
	"
>
  <div 
  	style="
  	 color: white;
	  background-color: #2ecc71;
	  border-color: #2ecc71;
	  border-top-color: #d6e9c6;
	  padding: 10px 15px;
	  border-bottom: 1px solid transparent;
	  border-top-left-radius: 3px;
	  border-top-right-radius: 3px;"
	><?php echo $kind; ?></div>
  <div style="
  	padding: 15px;
	  border-bottom: 1px solid #bdc3c7;
	">
    <p>
    	<?php if($numS == 6){ ?>
			<?php $link = "localhost/meteor"; ?>
			<strong>Thank You!</strong><br/><br/>Your request for the course <strong><?php echo $tempCourseName;?></strong> is now for the approval of the administrator. You will be notified if the administrator approved the request.
			If You have any comments, suggestions, and reactions, feel free to contact us at <a style='color: #2ECC71; text-decoration: none; font-size: 15px' href='localhost/meteor'>localhost/meteor</a>
			<?php return ;?>
		<?php }elseif( $numS == 5 ){ ?>
			<?php $link = "localhost/meteor"; ?>
			<strong>Congratulations <?php echo $firstname; ?>!</strong><br/><br/>You are added as one of the managers for MeTEOR (My eUP Training Events and Online Registration).<br/><br/>
			Your username is: <a style="color: #2ECC71; text-decoration: none; font-size: 15px"><?php echo $username; ?></a><br/>Your temporary password is: <a style="color: #2ECC71; text-decoration: none; font-size: 15px"><?php echo $password;?></a><br/><br/>Please sign in at 
		<?php }elseif( $numS == 4 ){ ?>
			The requested-course <strong><?php echo $CourseName; ?></strong>, you've confirmed to attend, has been automatically deleted by the system. It is not yet approved by the administrator before the starting date of the said course.
		<?php return;
		}elseif( $numS == 3 ){ ?>
			<?php $link = "localhost/meteor/index.php/finalStepRequest/".$ident."/".$unique; ?>
			<strong>A final Step to confirm your Attendance for <?php echo $CourseName;?>!</strong><br/><br/>Please click the proceeding link to confirm your slot:<br/>
		<?php }elseif( $numS == 2 ){ ?>
			<?php $link = "localhost/meteor/index.php/confirmRequest/".$unique."/".$CourseName; ?>
			<strong>A CONFIRMATION of ATTENDANCE for <?php echo $tempCourseName;?> has been sent to you!</strong><br/><br/>Please click the proceeding link to SIGN UP or LOGIN at MeTEOR:<br/>
		<?php }elseif(!$numS){ ?>
			<?php $link = "localhost/meteor/index.php/validate/".$ident; ?>
	 		<strong>Thank You Registering!</strong><br/>Please click the proceeding link to confirm your registration:<br/>
	  <?php } else {?>
		  <?php $link = "localhost/meteor/index.php/changePassword/".$ident; ?>
	  Hello <?php echo $firstname.",<br/><br/>"; ?><strong>You have recently change your password.</strong><br/><br/>Please click the proceeding link to enter at MeTEOR and set your new password:<br/>
	  <?php }?>
	  <a style="color: #2ECC71; text-decoration: none; font-size: 15px" href="<?php echo $link;?>"><?php echo $link;?></a>.
    </p>
  </div>
</div>
</body>