<?php
use \System\helpers\Intl as Intl;
use \core\Router as Router;
use \core\Helper as Helper;
use \core\Controllers as Controllers;
use \Data\Config\Config as Config;
	
if($this->Controller(SCONTROLLER."Theme",Config::$data['models'][0])):

?>
<!DOCTYPE HTML>
<html>
  
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <script type="text/javascript" src="http://cdnjs.cloudflare.com/ajax/libs/jquery/2.0.3/jquery.min.js"></script>
    <script type="text/javascript" src="http://netdna.bootstrapcdn.com/bootstrap/3.3.4/js/bootstrap.min.js"></script>
    <link href="http://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.3.0/css/font-awesome.min.css"
    rel="stylesheet" type="text/css">
    <link href="http://pingendo.github.io/pingendo-bootstrap/themes/default/bootstrap.css"
    rel="stylesheet" type="text/css">
    <title><?=$this ->ViewData('title') ?></title>
      <style>
		body {
			position: relative;
		}
		#section1 {
			padding-top: 50px;
			height: auto;
			color: #fff;
			background-color: #1E88E5;
		}
		#section2 {
			padding-top: 50px;
			height: auto;
			color: #fff;
			background-color: #673ab7;
		}
		#section3 {
			padding-top: 50px;
			height: auto;
		}
		#section41 {
			padding-top: 50px;
			height: auto;
			color: #fff;
			background-color: #00bcd4;
		}
		#section42 {
			padding-top: 50px;
			height: 500px;
			color: #fff;
			background-color: #009688;
		}
		/* Note: Try to remove the following lines to see the effect of CSS positioning */
		.affix {
			bottom: 20px;
			z-index: 1000;
		}
		.alert_fixed {
			position: fixed;
			bottom: 10px;
			z-index: 1000;
		}
  </style>
  </head>
  
  <body data-spy="scroll" data-target=".navbar" data-offset="100">
  	
<div class="container">
  <div class="jumbotron">
    <h1><?=$this ->ViewData('title') ?> <small><?=$this ->ViewData('subtitle') ?></small></h1>
    <p>Bootstrap is the most popular HTML, CSS, and JS framework for developing
    responsive, mobile-first projects on the web.</p>
  </div>
</div>

  	<!-- -->
  	   <div class="navbar navbar-inverse navbar-fixed-top">
  <div class="container-fluid">
    <div class="navbar-header">
        <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>                        
      </button>
      <a class="navbar-brand" href="#"><?=$this ->ViewData('title') ?> <small><?=$this ->ViewData('subtitle') ?></small></a>
    </div>
    <div>
      <div class="collapse navbar-collapse" id="myNavbar">
        <ul class="nav navbar-nav">
          <li><a href="#section1">Section 1</a></li>
          <li><a href="#section2">Section 2</a></li>
          <li><a href="#section3">Section 3</a></li>
        </ul>
      </div>
    </div>
  </div>
</div>  
<!-- -->
<?php endif; ?>


