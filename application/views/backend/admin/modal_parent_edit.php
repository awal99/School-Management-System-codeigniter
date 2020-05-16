<?php 
	$edit_data = $this->db->get_where('parent' , array('parent_id' => $param2))->result_array();
	foreach ($edit_data as $row):
?>

<div class="row">
	<div class="col-md-12">
		<div class="panel panel-primary" data-collapsed="0">
        	<div class="panel-heading">
            	<div class="panel-title">
            		<i class="entypo-plus-circled"></i>
					<?php echo get_phrase('add_parent');?>
            	</div>
            </div>
			<div class="panel-body">
				
                <?php echo form_open(base_url() . 'index.php?admin/parent/edit/' . $row['parent_id'] , array('class' => 'form-horizontal parentedit form-groups-bordered validate', 'enctype' => 'multipart/form-data'));?>
                    <input class="parent_id" type="text" value="<?php echo $row['parent_id']; ?>" hidden="hidden"/>
					<div class="form-group">
						<label for="field-1" class="col-sm-3 control-label"><?php echo get_phrase('name');?></label>
                        
						<div class="col-sm-5">
							<input type="text" class="form-control" name="name" data-validate="required" data-message-required="<?php echo get_phrase('value_required');?>"
                            	value="<?php echo $row['name'];?>">
						</div>
					</div>
                    
					<div class="form-group">
						<label for="field-1" class="col-sm-3 control-label"><?php echo get_phrase('email');?></label>
						<div class="col-sm-5">
							<input type="email" class="form-control parentemail" name="email" 
                            	value="<?php echo $this->db->get_where('credentials',array('user_id'=>$row['parent_id'],'school_id'=>$this->session->userdata('school'),'account'=>2))->row()->email;?>">
								<small><i class="email_note" style="color:red"></i></small>
						</div>
					</div>
					
					<div class="form-group">
						<label for="field-2" class="col-sm-3 control-label"><?php echo get_phrase('phone');?></label>
                        
						<div class="col-sm-5">
							<input type="text" class="form-control" name="phone" data-validate="required" data-message-required="<?php echo get_phrase('value_required');?>" value="<?php echo $row['phone'];?>">
						</div>
					</div>
					
					<div class="form-group">
						<label for="field-2" class="col-sm-3 control-label"><?php echo get_phrase('address');?></label>
                        
						<div class="col-sm-5">
							<input type="text" class="form-control" data-validate="required" data-message-required="<?php echo get_phrase('value_required');?>" name="address" value="<?php echo $row['address'];?>">
						</div>
					</div>
					
					<div class="form-group">
						<label for="field-2" class="col-sm-3 control-label"><?php echo get_phrase('profession');?></label>
                        
						<div class="col-sm-5">
							<input type="text" class="form-control" name="profession" value="<?php echo $row['profession'];?>">
						</div>
					</div>
                    
                    <div class="form-group">
						<div class="col-sm-offset-3 col-sm-5">
							<button type="submit" class="btn btn-default" onclick="check_data();"><?php echo get_phrase('update');?></button>
						</div>
					</div>
                <?php echo form_close();?>
            </div>
        </div>
    </div>
</div>
<?php endforeach;?>

<script type="text/javascript">

function check_data(){
        event.preventDefault();
       
        var email = $('.parentemail').val();
        var parent_id = $('.parent_id').val();
		
		$.ajax({
			url: '<?php echo base_url();?>index.php?admin/check_email_update/'+ encodeURIComponent(email)+'/'+parent_id+'/'+"4",
			dataType: 'json',
			success: function(response)
			{
				if(response.status=='invalid')
				{
                    $('input[type="email"]').val(email);
				$('.email_note').html("This email already exist");

				}else{
					$('.parentedit').submit();
				}

			},
		   Error: function(err,status,messg){
			   alert(status+" "+messg);
		   }
		});
		return false;
	}


</script>