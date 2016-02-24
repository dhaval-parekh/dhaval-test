<!doctype html>
<html>
<head>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
<script>
  // This is called with the results from from FB.getLoginStatus().
  function checkLoginState() {
	  console.log('checkLoginState');
	  FB.getLoginStatus(function(response) {
	    statusChangeCallback(response);
	  });
	}
 
  
  function statusChangeCallback(response) {
	console.log('statusChangeCallback');
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
    appId      : '1639314812986683',
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
console.log('FBLogin');
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
console.log('getUserInfo');
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
        appId   : '1639314812986683',
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
<meta charset="utf-8">
<title>Untitled Document</title>
</head>
<body>
<div id="fb-root"> <a  class="ic-btn ic-btn-facebook" href="#" onclick="fb_login();"> <i class="fa fa-facebook-official"></i> <span> &nbsp; Connect with Facebook</span><span class="loaderr"></span></a></div>
</body>
</html>