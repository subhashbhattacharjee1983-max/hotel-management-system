<?php 
	$this->assign('title','Profile');
	$this->assign('heading','Profile');
	$this->assign('breadcrumb','Profile'); 
	$this->assign('breadcrumb_url',$this->Url->build(['controller'=>'Admins', 'action'=>'edit_profile'])); 
?>
<script type="text/javascript">
<!--
	$(function(){
		$("#edit-form").validationEngine();
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
				 <div class="panel panel-grey">
					<div class="panel-heading">Admin Profile</div>
					<div class="panel-body">
						<div class="row">
							<div class="col-lg-12">
								<div class="panel-body pan">
									<?php echo $this->Form->create($admin, ["name" => "edit-form", "id" => "edit-form", "method" => "POST", "type" => "file"]); ?>
									<div class="form-body pal">
										<div class="row">
											<div class="col-md-4">
												<div class="form-group">
													<label for="inputName" class="control-label">
														Email Address
													</label>
													<div class="input-icon right">
														<?php echo $this->Form->control('email', ['autocomplete' => 'off', 'class' => 'form-control validate[required,custom[email]]', 'data-errormessage-value-missing'=>'Email Address is required', 'label'=>false, 'required'=>false, 'div'=>false, 'action'=>'', 'placeholder'=>'E-mail']);?>
													</div>
												</div>
											</div>
											<div class="col-md-4">
												<div class="form-group">
													<label for="inputName" class="control-label">
														Password
													</label>
													<div class="input-icon right">
														<?php echo $this->Form->control('password', ['autocomplete' => 'off', 'type'=>'password', 'class' => 'form-control validate[optional]', 'id'=>'password', 'label'=>false, 'required'=>false, 'div'=>false, 'placeholder'=>'Password','value'=>'']);?>
													</div>

												</div>
											</div>
											<div class="col-md-4">
												<div class="form-group">
													<label for="inputName" class="control-label">
														Confirm Password
													</label>
													<div class="input-icon right">
														<?php echo $this->Form->control('admin_con_pass', ['autocomplete' => 'off', 'type'=>'password', 'class' => 'form-control validate[equals[password]]', 'label'=>false, 'required'=>false, 'div'=>false, 'placeholder'=>'Confirm Password','value'=>'']);?>
													</div>
												</div>
											</div>
										</div>
										</div>
										<div class="form-actions text-right pal">
											<button type="submit" class="btn btn-orange-middle" name = "btn_submit" id = "btn_submit">Update</button>
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