<?php 
	if($settings->id==null){$settings = $settings->row();}
?>
<div class="row">
	<div class="col-md-10">
		<div class="panel panel-primary" data-collapsed="0">
        	<div class="panel-heading">
            	<div class="panel-title" >
            		<i class="entypo-plus-circled"></i>
					<?php echo get_phrase('addmission_form');?>
            	</div>
            </div>
		
			<div class="panel-body">
				
                <?php echo form_open(base_url() . 'index.php?admin/student/create/' , array('class' => 'form-horizontal studentadd form-groups-bordered validate', 'enctype' => 'multipart/form-data'));?>
	
					<div class="form-group">
						<label for="field-1" class="col-sm-3 control-label"><?php echo get_phrase('name');?></label>
                        
						<div class="col-sm-5">
							<input type="text" class="form-control" name="name" data-validate="required" data-message-required="<?php echo get_phrase('value_required');?>" value="" autofocus>
						</div>
					</div>

					<div class="form-group">
						<label for="field-2" class="col-sm-3 control-label"><?php echo get_phrase('parent');?></label>
                        
						<div class="col-sm-5">
							<select name="parent_id" class="form-control">
                              <option value=""><?php echo get_phrase('select');?></option>
							  <?php 
							     
								$parents = $this->db->get_where('parent',array('school_id'=> $settings->id))->result_array();
								foreach($parents as $row):
									?>
                            		<option value="<?php echo $row['parent_id'];?>">
										<?php echo $row['name'];?>
                                    </option>
                                <?php
								endforeach;
							  ?>
                          </select>
						</div> 
					</div>

					<div class="form-group">
						<label for="field-2" class="col-sm-3 control-label"><?php echo get_phrase('Dormitory');?></label>
                        
						<div class="col-sm-5">
							<select name="dormitory_id" class="form-control">
                              <option value=""><?php echo get_phrase('select');?></option>
							  <?php 
							     
								$parents = $this->db->get_where('dormitory',array('school_id'=> $settings->id))->result_array();
								foreach($parents as $row):
									?>
                            		<option value="<?php echo $row['dormitory_id'];?>">
										<?php echo $row['name'];?>
                                    </option>
                                <?php
								endforeach;
							  ?>
                          </select>
						</div> 
					</div>
					
					<div class="form-group">
						<label for="field-2" class="col-sm-3 control-label"><?php echo get_phrase('class');?></label>
                        
						<div class="col-sm-5">
							<select name="class_id" class="form-control" data-validate="required" id="class_id" 
								data-message-required="<?php echo get_phrase('value_required');?>"
									onchange="return get_class_sections(this.value)">
                              <option value=""><?php echo get_phrase('select');?></option>
                              <?php 
								//$classes = $this->db->get('class')->result_array();
								if($classes == null){
									$classes = $this->db->get_where('class',array('school_id'=>$settings->id))->result_array();
								}
								foreach($classes as $row):
									?>
                            		<option value="<?php echo $row['class_id'];?>">
											<?php echo $row['name'];?>
                                            </option>
                                <?php
								endforeach;
							  ?>
                          </select>
						</div> 
					</div>

					<div class="form-group">
						<label for="field-2" class="col-sm-3 control-label"><?php echo get_phrase('section');?></label>
		                    <div class="col-sm-5">
		                        <select name="section_id" class="form-control" id="section_selector_holder">
		                            <option value=""><?php echo get_phrase('select_class_first');?></option>
			                        
			                    </select>
			                </div>
					</div>
					
					<div class="form-group">
						<label for="field-2" class="col-sm-3 control-label"><?php echo get_phrase('roll');?></label>
                        
						<div class="col-sm-5">
							<input type="text" class="form-control" name="roll" value="" >
						</div> 
					</div>
					
					<div class="form-group">
						<label for="field-2" class="col-sm-3 control-label"><?php echo get_phrase('birthday');?></label>
                        
						<div class="col-sm-5">
							<input type="text" class="form-control datepicker" name="birthday" value="" data-start-view="2">
						</div> 
					</div>
					
					<div class="form-group">
						<label for="field-2" class="col-sm-3 control-label"><?php echo get_phrase('gender');?></label>
                        
						<div class="col-sm-5">
							<select name="sex" class="form-control">
                              <option value=""><?php echo get_phrase('select');?></option>
                              <option value="male"><?php echo get_phrase('male');?></option>
                              <option value="female"><?php echo get_phrase('female');?></option>
                          </select>
						</div> 
					</div>
					
					<div class="form-group">
						<label for="field-2" class="col-sm-3 control-label"><?php echo get_phrase('address');?></label>
                        
						<div class="col-sm-5">
							<input type="text" class="form-control" name="address" value="" >
						</div> 
					</div>
					
					<div class="form-group">
						<label for="field-2" class="col-sm-3 control-label"><?php echo get_phrase('phone');?></label>
                        
						<div class="col-sm-5">
							<input type="text" class="form-control" name="phone" value="" >
							
						</div> 
					</div>
                    
					<div class="form-group">
						<label for="field-1" class="col-sm-3 control-label"><?php echo get_phrase('email');?></label>
						<div class="col-sm-5">
							<input type="email" class="form-control" name="email" value="">
							<small><i class="email_note" style="color:red"></i></small>
						</div>
					</div>
					
					<div class="form-group">
						<label for="field-2" class="col-sm-3 control-label"><?php echo get_phrase('password');?></label>
                        
						<div class="col-sm-5">
							<input type="password" class="form-control" name="password" >
						</div> 
					</div>

					
	
					<div class="form-group">
						<label for="field-1" class="col-sm-3 control-label"><?php echo get_phrase('photo');?></label>
                        
						<div class="col-sm-5">
							<div class="fileinput fileinput-new" data-provides="fileinput">
								<div class="fileinput-new thumbnail" style="width: 100px; height: 100px;" data-trigger="fileinput">
									<img src="http://placehold.it/200x200" alt="...">
								</div>
								<div class="fileinput-preview fileinput-exists thumbnail" style="max-width: 200px; max-height: 150px"></div>
								<div>
									<span class="btn btn-white btn-file">
										<span class="fileinput-new">Select image</span>
										<span class="fileinput-exists">Change</span>
										<input type="file" name="userfile" accept="image/*">
									</span>
									<a href="#" class="btn btn-orange fileinput-exists" data-dismiss="fileinput">Remove</a>
								</div>
							</div>
						</div>
					</div>
                    
                    <div class="form-group">
						<div class="col-sm-offset-3 col-sm-5">
							<button type="submit" class="btn btn-info" onclick="check_data()"><?php echo get_phrase('add_student');?></button>
						</div>
					</div>
                <?php echo form_close();?>
            </div>
        </div>
    </div>

	<div class="col-md-2">
		<div class="blockquote card bg-primary">
			<i>Please make sure to fill all fields, the password field must be at least 8 character or left blank. <br/>The email field should also 
			be in email format or should be left blank.<p>default password for students is 'Student123'</p></i>
		</div>
	</div>
</div>

<script type="text/javascript">

	function get_class_sections(class_id) {

    	$.ajax({
            url: '<?php echo base_url();?>index.php?admin/get_class_section/' + class_id ,
            success: function(response)
            {
                jQuery('#section_selector_holder').html(response);
            }
        });

	}

	function check_data(){
		event.preventDefault();
		var email = $('input[type="email"]').val();
        
		var count = jQuery('input[type="password"]').val().length;
		
		if(count > 0 && count < 8){
		alert('Password must be at least 8 characters or blank');
		}else{

		$.ajax({
			url: '<?php echo base_url();?>index.php?admin/check_email/'+ encodeURIComponent(email),
			dataType: 'json',
			success: function(response)
			{
				if(response.status=='invalid')
				{
					if(response.data != null)
					{
						$('input[type="email"]').val(response.data);
						$('.email_note').html("An email has been generated for you.  <button class='btn btn-primary getEmail' onclick='event.preventDefault();'>Get new email</button>");
					}else{
						$('.email_note').html("This email already exist  <button class='btn btn-primary getEmail' onclick='event.preventDefault();'>Get email</button> ");

					}
				}else if(response.status=='valid'){
					
					$('.studentadd').submit();
				}

			},
		   Error: function(err,status,messg){
			   alert(status+" "+messg);
		   }
		});
		}
	}

    
	
	

</script>