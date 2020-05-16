<style>
    #chartdiv {
	width       : 100%;
        height      : 250px;
        font-size   : 11px;
}	
</style>

<?php
$student_info = $this->crud_model->get_student_info($student_id);
$exams         = $this->crud_model->get_exams();
foreach ($student_info as $row1):
 foreach ($exams as $row2):
    ?>
    <center>
      
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
                                                        'exam_id' => $row2['exam_id'],
                                                            'class_id' => $class_id,
                                                                'student_id' => $student_id 
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

            <!-- <div class="panel panel-primary" data-collapsed="0"> -->

                <form action="<?php echo base_url();?>index.php?admin/student_marksheet_print_view/<?php echo urlencode($student_id);?>/<?php echo $row2['exam_id'];?>" class="form-horizontal form-groups-bordered validate" method="post" target="_blank">

                    <div class="panel-body">

                        <!-- ATTENDANCE -->                   
                        <div class="form-group">
                                <label for="field-1" class="col-sm-2 control-label">Attendance: </label>
                                
                                <div class="col-sm-5">
                                    <input type="text" class="form-control" name="attendance" data-validate="required" data-message-required="<?php echo get_phrase('Please enter attendance');?>" value="" autofocus>
                                </div>

                                <!-- PROMOTE --> 
                                 <label for="promote" class="col-sm-1 control-label">Promote: </label>
                                
                                <div class="col-sm-4">
                                    <input type="text" class="form-control" name="promote" value="" autofocus>
                                </div>
                        </div>

                        <!-- CONDUCT -->                   
                        <div class="form-group">
                                <label for="field-1" class="col-sm-2 control-label">Conduct: </label>
                                
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" name="conduct" data-validate="required" data-message-required="<?php echo get_phrase('Please enter student\'s conduct');?>" value="" autofocus>
                                </div>
                        </div>

                        <!-- INTEREST -->
                        <div class="form-group">
                                <label for="field-1" class="col-sm-2 control-label">Interest: </label>
                                
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" name="interest" data-validate="required" data-message-required="<?php echo get_phrase('Please enter student\'s interest');?>" value="" autofocus>
                                </div>
                        </div>
                        <!-- FORM MASTER/MISTRESS'S COMMENT -->
                        <div class="form-group">
                                <label for="field-1" class="col-sm-2 control-label">Form Master's / Mistress' Remarks: </label>
                                <div class="col-sm-10" style="float:right">
                                    <input style="float:right" type="text" class="form-control" name="form_master_remarks" data-validate="required" data-message-required="<?php echo 'Please enter Form Master/Mistress Remarks.';?>" value="" autofocus>
                                </div>
                        </div>
                        <!-- HEADMASTER'S COMMENT -->
                        <div class="form-group">
                                <label for="field-1" class="col-sm-2 control-label">Headmaster's Remarks: </label>
                                
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" name="headmaster_remarks" data-validate="required" data-message-required="<?php echo get_phrase('Please enter Headmaster\'s Remarks');?>" value="" autofocus>
                                </div>
                        </div>                    
                       
                        <button style="float:right" type="submit" class="btn btn-primary"><?php echo get_phrase('print_report');?></button>
                     </div>    
                </form>

                   
            <!-- </div> -->

        </div>  
    </div>
</div>
        
    </center>
<?php endforeach;
        endforeach; ?>