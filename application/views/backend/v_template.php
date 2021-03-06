<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title>
			<?php
            echo $this->config->item("web_title");
            if (isset($title)) {
                echo " - " . $title . "\n";
            }
            ?>
    </title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta name="description" content="e-Recruitment is an application to manage recruitment">
	<meta name="author" content="Asep Muhammad Fahrus">

	<!-- The styles -->
	<link id="bs-css" href="<?php echo base_url() ?>assets/backend/css/bootstrap-cerulean.css" rel="stylesheet">
	<style type="text/css">
	  body {
		padding-bottom: 40px;
	  }
	  .sidebar-nav {
		padding: 9px 0;
	  }
	</style>
	<link href="<?php echo base_url() ?>assets/backend/css/bootstrap-responsive.css" rel="stylesheet">
	<link href="<?php echo base_url() ?>assets/backend/css/charisma-app.css" rel="stylesheet">
	<link href="<?php echo base_url() ?>assets/backend/css/jquery-ui-1.8.21.custom.css" rel="stylesheet">
	<link href='<?php echo base_url() ?>assets/backend/css/fullcalendar.css' rel='stylesheet'>
	<link href='<?php echo base_url() ?>assets/backend/css/fullcalendar.print.css' rel='stylesheet'  media='print'>
	<link href='<?php echo base_url() ?>assets/backend/css/chosen.css' rel='stylesheet'>
	<link href='<?php echo base_url() ?>assets/backend/css/uniform.default.css' rel='stylesheet'>
	<link href='<?php echo base_url() ?>assets/backend/css/colorbox.css' rel='stylesheet'>
	<link href='<?php echo base_url() ?>assets/backend/css/jquery.cleditor.css' rel='stylesheet'>
	<link href='<?php echo base_url() ?>assets/backend/css/jquery.noty.css' rel='stylesheet'>
	<link href='<?php echo base_url() ?>assets/backend/css/noty_theme_default.css' rel='stylesheet'>
	<link href='<?php echo base_url() ?>assets/backend/css/elfinder.min.css' rel='stylesheet'>
	<link href='<?php echo base_url() ?>assets/backend/css/elfinder.theme.css' rel='stylesheet'>
	<link href='<?php echo base_url() ?>assets/backend/css/jquery.iphone.toggle.css' rel='stylesheet'>
	<link href='<?php echo base_url() ?>assets/backend/css/opa-icons.css' rel='stylesheet'>
	<link href='<?php echo base_url() ?>assets/backend/css/uploadify.css' rel='stylesheet'>

	<!-- The HTML5 shim, for IE6-8 support of HTML5 elements -->
	<!--[if lt IE 9]>
	  <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
	<![endif]-->

	<!-- The fav icon -->
	<link rel="shortcut icon" href="<?php echo base_url() ?>images/favicon.ico">
		
</head>

<body>


    <?php
    if (isset($content)) {
        echo $content;
    }
    ?>
	
	<!-- external javascript
	================================================== -->
	<!-- Placed at the end of the document so the pages load faster -->

	<!-- jQuery -->
	<script src="<?php echo base_url() ?>assets/backend/js/jquery-1.7.2.min.js"></script>
	<!-- jQuery UI -->
	<script src="<?php echo base_url() ?>assets/backend/js/jquery-ui-1.8.21.custom.min.js"></script>
	<!-- transition / effect library -->
	<script src="<?php echo base_url() ?>assets/backend/js/bootstrap-transition.js"></script>
	<!-- alert enhancer library -->
	<script src="<?php echo base_url() ?>assets/backend/js/bootstrap-alert.js"></script>
	<!-- modal / dialog library -->
	<script src="<?php echo base_url() ?>assets/backend/js/bootstrap-modal.js"></script>
	<!-- custom dropdown library -->
	<script src="<?php echo base_url() ?>assets/backend/js/bootstrap-dropdown.js"></script>
	<!-- scrolspy library -->
	<script src="<?php echo base_url() ?>assets/backend/js/bootstrap-scrollspy.js"></script>
	<!-- library for creating tabs -->
	<script src="<?php echo base_url() ?>assets/backend/js/bootstrap-tab.js"></script>
	<!-- library for advanced tooltip -->
	<script src="<?php echo base_url() ?>assets/backend/js/bootstrap-tooltip.js"></script>
	<!-- popover effect library -->
	<script src="<?php echo base_url() ?>assets/backend/js/bootstrap-popover.js"></script>
	<!-- button enhancer library -->
	<script src="<?php echo base_url() ?>assets/backend/js/bootstrap-button.js"></script>
	<!-- accordion library (optional, not used in demo) -->
	<script src="<?php echo base_url() ?>assets/backend/js/bootstrap-collapse.js"></script>
	<!-- carousel slideshow library (optional, not used in demo) -->
	<script src="<?php echo base_url() ?>assets/backend/js/bootstrap-carousel.js"></script>
	<!-- autocomplete library -->
	<script src="<?php echo base_url() ?>assets/backend/js/bootstrap-typeahead.js"></script>
	<!-- tour library -->
	<script src="<?php echo base_url() ?>assets/backend/js/bootstrap-tour.js"></script>
	<!-- library for cookie management -->
	<script src="<?php echo base_url() ?>assets/backend/js/jquery.cookie.js"></script>
	<!-- calander plugin -->
	<script src='<?php echo base_url() ?>assets/backend/js/fullcalendar.min.js'></script>
	<!-- data table plugin -->
	<script src='<?php echo base_url() ?>assets/backend/js/jquery.dataTables.min.js'></script>

	<!-- chart libraries start -->
	<script src="<?php echo base_url() ?>assets/backend/js/excanvas.js"></script>
	<script src="<?php echo base_url() ?>assets/backend/js/jquery.flot.min.js"></script>
	<script src="<?php echo base_url() ?>assets/backend/js/jquery.flot.pie.min.js"></script>
	<script src="<?php echo base_url() ?>assets/backend/js/jquery.flot.stack.js"></script>
	<script src="<?php echo base_url() ?>assets/backend/js/jquery.flot.resize.min.js"></script>
	<script src="<?php echo base_url() ?>assets/backend/js/highcharts.js"></script>
	<!-- chart libraries end -->

	<!-- select or dropdown enhancer -->
	<script src="<?php echo base_url() ?>assets/backend/js/jquery.chosen.min.js"></script>
	<!-- checkbox, radio, and file input styler -->
	<script src="<?php echo base_url() ?>assets/backend/js/jquery.uniform.min.js"></script>
	<!-- plugin for gallery image view -->
	<script src="<?php echo base_url() ?>assets/backend/js/jquery.colorbox.min.js"></script>
	<!-- rich text editor library -->
	<script src="<?php echo base_url() ?>assets/backend/js/jquery.cleditor.min.js"></script>
	<!-- notification plugin -->
	<script src="<?php echo base_url() ?>assets/backend/js/jquery.noty.js"></script>
	<!-- file manager library -->
	<script src="<?php echo base_url() ?>assets/backend/js/jquery.elfinder.min.js"></script>
	<!-- star rating plugin -->
	<script src="<?php echo base_url() ?>assets/backend/js/jquery.raty.min.js"></script>
	<!-- for iOS style toggle switch -->
	<script src="<?php echo base_url() ?>assets/backend/js/jquery.iphone.toggle.js"></script>
	<!-- autogrowing textarea plugin -->
	<script src="<?php echo base_url() ?>assets/backend/js/jquery.autogrow-textarea.js"></script>
	<!-- multiple file upload plugin -->
	<script src="<?php echo base_url() ?>assets/backend/js/jquery.uploadify-3.1.min.js"></script>
	<!-- history.js for cross-browser state change on ajax -->
	<script src="<?php echo base_url() ?>assets/backend/js/jquery.history.js"></script>
	<!-- application script for Charisma demo -->
	<script src="<?php echo base_url() ?>assets/backend/js/charisma.js"></script>
		
</body>
</html>
