<hr />
<?php echo form_open(base_url() . 'index.php?admin/marks_selector');?>
<div class="row">

	<div class="col-md-2">
		<div class="form-group">
		<label class="control-label" style="margin-bottom: 5px;"><?php echo get_phrase('exam');?></label>
			<select name="exam_id" class="form-control " required>
				<?php
					$exams = $this->db->get_where('exam' , array('year' => $this->session->userdata('running_year'),'school_id'=>$this->session->userdata('school')))->result_array();
					foreach($exams as $row):
				?>
				<option value="<?php echo $row['exam_id'];?>"
					<?php if($exam_id == $row['exam_id']) echo 'selected';?>><?php echo $row['name'];?></option>
				<?php endforeach;?>
			</select>
		</div>
	</div>

	<div class="col-md-2">
		<div class="form-group">
		<label class="control-label" style="margin-bottom: 5px;"><?php echo get_phrase('class');?></label>
			<select name="class_id" class="form-control " onchange="get_class_subject(this.value)">
				<option value=""><?php echo get_phrase('select_class');?></option>
				<?php
					$classes = $this->db->get_where('class',array('school_id'=>$this->session->userdata('school')))->result_array();
					foreach($classes as $row):
				?>
				<option value="<?php echo $row['class_id'];?>"
					<?php if($class_id == $row['class_id']) echo 'selected';?>><?php echo $row['name'];?></option>
				<?php endforeach;?>
			</select>
		</div>
	</div>

	<div id="subject_holder">
		<div class="col-md-2">
			<div class="form-group">
			<label class="control-label" style="margin-bottom: 5px;"><?php echo get_phrase('section');?></label>
				<select name="section_id" id="section_id" class="form-control ">
					<?php 
						$sections = $this->db->get_where('section' , array(
							'class_id' => $class_id 
						))->result_array();
						foreach($sections as $row):
					?>
					<option value="<?php echo $row['section_id'];?>" 
						<?php if($section_id == $row['section_id']) echo 'selected';?>>
							<?php echo $row['name'];?>
					</option>
					<?php endforeach;?>
				</select>
			</div>
		</div>
		<div class="col-md-3">
			<div class="form-group">
			<label class="control-label" style="margin-bottom: 5px;"><?php echo get_phrase('subject');?></label>
				<select name="subject_id" id="subject_id" class="form-control ">
					<?php 
						$subjects = $this->db->get_where('subject' , array(
							'class_id' => $class_id 
						))->result_array();
						foreach($subjects as $row):
					?>
					<option value="<?php echo $row['subject_id'];?>"
						<?php if($subject_id == $row['subject_id']) echo 'selected';?>>
							<?php echo $row['name'];?>
					</option>
					<?php endforeach;?>
				</select>
			</div>
		</div>
		<div class="col-md-2" style="margin-top: 20px;">
			<center>
				<button type="submit" class="btn btn-info"><?php echo get_phrase('manage_marks');?></button>
			</center>
		</div>
	</div>

</div>
<?php echo form_close();?>

<hr />
<div class="row" style="text-align: center;">
	<div class="col-sm-4"></div>
	<div class="col-sm-4">
		<div class="tile-stats tile-gray">
			<div class="icon"><i class="entypo-chart-bar"></i></div>
			
			<h3 style="color: #696969;"><?php echo get_phrase('marks_for');?> <?php echo $this->db->get_where('exam' , array('exam_id' => $exam_id))->row()->name;?></h3>
			<h4 style="color: #696969;">
				<?php echo get_phrase('class:');?> <?php echo $this->db->get_where('class' , array('class_id' => $class_id))->row()->name;?>
				<?php //echo get_phrase('section');?> <?php echo $this->db->get_where('section' , array('section_id' => $section_id))->row()->name;?> 
			</h4>
			<h4 style="color: #696969;">
				<?php echo get_phrase('subject');?> : <?php echo $this->db->get_where('subject' , array('subject_id' => $subject_id))->row()->name;?>
			</h4>
		</div>
	</div>
	<div class="col-sm-4"></div>
</div>
<div class="row">
	<div class="col-md-2"></div>
	<div class="col-md-8">

		<?php echo form_open(base_url() . 'index.php?teacher/marks_update/'.$exam_id.'/'.$class_id.'/'.$section_id.'/'.$subject_id);?>
			<table class="table table-bordered">
				<thead>
					<tr>
						<th>#</th>
						<th><?php echo get_phrase('roll');?></th>
						<th><?php echo get_phrase('name');?></th>
						<th><?php echo get_phrase('class_score');?><br/>30%</th>
						<th><?php echo get_phrase('exam_score');?><br/>70%</th>
						<th><?php echo get_phrase('total_marks');?></th>
						<th><?php echo "Position";?></th>
					</tr>
				</thead>
				<tbody>
				<?php
					$count = 1;
					$marks_of_students = $this->db->get_where('mark' , array(
						'school_id'=> $this->session->userdata('school'),
						'class_id' => $class_id, 
							'section_id' => $section_id ,
								'year' => $this->session->userdata('running_year'),
									'subject_id' => $subject_id,
										'exam_id' => $exam_id
					))->result_array();
					foreach($marks_of_students as $row):
				?>
					<tr>
						<td><?php echo $count++;?></td>
						<td>
							<?php echo $this->db->get_where('enroll', array('student_id'=>$row['student_id']))->row()->roll;?>
						</td>
						<td>
							<?php echo $this->db->get_where('student' , array('student_id' => $row['student_id']))->row()->name;?>
						</td>
						<td>
							<input type="text" class="form-control" name="class_score_<?php echo $row['mark_id'];?>"
								value="<?php echo $row['class_score'];?>">	
						</td>
						<td>
							<input type="text" class="form-control" name="exam_score_<?php echo $row['mark_id'];?>"
								value="<?php echo $row['exam_score'];?>">	
						</td>
						<td>
							<?php $total_score = $row['class_score'] + $row['exam_score']; ?>
							<input type="text" class="form-control" name="total_score_<?php echo $row['mark_id'];?>"
								value="<?php echo $total_score;?>">

							<!-- <center><?php //echo $row['class_score'] + $row['exam_score'];?></center> -->
						</td>
						<td>
							<input type="text" class="form-control" name="position_<?php echo $row['mark_id'];?>" 
								value="<?php echo $row['position'];?>">
						</td>
					</tr>
				<?php endforeach;?>
				</tbody>
			</table>

		<center>
			<button type="submit" class="btn btn-success" id="submit_button">
				<i class="entypo-check"></i> <?php echo get_phrase('save_changes');?>
			</button>
		</center>
		<?php echo form_close();?>
		
	</div>
	<div class="col-md-2"></div>
</div>





<script type="text/javascript">
	function get_class_subject(class_id) {
		
	$.ajax({
            url: '<?php echo base_url();?>index.php?teacher/marks_get_subject/' + class_id ,
            success: function(response)
            {
                jQuery('#subject_holder').html(response);
            }
        });

	}
</script>