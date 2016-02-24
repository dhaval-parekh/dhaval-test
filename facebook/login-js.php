<title>Primecart</title>
<link href='https://fonts.googleapis.com/css?family=Passion+One' rel='stylesheet' type='text/css'>
<!-- Bootstrap Core CSS -->
<link href="css1/css/bootstrap.min.css" rel="stylesheet">
<link rel="shortcut icon" href="css/img/favicon1.ico" />
<link rel="stylesheet" type="text/css" href="css1/css/mystyle.css" />
<link rel="stylesheet" type="text/css" href="css1/css/animate-custom.css"/>
<link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
<link rel="stylesheet" href="http://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.3.0/css/font-awesome.min.css">
<link href='https://fonts.googleapis.com/css?family=Open+Sans:400,300italic,300,400italic,600,600italic,700italic,700,800,800italic' rel='stylesheet' type='text/css'>
<link href="css1/css/full-slider.css" rel="stylesheet">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
<script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
<!-- google account js-->

<script>
  // This is called with the results from from FB.getLoginStatus().
  
 
  function checkLoginState() {

	  FB.getLoginStatus(function(response) {

	    statusChangeCallback(response);
		

	  });

	}
 
  
  function statusChangeCallback(response) {

	 

	  if (response.status === 'connected') {

	      // Logged into your app and Facebook.

	      // we need to hide FB login button

	      $('#fblogin').hide();

	      //fetch data from facebook

	     getUserInfo();
		 

	  } else if (response.status === 'not_authorized') {

	      // The person is logged into Facebook, but not your app.

	      $('#status').html('Please log into this app.');

	  } else {

	      // The person is not logged into Facebook, so we're not sure if

	      // they are logged into this app or not.

	      $('#status').html('Please log into facebook');

	  }

	}

	 

	// This function is called when someone finishes with the Login

	// Button.  See the onlogin handler attached to it in the sample code below.

	
  window.fbAsyncInit = function() {
  FB.init({
    appId      : '219518101713829',
    cookie     : true,  // enable cookies to allow the server to access 
                        // the session
    xfbml      : true,  // parse social plugins on this page
    version    : 'v2.2' // use version 2.2
  });

  // Now that we've initialized the JavaScript SDK, we call 
  // FB.getLoginStatus().  This function gets the state of the
  // person visiting this page and can return one of three states to
  // the callback you provide.  They can be:
  //
  // 1. Logged into your app ('connected')
  // 2. Logged into Facebook, but not your app ('not_authorized')
  // 3. Not logged into Facebook and can't tell if they are logged into
  //    your app or not.
  //
  // These three cases are handled in the callback function.

  FB.getLoginStatus(function(response) {
    statusChangeCallback(response);
  });

  };
  
  
 
  function FBLogin()

	{

	      FB.login(function(response) {

	         if (response.authResponse)

	         {

	            getUserInfo();
				

	          } else

	          {

	           alert('Authorization failed.');

	          }

	       },{scope: 'public_profile,email'});

	}
	
 

  // Load the SDK asynchronously
  (function(d, s, id) {
    var js, fjs = d.getElementsByTagName(s)[0];
    if (d.getElementById(id)) return;
    js = d.createElement(s); js.id = id;
    js.src = "//connect.facebook.net/en_US/sdk.js";
    fjs.parentNode.insertBefore(js, fjs);
  }(document, 'script', 'facebook-jssdk'));

  // Here we run a very simple test of the Graph API after login is
  // successful.  See statusChangeCallback() for when this call is made.
 
 

  function getUserInfo() {

	    FB.api('/me',{fields: 'id,name,email'}, function(response) {
			
			
			
			
	       

	      $.ajax({
	            type: "POST",

	            dataType: 'json',

	            data: response,

	            url: 'index.php?route=account/forgotten',

	            success: function(json) {

	             if(json.error== 1)

	             {

	              alert('Something Went Wrong!');

	             } else {

	               //window.location.href = "home";
				   //$('#status').html('successfully login');
				  

	              $('#fblogin').hide();

	              

	             }
	            }

	      });

	 

	    });

	}
  function FBLogout()

	{

	  FB.logout(function(response) {

	       $('#fblogin').show(); //showing login button again

	       $('#fbstatus').hide(); //hiding the status

	  });

	}
</script>
<script>

window.fbAsyncInit = function() {
    FB.init({
        appId   : '219518101713829',
        oauth   : true,
        status  : true, // check login status
        cookie  : true, 
		version    : 'v2.2',// enable cookies to allow the server to access the session
        xfbml   : true // parse XFBML
		
    });

  };

function fb_login(){
	$('.loder').show('fast');
    FB.login(function(response) {

        if (response.authResponse) {
            console.log('Welcome!  Fetching your information.... ');
            //console.log(response); // dump complete info
            access_token = response.authResponse.accessToken; //get access token
            user_id = response.authResponse.userID; //get FB UID
			console.log(user_id);

            FB.api('/me',{fields: 'id,first_name,last_name,email'}, function(response) {
				  
				  console.log(response);
				
				
				 $.ajax({
	            type: "POST",

	            dataType: 'json',

	            data: response,

	            url: 'index.php?route=account/forgotten',

	            success: function(json) {

	             if(json.error== 1)

	             {

	              alert('Something Went Wrong!');

	             } else {
					 $('.loder').hide('fast');

	             window.location.href = "home";
				   //$('#status').html('successfully login');
				  

	              

	              

	             }
	            }

	      });
               
				 //get user email
          // you can store this data into your database             
            });

        } else {
            //user hit cancel button
            console.log('User cancelled login or did not fully authorize.');

        }
    }, {
        scope: 'public_profile,email,publish_actions,user_about_me'
    });
}
(function() {
    var e = document.createElement('script');
    e.src = document.location.protocol + '//connect.facebook.net/en_US/all.js';
    e.async = true;
    //document.getElementById('fb-root').appendChild(e);
}());

</script>

<!--google plus -->
<script type="text/javascript">
 
function logout()
{
    gapi.auth.signOut();
    location.reload();
}
function login() 
{
  var myParams = {
    'clientid' : '99700316464-k7ed7mqlfvsncb0759uaci7m8776v6fu.apps.googleusercontent.com',
    'cookiepolicy' : 'single_host_origin',
    'callback' : 'loginCallback',
    'approvalprompt':'force',
    'scope' : 'https://www.googleapis.com/auth/plus.login https://www.googleapis.com/auth/plus.profile.emails.read'
  };
  gapi.auth.signIn(myParams);
}
 
function loginCallback(result)
{
    if(result['status']['signed_in'])
    {
        var request = gapi.client.plus.people.get(
        {
            'userId': 'me'
        });
        request.execute(function (resp)
        {
            var email = '';
            if(resp['emails'])
            {
                for(i = 0; i < resp['emails'].length; i++)
                {
                    if(resp['emails'][i]['type'] == 'account')
                    {
                        email = resp['emails'][i]['value'];
                    }
                }
            }
			var name = resp['displayName'];
			var gid = resp['id'];
			
			
			$.ajax({
	            type: "POST",

	            dataType: 'json',

	            data: 'email='+email +'&id='+gid +'&name='+name,

	            url: 'index.php?route=account/account/gmail',

	             success: function(json) {

	             if(json.error== 1)

	             {

	              alert('Something Went Wrong!');

	             } else {
					 $('.loder').hide('fast');

	             window.location.href = "home";
				   //$('#status').html('successfully login');
				
	             }
	            }

	      });
		
        });
 
    }
 
}
function onLoadCallback()
{
    gapi.client.setApiKey('AIzaSyBoz0pMRqyj_1Om0q0-cUwe3FYzWPWsY7Y ');
    gapi.client.load('plus', 'v1',function(){});
}
 
    </script>
<script type="text/javascript">
      (function() {
       var po = document.createElement('script'); po.type = 'text/javascript'; po.async = true;
       po.src = 'https://apis.google.com/js/client.js?onload=onLoadCallback';
       var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(po, s);
     })();
</script>
</script>

<!-- <script type="text/javascript">
	var gpclass = (function(){
	
	//Defining Class Variables here
	var response = undefined;
	return {
		//Class functions / Objects
		
		mycoddeSignIn:function(response){
			// The user is signed in
			if (response['access_token']) {
			
				//Get User Info from Google Plus API
				gapi.client.load('plus','v1',this.getUserInformation);
				
			} else if (response['error']) {
				// There was an error, which means the user is not signed in.
				//alert('There was an error: ' + authResult['error']);
			}
		},
		
		getUserInformation: function(){
			var request = gapi.client.plus.people.get( {'userId' : 'me'} );
			request.execute( function(profile) {
				console.log(profile);
				var email = profile['emails'].filter(function(v) {
					return v.type === 'account'; // Filter out the primary email
				})[0].value;
				var fName = profile.displayName;
				$("#inputFullname").html(fName);
				$("#inputEmail").html(email);
			});
		}
	
	}; //End of Return
	})();
	
	function mycoddeSignIn(gpSignInResponse){
		gpclass.mycoddeSignIn(gpSignInResponse);
	}
	</script>-->

<style>
.error {
	color: #e8104a;
	font-size: 12px;
	text-align: center;
}
</style>

<!-- Navigation -->

<!-- Full Page Image Background Carousel Header -->
<body id="loginpage">
<header id="myCarousel" class="carousel slide"> 
	<!-- Indicators -->
	<ol class="carousel-indicators">
		<li data-target="#myCarousel" data-slide-to="0" class="active"></li>
		<li data-target="#myCarousel" data-slide-to="1"></li>
		<li data-target="#myCarousel" data-slide-to="2"></li>
	</ol>
	<!-- Wddrapper for Slides -->
	<div class="carousel-inner cinner">
		<div class="item active">
			<div class="fill" style="background-image:url('css1/img/Background1.jpg');"></div>
			<div class="carousel-caption fontss">
				<div class="img1"> Groceries and more, <br>
					delivered straight to your door ! </div>
				<div class="slidercontent"> Lorem ipsum dolor sit amet, summo graecis similique ad mea, epicuri reformidans no his, sed te audire <br>
					His dictas commodo quaestio cu. An autem alterum assentior qui. Primis quidam probatus cu ius, cu nec </div>
			</div>
		</div>
		<div class="item"> 
			<!-- Set the second background image using inline CSS below. -->
			<div class="fill" style="background-image:url('css1/img/Background1.jpg');"></div>
			<div class="carousel-caption fontss">
				<div class="img1"> Groceries and more, <br>
					delivered straight to your door ! </div>
				<div class="slidercontent"> Lorem ipsum dolor sit amet, summo graecis similique ad mea, epicuri reformidans no his, sed te audire <br>
					An autem alterum assentior qui. Primis quidam probatus cu ius, cu nec </div>
			</div>
		</div>
		<div class="item"> 
			<!-- Set the third background image using inline CSS below. -->
			<div class="fill" style="background-image:url('css1/img/Background1.jpg');"></div>
			<div class="carousel-caption fontss">
				<div class="img1"> Groceries and more, <br>
					delivered straightyour door ! </div>
				<div class="slidercontent"> Lorem ipsum dolor sit amet, summo graecis similique ad mea, epicuri reformidans no his, sed te audire <br>
					His dictas commodo quaestio cu.Primis quidam probatus cu ius, cu nec </div>
			</div>
		</div>
	</div>
	<div class="login" id="HeatNameDiv">
		<div class="btnlogin"> <a href="#" data-toggle="modal" onClick="formReset()" data-target="#myModalregister"/>sign Up </a> </div>
		<div class="btnsignup"> <a href="#" data-toggle="modal" onClick="formReset()" data-target="#myModallogin"/>Sign In </a> </div>
	</div>
	<div class="imags"> <img class="logo111" alt="primcart" src="css1/img/header_logo.png"/> </div>
	<div class="login_static" style="display:none"> 
		<!-- login home statrt -->
		
		<div  id="container_demo" >
			<div id="wrapper">
				<div id="login" class="animate form"></div>
				<div id="forget" class="animate form"></div>
				<div id="register" class="animate form"> </div>
			</div>
		</div>
	</div>
	</div>
	<div id="myModallogin" class="modal" role="dialog">
		<div class="modal-dialog"> 
			
			<!-- Modal content-->
			<div class="modal-content" id="wrapper">
				<div id="login" class="animate form">
					<div class="logo" > <img class="img-responsive imgpstyle" src="css1/img/formlogo.png"/> </div>
					<form  name="form-login" id="form-login" method="post">
						<div class="wlcm" >
							<p>Groceries delivered in 1 hour </p>
						</div>
						<div class="btns"> <a href="#" class="close closebtnstyle" data-dismiss="modal">&times;</a>
							<input class="btns" id="email" type="email" required="required"  placeholder="Email address"  name="email" />
							<div id="error" class="error" style="display:none"></div>
							<input class="btns marginstyle" id="password" required="required" type="password" placeholder="Password (min 6 characters)" name="password" />
							<div id="errorr" class="error" style="display:none"></div>
							<button type="submit" id="demologin" class="ic-btn ic-btn-success signbtn"> Log In <span class="loaderr"><img src="css1/img/fb_loader.gif" class="loder"></span></button>
							<!--<input type="submit" value="<?php echo $button_login; ?>" class="ic-btn ic-btn-success signbtn" />--> 
							
						</div>
						<div id="status"> </div>
						<div id="data"></div>
					</form>
					<div class="or"> <span>or</span> </div>
					<div class="socilicon">
						<div id="fb-root"> <a  class="ic-btn ic-btn-facebook" href="#" onclick="fb_login();"> <i class="fa fa-facebook-official"></i> <span> &nbsp; Connect with Facebook</span><span class="loaderr"><img src="css1/img/fb_loader.gif" class="loder"></a></div>
						<a  class="ic-btn ic-btn-gplus" href="#" onclick="login();"> <i  class="fa fa-google-plus-square"> </i><span > &nbsp; Connect with Google</span></a>
						<div id="profile"></div>
					</div>
					<div  class="signup-vs-login">
						<ul >
							<li> <span>Don't have an account? </span><a href="#" onClick="formReset()" data-dismiss="modal" data-toggle="modal" data-target="#myModalregister"/>Sign up</a></li>
							<li > <span >Forgot your password? </span><!--<a href="#">Reset it</a>--> 
								<a href="#"  data-dismiss="modal" data-toggle="modal" onClick="formReset()" data-target="#myModalforgetemail">Reset it</a></li>
						</ul>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div id="myModalregister" class="modal" role="dialog">
		<div class="modal-dialog"> 
			
			<!-- Modal content-->
			<div class="modal-content" id="wrapper">
				<div id="forget" class="animate form">
					<div class="logo" > <img class="img-responsive imgpstyle" src="css1/img/formlogo.png"/> </div>
					<div class="signup-top"> <span class="up-icon"></span>
						<p>sign Up</p>
						<span>Free delivery on your first order</span> </div>
					<form  name="form-register" id="form-register" method="post">
						<!--<div class="wlcm" > <p>sign Up </p><!--<img class="img-responsive welcomeimg" src="css1/img/welcome.png"/>-</div>-->
						<div class="btns"> <a href="#" class="close closebtnstyle" id="closemodal" data-dismiss="modal">&times;</a>
							<div class="leftbox">
								<input class="btns left" type="text" placeholder="First name" required="required" id="reg_firstname">
								<input class="btns right" type="text" placeholder="Last name" required="required" id="reg_lastname">
							</div>
							<input class="btns" type="email" placeholder="Email Address" required="required" id="reg_email">
							<div id="email_error" class="error" style="display:none"></div>
							<input class="btns marginstyle" name="password" required="required" type="password" id="reg_password" placeholder="Choose a password">
							<div id="pass_error" class="error" style="display:none"></div>
							<input class="btns marginstyle" name="confirm" required="required" type="password" id="reg_confirmpassword" placeholder="Confirm Password">
							<button type="submit" class="ic-btn ic-btn-success signbtn" id="reg_signup">Sign up<span class="loaderr"><img src="css1/img/fb_loader.gif" class="loder"></span></button>
						</div>
					</form>
					<div class="or"> <span>or</span> </div>
					<div class="socilicon"> <a  href="#" onclick="fb_login();" class="ic-btn ic-btn-facebook"> <i class="fa fa-facebook-official"></i> <span> &nbsp; Connect with Facebook</span></a> </div>
					<div class="signup-vs-login">
						<ul>
							<li> <span>Already have an account? </span><a href="#" onClick="formReset()" data-dismiss="modal" data-toggle="modal" data-target="#myModallogin"/>Log in</a></li>
							<!--<li><span>By creating an account, you agree to</span></li>
                    <li><span>our </span><a href="#">Terms of  Service</a><span> and </span><a href="#">Privacy Policy</a></li>-->
							
						</ul>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div id="myModalforgetemail" class="modal" role="dialog">
		<div class="modal-dialog"> 
			
			<!-- Modal content-->
			<div class="modal-content" id="wrapper">
				<div id="login" class="animate form">
					<div class="logo" > <img class="img-responsive imgpstyle" src="css1/img/formlogo.png"/> </div>
					<div class="wlcm" > <!--<img class="img-responsive welcomeimg" src="css1/img/welcome.png"/>-->
						<p>Forgot your password?</p>
					</div>
					<form  name="form-forgetmail" id="form-forgetmail" method="post">
						<div class="btns"> <a href="#" class="close closebtnstyle" data-dismiss="modal">&times;</a>
							<div class="sucess" style="display:none"></div>
							<div id="dontrec" class="error" style="display:none"></div>
							<input class="btns" type="email" placeholder="Email Address" required="required" name="email" id="email_1">
							<button type="submit" class="ic-btn ic-btn-success signbtn" value="" id="passwordback"/>
							Reset Password<span class="loaderr"><img src="css1/img/fb_loader.gif" class="loder"></span>
							</button>
						</div>
					</form>
					<div  class="signup-vs-login">
						<ul >
							<li> <span>Don't have an account? </span><a href="#" onClick="formReset()" data-dismiss="modal" data-toggle="modal" data-target="#myModalregister"/>Sign up</a></li>
						</ul>
					</div>
				</div>
			</div>
		</div>
	</div>
	
	<!-- end login page --> 
	
	<!-- Controls --> 
	<!-- <a class="left carousel-control" href="#myCarousel" data-slide="prev">
            <span class="icon-prev"></span>
        </a>
        <a class="right carousel-control" href="#myCarousel" data-slide="next">
            <span class="icon-next"></span>
        </a>--> 
	
</header>
</body>

<!-- Page Content -->
<!-- /.container -->

<!-- jQuery -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
<script src="css1/js/jquery.js"></script>

<!-- Bootstrap Core JavaScript -->
<script src="css1/js/bootstrap.min.js"></script>

<!-- Script to Activate the Carousel -->

<script>
    /*$('.carousel').carousel({
        interval: 3000 //changes the speed
    })
*/    
 jQuery(document).ready(function(){
jQuery("#login").hide();
jQuery("#register").hide();
jQuery("#forget").hide();
 });
    </script>
<script>

 function formReset()
  {
      document.getElementById("form-login").reset();
	  document.getElementById("form-register").reset();
	  document.getElementById("form-forgetmail").reset();
	  $('#pass_error').hide('fast');
         $("#errorr").hide('fast');
		 $("#error").hide('fast');
		 $('.error').hide('fast');
		 
  }
</script>
<script>
	  
	  
	  $(document).ready(function(){
	
	 $('#myModalregister').on('click', '#reg_signup', function () {
		 
		 jQuery('#pass_error').hide('fast');
		 jQuery('#email_error').hide('fast');
         $("#errorr").hide('fast');
		 var data = $("#form-register").serialize()+'&form-register=submit';	
		 var form = document.getElementById('form-register');
         
		 if(form.checkValidity() == false){
         	 return ;   
      		}
			
			$('.loder').show('fast');	
			 var email=jQuery("#reg_email").val();
			if(! /(.+)@(.+){2,}\.(.+){2,}/.test(email)){
  				
				jQuery('.loder').hide('fast');
				jQuery('#email_error').html('invalid Email').show();
				return false;
				
			} 
  			
			
			
			
		 
		var password = jQuery('#reg_password').val();
		var password_confirmation = jQuery('#reg_confirmpassword').val();
		//var filter = /^([\w-\.]+)@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.)|(([\w-]+\.)+))([a-zA-Z]{2,4}|[0-9]{1,3})(\]?)$/;
		
		if (password_confirmation != password) {
			jQuery('.loder').hide('fast');
			
			jQuery('#pass_error').html("password does't  match").show();
			
			return false;
			
			
			
		}
		

	  
	  
		 
		 
		 var firstname=$("#reg_firstname").val();
		  var lastname=$("#reg_lastname").val();
		  var email=$("#reg_email").val();
		  var password=$("#reg_password").val();
		 
		 
		  var confirm_password=$("#reg_confirmpassword").val();
		  
		  
		  
		  $.ajax({
 
				type: 'post',
				url: 'index.php?route=account/login/register',
	
				data: 'firstname='+firstname+'&lastname='+lastname+'&email='+email+'&password='+password,
				dataType: 'json',
				success: function(json) {
					
				if(json['success']) {
					 $('.loder').hide('fast');
					 $('#form-register')[0].reset();
						window.location.href = "home";
					
					}else{
						
					$('.loder').hide('fast');
					
					jQuery('#email_error').html(json['already']).show();
					}
}
});
		return false;
	});
	
		
	
});




	  </script>
<script>
	  
	  
	  $(document).ready(function(){
	
	 $('#myModallogin').on('click', '#demologin', function () {
		 
		 $("#error").hide('fast');
         $("#errorr").hide('fast');
		 var data = $("#form-login").serialize()+'&form-login=submit';	
		 var form = document.getElementById('form-login');
         
		 
		 
		 
		 if(form.checkValidity() == false){
          
	    
			
          return ;   
      }
		 $('.loder').show();
		 
		 
		 
		 
		 var email=$("#email").val();
		  var password=$("#password").val();
		  
		  
		  
		  $.ajax({
 
				type: 'post',
				url: 'index.php?route=account/login/login',
	
				data: 'email='+email+'&password='+password,
				dataType: 'json',
				success: function(json) {
					console.log(json['result'])
				if(json['success']) {
					
					window.location.href = "home";
					$('.loder').hide();
					$('#myModallogin').modal('hide');
					$('#form-login')[0].reset();
					
					}else{
						$('.loder').hide();
						$("#error").show('fast').html(json['error']);
						$("#errorr").show('fast').html(json['error']);
					
					}
}
});
		return false;
	});
	/*login hide and show signup*/
	  
	  /**/
		
	
});




	  </script>
<script>
	  
	  
	$(document).ready(function() {
	
		$('#myModalforgetemail').on('click', '#passwordback', function () {
			$('.error').hide('fast');
			
		var data = $("#form-forgetmail").serialize()+'&form-forgetmail=submit';	
		 var form = document.getElementById('form-forgetmail');
         
		 
		 var email = $('#email_1').val();
		 
		 if(form.checkValidity() == false){
          
	    
			
          return ;   
      }	
		$('.loder').show();	
		
		
		$.ajax({
			type: "post",
			url: "index.php?route=account/login/forgot",
			data: 'email='+email,
			dataType: 'json',
			
			success: function(json)
			{
				if(json['success'])
				{
				$('.loder').hide();
				$('#email_error').hide('fast');
				$('.sucess').show('fast').html(json['success']);
				$('#form-forgetmail')[0].reset();
				}
				else{
					$('.loder').hide();
					$('#dontrec').show('fast').html(json['error']);
					
					}
				
				
			}
		});
		return false;
	});
	$( "#email_1" ).keyup(function() {
	   var email = $('#email_1').val();
	   if(email.length == 0)
	   {
		$('.error').remove();
	   }
	});
}); 
	
	
  </script>
<style>
.error {
	color: red;
}
.sucess {
	color: green
}
</style>
