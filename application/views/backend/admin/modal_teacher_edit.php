<?php 
$school = $this->db->get_where('s_settings',array('id'=>$this->session->userdata('school')))->row()->system_name;
$edit_data		=	$this->db->get_where('teacher' , array('school_id'=>$this->session->userdata('school'),'teacher_id' => $param2) )->result_array();
foreach ( $edit_data as $row):
?>
<div class="row">
	<div class="col-md-12">
		<div class="panel panel-primary" data-collapsed="0">
        	<div class="panel-heading">
            	<div class="panel-title" >
            		<i class="entypo-plus-circled"></i>
					<?php echo get_phrase('edit_teacher');?>
            	</div>
            </div>
			<div class="panel-body">

                    <?php echo form_open(base_url() . 'index.php?admin/teacher/do_update/'.$row['teacher_id'] , array('class' => 'form-horizontal teacheredit form-groups-bordered validate','target'=>'_top', 'enctype' => 'multipart/form-data'));?>
                        		<input type="text" class="teacher_id" value="<?php echo $row['teacher_id']; ?>" hidden="hidden"/>
                                <div class="form-group">
                                <label for="field-1" class="col-sm-3 control-label"><?php echo get_phrase('photo');?></label>
                                
                                <div class="col-sm-5">
                                    <div class="fileinput fileinput-new" data-provides="fileinput">
                                        <div class="fileinput-new thumbnail" style="width: 100px; height: 100px;" data-trigger="fileinput">
                                            <img src="<?php echo $this->crud_model->get_image_url($school,'teacher' , $row['teacher_id']);?>" alt="...">
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
                                <label class="col-sm-3 control-label"><?php echo get_phrase('name');?></label>
                                <div class="col-sm-5">
                                    <input type="text" class="form-control" name="name" value="<?php echo $row['name'];?>"/>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label"><?php echo get_phrase('birthday');?></label>
                                <div class="col-sm-5">
                                    <input type="text" class="datepicker form-control" name="birthday" value="<?php echo $row['birthday'];?>"/>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label"><?php echo get_phrase('sex');?></label>
                                <div class="col-sm-5">
                                    <select name="sex" class="form-control">
                                    	<option value="male" <?php if($row['sex'] == 'male')echo 'selected';?>><?php echo get_phrase('male');?></option>
                                    	<option value="female" <?php if($row['sex'] == 'female')echo 'selected';?>><?php echo get_phrase('female');?></option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label"><?php echo get_phrase('address');?></label>
                                <div class="col-sm-5">
                                    <input type="text" class="form-control" name="address" value="<?php echo $row['address'];?>"/>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label"><?php echo get_phrase('phone');?></label>
                                <div class="col-sm-5">
                                    <input type="text" class="form-control" name="phone" value="<?php echo $row['phone'];?>"/>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label"><?php echo get_phrase('email');?></label>
                                <div class="col-sm-5">
                                    <input type="email" class="form-control" name="email" value="<?php echo $this->db->get_where('credentials',array('user_id'=>$row['teacher_id'],'account'=>2))->row()->email;?>"/>
                                    <small><i class="email_note" style="color:red"></i></small>
                                </div>
                            </div>
                           <!--- <div class="form-group">
                                <label class="col-sm-3 control-label"><?php// echo get_phrase('password');?></label>
                                <div class="col-sm-5">
                                    <input type="text" class="form-control" name="password" value="<?php// echo $row['password'];?>"/>
                                </div>
                            </div> -->
                            
                            
                        <div class="form-group">
                            <div class="col-sm-offset-3 col-sm-5">
                                <button type="submit" class="btn btn-info" onclick="check_data()"><?php echo get_phrase('edit_teacher');?></button>
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

function check_data(){
        event.preventDefault();
        
        var email = $('input[type="email"]').val();
        var teacher_id = $('.teacher_id').val();

		$.ajax({
			url: '<?php echo base_url();?>index.php?admin/check_email_update/'+ encodeURIComponent(email)+'/'+teacher_id+'/'+"2",
			dataType: 'json',
			success: function(response)
			{
				if(response.status=='invalid')
				{
                    $('input[type="email"]').val(email);
				$('.email_note').html("This email already exist");

				}else{
					
					$('.teacheredit').submit();
				}

			},
		   Error: function(err,status,messg){
			   alert(status+" "+messg);
		   }
		});
	}


</script>