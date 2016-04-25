
<div>
	<ul class="breadcrumb">
		<li>
			<a href="<?php echo $home; ?>"><? echo $modul; ?></a> <span class="divider">/</span>
		</li>
		<li>
			<a href="#"><? echo $subtitle; ?></a>
		</li>
	</ul>
</div>

<div class="row-fluid sortable">
				<div class="box span12">
					<div class="box-header well" data-original-title>
						<h2><i class="icon-edit"></i><? echo $subtitle; ?></h2>
						<div class="box-icon">
							<a href="#" class="btn btn-minimize btn-round"><i class="icon-chevron-up"></i></a>
						</div>
					</div>
					<div class="box-content">
						<form class="form-horizontal" action="<?php echo base_url() . $act; ?>" accept-charset="utf-8" enctype="multipart/form-data" method='post'>
							<fieldset>
								<div class="control-group">
									<label class="control-label" for="focusedInput">Step Name</label>
									<div class="controls">
									  <input class="input-xlarge focused" name='step_name' id="focusedInput" type="text" value="<?php echo set_value('step_name', isset($data['step_name']) ? $data['step_name'] : ''); ?>">
									</div>
								</div>
								
								<div class="control-group">
								  <label class="control-label" for="textarea2">Desc</label>
								  <div class="controls">
									<textarea class="cleditor" id="textarea2" rows="3" name='step_desc'><?php echo set_value('step_desc', isset($data['step_desc']) ? $data['step_desc'] : ''); ?></textarea>
								  </div>
								</div>
							  
							  <div class="form-actions">
								<button type="submit" class="btn btn-primary">Submit</button>
							  </div>
								
							</fieldset>
						</form>
					</div>
				</div><!--/span-->
</div><!--/row-->
