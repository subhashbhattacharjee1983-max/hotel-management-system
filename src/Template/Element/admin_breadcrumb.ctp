<div id="title-breadcrumb-option-demo" class="page-title-breadcrumb">
	<div class="page-header pull-left">
		<div class="page-title">
			<?php echo $this->fetch('heading'); ?>
		</div>
	</div>
	<ol class="breadcrumb page-breadcrumb pull-right">
		<?php 
		$limit_access = $this->request->getSession()->read('Auth.User.limit_access');
		if($this->fetch('heading') == "Dashboard")
		{ 
		?>
		<?php
		if(in_array(2, explode(',',$limit_access))) 
		{
		?>
		<li><a href="<?=$this->Url->build(['controller'=>'Bookings', 'action'=>'add']);?>" class="btn btn-orange-middle">Add Booking</a></li>
		<?php
		}
		if(in_array(5, explode(',',$limit_access))) 
		{
		?>
		<li><a href="<?=$this->Url->build(['controller'=>'Reservations', 'action'=>'add']);?>" class="btn btn-orange-middle">Add Reservation</a></li>
		<?php
		}
		if(in_array(6, explode(',',$limit_access))) 
		{
		?>
		<li><a href="<?=$this->Url->build(['controller'=>'FoodItemOrders', 'action'=>'add']);?>" class="btn btn-orange-middle">Add Kitchen Orders (KOT)</a></li>
		<?php
		}
		if(in_array(7, explode(',',$limit_access))) 
		{
		?>
		<li><a href="<?=$this->Url->build(['controller'=>'BeverageItemOrders', 'action'=>'add']);?>" class="btn btn-orange-middle">Add Beverage & Bar (BOT)</a></li>
		<?php
		}
		if(in_array(9, explode(',',$limit_access))) 
		{
		?>
		<li><a href="<?=$this->Url->build(['controller'=>'Bookings', 'action'=>'report']);?>" class="btn btn-orange-middle">Reports</a></li>
		<?php
		}
		?>
		<li></li>
		<li></li>
		<?php 
		} 
		?>
		<li><i class="fa fa-home"></i>&nbsp;<a href="javascript:void(0);">Home</a>&nbsp;&nbsp;<i class="fa fa-angle-right"></i>&nbsp;&nbsp;</li>
		<li class="hidden"><a href="<?php echo $this->fetch('breadcrumb_url'); ?>"><?php echo $this->fetch('breadcrumb'); ?></a>&nbsp;&nbsp;<i class="fa fa-angle-right"></i>&nbsp;&nbsp;</li>
		<li class="active"><a href="<?php echo $this->fetch('breadcrumb_url'); ?>"><?php echo $this->fetch('breadcrumb'); ?></a></li>
	</ol>
	<div class="clearfix">
	</div>
</div>