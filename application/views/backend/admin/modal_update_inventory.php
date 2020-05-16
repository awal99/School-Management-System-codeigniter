
<div class="row">
	<div class="col-md-12">
		<div class="panel panel-primary" data-collapsed="0">
        	<div class="panel-heading">
            	<div class="panel-title">
            		<i class="entypo-plus-circled"></i>
					<?php echo get_phrase('update_stock');?>
            	</div>
            </div>
			<div class="panel-body">
				
                <?php echo form_open(base_url() . 'index.php?admin/inventory/update/'.$param2 , array('class' => 'form-horizontal form-groups-bordered validate', 'enctype' => 'multipart/form-data'));?>
                    

                    <div class="form-group">
						<label for="field-2" class="col-sm-3 control-label"><?php echo get_phrase('action');?></label>
                        
						<div class="col-sm-5">
							<select name="action" class="form-control">
                              <option value="add"><?php echo get_phrase('add');?></option>
                              <option value="reduce"><?php echo get_phrase('reduce');?></option>
                          </select>
						</div> 
					</div>

					<div class="form-group">
						<label for="field-1" class="col-sm-3 control-label"><?php echo get_phrase('quantity');?></label>
                        
						<div class="col-sm-5">
                        <i>Input the quantity you want to increase or reduce stock by.</i>
							<input type="text" class="form-control" name="quantity" data-validate="required" data-message-required="<?php echo get_phrase('value_required');?>"  autofocus
                            	value="">
						</div>
					</div>
                    
	
                    
                    <div class="form-group">
						<div class="col-sm-offset-3 col-sm-5">
							<button type="submit" class="btn btn-default" ><?php echo get_phrase('save');?></button>
						</div>
					</div>
                <?php echo form_close();?>
				
            </div>
        </div>
    </div>
</div>