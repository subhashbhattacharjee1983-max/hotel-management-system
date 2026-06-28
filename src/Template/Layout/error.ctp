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
		Hotel Management System :: <?php echo $this->fetch('title'); ?>
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
	?>
</head>
<body>
	<div id="notify_msg_div"></div>
	<div>
		<?php echo $this->element('admin_header'); ?>
        <div id="wrapper">
			<?php echo $this->element('admin_left_navigation'); ?>
            <div id="page-wrapper">
				<div class="page-content text-center">
					<?= $this->Html->image('/images/404.png', ['alt' => "404.png", 'border' => '0'])?> <br />
					<a href="<?php echo $this->Url->build("/bookings/dashboard") ?>" class="btn btn-success" style="margin-top: 45px;">Go To Dashboard</a>
				</div>
                <?php echo $this->element('admin_footer'); ?>
            </div>
        </div>
    </div>
</body>
</html>

