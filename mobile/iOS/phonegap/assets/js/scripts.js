function login_auth(){
	//get token from localstorage
	if (localStorage.getItem("token") === null){
		//user not logged in, continue to login page
		$.mobile.changePage("index.html");
	}
	
}

//edit_profile

$(document).on('pagebeforeshow',"#edit_profile",function(){		
	$('#input_firstname').val(localStorage.firstName);
	$('#input_lastname').val(localStorage.lastName);
	$('#input_email').val(localStorage.email);
	if(localStorage.mobile!="null")
		$('#input_mobile').val(localStorage.mobile);	
	if(localStorage.address1!="null")
		$('#input_street').val(localStorage.address1);		
	if(localStorage.address2!="null")
		$('#input_neighborhood').val(localStorage.address2);		
	if(localStorage.address3!="null")
		$('#input_city').val(localStorage.address3);
	$('#edit_profile_form').submit(function(){
		var querystring = $('#edit_profile_form').serialize();
		querystring += "&token="+encodeURIComponent(localStorage.token);
		console.log(querystring);
		$('[type="submit"]').button('disable');
		$("#edit_profile_loader_wrapper").html("<img  style='padding-left:45%;padding-bottom:5%;'src='assets/img/ajax-loader.gif'/>");
		
		$.ajax({
			url: "http://meteor.upsitf.org/mobile/iOS/webservice/edit_profile.php", 
			type: "POST",
			data: querystring,
			dataType: "json",
			timeout: 10000,
			success: function(data) {		
				console.log(data);
				var header = data['header'];
				if(header == 0){
					//error
				}
				else if(header == 1){
					//success
					$.mobile.changePage("profile.html");
				}	
			},
			error: function(x, t, m) {
				if(t==="timeout") {
					$("#edit_profile_loader_wrapper").html("Request timed out. Check your connection");
				} else {
					$("#edit_profile_loader_wrapper").html("ERROR: ");
				}
			}
		});		
		return false;
	});
})

//logout.html
function logout(){
	var token = localStorage.token;
	$('[type="submit"]').button('disable');
	$("#load_wrapper").html("<img  style='padding-top:5%;'src='assets/img/ajax-loader.gif'/>");	
	$.ajax({
		url: "http://meteor.upsitf.org/mobile/iOS/webservice/logout.php", 
		type: "POST",
		data: { "session_ID": token},
		dataType: "json",
		timeout: 10000,
		success: function(data) {
			$('[type="submit"]').button('enable');
			var header = data['header'];
			if(header == 1){
				//logout success
				localStorage.removeItem("token");
				localStorage.removeItem("firstName");
				localStorage.removeItem("lastName");
				localStorage.removeItem("email");
				localStorage.removeItem("mobile");
				localStorage.removeItem("address1");
				localStorage.removeItem("address2");
				localStorage.removeItem("address3");
				localStorage.removeItem("address");
				$.mobile.navigate("index.html");									
			}
			else if(header == 0){
				//logout fail
				// console.log(token);
			}		
		},
		error: function(x, t, m) {
			$('[type="submit"]').button('enable');
			if(t==="timeout") {
					$("#load_wrapper").html("Request timed out. Check your connection");
				} else {
					$("#load_wrapper").html("ERROR: ");
				}
		}
	});							
}						

var message;

//courses.html
message = "\
		<h1>:(</h1>\
		<h2>Sorry.</h2>\
		<p>No more courses are available at the moment. The ITDC team is working hard so they can provide more!</p>\
		<a data-role='button' href='splash.html' data-transition='fade' data-theme='a'>Okay!</a>\
";

list = "<ul data-role='listview' data-theme='d'  data-filter='true' data-filter-placeholder='Search courses' data-filter-theme='d' data-count-theme='d' id='course_list'></ul>";
populate_course_list("get_courses.php","#courses","#course_list","#course_container",message,list);

//my_courses_reserved.html
message = "\
		<h2>Oops!</h2>\
		<p>You don't have any reserved courses!</p>\
		<p>Why don't you check out upcoming courses? I'm sure you'll find one that suits your interests. :)</p>\
		<a data-role='button' href='courses.html' data-transition='none' data-theme='a'>Oh, thanks!</a>\
";
list = "<ul data-role='listview' data-theme='d' data-inset='true' data-count-theme='d' id='reserved_course_list'></ul>";
populate_course_list("get_reserved_courses.php","#my_courses_reserved","#reserved_course_list","#reserved_course_container",message,list);

//my_courses_paid.html
message = "\
		<p>You haven't paid for any courses yet.</p>\
		<p>...or have you? </p><p>Check out your reserved courses and submit your payment details to get tagged! :)</p>\
		<a data-role='button' href='my_courses_reserved.html'  data-transition='none' >Sure! Thanks!</a>\
		<a data-role='button' href='how_to_pay.html' data-theme='b'  data-transition='none' >I haven't paid, help!</a>\
";
list = "<ul data-role='listview' data-theme='d'  data-inset='true'  data-count-theme='d' id='paid_course_list'></ul>";
populate_course_list("get_paid_courses.php","#my_courses_paid","#paid_course_list","#paid_course_container",message,list);



//view_courses.html
$(document).on('pagebeforeshow',"#single_course",function(){
	var id, name, description, cost, total, reserved, paid, availablestart, end, venue;
	var html = "";
	var token = localStorage.token;
	var course_id = location.search.replace("?id=","").replace("#","").replace("#","");
	//show loading screen
	// console.log(course_id);	
	$.ajax({
		url: "http://meteor.upsitf.org/mobile/iOS/webservice/get_single_course.php", 
		type: "POST",
		data: { 'course_id' : course_id, 'token' : token},
		dataType: "json",
		timeout: 10000,
		success: function(data) {
			console.log(data);
			id = data['courses']['0']['id'];
			name = data['courses']['0']['name'];
			description = data['courses']['0']['description'];
			cost = data['courses']['0']['cost'];
			start = parseDate(data['courses']['0']['start']);
			end = parseDate(data['courses']['0']['end']);
			venue = data['courses']['0']['venue'];
			reserved = parseInt(data['courses']['0']['reserved']);
			paid = parseInt(data['courses']['0']['paid']);
			total = parseInt(data['courses']['0']['available']);
			available = total - reserved - paid;

			var action_form = "";
			
			if(data['courses']['0']['user_reserved']==1){
				//change reserve button  to cancel
				action_form = cancel_form();
				if(data['courses']['0']['user_paid']==0){
					//add payment link if not yet paid but reserved
					action_form += "<div id='payment_button_div'><a id='payment_link' href='pay_course.html?id="+course_id+"' data-role='button'>Submit payment details</a></div>";
				}
			}
			else if(data['courses']['0']['user_paid']==0){
				action_form = reserve_form();
			}

			// console.log(data['courses']['0']['user_paid']);
			if(data['courses']['0']['user_paid']==1){
				//additional payment info
				$('#slot_info').css("display",'none');				
				$('#payment_info').css("display",'block');
				$('#payment_status').html("Submitted");
				$('#remarks').html(data['payment_info']['0']['remarks']);
				$('#or_number').html(data['payment_info']['0']['ornumber']);
				
				$('#back_button').attr('href','my_courses_paid.html');		
			}
			else if(data['courses']['0']['user_reserved']==1){
				$('#back_button').attr('href','my_courses_reserved.html');		
			}
			else{
				$('#back_button').attr('href','courses.html');			
			}
			$("#course_name").html(name);
			$("#start_date").html(start);
			$("#end_date").html(end);
			$("#fee").html(cost);
			$("#venue").html(venue);
			$("#description").html(description);
			$("#total_slots").html(total);
			$("#available_slots").html(available);
			
			//
			
			$("#course_action").html(action_form);

			$("#loader").css('display','none');
			$("#view_course").trigger('create');
			//bind form submit handlers
			if(data['courses']['0']['user_paid']!=1){
				if(data['courses']['0']['user_reserved']==1){
					cancel_course();
				}
				else{
					reserve_course();
				}
			}

			//disable reserve button if no slots are available
			if(available==0){
				$('[type="submit"]').button('disable');
			}		
		},
		error: function(x, t, m) {
			$('[type="submit"]').button('enable');
			if(t==="timeout") {
					$("#loader").html("Request timed out. Check your connection");
				} else {
					$("#loader").html("ERROR: ");
				}
		}
	});	
});

//pay_course.html
$(document).on('pagebeforeshow',"#pay_course",function(){
	$('#course_link').attr('href','view_course.html'+location.search);
	
	$('#pay_course').submit(function(){
		//disable buttons and form fields
		$('[type="submit"]').button('disable');  
		$('#payment_field').append("<img style='padding-left:45%;padding-top:20px;'src='assets/img/ajax-loader.gif'/>");		
		$(".ui-btn-active").removeClass('ui-btn-active');	
		var token = localStorage.token;
		var course_id = location.search.replace("?id=","").replace("#","");
		var or_number = $('#input_or_number').val();
		var remarks = $('#input_remarks').val();
		var amount = $('#input_amount').val();
		$.ajax({
			url: "http://meteor.upsitf.org/mobile/iOS/webservice/pay_course.php", 
			type: "POST",
			data: { course_id: course_id, amount : amount, token : token, or_number : or_number, remarks : remarks},
			dataType: "json",
			timeout: 10000,
			success: function(data) {
				$.mobile.changePage("view_course.html"+location.search, {transition:'fade'});
			},
			error: function(x, t, m) {
				$('[type="submit"]').button('enable');
				if(t==="timeout") {
						$("#payment_field").html("Request timed out. Check your connection");
					} else {
						$("#payment_field").html("ERROR: ");
					}
			}
		});	

	});
});


$(document).on('pagebeforeshow',"#profile",function(){
	// console.log("localStorage");
	console.log(localStorage);
	var querystring = {token : localStorage.token};
	var address1, address2, address3;
	$("#user_profile").html("<img style='padding-top:50%;padding-left:45%;'src='assets/img/ajax-loader.gif'/>");		
	$.ajax({
		url: "http://meteor.upsitf.org/mobile/iOS/webservice/get_profile.php", 
		type: "POST",
		data: querystring,
		dataType: "json",
		timeout: 10000,
		success: function(data) {
			// console.log(data);
			localStorage.firstName = data['response']['0'];
			localStorage.lastName = data['response']['1'];
			localStorage.email = data['response']['2'];
			localStorage.mobile = data['response']['3'];
			localStorage.address1 = data['response']['4'];
			localStorage.address2 = data['response']['5'];
			localStorage.address3 = data['response']['6'];
			
			localStorage.address = "";
			if(localStorage.address1 !== null && localStorage.address1 != "null"){
				localStorage.address += localStorage.address1;
			}
			if(localStorage.address2 !== null && localStorage.address2 != "null"){
				if(localStorage.address != "")
					localStorage.address += ", ";
				localStorage.address += localStorage.address2;			
			}
				
			if(localStorage.address3 !== null && localStorage.address3 != "null"){
				if(localStorage.address != "" )
					localStorage.address += ", ";
				localStorage.address += localStorage.address3;
			}
			
			var name, email, mobile, address;
			
			name = localStorage.firstName+" "+localStorage.lastName;
			
			if(localStorage.email===null)
				email = "No email specified";							
			else
				email = localStorage.email;					
				
			if(localStorage.mobile == "null")
				mobile = "<a href='edit_profile.html' class='ui-btn ui-shadow ui-btn-corner-all ui-btn-up-d'>Add your mobile number</a>";
			else
				mobile = localStorage.mobile;

			if((localStorage.address1=='null')&&(localStorage.address2=='null')&&(localStorage.address3=='null'))			
				address = "<a href='edit_profile.html' class='ui-btn ui-shadow ui-btn-corner-all ui-btn-up-d'>Add your address</a>";
			else
				address = localStorage.address;				
				
			var content = 
				"\
				<div class='profile-info'>\
					<h2>"+name+"</h2>\
					<h4>"+email+"</h4>\
					<h4>"+mobile+"</h4>\
					<h4>"+address+"</h4>\
				</div>\
				<a data-role='button' id='logout_button' style='margin-top:20%;' href='logout.html' data-rel='dialog' data-theme='d'>Logout</a>\
				";
			// console.log(content);
			$("#user_profile").html(content);
			$("#logout_button").button();		
		},
		error: function(x, t, m) {
			$('[type="submit"]').button('enable');
			if(t==="timeout") {
					$("#user_profile").html("Request timed out. Check your connection");
				} else {
					$("#user_profile").html("ERROR: ");
				}
		}
	});	

});

//signup.html
$(document).on('pagebeforeshow',"#signup_page",function(){
	$('#signup_form').submit(function(){
		var querystring = $('#signup_form').serialize();
		$('[type="submit"]').button('disable');
		$('#signup_loader_wrapper').html("<img style='padding-left:45%;'src='assets/img/ajax-loader.gif'/>");
		console.log('request sent');
		$.ajax({
			url: "http://meteor.upsitf.org/mobile/iOS/webservice/signup.php", 
			type: "POST",
			data: querystring,
			dataType: "json",
			timeout: 10000,
			success: function(data) {
				var header = data['header'];
				console.log(header);
				$('[type="submit"]').button('enable');
				$('[type="submit"]').button('refresh');
				if(header == 0){
					$('#signup_loader_wrapper').html("E-mail already registered.");
					$('#input_email').val("");
				}
				else if(header == 1){
					$('#signup_loader_wrapper').html("");
					$.mobile.changePage( "signup_success.html", { role: "dialog"});
				}
				else if(header == 2){
					$('#signup_loader_wrapper').html("Oops! It seems that the mail server is experiencing problems, please try again later. :(");
				}			
			},
			error: function(x, t, m) {
				$('[type="submit"]').button('enable');
				if(t==="timeout") {
						$("#signup_loader_wrapper").html("Request timed out. Check your connection");
					} else {
						$("#signup_loader_wrapper").html("ERROR: ");
					}
			}
		});				
		
		return false;
	});
});


//forgot.html
$(document).on('pagebeforeshow',"#forgot_page",function(){
	$('#forgot_form').submit(function(){
		var querystring = $('#forgot_form').serialize();
				$('[type="submit"]').button('disable');
		$('#forgot_loader_wrapper').html("<img style='padding-left:45%;'src='assets/img/ajax-loader.gif'/>");
		console.log('request sent');
		$.ajax({
			url: "http://meteor.upsitf.org/mobile/iOS/webservice/forgot.php", 
			type: "POST",
			data: querystring,
			dataType: "json",
			timeout: 10000,
			success: function(data) {
				var header = data['header'];
				console.log(header);
				$('[type="submit"]').button('enable');
				$('[type="submit"]').button('refresh');
				if(header == 0){
					$('#forgot_loader_wrapper').html("E-mail not registered to a valid user.");
					$('#input_email').val("");
				}
				else if(header == 1){
					$('#forgot_loader_wrapper').html("Password reset link sent. Check your e-mail!");
				}
				else if(header == 2){
					$('#forgot_loader_wrapper').html("Oops! It seems that the mail server is experiencing problems, please try again later. Sorry! :(");
				}			
			},
			error: function(x, t, m) {
				$('[type="submit"]').button('enable');
				if(t==="timeout") {
						$("#forgot_loader_wrapper").html("Request timed out. Check your connection");
					} else {
						$("#forgot_loader_wrapper").html("ERROR: ");
					}
			}
		});	
			
		
		return false;
	});
});
function parseDate(input) {
  var parts = input.match(/(\d+)/g);
  // new Date(year, month [, date [, hours[, minutes[, seconds[, ms]]]]])
 
  return new Date(parts[0], parts[1]-1, parts[2]).toDateString(); // months are 0-based
}

//cancel course
function cancel_course(){
	//binds submit function to cancel_course form
	$('#cancel_course').submit(function(){
		var token = localStorage.token;
		var course_id = location.search.replace("?id=","").replace("#","");
		$('[type="submit"]').button('disable');
		$('#payment_button_div').html("<img style='padding-top:5%;padding-left:45%;'src='assets/img/ajax-loader.gif'/>");		
		$.ajax({
			url: "http://meteor.upsitf.org/mobile/iOS/webservice/cancel_course.php", 
			type: "POST",
			data: { 'course_id': course_id, 'token' : token},
			dataType: "json",
			timeout: 10000,
			success: function(data) {
				if(data['header']){
				
					//show reserve button again? or go to previous page?
					$("#course_action").html(
						reserve_form()
					).trigger('create');
					var available = parseInt($("#available_slots").html())+1;
					$("#available_slots").html(available);
					reserve_course();
				}			
			},
			error: function(x, t, m) {
				$('[type="submit"]').button('enable');
				if(t==="timeout") {
						$("#payment_button_div").html("Request timed out. Check your connection");
					} else {
						$("#payment_button_div").html("ERROR: ");
					}
			}
		});	
			
		return false;
	});	
}

function reserve_course(){
	//binds submit function to reserve_course form
	$('#reserve_course').submit(function(){
		var token = localStorage.token;
		var course_id = location.search.replace("?id=","").replace("#","");
		$('[type="submit"]').button('disable');
		$("#course_loader").html("<img  style='padding-top:5%;padding-left:45%;'src='assets/img/ajax-loader.gif'/>");
		$.ajax({
			url: "http://meteor.upsitf.org/mobile/iOS/webservice/reserve_course.php", 
			type: "POST",
			data: { 'course_id': course_id, 'token' : token},
			dataType: "json",
			timeout: 10000,
			success: function(data) {
				$("#course_loader").html("");
				if(data['header']==1){
					$("#course_action").html(
						cancel_form()+"<div id='payment_button_div'><a id='payment_link' href='pay_course.html?id="+course_id+"' data-role='button'>Submit payment details</a></div>"
					).trigger('create');
					var available = parseInt($("#available_slots").html())-1;
					$("#available_slots").html(available);
					cancel_course();
				}
				else{
					//transaction failed, no slots left
					$.mobile.changePage("reserve_fail.html");
				}		
			},
			error: function(x, t, m) {
				$('[type="submit"]').button('enable');
				if(t==="timeout") {
						$("#course_loader").html("Request timed out. Check your connection");
					} else {
						$("#course_loader").html("ERROR: ");
					}
			}
		});	
			
		return false;
	});
}

function cancel_form(){
	return "<form id='cancel_course'><button id='cancel_button' type='submit' data-theme='d'>Cancel</button></form>";
}

function reserve_form(){
	return "<form id='reserve_course'><button id='reserve_button' type='submit' data-theme='a'>Reserve</button></form>";
}

//webservice: the php webservice from which data is fetched
//page_id: the id of the page div containing the content
//list_id: the id of the ul element
//container_id: id of the content div
//empty_text: text to display when no results are found
function populate_course_list(webservice, page_id, list_id, container_id,empty_text,list_object){
	$(document).on('pagebeforeshow',page_id,function(){
		var id, name, description, cost, slots, reserved, start;
		var html = "";
		var user_token = localStorage.token;

		//show loading screen
		$(container_id).html("<img style='padding-top:45%;padding-left:45%;'src='assets/img/ajax-loader.gif'/>");		
		$.ajax({
			url: "http://meteor.upsitf.org/mobile/iOS/webservice/"+webservice, 
			type: "POST",
			data: {token : user_token},
			dataType: "json",
			timeout: 10000,
			success: function(data) {
				// console.log(data);
				html = "";
				$.each(data['courses'], function(index, element){
					id = element['id'];
					name = element['name'];
					description = element['description'];
					cost = element['cost'];
					slots = element['slots'] - element['reserved'] - element['paid'];
					start = parseDate(element['start']);
					html += "<li  data-icon='false'><a href='view_course.html?id="+id+"' data-transition='slide'><span class='ui-li-count'>Slots: "+slots+"</span><h3>"+name+"</h3><p>"+description+"</p><small><p>&#x20B1; "+cost+"</p></small><small><p>Starts on: "+start+"</p></small></a></li>";
				});
				if(data['courses'].length == 0){
					html = "<div id='message' style='text-align:center; padding-top:5px;'>"+empty_text+"</div>";
					$(container_id).html(html).trigger('create');
				}
				else{
					$(container_id).html(list_object).trigger('create');
					$(list_id).html(html);
				}
				$(list_id).listview('refresh');			
			},
			error: function(x, t, m) {
				if(t==="timeout") {
						$(container_id).html("Request timed out. Check your connection");
					} else {
						$(container_id).html("ERROR: ");
					}
			}
		});	
	});
}