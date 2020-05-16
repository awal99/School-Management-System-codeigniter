<div class="row">
	<div class="col-md-12">
		<div class="panel panel-primary" data-collapsed="0">
        	<div class="panel-heading">
            	<div class="panel-title">
            		<i class="entypo-plus-circled"></i>
					<?php echo get_phrase('add_item');?>
            	</div>
            </div>
			<div class="panel-body">
				
                <?php echo form_open(base_url() . 'index.php?admin/inventory/create/' , array('class' => 'form-horizontal form-groups-bordered validate', 'enctype' => 'multipart/form-data'));?>
                    
					<div class="form-group">
						<label for="field-1" class="col-sm-3 control-label"><?php echo get_phrase('name');?></label>
                        
						<div class="col-sm-5">
							<input type="text" class="form-control" name="name" data-validate="required" data-message-required="<?php echo get_phrase('value_required');?>"  autofocus
                            	value="">
						</div>
					</div>
                    
					<div class="form-group">
						<label for="field-1" class="col-sm-3 control-label"><?php echo get_phrase('quantity');?></label>
						<div class="col-sm-5">
							<input type="text" class="form-control" name="quantity" value="">
						</div>
					</div>

                    <div class="form-group">
						<label for="field-2" class="col-sm-3 control-label"><?php echo get_phrase('Unit');?></label>
                        
						<div class="col-sm-5">
							<select name="unit" class="form-control">
                              <option value=""><?php echo get_phrase('select');?></option>
                              <option value="boxes"><?php echo get_phrase('boxes');?></option>
                              <option value="pieces"><?php echo get_phrase('piecies');?></option>
                              <option value="bags"><?php echo get_phrase('bags');?></option>
                              <option value="sacks"><?php echo get_phrase('sacks');?></option>
                              <option value="packets"><?php echo get_phrase('packets');?></option>
                              <option value="gallons"><?php echo get_phrase('gallons');?></option>
                          </select>
						</div> 
					</div>
					
					<<div class="form-group">
						<label for="field-2" class="col-sm-3 control-label"><?php echo get_phrase('date');?></label>
                        
						<div class="col-sm-5">
							<input type="text" class="form-control datepicker" name="date" value="" data-start-view="2">
						</div> 
					</div>
                    
                    <div class="form-group">
						<div class="col-sm-offset-3 col-sm-5">
							<button type="submit" class="btn btn-default" ><?php echo get_phrase('add_item');?></button>
						</div>
					</div>
                <?php echo form_close();?>
            </div>
        </div>
    </div>
</div>