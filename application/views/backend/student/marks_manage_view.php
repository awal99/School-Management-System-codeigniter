<hr />
<?php echo form_open(base_url() . 'index.php?student/marks_selector',array('id'=>"manage_marks_form"));?>
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

	<?php $sec_id = $this->db->get_where('section',array('class_id'=>$class_id))->row()->section_id; ?>

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

	
	<div class="col-md-2" style="margin-top: 20px;">
		<center>
			<button id="submit" type="submit" class="btn btn-info" ><?php echo get_phrase('manage_marks');?></button>
		</center>
	</div>
	<!-- </div> -->

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
				<?php echo get_phrase('Name');?> : <?php echo $this->db->get_where('student' , array('student_id' => $this->session->userdata('student_id')))->row()->name;?>
			</h4>
		</div>
	</div>
	<div class="col-sm-4"></div>
</div>
<div class="row">

	<div class="row">
    <div class="col-md-12">
        <div class="panel panel-primary panel-shadow" data-collapsed="0">
            <div class="panel-heading">
           
                <div class="panel-title"><?php echo $row2['name'];?></div>

            </div>
            <div class="panel-body">
                
                
               <div class="col-md-12">
                   <table class="table table-bordered">
                       <thead>
                        <tr>
                            <td style="text-align: center;">Subject</td>
                            <td style="text-align: center;">Class Score<br> (30%)</td>
                            <td style="text-align: center;">Exam Score<br> (70%)</td>
                            <td style="text-align: center;">Total Score<br> 100%</td>
                            <td style="text-align: center;">Grade</td>
                            <td style="text-align: center;">Position in<br> Subject</td>
                            <td style="text-align: center;">Remarks</td>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                            $total_marks = 0;
                            $total_grade_point = 0;
                            $subjects = $this->db->get_where('subject' , array(
                                'class_id' => $class_id,
                                'school_id' => $this->session->userdata('school') 
                            ))->result_array();
                            foreach ($subjects as $row3):

                            $obtained_mark_query = $this->db->get_where('mark' , array(
                                                    'subject_id' => $row3['subject_id'],
														'exam_id' => $exam_id,
														 'section_id' => $section_id,
                                                            'class_id' => $class_id,
                                                                'student_id' => $this->session->userdata('student_id') 
                                                                    ));

                        ?>
                            <tr>
                                <!-- SUBJECT -->
                                <td style="text-align: center;"><?php echo $row3['name'];?></td>
                                
                                <!-- CLASS SCORE -->
                                <td style="text-align: center;">
                                <?php
                                    if ( $obtained_mark_query->num_rows() > 0) {
                                        $marks = $obtained_mark_query->result_array();
                                        foreach ($marks as $row4) {

                                        }
                                    }
                                ?>
                                <?php
                                    if($obtained_mark_query->num_rows() > 0) 
                                        echo $row4['class_score'];
                                ?>
                                </td>

                                <!-- EXAM SCORE -->
                                <td style="text-align: center;">
                                    <?php
                                        if($obtained_mark_query->num_rows() > 0) 
                                            echo $row4['exam_score'];
                                    ?>
                                </td>

                                <!-- TOTAL MARKS -->
                                <td style="text-align: center;">
                                    <?php
                                        if ( $obtained_mark_query->num_rows() > 0) {
                                            $marks = $obtained_mark_query->result_array();
                                            foreach ($marks as $row4) {

                                                echo $totalM =  $row4['class_score'] + $row4['exam_score'];
                                                $total_marks += $totalM;

                                                /*echo $row4['mark_obtained'];
                                                $total_marks += $row4['mark_obtained'];*/
                                            }
                                        }
                                        


                                    ?>
                                </td>

                              

                                <!--GRADE-->
                                <td style="text-align: center;">
                                    <?php
                                        if($obtained_mark_query->num_rows() > 0) {
                                            $marks = $obtained_mark_query->result_array();
                                            foreach ($marks as $row4) {

                                                $totalM =  $row4['class_score'] + $row4['exam_score'];
                                                $total_marks =$toltal_marks + $totalM;
                                            }
                                            if ($row4['exam_score'] >= 0 || $row4['exam_score'] != '') {
                                                $grade = $this->crud_model->get_grade($totalM);
                                                echo $grade['name'];
                                                $total_grade_point += $grade['grade_point'];
                                            }
                                        }
                                    ?>
                                </td>

                                <!-- POSITION IN SUBJECT -->
                                <td style="text-align: center;">
                                    <?php
                                        
                                        if($obtained_mark_query->num_rows() > 0) 
                                            echo $row4['position'];

                                    ?>
                                </td>

                                <!-- REMARKS -->
                                <td style="text-align: center;">
                                    <?php  
                                            //echo $row4['comment'];

                                        if($obtained_mark_query->num_rows() > 0) {
                                            $marks = $obtained_mark_query->result_array();
                                            foreach ($marks as $row4) {

                                                $totalM =  $row4['class_score'] + $row4['exam_score'];
                                                $total_marks += $totalM;
                                            }
                                            if ($row4['exam_score'] >= 0 || $row4['exam_score'] != '') {
                                                $grade = $this->crud_model->get_grade($totalM);
                                                echo $grade['comment'];
                                                $total_grade_point += $grade['grade_point'];
                                            }
                                        }
                                    ?>
                                </td>
                            </tr>
                        <?php endforeach;?>
                    </tbody>
                   </table>

                   <hr />

                   <?php 
                   echo "<b>" . get_phrase('total_marks');?> : </b>
                <?php 
                $this->db->where('class_id' , $class_id);
                /*$this->db->where('year' , $running_year);*/
                $this->db->from('subject');
                $number_of_subjects = $this->db->count_all_results();
                
                echo round(($total_marks / $number_of_subjects), 2);
                ?>
                   <br>

                   <!--AVERAGE SCORE-->
                   <?php echo "<b>" . get_phrase('Average Score');?> : </b>
                        <?php 
                            $this->db->where('class_id' , $class_id);
               /* $this->db->where('year' , $running_year);*/
                $this->db->from('subject');
                $number_of_subjects = $this->db->count_all_results();
                
                echo round((($total_marks / $number_of_subjects)/$number_of_subjects), 2);
                        ?>

                    <br> <br>

                 
               </div>

                             
            </div>
		
	</div>
	<div class="col-md-2"></div>
</div>





<script type="text/javascript">
	// function get_class_subject(class_id) {
		
	// $.ajax({
    //         url: '<?php// echo base_url();?>index.php?teacher/marks_get_subject/' + class_id ,
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