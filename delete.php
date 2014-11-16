<?php
if (isset($_POST['name'])) {
   	require('functions.php');
	$failed = false;
	$message = 'Group deleted.';

	try {
		delete_group($_POST['name']);
	}
	catch (GroupDoesNotExistException $e) {
		$failed = true;
		$message = 'That group does not exist.';
	}
}
?><!DOCTYPE html>
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
      require_once('menu.php'); ?>
    <div class="text-center">
    	 <div class="container update-form">
	    <form method="post" role="form">
		    <div class="form-group">
			    <label for="name">Group Name</label>
			    <input type="text" name="name" value="" />
		    </div>
		    <button type="submit" class="btn btn-default">Delete Group</button>
	    </form>
	   </div>
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
