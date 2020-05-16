<div class="row">
	<div class="col-md-12">
    
    	<!------CONTROL TABS START------->
		<ul class="nav nav-tabs bordered">

			<li class="active">
            	<a href="#list" data-toggle="tab"><i class="entypo-user"></i> 
					<?php echo get_phrase('manage_profile');?>
                    	</a></li>
		</ul>
    	<!------CONTROL TABS END------->
        
	
		<div class="tab-content">
        	<!----EDITING FORM STARTS---->
			<div class="tab-pane box active" id="list" style="padding: 5px">
                <div class="box-content">
				
                        <?php echo form_open(base_url() . 'index.php?parents/manage_profile/update_profile_info' , array('class' => 'form-horizontal parent-edit form-groups-bordered validate','target'=>'_top'));?>
                        <input type="text" class="parent_id" value="<?php echo $this->session->userdata('parent_id'); ?>" hidden="hidden"/>
                            <div class="form-group">
                                <label class="col-sm-3 control-label"><?php echo get_phrase('name');?></label>
                                <div class="col-sm-5">
                                    <input type="text" class="form-control" name="name" value="<?php echo $name;?>"/>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label"><?php echo get_phrase('email');?></label>
                                <div class="col-sm-5">
                                    <input type="email" class="form-control" name="email" value="<?php echo $email;?>"/>
                                    <small><i class="email_note" style="color:red"></i></small>
                                </div>
                            </div>
                            <div class="form-group">
                              <div class="col-sm-offset-3 col-sm-5">
                                  <button type="submit" class="btn btn-info" onclick="check_data()"><?php echo get_phrase('update_profile');?></button>
                              </div>
								</div>
                        </form>
					
                </div>
			</div>
            <!----EDITING FORM ENDS--->
            
		</div>
	</div>
</div>


<!--password-->
<div class="row">
	<div class="col-md-12">
    
    	<!------CONTROL TABS START------>
		<ul class="nav nav-tabs bordered">

			<li class="active">
            	<a href="#list" data-toggle="tab"><i class="entypo-lock"></i> 
					<?php echo get_phrase('change_password');?>
                    	</a></li>
		</ul>
    	<!------CONTROL TABS END------>
        
	
		<div class="tab-content">
        	<!----EDITING FORM STARTS---->
			<div class="tab-pane box active" id="list" style="padding: 5px">
                <div class="box-content padded">
				
                        <?php echo form_open(base_url() . 'index.php?parents/manage_profile/change_password' , array('class' => 'form-horizontal form-groups-bordered validate','target'=>'_top'));?>
                            <div class="form-group">
                                <label class="col-sm-3 control-label"><?php echo get_phrase('current_password');?></label>
                                <div class="col-sm-5">
                                    <input type="password" class="form-control" name="password" value=""/>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label"><?php echo get_phrase('new_password');?></label>
                                <div class="col-sm-5">
                                    <input type="password" class="form-control" name="new_password" value=""/>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label"><?php echo get_phrase('confirm_new_password');?></label>
                                <div class="col-sm-5">
                                    <input type="password" class="form-control" name="confirm_new_password" value=""/>
                                </div>
                            </div>
                            <div class="form-group">
                              <div class="col-sm-offset-3 col-sm-5">
                                  <button type="submit" class="btn btn-info" onclick="checkpassword()"><?php echo get_phrase('update_profile');?></button>
                              </div>
								</div>
                        </form>
					
                </div>
			</div>
            <!----EDITING FORM ENDS-->
            
		</div>
	</div>
</div>

<script type="text/javascript">

function checkpassword(){
	var count = jQuery('input[type="password"]').val().length;
	if(count > 0 && count < 8){
	alert('Password must be at least 8 characters or blank');
	event.preventDefault();
	}
}

function check_data(){
        event.preventDefault();
        var email = $('input[type="email"]').val();
        var parent_id = $('.parent_id').val();

		$.ajax({
			url: '<?php echo base_url();?>index.php?parents/check_email_update/'+ encodeURIComponent(email)+'/'+parent_id+'/'+"4",
			dataType: 'json',
			success: function(response)
			{
				if(response.status=='invalid')
				{
                    $('input[type="email"]').val(email);
				$('.email_note').html("This email already exist");

				}else{
					
					$('.parent-edit').submit();
				}

			},
		   Error: function(err,status,messg){
			   alert(status+" "+messg);
		   }
		});


}


</script>