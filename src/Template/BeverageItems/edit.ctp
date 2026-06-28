<?php 
	$this->assign('title','Beverage Item');
	$this->assign('heading','Edit Beverage Item');
	$this->assign('breadcrumb','Beverage Item'); 
	$this->assign('breadcrumb_url',$this->Url->build(['controller'=>'BeverageItems', 'action'=>'index'])); 
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
			<div id="notify_msg_div"></div>
		</div>
		<div class="col-lg-12">
			<div class="panel panel-grey">
				<div class="panel-heading">Edit Beverage Item </div>
				<div class="panel-body">
					<div class="row">
						<div class="col-lg-12">
							<div class="panel-body pan">
								<?php echo $this->Form->create($beverageItem,["name" => "edit-form", "id" => "edit-form", "method" => "POST", "type" => "file"]); ?>
								<div class="form-body pal">
									<div class="row">
										<div class="col-md-4">
											<div class="form-group">
												<label for="inputName" class="control-label">
													Beverage Item Name
												</label>
												<div class="input-icon right">
													<?php echo $this->Form->control('beverage_item_name', ['autocomplete' => 'off', 'class' => 'form-control validate[required]', 'label'=>false, 'required'=>false, 'div'=>false]);?>
												</div>
											</div>
										</div>
										<div class="col-md-4">
											<div class="form-group">
												<label for="inputName" class="control-label">
												Beverage Item Price (<?php echo $site_general_settings->currency; ?>)
												</label>
												<div class="input-icon right">
													<?php echo $this->Form->control('beverage_item_price', ['autocomplete' => 'off', 'class' => 'form-control validate[required]', 'label'=>false, 'required'=>false, 'div'=>false]);?>
												</div>
											</div>
										</div>
										<div class="col-md-4">
											<div class="form-group">
												<label for="inputName" class="control-label">
													Beverage Item Category
												</label>
												<div class="input-icon right">
													<?php echo $this->Form->control('beverage_category_id',['type'=>'select', 'options'=>$beverageCategories, 'class'=>'form-control validate[required]', 'empty'=>'Beverage Item Category', 'label'=>false, 'required'=>false]); ?>
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
										<?=$this->Form->button('Update', ['type'=>'submit', 'name'=>'btn_login', 'id'=>'btn_login', 'class'=>'btn btn-orange-middle','value'=>'Login']);?>
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
<script type="text/javascript">
<!--
	$("label").each(function() {
		var label = $(this);
		var placeholder = label.text();
		label.parent(".form-group").find(".form-control").attr("placeholder", placeholder.trim());
	});
//-->
</script>