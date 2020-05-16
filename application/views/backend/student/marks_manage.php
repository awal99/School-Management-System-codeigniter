<hr />
<?php echo form_open(base_url() . 'index.php?student/marks_selector' ,array('id'=>"manage_marks_form"));?>
<div class="row">

	<div class="col-md-2">
		<div class="form-group">
		<label class="control-label" style="margin-bottom: 5px;"><?php echo get_phrase('exam');?></label>
			<select id="exam_id" name="exam_id" class="form-control " >
				<?php
					$exams = $this->db->get_where('exam' , array('year' => $running_year,'school_id'=>$settings->id))->result_array();
					foreach($exams as $row):
				?>
				<option value="<?php echo $row['exam_id'];?>"><?php echo $row['name'];?></option>
				<?php endforeach;?>
			</select>
		</div>
	</div>

	<div class="col-md-2">
		<div class="form-group">
		<label class="control-label" style="margin-bottom: 5px;"><?php echo get_phrase('class');?></label>
			<input name="class_id" class="form-control " value="<?php 
				 echo  $this->db->get_where('class',array('class_id'=>$class_id,'school_id'=>$settings->id))->row()->name;
			?>" disabled="disabled">
		  </input>
		</div>
	</div>

	<input name="class_id" value="<?php echo $class_id; ?>" hidden/>

	<?php $sec_id = $this->db->get_where('section',array('class_id'=>$class_id))->row()->section_id;	?>

	<!-- <div id="subject_holder"> -->
	<?php if($sec_id != ''){ ?>
		<div class="col-md-3">
			<div class="form-group">
			<label class="control-label" style="margin-bottom: 5px;"><?php echo get_phrase('section');?></label>
				<input name="section_id" class="form-control " value="<?php 
					echo  $this->db->get_where('section',array('section_id'=>$sec_id,'school_id'=>$settings->id))->row()->name;
				?>" disabled="disabled">
				</input>
			</div>
		</div>
	<?php } ?>

   <input name="section_id" value="<?php echo $sec_id; ?>" hidden/>

	<!-- <div class="col-md-3">
		<div class="form-group">
		<label class="control-label" style="margin-bottom: 5px;"><?php// echo get_phrase('subject');?></label>
		  <select id="subject" name="subject_id" class="form-control" onchange="enable_submit_button()" >
				<option value=""><?php// echo get_phrase('select_subject');?></option>
				<?php 
				//$subjects	=	$this->crud_model->get_subjects_by_class($class_id,$settings->id); 
			//	foreach($subjects as $row2): ?>
				<option value="<?php //echo $row2['subject_id'];?>"
					<?php //if(isset($subject_id) && $subject_id == $row2['subject_id'])
							//echo 'selected="selected"';?>><?php //echo $row2['name'];?>
				</option>
				<?php //endforeach;?>
				
				
			</select> 
		</div>
	</div> -->
	<div class="col-md-2" style="margin-top: 20px;">
		<center>
			<button id="submit" type="submit" class="btn btn-info" ><?php echo get_phrase('manage_marks');?></button>
		</center>
	</div>
	<!-- </div> -->

</div>
<?php echo form_close();?>





<script type="text/javascript">
	// function get_class_subject(class_id) {
		
	// 	$.ajax({
    //         url: '<?php// echo base_url();?>index.php?admin/marks_get_subject/' + class_id ,
    //         success: function(response)
    //         {
    //             jQuery('#subject_holder').html(response);
    //         }
    //     });

	// }

	$('#manage_marks_form').submit(function(){
		if($('#exam_id').val()==''){
			event.preventDefault();
			alert('Please Select an Exam first');
		}
	});
</script>