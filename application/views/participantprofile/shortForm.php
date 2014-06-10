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
	    border-color: #E74C3C;
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

<script type="text/javascript">
	window.setTimeout("closeHelpDiv();", 2000);
	function closeHelpDiv(){
		document.getElementById("helpdiv").style.display=" none";
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
		return mess;
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
</script>

</head>

<div class="span9" id="bodyMe" style="margin-left: -30px">
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
		<?php echo form_open('participantprofile/updateShortForm',  $class);?>
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
							  <input name="lastName" required placeholder="Last Name" type="text" class="<?php echo "cap input-large ".$class; ?> " value="<?php if(!empty($last_name)) echo $last_name; ?>" />
							</div>
							<div class="btn-group btn-input clearfix">
							  <input name="firstName" required placeholder="First Name" type="text" class="<?php echo "cap input-large ".$class; ?> " value="<?php if(!empty($first_name)) echo $first_name; ?>" />
							</div>
							<div class="btn-group btn-input clearfix">
							  <input name="middleName" required placeholder="Middle Name" type="text" class="<?php echo "cap input-large ".$class; ?> " value="<?php if(!empty($middle_name)) echo $middle_name; ?>" />
							</div>
						</td>
					</tr>
					<tr class='<?php $class = (form_error('username') !== '') ? 'alert-error' : ''; echo $class;?>'>
						<td>User Name</td>
						<td><input class="<?php echo "input-xlarge ".$class; ?>" type="text" id="username" required name="username" value="<?php if(!empty($username)) echo $username?>" ></td>
					</tr>
					<tr class='<?php $class = (form_error('c_unit') !== '') ? 'alert-error' : ''; echo $class;?>'>
						<td>Constituent Unit</td>
						<td><input class="<?php echo " cap input-xlarge ".$class; ?>" type="text" required name="c_unit" <?php if(!empty($c_unit)){ ?> value="<?php echo $c_unit; ?>"<?php }?> ></td>
					</tr>
					<tr class='<?php $class = (form_error('office') !== '') ? 'alert-error' : ''; echo $class;?>'>
						<td>Office</td>
						<td><input class="<?php echo " cap input-xlarge ".$class; ?>" type="text" required name="office" <?php if(!empty($office)){ ?> value="<?php echo $office; ?>"<?php }?> ></td>
					</tr>
					<tr class='<?php $class = (form_error('position') !== '') ? 'alert-error' : ''; echo $class;?>'>
						<td>Position/Designation</td>
						<td><input class="<?php echo " cap input-xlarge ".$class; ?>" type="text" required name="position" <?php if(!empty($position)){ ?> value="<?php echo $position; ?>"<?php }?> ></td>
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
						<td width="200"><input onkeyup="javascript:backspacerUP(this,event);" required onkeydown="javascript:backspacerDOWN(this,event);" class="<?php echo "input-large ".$class; ?>" type="text" name="mobileNum[]" required value="<?php if(!empty($number[$i])) echo $number[$i];?>" ></td>
						<?php if($i==0){?><td><button onclick="addrow('mobile',0)" id="mobBut" type="button" class="btn btn-group btn-group-sm btn-inverse"><span id="plus_mob" class="glyphicon glyphicon-plus"></span> <span id="tit_mob" >Add Another</span></button></td><?php }else{?>
						<td><button id="mobBut" class="btn btn-group btn-group-sm btn-warning" type="button" onclick="javascript:deleteRows(<?php echo "mob_".($i+1); ?>);" ><span id="plus_mob" class="glyphicon glyphicon-remove"></span> <span id="tit_mob" >Remove</span></button></td>
						<?php }?>
					</tr>
					<?php }?>
					<?php for($i=0;$i<$count_numLine;$i++){?>
					<tr <?php if($i==0){ ?>id="landline"<?php }else{ ?><?php echo "id=land_".($i+1); ?><?php }?> class='<?php $class = (form_error('mobileNum') !== '') ? 'alert-error' : ''; echo $class;?>' >
						<td width="250" id="land">Landline Number <?php if($i==0){ ?>(primary)<?php }?></td>
						<td width="200"><input onkeyup="javascript:backspacerUP(this,event);" onkeydown="javascript:backspacerDOWN(this,event);" class="<?php echo "input-large ".$class; ?>" type="text" name="landlineNum[]" value="<?php if(!empty($numberLine[$i])) echo $numberLine[$i]; ?>" ></td>
						<?php if($i==0){ ?><td><button onclick="addrow('mobile',1)" id="landbut" type="button" class="btn btn-group btn-group-sm btn-inverse"><span id="plus_land" class="glyphicon glyphicon-plus"></span><span id="tit_land">Add Another</span></button></td><?php }else{ ?>
						<td><button id="landbut" class="btn btn-group btn-group-sm btn-warning" type="button" onclick="javascript:deleteRows(<?php echo "land_".($i+1); ?>);" ><span id="plus_mob" class="glyphicon glyphicon-remove"></span> <span id="tit_mob" >Remove</span></button></td>
						<?php }?>
					</tr>
					<?php }?>
				</tbody>
			</table>

		<hr>
		<br/>
		<input type='hidden' name='course_id' value='<?php echo $course_id;?>' />
		<center><button type='submit' class="btn btn-success btn-large" onclick="return checkMail()" name='submit'/>SUBMIT<i class="glyphicon glyphicon-send"></i></button></center><br/>
	
		</div>
		
								
		</td>

		<?php echo form_close();?>
</div>
</div>

<script type="text/javascript">
	var count = 1;

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