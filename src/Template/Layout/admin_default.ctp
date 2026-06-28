<?php
/**
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       app.View.Layouts
 * @since         CakePHP(tm) v 0.10.0.1076
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */

//$cakeDescription = __d('cake_dev', 'CakePHP: the rapid development php framework');
//$cakeVersion = __d('cake_dev', 'CakePHP %s', Configure::version())
?>
<!DOCTYPE html>
<html>
<head>
	<?php echo $this->Html->charset(); ?>
	<title>
		Hotel Booking System :: <?php echo $this->fetch('title'); ?>
	</title>
	<meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!--Loading bootstrap css-->
    <link type="text/css" rel="stylesheet" href="http://fonts.googleapis.com/css?family=Open+Sans:400italic,400,300,700">
    <link type="text/css" rel="stylesheet" href="http://fonts.googleapis.com/css?family=Oswald:400,700,300">
	<?php
		echo $this->Html->meta('icon');
		// ::::::::::::: CSS ::::::::::::::
		echo $this->Html->css([
				//'/styles/cake.generic',
				'/styles/jquery-ui-1.10.4.custom.min', 
				'/styles/font-awesome.min', 
				'/styles/bootstrap.min', 
				'/styles/animate', 
				'/styles/all', 
				'/styles/main', 
				'/styles/style-responsive', 
				'/styles/zabuto_calendar.min', 
				'/styles/pace', 
				'/styles/jquery.news-ticker', 
				'/styles/notifyBar',
				'/styles/validationEngine.jquery',
				'/styles/datatables.min',
				'/styles/bootstrap-colorpicker.min.css',
				'/styles/chosen.min.css'
			]);
		// :::::::::::::::: JS :::::::::::::
		echo $this->Html->script([
				'/script/jquery-1.10.2.min', 
				'/script/jquery-migrate-1.2.1.min',
				'/script/jquery-ui',
				'/script/bootstrap.min',
				'/script/bootstrap-hover-dropdown',
				'/script/html5shiv',
				'/script/respond.min',
				'/script/jquery.metisMenu',
				'/script/jquery.slimscroll',
				'/script/jquery.cookie',
				'/script/icheck.min', 
				'/script/custom.min',
				'/script/jquery.menu',
				'/script/responsive-tabs',
				/*'/script/index',*/
				// :::::::::: LOADING SCRIPTS FOR CHARTS :::::::::::
				// :::::::::: CORE JAVASCRIPT :::::::::::
				'/script/main', 
				'/script/jquery.notifyBar.fade', 
				'/script/jquery.validationEngine',
				'/script/jquery.validationEngine-en',
				'/script/datatables.min',
				'/script/bootstrap-colorpicker.min',
				'jquery.multi-select.min',
				'/script/chosen.jquery.min',
			]);

		/*echo $this->fetch('meta');
		echo $this->fetch('css');
		echo $this->fetch('script');*/
	?>
	<script type="text/javascript">
	<!--
		function readURL(input,id) {
			if (input.files && input.files[0]) {
				var reader = new FileReader();
				reader.onload = function (e) {
					$('#'+id+' img').show();
					$('#'+id+' img').attr('src', e.target.result);
					$('#'+id+'').next(".del_img").remove();
				}
				reader.readAsDataURL(input.files[0]);
			}
		}
		$(function(){
			$("input[type=file]").change(function(){
				if ($(this).attr('data-id') && $(this).attr('data-id')!='') {
					readURL(this,$(this).attr('data-id'));
				}
			});
		});
		
	//-->
	</script>
<style type="text/css">
	.jquery-notify-bar{
    padding:0px !important;
    margin:0;
    position:fixed;
    width:100%;
    background:transparent;
    z-index:10000000;
    top:0px;
    left:0px;
    }
.notify-bar-close {
	position: absolute;
	font-size: 11px;
	left: 95%;
	top: 5px;
	color: #fff !important;
}
.jquery-notify-bar div.error {
	filter: progid:dximagetransform.microsoft.gradient(startcolorstr='#db4444', endcolorstr='#bd3a3a'); background-color: #E77300; color: #fff0f0; text-shadow: 1px 1px 1px #bd3a3a;
	padding:15px;
	position:relative;
}
.jquery-notify-bar div.success{
	filter: progid:dximagetransform.microsoft.gradient(startcolorstr='#8dc96f', endcolorstr='#509c4b'); background-color: #8dc96f; color: #fff; text-shadow: #509c4b 1px 1px 1px;
	padding:15px;
	position:relative;
}
#flashMessage.success{
	/*filter: progid:dximagetransform.microsoft.gradient(startcolorstr='#8dc96f', endcolorstr='#509c4b'); background-color: #8dc96f; color: #fff; text-shadow: #509c4b 1px 1px 1px;*/
	padding:15px;
	position:relative;
}
	.status_btn
	{
		cursor: pointer;
		text-decoration: none;
		width: 74px;
		display: inline-block;
		text-align: center;
		font-weight: bold;
		padding: 6px;
	}
</style>
</head>
<body>
	<section id="loader_section" class="text-center">
		<?= $this->Html->image('/images/loder_img.gif', ['alt' => 'loder_img.gif'])?>
		<p>Please wait, your request is being processed</p>
	</section>
	<div id="notify_msg_div"></div>
	<div>
        <!--BEGIN BACK TO TOP-->
        <a id="totop" href="#"><i class="fa fa-angle-up"></i></a>
        <!--END BACK TO TOP-->
        <!--BEGIN TOPBAR-->
		<?php echo $this->element('admin_header'); ?>
        <!--END TOPBAR-->
        <div id="wrapper">
            <!--BEGIN SIDEBAR MENU-->
			<?php echo $this->element('admin_left_navigation'); ?>
            <!--END SIDEBAR MENU-->
            <!--BEGIN PAGE WRAPPER-->
            <div id="page-wrapper">
                <!--BEGIN TITLE & BREADCRUMB PAGE-->
				<?php echo $this->element('admin_breadcrumb'); ?>
                <!--END TITLE & BREADCRUMB PAGE-->
                <!--BEGIN CONTENT-->
				<div class="page-content">
					<!-- Flash Message -->
					<?php echo $this->fetch('content'); ?><!-- Content -->
				</div>
                <!--END CONTENT-->
                <!--BEGIN FOOTER-->
                <?php echo $this->element('admin_footer'); ?>
                <!--END FOOTER-->
            </div>
            <!--END PAGE WRAPPER-->
        </div>
    </div>
	<!-- ========== custom notify bar message =========== -->
	<script type="text/javascript">
	<!--
		showCustomMessage('<?=$this->Flash->render()?>');
	//-->
	</script>
</body>
</html>

