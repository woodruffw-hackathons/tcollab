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

	<?php require_once(menu.php); ?>

    <div class="container">
      <div class="jumbotron text-center">
            <h1> <img src="images/logo.png" width="100px"> TCollab<h1>
				<p>The best way to collaborate with your peers.</p>

        </div>

    </div>
    <div class="text-center">
	  <div class="signup">
		<div class="col-md-4">
			<h2>Create a group</h2>
		  	<a href="create.php" role="button" class="btn btn-lg btn-default">Create a group online</a>
		  	<em class="signup-or">or</em>
		  	Send a text with <code>+create groupname</code> to (804) 853-6170.
		</div>
		<div class="col-md-4">
		  	<h2>Get your team to join</h2>
		  	<a href="join.php" role="button" class="btn btn-lg btn-default">Join a group now</a>
		  	<em class="signup-or">or</em>
		  	Send a text with <code>+join groupname</code> to (804) 853-6170.
		</div>
		<div class="col-md-4">
		  	<h2>Start collaborating!</h2>
		  	Send text messages to (804) 853-6170 to instantly reach all of your teammates!
		</div>
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
