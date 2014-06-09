<body>
<style>
	#head{
		height: 169px;
		margin-top: -10px;
		margin-left: -10px;
		width: 105%;
		background-color: #5e0000;
	}

	#logo{
		width: 300px;
	}

	#headercont{
		border-collapse: collapse;
	}

	.titleX{
		font: 10px gothic;
	}

	h1 {
	  margin: 10px 0;
	  font-family: inherit;
	  font-weight: bold;
	  line-height: 20px;
	  color: inherit;
	  text-rendering: optimizelegibility;
	}

	h1,
	h2,
	h3 {
	  line-height: 40px;
	}

	h1 {
	  font-size: 38.5px;
	}

	.up {
	  font-size: 31.5px;
	  font-weight: bold;
	}
</style>

<div>
	<br/>
	<div style="padding: 60px;
	  margin-bottom: 30px;
	  font-size: 18px;
	  font-weight: 200;
	  line-height: 30px;
	  color: inherit;
	  background-color: #eeeeee;
	  -webkit-border-radius: 6px;
	     -moz-border-radius: 6px;
	          border-radius: 6px;" >
		<div style=" padding: 8px 35px 8px 14px;
	  margin-bottom: 20px;
	  text-shadow: 0 1px 0 rgba(255, 255, 255, 0.5);
	  color: #468847;
	  background-color: #dff0d8;
	  border-color: #d6e9c6;
	  border: 1px solid #fbeed5;
	  -webkit-border-radius: 4px;
	     -moz-border-radius: 4px;
	          border-radius: 4px;">	
			<?php $link = "http://localhost/meteor/index.php/validate/".$ident; ?>
		  <strong>You have recently change your password.</strong><br/>Please click the proceeding link to enter at MeTEOR and set your new password:<br/><a style="color: #0088cc;
	  text-decoration: none;" href="<?php echo $link;?>"><?php echo $link;?></a>.
		</div>
	</div>
</div>
</body>