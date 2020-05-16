<?php 
$edit_data		=	$this->db->get_where('enroll' , array('student_id' => urldecode($param2),'year'=>$this->session->userdata('running_year')) )->result_array();
$settings = $this->db->get_where('s_settings',array('id'=>$this->session->userdata('school')))->row();
foreach ( $edit_data as $row):
?>
<div class="row">
	<div class="col-md-12">
		<div class="panel panel-primary" data-collapsed="0">
        	<div class="panel-heading">
            	<div class="panel-title" >
            		<i class="entypo-plus-circled"></i>
					<?php echo get_phrase('edit_student');?>
            	</div>
            </div>
			<div class="panel-body">
				
                <?php echo form_open(base_url() . 'index.php?admin/student/'.$row['class_id'].'/do_update/'.urlencode($row['student_id']) , array('class' => 'form-horizontal form-groups-bordered studentedit validate', 'enctype' => 'multipart/form-data'));?>
                
				<input type="text" class="student_id" value="<?php echo urlencode($row['student_id']); ?>" hidden="hidden"/>

					<div class="form-group">
						<label for="field-1" class="col-sm-3 control-label"><?php echo get_phrase('photo');?></label>
                        
						<div class="col-sm-5">
							<div class="fileinput fileinput-new" data-provides="fileinput">
								<div class="fileinput-new thumbnail" style="width: 100px; height: 100px;" data-trigger="fileinput">
									<img src="<?php echo $this->crud_model->get_image_url($settings->system_name,'student' , $row['student_id']);?>" alt="...">
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
						<label for="field-1" class="col-sm-3 control-label"><?php echo get_phrase('name');?></label>
                        
						<div class="col-sm-5">
							<input type="text" class="form-control" name="name" data-validate="required" data-message-required="<?php echo get_phrase('value_required');?>" 
							value="<?php echo $this->db->get_where('student',array('student_id'=>$row['student_id']))->row()->name;?>">
						</div>
					</div>

					<div class="form-group">
						<label for="field-2" class="col-sm-3 control-label"><?php echo get_phrase('parent');?></label>
                        
						<div class="col-sm-5">
							<select name="parent_id" class="form-control" data-validate="required" data-message-required="<?php echo get_phrase('value_required');?>">
                              <option value=""><?php echo get_phrase('select');?></option>
                              <?php 
									$parents = $this->db->get_where('parent',array('school_id'=>$this->session->userdata('school')))->result_array();
									$pid = $this->db->get_where('student',array('student_id'=>$row['student_id']))->row()->parent_id;
									foreach($parents as $row3):
										?>
                                		<option value="<?php echo $row3['parent_id'];?>"
                                        	<?php if($pid == $row3['parent_id'])echo 'selected';?>>
													<?php echo $row3['name'];?>
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
									onchange="return get_class_sections(this.value)" data-validate="required" data-message-required="<?php echo get_phrase('value_required');?>">
                              <option value=""><?php echo get_phrase('select');?></option>
                              <?php 
									$classes = $this->db->get_where('class',array('school_id'=>$this->session->userdata('school')))->result_array();
									
									foreach($classes as $row2):
										?>
                                		<option value="<?php echo $row2['class_id'];?>"
                                        	<?php if($row['class_id'] == $row2['class_id'])echo 'selected';?>>
													<?php echo $row2['name'];?>
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
							<input type="text" class="form-control" name="roll" value="<?php echo $row['roll'];?>" >
						</div> 
					</div>
					
					<div class="form-group">
						<label for="field-2" class="col-sm-3 control-label"><?php echo get_phrase('birthday');?></label>
                        
						<div class="col-sm-5">
							<input type="text" class="form-control datepicker" name="birthday" 
							value="<?php echo $this->db->get_where('student',array('student_id'=>$row['student_id']))->row()->birthday;?>" data-start-view="2">
						</div> 
					</div>
					
					<div class="form-group">
						<label for="field-2" class="col-sm-3 control-label"><?php echo get_phrase('gender');?></label>
                        
						<div class="col-sm-5">
						<?php $sex = $this->db->get_where('student',array('student_id'=>$row['student_id']))->row()->sex; ?>
							<select name="sex" class="form-control" data-validate="required" data-message-required="<?php echo get_phrase('value_required');?>">
                              <option value=""><?php echo get_phrase('select');?></option>
                              <option value="male" <?php if($sex == 'male')echo 'selected';?>><?php echo get_phrase('male');?></option>
                              <option value="female"<?php if($sex == 'female')echo 'selected';?>><?php echo get_phrase('female');?></option>
                          </select>
						</div> 
					</div>
					
					<div class="form-group">
						<label for="field-2" class="col-sm-3 control-label"><?php echo get_phrase('address');?></label>
                        
						<div class="col-sm-5">
							<input type="text" class="form-control" name="address" 
							value="<?php echo $this->db->get_where('student',array('student_id'=>$row['student_id']))->row()->address;?>" 
							data-validate="required" data-message-required="<?php echo get_phrase('value_required');?>">
						</div> 
					</div>
					
					<div class="form-group">
						<label for="field-2" class="col-sm-3 control-label"><?php echo get_phrase('phone');?></label>
                        
						<div class="col-sm-5">
							<input type="text" class="form-control" name="phone" 
							value="<?php echo $this->db->get_where('student',array('student_id'=>$row['student_id']))->row()->phone;?>" 
							data-validate="required" data-message-required="<?php echo get_phrase('value_required');?>">
						</div> 
					</div>
                    
					<div class="form-group">
						<label for="field-1" class="col-sm-3 control-label"><?php echo get_phrase('email');?></label>
						<div class="col-sm-5">
							<input type="email" class="form-control studentemail" name="email" 
							value="<?php echo $this->db->get_where('credentials',array('user_id'=>$row['student_id'],'school_id'=>$this->session->userdata('school')))->row()->email;?>" 
							data-validate="required" data-message-required="<?php echo get_phrase('value_required');?>">
							<small><i class="email_note" style="color:red"></i></small>
						</div>
					</div>
                    
                    <div class="form-group">
						<div class="col-sm-offset-3 col-sm-5">
							<button type="submit" class="btn btn-info btnsubmit"><?php echo get_phrase('edit_student');?></button>
						</div>
					</div>
                <?php echo form_close();?>
            </div>
        </div>
    </div>
</div>

<?php
endforeach;
?>

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

var class_id = $("#class_id").val();

$.ajax({
	url: '<?php echo base_url();?>index.php?admin/get_class_section/' + class_id ,
	success: function(response)
	{
		jQuery('#section_selector_holder').html(response);
	}
});

$('.btnsubmit').click(function(e){
       e.preventDefault();

        var email = $('.studentemail').val();
        var student_id = $('.student_id').val();
		
		$.ajax({
			url: '<?php echo base_url();?>index.php?admin/check_email_update/'+ encodeURIComponent(email)+'/'+ student_id+'/'+'3',
			dataType: 'json',
			success: function(response)
			{
				if(response.status=='invalid')
				{
                    $('input[type="email"]').val(email);
				$('.email_note').html("This email already exist");

				}else{
					
					$('.studentedit').submit();
				}

			},
		   Error: function(err,status,messg){
			   alert(status+" "+messg);
		   }
		});

		return false;
	});

	


</script>