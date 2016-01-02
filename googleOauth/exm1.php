<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Untitled Document</title>
<script src="https://apis.google.com/js/platform.js" async defer></script>
<meta name="google-signin-client_id" content="99700316464-dcp2ivnv1l58ohn9792kqci6cumno53c.apps.googleusercontent.com">
</head>

<body>
<div class="g-signin2" data-onsuccess="onSignIn"></div>

</body>
<script type="text/javascript">
function onSignIn(googleUser) {
  var profile = googleUser.getBasicProfile();
  console.log('ID: ' + profile.getId()); // Do not send to your backend! Use an ID token instead.
  console.log('Name: ' + profile.getName());
  console.log('Image URL: ' + profile.getImageUrl());
  console.log('Email: ' + profile.getEmail());
}

</script>
</html>