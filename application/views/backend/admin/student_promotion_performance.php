<center>
	<button class="btn btn-primary">
		<i class="entypo-user"></i> <?php echo $this->crud_model->get_type_name_by_id('student' , urldecode($param2));?>
	</button>
</center>
<hr />
<?php

	$running_year = $this->db->get_where('s_settings' , array('id' => $this->session->userdata('school')))->row()->running_year; 
    $student_info = $this->crud_model->get_student_info($param2);
    $class_id = $this->db->get_where('enroll', array('student_id'=>urldecode($param2),'year'=>$running_year))->row()->class_id;
    $exams         = $this->crud_model->get_exams();
    foreach ($student_info as $row1):
    foreach ($exams as $row2):
?>

<div class="row">
    <div class="col-md-12">
        <div class="panel panel-primary panel-shadow" data-collapsed="0">
            <div class="panel-heading">
                <div class="panel-title"><?php echo $row2['name'];?></div>
            </div>
            <div class="panel-body">
               
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
                                'class_id' => $class_id,'school_id'=>$this->session->userdata('school')
                            ))->result_array();
                            foreach ($subjects as $row3):

                            $obtained_mark_query = $this->db->get_where('mark' , array(
                                                    'subject_id' => $row3['subject_id'],
                                                        'exam_id' => $row2['exam_id'],
                                                            'class_id' => $class_id,
                                                                'student_id' => urldecode($param2) , 
                                                                    'year' => $running_year));

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

                                <!-- HIGHEST MARK -->
                                <!-- <td style="text-align: center;">
                                <?php 

                                    /*$highest_mark = $this->crud_model->get_highest_marks( $row2['exam_id'] , $class_id , $row3['subject_id'] );
                                echo $highest_mark;     */

                                /*$rank_mark = $this->crud_model->get_rank($row2['exam_id'] , $class_id , $row3['subject_id']);
                                echo $rank_mark;     */                     

                                ?>
                                </td> -->

                                <!--GRADE-->
                                <td style="text-align: center;">
                                    <?php
                                        if($obtained_mark_query->num_rows() > 0) {
                                            $marks = $obtained_mark_query->result_array();
                                            foreach ($marks as $row4) {

                                                $totalM =  $row4['class_score'] + $row4['exam_score'];
                                                $total_marks += $totalM;
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

                                        /*$rank_mark = $this->crud_model->get_rank($row2['exam_id'] , $class_id , $row3['subject_id'] );
                                        echo $rank_mark;*/
                                        
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

                <?php echo get_phrase('total_marks');?> : <?php echo $total_marks;?>
                <br>
                <?php echo get_phrase('average_grade_point');?> : 
                    <?php 
                        $this->db->where('class_id' , $param3);
                        $this->db->where('year' , $running_year);
                        $this->db->from('subject');
                        $number_of_subjects = $this->db->count_all_results();
                        echo ($total_grade_point / $number_of_subjects);
                    ?>
            </div>
        </div>  
    </div>
</div>
<?php
    endforeach;
        endforeach;
?>