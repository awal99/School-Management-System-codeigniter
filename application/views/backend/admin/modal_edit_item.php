<?php 
	$data = $this->db->get_where('inventory', array('id' => $param2))->result_array();
?>

<div class="row">
	<div class="col-md-12">
		<div class="panel panel-primary" data-collapsed="0">
        	<div class="panel-heading">
            	<div class="panel-title">
            		<i class="entypo-plus-circled"></i>
					<?php echo get_phrase('edit_item');?>
            	</div>
            </div>
			<div class="panel-body">
				<?php foreach($data as $row):?>
                <?php echo form_open(base_url() . 'index.php?admin/inventory/edit/'.$row['id'] , array('class' => 'form-horizontal form-groups-bordered validate', 'enctype' => 'multipart/form-data'));?>
                    
					<div class="form-group">
						<label for="field-1" class="col-sm-3 control-label"><?php echo get_phrase('name');?></label>
                        
						<div class="col-sm-5">
							<input type="text" class="form-control" name="name" data-validate="required" data-message-required="<?php echo get_phrase('value_required');?>"  autofocus
                            	value="<?php echo $row['name'];?>">
						</div>
					</div>
                    
					<div class="form-group">
						<label for="field-1" class="col-sm-3 control-label"><?php echo get_phrase('quantity');?></label>
						<div class="col-sm-5">
						<i>This quantity is the last stocked quantity, you may only change it if you did a mistake while stocking</i>
							<input type="text" class="form-control" name="quantity" value="<?php echo $row['quantity']; ?>">
						</div>
					</div>

					<div class="form-group">
						<label for="field-1" class="col-sm-3 control-label"><?php echo get_phrase('current_quantity');?></label>
						<div class="col-sm-5">
							<input type="text" class="form-control" name="current_quantity" value="<?php echo $row['current_quantity']; ?>" disabled>
						</div>
					</div>

                    <div class="form-group">
						<label for="field-2" class="col-sm-3 control-label"><?php echo get_phrase('Unit');?></label>
                        
						<div class="col-sm-5">
							<select name="unit" class="form-control" >
                              <option value="<?php echo $row['unit']; ?>"><?php echo $row['unit']; ?></option>
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
							<input type="text" class="form-control datepicker" name="date" value="<?php echo $row['last_stocked']; ?>" data-start-view="2">
						</div> 
					</div>
                    
                    <div class="form-group">
						<div class="col-sm-offset-3 col-sm-5">
							<button type="submit" class="btn btn-default" ><?php echo get_phrase('save');?></button>
						</div>
					</div>
                <?php echo form_close();?>
				<?php endforeach;?>
            </div>
        </div>
    </div>
</div>