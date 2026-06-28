<?php 
	$this->assign('title','Room Category');
	$this->assign('heading','Add Room Category');
	$this->assign('breadcrumb','Room Category'); 
	$this->assign('breadcrumb_url',$this->Url->build(['controller'=>'RoomCategories', 'action'=>'index'])); 
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
				<div class="panel-heading">Add Room Category</div>
				<div class="panel-body">
					<div class="row">
						<div class="col-lg-12">
							<div class="panel-body pan">
								<?php echo $this->Form->create($roomCategory,["name" => "add-form", "id" => "add-form", "method" => "POST", "type" => "file"]); ?>
								<div class="form-body pal">
									<div class="row">
										<div class="col-md-6">
											<div class="form-group">
												<label for="inputName" class="control-label">
													Room Category Name
												</label>
												<div class="input-icon right">
													<?php echo $this->Form->control('room_category_name', ['autocomplete' => 'off', 'class' => 'form-control validate[required]', 'label'=>false, 'required'=>false, 'div'=>false]);?>
												</div>
											</div>
										</div>
										<div class="col-md-6">
											<div class="form-group">
												<label for="inputName" class="control-label">
													Price Per Night (<?php echo $site_general_settings->currency; ?>)
												</label>
												<div class="input-icon right">
													<?php echo $this->Form->control('price_per_night', ['autocomplete' => 'off', 'min'=>'0', 'class' => 'form-control', 'label'=>false, 'required'=>false, 'div'=>false, 'placeholder'=>'Price Per Night']);?>
												</div>
											</div>
										</div>
										<div class="col-md-12">
											<div class="form-group">
												<label for="inputName" class="control-label">
												Description
												</label>
												<div class="input-icon right">
													<?php echo $this->Form->control('description', ['type'=>'textarea',  'autocomplete' => 'off', 'id'=>'editor1', 'class' => 'form-control', 'data-errormessage-value-missing'=>'Description is required', 'label'=>false, 'required'=>false, 'div'=>false]);?>
												</div>
											</div>
										</div>
										<div class="col-md-12">
											<div class="form-group">
												<label for="inputName" class="control-label">
													Status
												</label>
												<div class="input-icon right">
													<?php echo $this->Form->control('status',['type'=>'select','options'=>$status, 'class'=>'form-control', 'label'=>false, 'required'=>false]); ?>
												</div>
											</div>
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
<script>
	$("label").each(function() {
		var label = $(this);
		var placeholder = label.text();
		label.parent(".form-group").find(".form-control").attr("placeholder", placeholder.trim());
	});
</script>