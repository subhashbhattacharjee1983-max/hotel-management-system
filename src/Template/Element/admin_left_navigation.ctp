<?php
	$controller = $this->request->getParam('controller');
	$action = $this->request->getParam('action');
	$limit_access = $this->request->getSession()->read('Auth.User.limit_access');
	?>
<nav id="sidebar" role="navigation" data-step="2" data-intro="Template has &lt;b&gt;many navigation styles&lt;/b&gt;" data-position="right" class="navbar-default navbar-static-side">
	<div class="sidebar-collapse menu-scroll">
		<ul id="side-menu" class="nav">
			<div class="clearfix"></div>
			<?php if($this->request->getSession()->check('Auth.User.user_type') && $this->request->getSession()->read('Auth.User.user_type') == '1'){ ?>
			<li <?=(($controller == 'Admins' && ($action=='index' || $action=='add' || $action=='edit')) ? 'class="active"' : '')?>>
				<a href="<?php echo $this->Url->build(['controller'=>'Admins', 'action'=>'add']); ?>">
					<i class="fa fa-user">
						<div class="icon-bg bg-pink"></div>
					</i>
					<span class="menu-title">Admin Users</span>									
				</a>
				<ul class="nav">
					<div class="clearfix"></div>
					<li <?=(($controller == 'Admins' && $action=='index') ? 'class="active"' : '')?>>
						<a href="<?php echo $this->Url->build(['controller'=>'Admins', 'action'=>'index']); ?>">
							<i class="fa fa-chevron-right fa-fw">
								<div class="icon-bg bg-violet"></div>
							</i>
							<span class="menu-title">List of Admin Users</span>
						</a>
					</li>
					<li <?=(($controller == 'Admins' && $action=='add') ? 'class="active"' : '')?>>
						<a href="<?php echo $this->Url->build(['controller'=>'Admins', 'action'=>'add']); ?>">
							<i class="fa fa-chevron-right fa-fw">
								<div class="icon-bg bg-violet"></div>
							</i>
							<span class="menu-title">Add New Admin Users</span>
						</a>
					</li>
				</ul>
			</li>
			<?php } ?>
			<?php
			if(in_array(10, explode(',',$limit_access))) 
			{
			?>
			<li <?=(($controller == 'Settings' && $action=='edit') ? 'class="active"' : '')?>>
				<a href="<?php echo $this->Url->build(['controller'=>'Settings', 'action'=>'edit']); ?>">
					<i class="fa fa-cogs">
						<div class="icon-bg bg-orange"></div>
					</i>
					<span class="menu-title">Settings</span>
				</a>
			</li>
			<?php } ?>
			<?php
			if(in_array(1, explode(',',$limit_access))) 
			{
			?>
			<li <?=(($controller == 'Bookings' && $action=='dashboard') ? 'class="active"' : '')?>>
				<a href="<?php echo $this->Url->build(['controller'=>'Bookings', 'action'=>'dashboard']); ?>">
					<i class="fa fa-th-list">
						<div class="icon-bg bg-orange"></div>
					</i>
					<span class="menu-title">Dashboard</span>
				</a>
			</li>
			<?php
			}
			if(in_array(2, explode(',',$limit_access))) 
			{
			?>
			<li <?=(($controller == 'Rooms' || $controller == 'RoomCategories') ? 'class="active"' : '')?>>
				<a href="<?=$this->Url->build(['controller'=>'Rooms', 'action'=>'index']);?>">
					<i class="fa fa-home">
						<div class="icon-bg bg-pink"></div>
					</i>
					<span class="menu-title">Room Management</span>									
				</a>
				<ul class="nav">
					<div class="clearfix"></div>
					<li <?=(($controller == 'RoomCategories' && $action=='index') ? 'class="active"' : '')?>>
						<a href="<?=$this->Url->build(['controller'=>'RoomCategories', 'action'=>'index']);?>">
							<i class="fa fa-chevron-right fa-fw">
								<div class="icon-bg bg-violet"></div>
							</i>
							<span class="menu-title">Room Category</span>
						</a>
					</li>
					<li <?=(($controller == 'Rooms' && $action=='index') ? 'class="active"' : '')?>>
						<a href="<?=$this->Url->build(['controller'=>'Rooms', 'action'=>'index']);?>">
							<i class="fa fa-chevron-right fa-fw">
								<div class="icon-bg bg-violet"></div>
							</i>
							<span class="menu-title">List of Rooms</span>
						</a>
					</li>
					<li <?=(($controller == 'Rooms' && $action=='add') ? 'class="active"' : '')?>>
						<a href="<?=$this->Url->build(['controller'=>'Rooms', 'action'=>'add']);?>">
							<i class="fa fa-chevron-right fa-fw">
								<div class="icon-bg bg-violet"></div>
							</i>
							<span class="menu-title">Add New Room</span>
						</a>
					</li>
				</ul>
			</li>
			<?php
			}
			?>
			<?php
			if(in_array(3, explode(',',$limit_access))) 
			{
			?>
			<li <?=(($controller == 'ServiceCategories' || $controller == 'RoomServices') ? 'class="active"' : '')?>>
				<a href="<?=$this->Url->build(['controller'=>'ServiceCategories', 'action'=>'index']);?>">
					<i class="fa fa-search">
						<div class="icon-bg bg-pink"></div>
					</i>
					<span class="menu-title">Room Service</span>									
				</a>
				<ul class="nav">
					<div class="clearfix"></div>
					<li <?=(($controller == 'ServiceCategories' && $action=='index') ? 'class="active"' : '')?>>
						<a href="<?=$this->Url->build(['controller'=>'ServiceCategories', 'action'=>'index']);?>">
							<i class="fa fa-chevron-right fa-fw">
								<div class="icon-bg bg-violet"></div>
							</i>
							<span class="menu-title">Service Categories</span>
						</a>
					</li>
					<li <?=(($controller == 'RoomServices' && $action=='index') ? 'class="active"' : '')?>>
						<a href="<?=$this->Url->build(['controller'=>'RoomServices', 'action'=>'index']);?>">
							<i class="fa fa-chevron-right fa-fw">
								<div class="icon-bg bg-violet"></div>
							</i>
							<span class="menu-title">Room Service</span>
						</a>
					</li>
				</ul>
			</li>
			<?php
			}
			if(in_array(4, explode(',',$limit_access))) 
			{
			?>
			<li <?php echo (($controller == 'Bookings' && ($action=='index' || $action=='add' || $action=='edit' || $action=='view' || $action=='oldbooking' || $action=='unpaid' || $action=='revedit')) ? 'class="active"' : '')?>>
				<a href="<?php echo $this->Url->build(['controller'=>'Bookings', 'action'=>'index']);?>">
					<i class="fa fa-cart-arrow-down">
						<div class="icon-bg bg-pink"></div>
					</i>
					<span class="menu-title">Bookings</span>									
				</a>
				<ul class="nav">
					<div class="clearfix"></div>
					<li <?php echo (($controller == 'Bookings' && $action=='index') ? 'class="active"' : '')?>>
						<a href="<?php echo $this->Url->build(['controller'=>'Bookings', 'action'=>'index']);?>">
							<i class="fa fa-chevron-right fa-fw">
								<div class="icon-bg bg-violet"></div>
							</i>
							<span class="menu-title">Recent Bookings</span>
						</a>
					</li>					
					<li <?php echo (($controller == 'Bookings' && $action=='add') ? 'class="active"' : '')?>>
						<a href="<?php echo $this->Url->build(['controller'=>'Bookings', 'action'=>'add']);?>">
							<i class="fa fa-chevron-right fa-fw">
								<div class="icon-bg bg-violet"></div>
							</i>
							<span class="menu-title">Add Bookings</span>
						</a>
					</li>
					<li <?php echo (($controller == 'Bookings' && $action=='oldbooking') ? 'class="active"' : '')?>>
						<a href="<?php echo $this->Url->build(['controller'=>'Bookings', 'action'=>'oldbooking']);?>">
							<i class="fa fa-chevron-right fa-fw">
								<div class="icon-bg bg-violet"></div>
							</i>
							<span class="menu-title">All Bookings</span>
						</a>
					</li>
				</ul>
			</li>
			<?php
			}
			if(in_array(5, explode(',',$limit_access))) 
			{
			?>
			<li <?php echo (($controller == 'Reservations' && ($action=='index' || $action=='add' || $action=='edit' || $action=='view')) ? 'class="active"' : '')?>>
				<a href="<?php echo $this->Url->build(['controller'=>'Reservations', 'action'=>'index']);?>">
					<i class="fa fa-cart-arrow-down">
						<div class="icon-bg bg-pink"></div>
					</i>
					<span class="menu-title">Reservations</span>									
				</a>
				<ul class="nav">
					<div class="clearfix"></div>
					<li <?php echo (($controller == 'Reservations' && $action=='index') ? 'class="active"' : '')?>>
						<a href="<?php echo $this->Url->build(['controller'=>'Reservations', 'action'=>'index']);?>">
							<i class="fa fa-chevron-right fa-fw">
								<div class="icon-bg bg-violet"></div>
							</i>
							<span class="menu-title">List of Reservation</span>
						</a>
					</li>					
					<li <?php echo (($controller == 'Reservations' && $action=='add') ? 'class="active"' : '')?>>
						<a href="<?php echo $this->Url->build(['controller'=>'Reservations', 'action'=>'add']);?>">
							<i class="fa fa-chevron-right fa-fw">
								<div class="icon-bg bg-violet"></div>
							</i>
							<span class="menu-title">Add Reservations</span>
						</a>
					</li>
				</ul>
			</li>
			<?php
			}
			if(in_array(6, explode(',',$limit_access))) 
			{
			?>
			<li <?=(($controller == 'FoodCategories' || $controller == 'FoodItems' || $controller == 'FoodItemOrders' && ($action=='index' || $action=='add' || $action=='edit' || $action=='view' || $action=='oldkotorder')) ? 'class="active"' : '')?>>
				<a href="<?=$this->Url->build(['controller'=>'FoodCategories', 'action'=>'index']);?>">
					<i class="fa fa-cutlery">
						<div class="icon-bg bg-pink"></div>
					</i>
					<span class="menu-title">Food & Kitchen</span>									
				</a>
				<ul class="nav">
					<div class="clearfix"></div>
					<li <?=(($controller == 'FoodCategories' && $action=='index') ? 'class="active"' : '')?>>
						<a href="<?=$this->Url->build(['controller'=>'FoodCategories', 'action'=>'index']);?>">
							<i class="fa fa-chevron-right fa-fw">
								<div class="icon-bg bg-violet"></div>
							</i>
							<span class="menu-title">Food Category</span>
						</a>
					</li>
					<li <?=(($controller == 'FoodItems' && $action=='index') ? 'class="active"' : '')?>>
						<a href="<?=$this->Url->build(['controller'=>'FoodItems', 'action'=>'index']);?>">
							<i class="fa fa-chevron-right fa-fw">
								<div class="icon-bg bg-violet"></div>
							</i>
							<span class="menu-title">Food Item</span>
						</a>
					</li>
					<li <?=(($controller == 'FoodItemOrders' && $action=='index') ? 'class="active"' : '')?>>
						<a href="<?=$this->Url->build(['controller'=>'FoodItemOrders', 'action'=>'index']);?>">
							<i class="fa fa-chevron-right fa-fw">
								<div class="icon-bg bg-violet"></div>
							</i>
							<span class="menu-title">Recent Kitchen Orders (KOT)</span>
						</a>
					</li>
					<li <?=(($controller == 'FoodItemOrders' && $action=='oldkotorder') ? 'class="active"' : '')?>>
						<a href="<?=$this->Url->build(['controller'=>'FoodItemOrders', 'action'=>'oldkotorder']);?>">
							<i class="fa fa-chevron-right fa-fw">
								<div class="icon-bg bg-violet"></div>
							</i>
							<span class="menu-title">All Kitchen Orders (KOT)</span>
						</a>
					</li>
				</ul>
			</li>
			<?php
			}
			if(in_array(7, explode(',',$limit_access))) 
			{
			?>
			<li <?=(($controller == 'BeverageCategories' || $controller == 'BeverageItems' || $controller == 'BeverageItemOrders' && ($action=='index' || $action=='add' || $action=='view' || $action=='oldbotorder')) ? 'class="active"' : '')?>>
				<a href="<?=$this->Url->build(['controller'=>'BeverageCategories', 'action'=>'index']);?>">
					<i class="fa fa-glass">
						<div class="icon-bg bg-pink"></div>
					</i>
					<span class="menu-title">Beverage & Bar</span>									
				</a>
				<ul class="nav">
					<div class="clearfix"></div>
					<li <?=(($controller == 'BeverageCategories' && $action=='index') ? 'class="active"' : '')?>>
						<a href="<?=$this->Url->build(['controller'=>'BeverageCategories', 'action'=>'index']);?>">
							<i class="fa fa-chevron-right fa-fw">
								<div class="icon-bg bg-violet"></div>
							</i>
							<span class="menu-title">Beverage Category</span>
						</a>
					</li>
					<li <?=(($controller == 'BeverageItems' && $action=='index') ? 'class="active"' : '')?>>
						<a href="<?=$this->Url->build(['controller'=>'BeverageItems', 'action'=>'index']);?>">
							<i class="fa fa-chevron-right fa-fw">
								<div class="icon-bg bg-violet"></div>
							</i>
							<span class="menu-title">Beverage Item</span>
						</a>
					</li>
					<li <?=(($controller == 'BeverageItemOrders' && $action=='index') ? 'class="active"' : '')?>>
						<a href="<?=$this->Url->build(['controller'=>'BeverageItemOrders', 'action'=>'index']);?>">
							<i class="fa fa-chevron-right fa-fw">
								<div class="icon-bg bg-violet"></div>
							</i>
							<span class="menu-title">Recent Bar Orders (BOT)</span>
						</a>
					</li>
					<li <?=(($controller == 'BeverageItemOrders' && $action=='oldbotorder') ? 'class="active"' : '')?>>
						<a href="<?=$this->Url->build(['controller'=>'BeverageItemOrders', 'action'=>'oldbotorder']);?>">
							<i class="fa fa-chevron-right fa-fw">
								<div class="icon-bg bg-violet"></div>
							</i>
							<span class="menu-title">All Bar Orders (BOT)</span>
						</a>
					</li>
				</ul>
			</li>
			<?php
			}
			if(in_array(8, explode(',',$limit_access))) 
			{
			?>
			<li <?php echo (($controller == 'Customers') ? 'class="active"' : '')?>>
				<a href="<?=$this->Url->build(['controller'=>'Customers', 'action'=>'index']);?>">
					<i class="fa fa-users">
						<div class="icon-bg bg-pink"></div>
					</i>
					<span class="menu-title">Customers</span>									
				</a>
				<ul class="nav">
					<div class="clearfix"></div>
					<li <?php echo (($controller == 'Customers' && $action=='index') ? 'class="active"' : '')?>>
						<a href="<?php echo $this->Url->build(['controller'=>'Customers', 'action'=>'index']);?>">
							<i class="fa fa-chevron-right fa-fw">
								<div class="icon-bg bg-violet"></div>
							</i>
							<span class="menu-title">List of Customers</span>
						</a>
					</li>
				</ul>
			</li>
			<?php
			}
			if(in_array(9, explode(',',$limit_access))) 
			{
			?>
			<li <?=(($controller == 'Bookings' && $action=='report') ? 'class="active"' : '')?>>
				<a href="<?php echo $this->Url->build(['controller'=>'Bookings', 'action'=>'report']); ?>">
					<i class="fa fa-bar-chart">
						<div class="icon-bg bg-orange"></div>
					</i>
					<span class="menu-title">Reports</span>
				</a>
			</li>
			<?php
			}
			?>
		</ul>
	</div>
	<?php if($this->fetch('heading') == "Dashboard"){ ?>
	<style>
    .slider {
      position: relative;
      width: 95%;
      max-width: 100%;
	  margin: 5px;
      height: 217px;
      overflow: hidden;
      border-radius: 10px;
      box-shadow: 0 5px 30px rgba(0, 0, 0, 0.4);
    }
    .slide-track {
      display: flex;
      width: 240px;
      animation: scroll 40s linear infinite;
    }
    .slide {
      width: 100%;
      height: 217px;
      flex-shrink: 0;
    }
    .slide img {
      width: 100%;
      height: 100%;
      object-fit: cover;
    }
    @keyframes scroll {
      0% {
        transform: translateX(0);
      }
      100% {
        transform: translateX(-1700px);
      }
    }
    @media (max-width: 768px) {
      .slider {
        height: 300px;
      }
      .slide {
        width: 100vw;
        height: 300px;
      }
      .slide-track {
        width: calc(100vw * 8);
        animation: scroll 40s linear infinite;
      }
      @keyframes scroll {
        0% { transform: translateX(0); }
        100% { transform: translateX(-400vw); }
      }
    }
  </style>
  <div class="slider">
    <div class="slide-track">
      <div class="slide"><img src="<?php echo $this->Url->build('/images/hotel_image_room.jpg');?>" alt="1"></div>
      <div class="slide"><img src="<?php echo $this->Url->build('/images/hotel_image_view.jpg');?>" alt="2"></div>
	  <div class="slide"><img src="<?php echo $this->Url->build('/images/food.jpg');?>" alt="3"></div>
      <div class="slide"><img src="<?php echo $this->Url->build('/images/dyning.jpg');?>" alt="4"></div>

	  <div class="slide"><img src="<?php echo $this->Url->build('/images/hotel_image_room.jpg');?>" alt="1"></div>
      <div class="slide"><img src="<?php echo $this->Url->build('/images/hotel_image_view.jpg');?>" alt="2"></div>
	  <div class="slide"><img src="<?php echo $this->Url->build('/images/food.jpg');?>" alt="3"></div>
      <div class="slide"><img src="<?php echo $this->Url->build('/images/dyning.jpg');?>" alt="4"></div>
    </div>
  </div>
  <?php } ?>
</nav>