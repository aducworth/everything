<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>Everything...<?=($action != 'index')?ucwords( str_replace( '_', ' ', $action ) ):'' ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">
    
    <!-- Bootstrap -->
    <link href="/assets/css/bootstrap.min.css" rel="stylesheet" media="screen">
    <link href="/assets/css/bootstrap.css" rel="stylesheet">
    <link rel="stylesheet" href="http://code.jquery.com/ui/1.10.0/themes/base/jquery-ui.css" />
    <link href="/assets/fullcalendar/fullcalendar.css" rel="stylesheet">
    <link href="/assets/fullcalendar/fullcalendar.print.css" rel="stylesheet">
    
    <link href="/assets/css/app.css" rel="stylesheet" media="screen">
    <link href="/assets/datepicker/css/datepicker.css" rel="stylesheet" media="screen">
    
    
    <style>
      body {
        padding-top: 60px; /* 60px to make the container go all the way to the bottom of the topbar */
      }
    </style>
    <link href="/assets/css/bootstrap-responsive.css" rel="stylesheet">
    
    <!-- HTML5 shim, for IE6-8 support of HTML5 elements -->
    <!--[if lt IE 9]>
      <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->
    
  </head>
  <body>
  
  <div class="navbar navbar-default navbar-fixed-top">
	  <div class="navbar-header">
	    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-responsive-collapse">
	      <span class="icon-bar"></span>
	      <span class="icon-bar"></span>
	      <span class="icon-bar"></span>
	    </button>
	    <a class="navbar-brand" href="/">{e} everything...</a>
	  </div>
	  
	  <? if( $controller->auth->logged_in() ): ?>
	  
	  <div class="navbar-collapse collapse navbar-responsive-collapse">
	    <ul class="nav navbar-nav">
	      
	      <?=$controller->auth->navigation() ?>
	      
	      <li><a href="/logout">Logout</a></li>
	      
	    </ul>
	    
	    <? if( in_array( $_GET['url'], $controller->auth->show_search ) ): ?>
                
            <form class="navbar-form navbar-left" action='/<?=$_GET['url'] ?>'>
            
              <input name='search' class="span2 form-control col-lg-8" type="text" placeholder="Search" value="<?=$_GET['search'] ?>">
              
            </form>
        
        <? endif; ?>
        
        <ul class="nav navbar-nav navbar-right">
	      <li><a href="/timesheet" id='hour-update'>Loading...</a></li>
	    </ul>
                
	  </div>
	  
	  <? endif; ?>
	  
	</div>
  
    <div id='main-content' class="container">
    
    	<? if( $_GET['search'] ): ?>
        
            <div class="alert alert-info">
              
              <a class="close" data-dismiss="alert" href='/<?=$_GET['url'] ?>'>×</a>  
              
              Results for "<?=$_GET['search'] ?>"  
              
            </div> 
        
        <? endif; ?>

        <? if( $controller->message ): ?>
        
        	<div class='alert alert-error'>
            
            	<?=$controller->message ?>
            
            </div>
        
        <? endif; ?>
        
        <? //print_r( $_SESSION ) ?>