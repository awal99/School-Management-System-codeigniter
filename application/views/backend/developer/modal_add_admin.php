<div class="row">
	<div class="col-md-12">
		<div class="panel panel-primary" data-collapsed="0">
        	<div class="panel-heading">
            	<div class="panel-title" >
            		<i class="entypo-plus-circled"></i>
					<?php echo get_phrase('add_admin');?>
            	</div>
            </div>
			<div class="panel-body">
				
                <?php echo form_open(base_url() . 'index.php?developer/admin/create/' , array('class' => 'form-horizontal form-groups-bordered adminadd validate', 'enctype' => 'multipart/form-data'));?>
	
					<div class="form-group">
						<label for="field-1" class="col-sm-3 control-label"><?php echo get_phrase('name');?></label>
                        
						<div class="col-sm-5">
							<input type="text" class="form-control" name="name" data-validate="required" data-message-required="<?php echo get_phrase('value_required');?>" value="" autofocus>
						</div>
					</div>
					
	                    
					<div class="form-group">
						<label for="field-1" class="col-sm-3 control-label"><?php echo get_phrase('email');?></label>
						<div class="col-sm-5">
							<input type="email" class="form-control" name="email" value="" required>
							<small><i class="email_note" style="color:red"></i></small>
						</div>
					</div>
					
					<div class="form-group">
						<label for="field-2" class="col-sm-3 control-label"><?php echo get_phrase('password');?></label>
                        
						<div class="col-sm-5">
							<input type="password" class="form-control" name="password" value="" pattern="" required>
						</div> 
					</div>
	
					<div class="form-group">
                        <?php
                        $schools		=	$this->db->select('id,system_name')->from('s_settings')->get()->result_array();
                        ?>
                        <label for="field-2" class="col-sm-3 control-label"><?php echo get_phrase('school');?></label>
                        <div class="col-sm-5">
                            <select name="school" id="school" class="form-control" required>
                                <option value=""><?php echo get_phrase('select_school');?></option>
                                <?php foreach($schools as $school): ?>
                                <option value="<?php echo $school['id'] ?>" style="color:black;font-weight:bold"><?php echo get_phrase($school['system_name']);?></option>
                                <?php endforeach; ?>
                            </select>
                            <!--<input type="text" class="form-control" name="email" id="email" placeholder="Email" autocomplete="off" data-mask="email" />-->
                        </div>
      				</div>
                    
                    <div class="form-group">
						<div class="col-sm-offset-3 col-sm-5">
							<button type="submit" class="btn btn-info" onclick="check_data()"><?php echo get_phrase('add_admin');?></button>
						</div>
					</div>
                <?php echo form_close();?>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">

// function checkpassword(){
// 		var count = jQuery('input[type="password"]').val().length;
// 		if(count > 0 && count < 8){
// 		alert('Password must be at least 8 characters or blank');
// 		event.preventDefault();
// 		}
// }

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
					
					$('.adminadd').submit();
				}

			},
		   Error: function(err,status,messg){
			   alert(status+" "+messg);
		   }
		});
		}
	}


</script>