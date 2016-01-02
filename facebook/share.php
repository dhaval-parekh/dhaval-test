<html>
<head>
    <title>Your Website Title</title>
    <!-- You can use open graph tags to customize link previews.
    Learn more: https://developers.facebook.com/docs/sharing/webmasters -->
   <meta property="og:url"           content="http://whiteorangesoftware.com/" />
    <meta property="og:type"          content="website" />
    <meta property="og:title"         content="White Orange Software " />
    <meta property="og:description"   content="The web development Company" />
    <meta property="og:image"         content="http://leclient.ciphersoul.com/uploads/product/default.png" />
    
</head>
<body>

    <!-- Load Facebook SDK for JavaScript -->
  <div id="fb-root"></div>
<script>(function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) return;
  js = d.createElement(s); js.id = id;
  js.src = "//connect.facebook.net/en_GB/sdk.js#xfbml=1&version=v2.4";
  fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));</script>

    <!-- Your share button code -->
   <div class="fb-share-button" data-href="http://whiteorangesoftware.com/" data-layout="button_count"></div>
  
   <?php
	$title=urlencode('Title of Your iFrame Tab');
	$url=urlencode('http://whiteorangesoftware.com/');
	$summary=urlencode('Custom message that summarizes what your tab is about, or just a simple message to tell people to check out your tab.');
	$image=urlencode('http://leclient.ciphersoul.com/uploads/product/default.png');
	?>
   <a onClick="window.open('http://www.facebook.com/sharer.php?s=100&amp;p[title]=<?php echo $title;?>&amp;p[summary]=<?php echo $summary;?>&amp;p[url]=<?php echo $url; ?>&amp;p[images][0]=<?php echo $image;?>','sharer','toolbar=0,status=0,width=548,height=325');" href="javascript: void(0)">Post on Face book</a>

</body>
</html>