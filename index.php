
<!DOCTYPE html>
<html lang="en"><head>
    <meta charset="utf-8">
    <title>Twitter CP</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">

    <!-- Le styles -->
       
 <link rel="stylesheet" type="text/css" href="css/metro-bootstrap.css">
    <link rel="stylesheet" href="docs/font-awesome.css">
    <style type="text/css">
      body {
        padding-top: 60px;
        padding-bottom: 40px;
      }
      .sidebar-nav {
        padding: 9px 0;
      }
	  form .counter{
	}
form .warning{color:#600;}	
form .exceeded{color:#e00;}
#update {
			margin-top:10px;
            width: 400px;
            background-color: #EFEFEF;
            margin-bottom: 5px;
            padding: 5 5 5 5;
        }
        #update #left {
            float:left;
            display: inline;
            padding-right: 7px;
        }
        #update .user {
            font-weight: bold;
            color: #0383FF;
 
        }
#update A:link { text-decoration: none }
       #update A:active { text-decoration: none }
       #update A:visited { text-decoration: none }
      @media (max-width: 980px) {
        /* Enable use of floated navbar text */
        .navbar-text.pull-right {
          float: none;
          padding-left: 5px;
          padding-right: 5px;
        }
      }
    </style>

    <!-- HTML5 shim, for IE6-8 support of HTML5 elements -->
    <!--[if lt IE 9]>
      <script src="../assets/js/html5shiv.js"></script>
    <![endif]-->

    <!-- Fav and touch icons -->
    
  </head>

  <body>

    <div class="navbar navbar-fixed-top">
      <div class="navbar-inner">
        <div class="container-fluid">
          <button type="button" class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="brand" href="#">Twitter Controle Panel</a>
          <div class="nav-collapse collapse">
            <ul class="nav">
              <li><a href="#A" data-toggle="tab"><i class="icon-home"></i>Home</a></li>
            </ul>
            <div class="input-append navbar-search pull-right">
  <input class="span2" id="appendedInputButtons" type="text" >
  <button class="btn btn-primary" type="button"><i class="icon-search"></i></button>
</div>
          </div><!--/.nav-collapse -->
        </div>
      </div>
    </div>
     <?
  include_once("class.php");
  if (empty($_SESSION['access_token']) || empty($_SESSION['access_token']['oauth_token']) || empty($_SESSION['access_token']['oauth_token_secret'])) {
	$_SESSION['login'] = array();
	 echo '<div class="row">
    <div class="span4 offset4">
      <div class="well">
       <legend>Sign in to WebApp</legend>
        <form id="loginform" action="class.php" method="post">    <div id="response"></div>
            <input class="span3" placeholder="Username" type="text" name="username">
            <input class="span3" placeholder="Password" type="password" name="password">
			<input name="action" type="hidden" value="login"> 
            <button name="submit" class="btn-info btn" type="submit">Login</button>      
        </form></div>
    </div>
</div>';
			}else{
  ?>
 <div class="span4 well pull-right">
	<div class="row">
    <?php 
	$user = $twitter->userdata();
	?>
    
		<div class="span1"><img src="<?php echo $user->profile_image_url ?>" alt=""></div>
		<div class="span3">
			<p>@<?php echo $user->screen_name; ?></p>
            <span class="badge badge-important">api hit left: <?php echo $twitter->ratelimet() ?></span>
	<span class=" badge badge-info"><?php echo $user->followers_count; ?> followers</span>
		</div>
	</div>
</div>
<div class=" clearfix"></div>

    <div class="container-fluid">
          <div class="row-fluid">
      <div class="span3 pull-left">
      <div class="sidebar-nav">
	<div class="well">
		<ul class="nav nav-list"> 
		  <li class="nav-header">Admin Menu</li>        
		  <li ><a href="#dashboard" data-toggle="tab"><i class="icon-desktop"></i> Dashboard</a></li>
          <li><a href="#plaatstweet" data-toggle="tab"><i class="icon-edit"></i> Tweet</a></li>
          <li class="divider"></li>
		  <li><a href="clearsessions.php"><i class="icon-off"></i> Logout</a></li>
		</ul>
	</div>
</div>
        </div><!--/span-->
        <div class="span9">
          <div class="tabbable">
                                  
 
                                  <div class="tab-content pull-left">
                                    <div class="tab-pane active" id="A">
                                    <ul class="breadcrumb">
  <li>
    <a href="#">Home</a> <span class="divider">/</span>
  </li>
  <li>
    <a href="#">Library</a> <span class="divider">/</span>
  </li>
  <li class="active">Data</li>
</ul>
<div class="hero-unit">
            <h1>Hello, world!</h1>
            <p>This is a template for a simple marketing or informational website. It includes a large callout called the hero unit and three supporting pieces of content. Use it as a starting point to create something more unique.</p>
            <p><a href="#" class="btn btn-primary btn-large">Learn more &raquo;</a></p>
          </div>
          </div><!--/tab A-->
          <div class="tab-pane fade" id="dashboard">
<?php 
	$timeline = $twitter->timeline();
	foreach ($timeline as $status) {
		
	?> 
    
        <div id="update">
         <? echo date("H:m j.n.Y", strtotime($status->created_at)); ?> 
            <div id="left"><a href="https://twitter.com/#!/<?=$status->user->screen_name?>" target="_blank"/><img width="48px" height="48px" src="<?=$status->user->profile_image_url?>"/></a></div>
            <div id="right">
                <div class="user"><a href="https://twitter.com/#!/<?=$status->user->screen_name?>" target="_blank"/><?=$status->user->screen_name?></a>&nbsp;<?=$status->user->name?></div>
                <div class="detail">
                <?=$status->text?>
                </div>
            </div>
        </div>
<?php
}
?>
          </div><!--/tab B-->
          <div class="tab-pane fade" id="plaatstweet">
          <ul class="breadcrumb">
  <li>
    <a href="#">Home</a> <span class="divider">/</span>
  </li>
  <li>
    <a href="#">Tweet</a> <span class="divider">/</span>
  </li>
  <li class="active">Data</li>
</ul>
          <div class="well">
    <form accept-charset="UTF-8" action="class.php" method="POST" id="loginform">
    <div id="response"></div>
        <textarea  id="message2" name="new_message" placeholder="Type in your message" rows="5" style="margin: 0px 0px 12.5px; width: 399px; height: 170px; resize:none;"></textarea>
        <span class="counter span5 pull-left"></span>
        <input name="action" type="hidden" value="tweet">
        <button class="btn btn-primary pull-right" type="submit" name="submit">Tweet</button>
    </form>
</div>
</div>
          </div><!--tab-->
          
          </div><!--tabel-->
        </div><!--/span-->
      </div><!--/row-->
      <hr>
      <?php } ?>
      <footer>
        <div class="container">	
<div class="row-fluid">

				<div class="span12">
					<div class="span2" style="width: 15%;">
						<ul class="unstyled">
							<li>GitHub<li>
							<li><a href="#">About us</a></li>
							<li><a href="#">Blog</a></li>
							<li><a href="#">Contact & support</a></li>
							<li><a href="#">Enterprise</a></li>
							<li><a href="#">Site status</a></li>
						</ul>
					</div>
					<div class="span2" style="width: 15%;">
						<ul class="unstyled">
							<li>Applications<li>
							<li><a href="#">Product for Mac</a></li>
							<li><a href="#">Product for Windows</a></li>
							<li><a href="#">Product for Eclipse</a></li>
							<li><a href="#">Product mobile apps</a></li>							
						</ul>
					</div>
					<div class="span2" style="width: 15%;">
						<ul class="unstyled">
							<li>Services<li>
							<li><a href="#">Web analytics</a></li>
							<li><a href="#">Presentations</a></li>
							<li><a href="#">Code snippets</a></li>
							<li><a href="#">Job board</a></li>							
						</ul>
					</div>
					<div class="span2" style="width: 15%;">
						<ul class="unstyled">
							<li>Documentation<li>
							<li><a href="#">Product Help</a></li>
							<li><a href="#">Developer API</a></li>
							<li><a href="#">Product Markdown</a></li>
							<li><a href="#">Product Pages</a></li>							
						</ul>
					</div>	
					<div class="span2" style="width: 15%;">
						<ul class="unstyled">
							<li>More<li>
							<li><a href="#">Training</a></li>
							<li><a href="#">Students & teachers</a></li>
							<li><a href="#">The Shop</a></li>
							<li><a href="#">Plans & pricing</a></li>
							<li><a href="#">Contact us</a></li>
						</ul>
					</div>					
				</div>
		  </div>
			<hr>
			<div class="row-fluid">
				<div class="span12">
					<div class="span8">
						<a href="#">Terms of Service</a>    
						<a href="#">Privacy</a>    
						<a href="#">Security</a>
					</div>
					<div class="span4">
						<p class="muted pull-right">© 2013 Company Name. All rights reserved</p>
					</div>
				</div>
			</div>
  </div>
      </footer>

    </div><!--/.fluid-container-->

    <!-- Le javascript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
        <script type="text/javascript" src="docs/jquery-1.8.0.js"></script>
<script type="text/javascript" src="docs/bootstrap-tooltip.js"></script>
<script type="text/javascript" src="docs/bootstrap-alert.js"></script>
<script type="text/javascript" src="docs/bootstrap-button.js"></script>
<script type="text/javascript" src="docs/bootstrap-carousel.js"></script>
<script type="text/javascript" src="docs/bootstrap-collapse.js"></script>
<script type="text/javascript" src="docs/bootstrap-dropdown.js"></script>
<script type="text/javascript" src="docs/bootstrap-modal.js"></script>
<script type="text/javascript" src="docs/bootstrap-popover.js"></script>
<script type="text/javascript" src="docs/bootstrap-scrollspy.js"></script>
<script type="text/javascript" src="docs/bootstrap-tab.js"></script>
<script type="text/javascript" src="docs/bootstrap-transition.js"></script>
<script type="text/javascript" src="docs/bootstrap-typeahead.js"></script>
<script type="text/javascript" src="docs/jquery.unobtrusive-ajax.js"></script>
<script type="text/javascript" src="docs/jquery.validate.min.js"></script>
		<script type="text/javascript" src="docs/jquery.form.js"></script>
<script type="text/javascript"></script>

<script type="text/javascript" src="docs/charCount.js"></script>
<script type="text/javascript">
	$(document).ready(function(){	
		//default usage
		$("#message1").charCount();
		//custom usage
		$("#message2").charCount({
			allowed: 140,		
			warning: 20,
			counterText: 'Characters left: '	
		});
	});
</script>
    		<script>$(function() {
	// Validate the contact form
  $('#loginform').validate({
  	// Specify what the errors should look like
  	// when they are dynamically added to the form
  	submitHandler: function(form) {
  		$(form).ajaxSubmit({
  			success: function(responseText, statusText, xhr, $form) {
  				$("#response").html(responseText).hide().slideDown("fast");
  			}
  		});
  		return false;
  	}
  });
});</script>


  </body>
</html>
