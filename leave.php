<?php
if (isset($_POST['area_code']) &&
    isset($_POST['exchange']) &&
    isset($_POST['station_code'])) {
	require_once('functions.php');
	$number = '+1' .
		$_POST['area_code'] .
		$_POST['exchange'] .
		$_POST['station_code'];
	$failed = false;
	$message = 'Left group.';

	try {
		leave_group($phone_number);
	}
	catch(NotGroupMemberException $e) {
		$failed = true;
		$message = "You're not a member of any groups.";
	}
}
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>TCollab Collaboration Software</title>

    <!-- Bootstrap -->
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="../WudayHackDuke/bootstrap.css" rel="stylesheet" type="text/css">
    <link href="css/custom.css" rel="stylesheet">

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>

  <!-- This is Piwik capability, tracking all entries and inputs given in by the user of TCollab-->
  <!-- Piwik -->
<script type="text/javascript">
  var _paq = _paq || [];
  _paq.push(['trackPageView']);
  _paq.push(['enableLinkTracking']);
  (function() {
    var u="//piwiktest.mybluemix.net/";
    _paq.push(['setTrackerUrl', u+'piwik.php']);
    _paq.push(['setSiteId', 1]);
    var d=document, g=d.createElement('script'), s=d.getElementsByTagName('script')[0];
    g.type='text/javascript'; g.async=true; g.defer=true; g.src=u+'piwik.js'; s.parentNode.insertBefore(g,s);
  })();
</script>
<noscript><p><img src="//piwiktest.mybluemix.net/piwik.php?idsite=1" style="border:0;" alt="" /></p></noscript>
<!-- End Piwik Code -->
<body>
	<?php if(isset($message)) {?>
	<div class="status <?php echo $failed ? 'failed' : 'succeeded'?>">
	<?php echo $message ?>
    </div>
    <?php }
      require_once(menu.php); ?>
    <div class="text-center">
	    <form method="post" role="form">
		    <div class="form-group">
			    <label for="area_code">Your Cell Number</label>
			    <input type="number" min="100" max="999" name="area_code" value="" />
			    <input type="number" min="100" max="999" name="exchange" value="" /> -
			    <input type="number" min="1000" max="9999" name="station_code" value="" />
		    </div>
		    <button type="submit" class="btn btn-default">Leave Group</button>
	    </form>
    </div>
    <!---Footer-->
    <div class="navbar navbar-inverse navbar-fixed-bottom" role="navigation">
        <div class="container">
          <div class="navbar-text pull-left">
          <p>2014 Tcollab by Udaiveer Virk, William Kunkel and William Woodruff<p>
        </div>
      </div>

    </div>    

    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="js/bootstrap.min.js"></script>
  </body>
</html>
