<?php
// Check for any tracking code in a theme.
<form action="http://www.google.co.uk/cse" id="cse-search-box" target="_blank">
  <div>
    <input type="hidden" name="cx" value="partner-pub-6604293069436720:y64p6y-dhix" /> // Error.
    <input type="hidden" name="ie" value="ISO-8859-1" />
    <input type="text" name="q" size="25" />
    <input type="submit" name="sa" value="Search" />
  </div>
</form>

// Google ad client.
<div id="headerad"><script type="text/javascript"><!--
        google_ad_client = "pub-4377028578985272"; // Error
        /* 728x15, created 9/5/08 */
        google_ad_slot = "7831920758";
        google_ad_width = 728;
        google_ad_height = 15;
        //-->
       </script>
       <script type="text/javascript"
       src="http://pagead2.googlesyndication.com/pagead/show_ads.js">
       </script>
       </div>

// Google analytics.
<!-- Google Analytics -->
<script>
(function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
(i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
})(window,document,'script','https://www.google-analytics.com/analytics.js','ga'); // Error.

ga('create', 'UA-XXXXX-Y', 'auto');
ga('send', 'pageview');
</script>
<!-- End Google Analytics -->

// Facebook pixel.
<!-- Facebook Pixel Code -->
<script>
  !function(f,b,e,v,n,t,s)
  {if(f.fbq)return;n=f.fbq=function(){n.callMethod?
  n.callMethod.apply(n,arguments):n.queue.push(arguments)};
  if(!f._fbq)f._fbq=n;n.push=n;n.loaded=!0;n.version='2.0';
  n.queue=[];t=b.createElement(e);t.async=!0;
  t.src=v;s=b.getElementsByTagName(e)[0];
  s.parentNode.insertBefore(t,s)}(window, document,'script',
  'https://connect.facebook.net/en_US/fbevents.js');
  fbq('init', '{your-pixel-id-goes-here}');
  fbq('track', 'PageView');
</script>
<noscript>
  <img height="1" width="1" style="display:none"
       src="https://www.facebook.com/tr?id={your-pixel-id-goes-here}&ev=PageView&noscript=1"/> // Error.
</noscript>
<!-- End Facebook Pixel Code -->

// Hotjar tracking.
</script>
window.hj('identify', userId, { // Error.
    user_attribute: value
});

window.hj=window.hj||function(){(hj.q=hj.q||[]).push(arguments)}; // Error.
</script>
