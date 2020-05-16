<div class="row">
	<div class="col-md-12">
		<div class="panel panel-primary" data-collapsed="0">
        	<div class="panel-heading">
            	<div class="panel-title" >
            		<i class="entypo-plus-circled"></i>
					<?php echo get_phrase('add_teacher');?>
            	</div>
            </div>
			<div class="panel-body">
				
                <?php echo form_open(base_url() . 'index.php?admin/teacher/create/' , array('class' => 'form-horizontal form-groups-bordered teacheradd validate', 'enctype' => 'multipart/form-data'));?>
	
					<div class="form-group">
						<label for="field-1" class="col-sm-3 control-label"><?php echo get_phrase('name');?></label>
                        
						<div class="col-sm-5">
							<input type="text" class="form-control" name="name" data-validate="required" data-message-required="<?php echo get_phrase('value_required');?>" value="" autofocus>
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
							<select name="sex" class="form-control" data-validate="required" data-message-required="<?php echo get_phrase('value_required');?>">
                              <option value=""><?php echo get_phrase('select');?></option>
                              <option value="male"><?php echo get_phrase('male');?></option>
                              <option value="female"><?php echo get_phrase('female');?></option>
                          </select>
						</div> 
					</div>
					
					<div class="form-group">
						<label for="field-2" class="col-sm-3 control-label"><?php echo get_phrase('address');?></label>
                        
						<div class="col-sm-5">
							<input type="text" class="form-control" name="address" data-validate="required" data-message-required="<?php echo get_phrase('value_required');?>" value="" >
						</div> 
					</div>
					
					<div class="form-group">
						<label for="field-2" class="col-sm-3 control-label"><?php echo get_phrase('phone');?></label>
                        
						<div class="col-sm-5">
							<input type="text" class="form-control" name="phone" data-validate="required" data-message-required="<?php echo get_phrase('value_required');?>" value="" >
						</div> 
					</div>
                    
					<div class="form-group">
						<label for="field-1" class="col-sm-3 control-label"><?php echo get_phrase('email');?></label>
						<div class="col-sm-5">
							<input type="email" class="form-control" name="email" data-validate="required" data-message-required="<?php echo get_phrase('value_required');?>" value="">
							<small><i class="email_note" style="color:red"></i></small>
						</div>
					</div>
					
					<div class="form-group">
						<label for="field-2" class="col-sm-3 control-label"><?php echo get_phrase('password');?></label>
                        
						<div class="col-sm-5">
							<input type="password" class="form-control" name="password" data-validate="required" data-message-required="<?php echo get_phrase('value_required');?>" value="" pattern="">
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
							<button type="submit" class="btn btn-info" onclick="check_data()"><?php echo get_phrase('add_teacher');?></button>
						</div>
					</div>
                <?php echo form_close();?>
            </div>
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
		
		var count = jQuery('input[type="password"]').val().length;
		if(count > 0 && count < 8){
		alert('Password must be at least 8 characters or blank');
		return false;
		}
        

		$.ajax({
			url: '<?php echo base_url();?>index.php?admin/check_email/'+ encodeURIComponent(email),
			dataType: 'json',
			success: function(response)
			{
				if(response.status=='invalid')
				{
					if(response.data !== null)
					{
						$('input[type="email"]').val(response.data);
						$('.email_note').html("An email has been generated for you.  <button class='btn btn-primary getEmail' onclick='event.preventDefault();'>Get new email</button>");
					}
					if(response.data == null)
					{
						$('.email_note').html("This email already exist  <button class='btn btn-primary getEmail' onclick='event.preventDefault();'>Get email</button>");

					}
				}else if(response.status=='valid'){
					
					$('.teacheradd').submit();
				}

			},
		   Error: function(err,status,messg){
			   alert(status+" "+messg);
		   }
		});
	}

</script>