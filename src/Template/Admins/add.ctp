<?php 
	$this->assign('title','Admin User');
	$this->assign('heading','Admin User');
	$this->assign('breadcrumb','Admin User'); 
	$this->assign('breadcrumb_url',$this->Url->build(['controller'=>'Admins', 'action'=>'index']));
	
?>
<script type="text/javascript">
<!--
	$(function(){
		$("#add-form").validationEngine();
	});
//-->
</script>

	<div id="tab-general">
		<div class="row mbl">
			<div class="col-lg-12">
				<div class="col-md-12">
					<div id="area-chart-spline" style="width: 100%; height: 300px; display: none;">
					</div>
				</div>
			</div>
			<div class="col-lg-12">
				<div id="notify_msg_div"></div>
			</div>
			
			<div class="col-lg-12">
				 <div class="panel panel-grey">
					<div class="panel-heading">Add Admin Users </div>
					<div class="panel-body">
						<div class="row">
							<div class="col-lg-12">
								<div class="panel-body pan">
									<?php echo $this->Form->create($admin, ["name" => "add-form", "id" => "add-form", "method" => "POST", "type" => "file"]); ?>
									<div class="form-body pal">
										<div class="row">
											<div class="col-md-4">
												<div class="form-group">
													<label for="inputName" class="control-label">
														Name
													</label>
													<div class="input-icon right">
														<?php echo $this->Form->control('name', ['autocomplete' => 'off', 'type'=>'text', 'class' => 'form-control validate[required]', 'label'=>false, 'required'=>false, 'div'=>false, 'placeholder'=>'Name']);?>
													</div>
												</div>
											</div>
											<div class="col-md-4">
												<div class="form-group">
													<label for="inputName" class="control-label">
														Email Address
													</label>
													<div class="input-icon right">
														<?php echo $this->Form->control('email', ['autocomplete' => 'off', 'type'=>'text', 'class' => 'form-control validate[required, custom[email]]', 'label'=>false, 'required'=>false, 'div'=>false, 'placeholder'=>'Email Address']);?>
													</div>
												</div>
											</div>
											<div class="col-md-4">
												<div class="form-group">
													<label for="inputName" class="control-label">
														Password
													</label>
													<div class="input-icon right">
														<?php echo $this->Form->control('password', ['autocomplete' => 'off', 'type'=>'password', 'id'=>'password', 'class' => 'form-control validate[required]', 'label'=>false, 'required'=>false, 'div'=>false, 'placeholder'=>'Password', 'value'=>'']);?>
													</div>
												</div>
											</div>
											<div class="col-md-4">
												<div class="form-group">
													<label for="inputName" class="control-label">
														Confirm Password
													</label>
													<div class="input-icon right">
														<?php echo $this->Form->control('confirm_pass', ['autocomplete' => 'off', 'type'=>'password', 'class' => 'form-control validate[required, equals[password]]', 'label'=>false, 'required'=>false, 'div'=>false, 'placeholder'=>'Confirm Password']);?>
													</div>
												</div>
											</div>
											<div class="col-md-4">
												<div class="form-group">
													<label for="inputName" class="control-label">
														Account Type
													</label>
													<div class="input-icon right">
														<?php echo $this->Form->control('user_type',['type'=>'select','options'=>$account_type, 'class'=>'form-control validate[required]', 'empty' => 'Select Account Type', 'label'=>false, 'required'=>false]); ?>
													</div>
												</div>	
											</div>
											<div class="col-md-4">
												<div class="form-group">
													<label for="inputName" class="control-label">
														Status
													</label>
													<div class="input-icon right">
														<?php echo $this->Form->control('status',['type'=>'select','options'=>$status, 'class'=>'form-control', 'label'=>false, 'required'=>false]); ?>
													</div>
												</div>	
											</div>
											<div class="col-md-12">
												<div class="form-group" style="padding-left:0px; font-size: 19px;">
												   <label for="inputSubject" class="control-label">
												   System Limitation Access
												   </label>
												</div>
											</div>
											<?php 
											if(!empty($access_menu))
											{ 
												foreach($access_menu as $key => $val)
												{
											?>
											<div class="form-group col-md-3">
											   <label for="inputSubject" style="margin-left:5px;" class="control-label">
											   <?php echo $this->Form->control('limit_access[]', array('type'=>'checkbox', 'value'=>$key, 'style' => 'width: 17px;', 'autocomplete' => 'off', 'class' => 'form-control', 'label'=>false, 'required'=>false, 'div'=>false))."<div style='margin: -20px 27px;'>".$val."</div>";;?>
											   </label>
											</div>
											<?php
												}
											}
											?>
										</div>
									</div>										
									<div class="form-actions text-right pal">
										<?=$this->Form->button('Add', ['type'=>'submit', 'name'=>'btn_login', 'id'=>'btn_login', 'class'=>'btn btn-orange-middle','value'=>'Login']);?>
									</div>
									<?php echo $this->Form->end(); ?>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>