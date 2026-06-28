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
		Welcome to Hotel Booking System <?php //echo $this->fetch('title'); ?>
	</title>
	<link type="text/css" href="http://fonts.googleapis.com/css?family=Open+Sans:400italic,700italic,800italic,400,700,800">
    <link type="text/css" rel="stylesheet" href="http://fonts.googleapis.com/css?family=Oswald:400,700,300">
    <link type="text/css" rel="stylesheet" href="styles/font-awesome.min.css">
	<?php
		echo $this->Html->meta('icon');
		echo $this->Html->css(['/styles/font-awesome.min', '/styles/bootstrap.min', '/styles/animate', '/styles/all', '/styles/main', '/styles/style-responsive', '/styles/login', '/styles/notifyBar', '/styles/validationEngine.jquery']);

		echo $this->Html->script(['/script/jquery-1.10.2.min', '/script/jquery.notifyBar', '/script/jquery.validationEngine', '/script/jquery.validationEngine-en']);

		echo $this->fetch('meta');
		echo $this->fetch('css');
		echo $this->fetch('script');
	?>
	<style type="text/css">
		#notify_msg_div
		{
			position:relative;
		}
		.jquery-notify-bar{
			padding:0;
			margin:0;
			/*position:fixed;
			top:0;*/
			width:100%;
			background:transparent;
			position:absolute;
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
		.jquery-notify-bar div.message{
			/*background-color: #ffffff;
			padding:15px;*/
			position:relative;
		}
	</style>
</head>
<?php
	$rand_image = [
		"bannerbg.jpg",
		"bannerbghome.jpg",
		"bannerbgtemple.jpg",
		"bhutanbgstreet.jpg"
	];
	$randomIndex = rand(0, count($rand_image) -1);
?>
<body style="background:url('<?=$this->Url->build('/images/'.$rand_image[$randomIndex])?>') no-repeat center center; background-size: cover; display: flex; align-items: center;">
	<div id="notify_msg_div"></div>
	<?php echo $this->fetch('content'); ?>
	<div class="clearfix"></div>
</body>
</html>

<!-- ========== custom notify bar message =========== -->
<script type="text/javascript">
<!--
	showCustomMessage('<?=$this->Flash->render()?>');
//-->
</script>