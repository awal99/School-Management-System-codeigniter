<?php
/*$student_info   =   $this->db->get_where('enroll' , array(
    'student_id' => $param2 , 'year' => $this->db->get_where('settings' , array('type' => 'running_year'))->row()->description
    ))->result_array();

    foreach($student_info as $row7):
    echo $section_name    =   $this->db->get_where('section' , array('section_id' => $row7['section_id']))->row()->name;
    endforeach;*/
?>

<?php
    date_default_timezone_set('GMT');

    $attendance = $_POST["attendance"];
    $promote = $_POST["promote"];
    $conduct = $_POST["conduct"];
    $interest = $_POST["interest"];
    $headmaster_remarks = $_POST["headmaster_remarks"];
    $form_master_remarks = $_POST["form_master_remarks"];

    $class_id           =   $this->db->get_where('class' , array('class_id' => $class_id))->row()->class_id;
    $class_name         =   $this->db->get_where('class' , array('class_id' => $class_id))->row()->name;
    $exam_name          =   $this->db->get_where('exam' , array('exam_id' => $exam_id))->row()->name;
    $system_name        =   $this->db->get_where('s_settings' , array('id'=>$this->session->userdata('school')))->row()->system_name;
    $system_phone       =   $this->db->get_where('s_settings' , array('id'=>$this->session->userdata('school')))->row()->phone;
    $system_address     =   $this->db->get_where('s_settings' , array('id'=>$this->session->userdata('school')))->row()->address;
    $next_session       =   $this->db->get_where('settings' , array('type'=>'next_session'))->row()->description;
    $running_year       =   $this->db->get_where('s_settings' , array('id'=>$this->session->userdata('school')))->row()->running_year;
    $session_days       =   $this->db->get_where('settings' , array('type'=>'session_days'))->row()->description;
    $student_name       =   $this->db->get_where('student' , array('student_id' => $param2))->row()->name;
    

   /* $dorm_id = $this->db->get_where('student' , array('student_id' => $student_id))->row()->dormitory_id;
    $dormitories = $this->db->get('dormitory')->result_array();
                                    foreach($dormitories as $row2){
                                        echo $row2['name'];
                                    }                       */
               
?>


<?php
$total_marks = 0;
            $total_grade_point = 0;
            $subjects = $this->db->get_where('subject' , array(
                    'class_id' => $class_id , 'year' => $running_year
            ))->result_array();
            foreach ($subjects as $row3):

                        $obtained_mark_query = $this->db->get_where('mark' , array(
                                                    'subject_id' => $row3['subject_id'],
                                                        'exam_id' => $exam_id,
                                                            'class_id' => $class_id,
                                                                'student_id' => $student_id , 
                                                                    'year' => $running_year
                                                ));
                        if($obtained_mark_query->num_rows() > 0){
                            $marks = $obtained_mark_query->result_array();
                            foreach ($marks as $row4) {
                                //echo $row4['mark_obtained'];
                                //$total_marks += $row4['mark_obtained'];

                                //TOTAL MARKS
                                $totalM =  $row4['class_score'] + $row4['exam_score'];
                                $total_marks += $totalM;
                            }
                        }
            endforeach;
                    ?>
                   
<div id="print">

    <script src="assets/js/jquery-1.11.0.min.js"></script>
    <style type="text/css">
        body{
            font-family: "Trebuchet MS";
        }
        td {
            padding: 5px;
        }
    </style>
            <center></center>
        <center>
        <p style="font-size: 16px; width: 100%"><b>&emsp; &emsp; &emsp; &emsp;&emsp; &emsp;&emsp;&emsp; MINISTRY OF  EDUCATION,  GHANA</b></p>
        <img src="uploads/<?php echo $system_name; ?>/logo.png" style="max-height:100px; float:left; " />
     
        <?php echo '<p style="text-transform: uppercase; font-size: 22px; font-weight: bold; line-height: 8px">'. $system_name . "</p>" ?>
        <?php echo $system_address . ". " . "Tel: " . $system_phone;?>

        <p style="text-transform: uppercase; ">Student's Teminal Report</p>
        </center>

        <p>NAME: <?php echo "<b>" . strtoupper($this->db->get_where('student' , array('student_id' => $student_id))->row()->name) . "</b>";?>

        <?php
            $dorm_id = $this->db->get_where('student' , array('student_id' => $student_id))->row()->dormitory_id;
            $dorm  =  $this->db->get_where('dormitory', array('dormitory_id' => $dorm_id))->row()->name;
        
        ?>
        <label style="float: right;"><b>House: </b><?php echo $dorm;?></label>

        <br>

        <?php 
            $section_id = $this->db->get_where('enroll' , array(
                            'student_id' => $student_id,
                                'year' => $running_year))->row()->section_id;
            $section_name       =   $this->db->get_where('section', array('section_id' => $section_id))->row()->name;

        ?>

        CLASS: <?php echo "<b>" . $class_name . " " . $section_name . "</b>";?>
        
        <label style="float: right;"><b>YEAR: </b><?php echo $running_year;?></label>
        <br>
        
        TERM: <?php echo "<b>" . $exam_name . "</b>";?>

        <?php echo "<label style='float: right;'> <b>Average Score:</b> "; 
  
                $this->db->where('class_id' , $class_id);
                $this->db->where('year' , $running_year);
                $this->db->from('subject');
                $number_of_subjects = $this->db->count_all_results();
                
                echo round(($total_marks / $number_of_subjects), 2);
                //echo ($total_grade_point / $number_of_subjects);
        
                echo "</label>"
        ?>
        </p>
        NEXT TERM BEGINS:</label> <?php echo '<b>' . $next_session . '</b>'; ?>

        <label style='float: right;'>
        Fees Due: <?php
        $stud_id = $this->db->get_where('invoice' , array('student_id' => $student_id))->row()->student_id;
        $fee  =  $this->db->get_where('invoice', array('student_id' => $stud_id))->row()->due;
        echo '<b> GH₵ ' . number_format($fee, 2) . '<b>';

        ?>
        </label>
    

    <table style="width:100%; border-collapse:collapse;border: 1px solid #ccc; margin-top: 10px;" border="1">
       <thead>
        <tr>
            <td style="font-weight: bold; text-transform: uppercase;">Subject</td>
            <td style="text-align: center; font-weight: bold;">Class Score <br>(30%)</td>
            <td style="text-align: center; font-weight: bold;">Exam Score <br>(70%)</td>
            <td style="text-align: center; font-weight: bold;">Total Score <br>(100%)</td>
            <td style="text-align: center; font-weight: bold;">Position in<br> Subject</td>
            <td style="text-align: center; font-weight: bold;">Grade</td>
            <td style="text-align: center; font-weight: bold;">Master's <br>Initial</td>
            <td style="text-align: center; text-transform: uppercase; font-weight: bold;">Remarks</td>
        </tr>
    </thead>
    <tbody>
        <?php 
            //$teachers   =   $this->db->get('teacher' )->result_array();
            $total_marks = 0;
            $total_grade_point = 0;
            $subjects = $this->db->get_where('subject' , array(
                    'class_id' => $class_id , 'school_id' => $this->session->userdata('school')
            ))->result_array();
            foreach ($subjects as $row3):

            $obtained_mark_query = $this->db->get_where('mark' , array(
                                                    'subject_id' => $row3['subject_id'],
                                                        'exam_id' => $exam_id,
                                                            'class_id' => $class_id,
                                                                'student_id' => $student_id , 
                                                                    'year' => $running_year
                                                ));
        ?>
            <tr>
                <td style="text-align: left;"><?php echo $row3['name'];?></td>
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

                <!-- TOTAL SCORE -->
                <td style="text-align: center;">
                    <?php
                        echo $totalM =  $row4['class_score'] + $row4['exam_score'];
                        $total_marks += $totalM;
                    ?>
                </td>

                <!--POSITION IN SUBJECT-->
                <td style="text-align: center;">
                    <?php

                    if($obtained_mark_query->num_rows() > 0) 
                        echo $row4['position'];

                   
                    ?>
                </td>                
                
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

                <!--TEACHER INITIAL-->                
                <td style="text-align: center;">  
                <?php $tname = $this->db->get_where('teacher' , array(
                                                      'teacher_id' => $row3['teacher_id'] 
                                                    ));
                $teach_ini_query = $tname->result_array();
                foreach ($teach_ini_query as $row1) {
                    $init = '';
                    $full_name_split =  explode(' ',$row1['name']);
                    for($i=0;$i<=sizeof($full_name_split);$i++){
                        $init =$init .substr($full_name_split[$i],0,1); 
                    }
                    echo $init;
                }
                ?>     
                </td>
                <!--TEACHER INITIAL END--> 

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
                            echo $grade['comment'];
                            $total_grade_point += $grade['grade_point'];
                        }
                    }


                ?>
                    <?php //if($obtained_mark_query->num_rows() > 0) echo $row4['comment'];?>
                </td>
            </tr>
        <?php endforeach;?>
    </tbody>
   </table>

        <br>
        <?php 
            $this->db->where('class_id' , $class_id);
            $this->db->where('year' , $running_year);
            $this->db->from('subject');
            $number_of_subjects = $this->db->count_all_results();
            //echo ($total_marks/ $number_of_subjects);
       ?>

    <br>
     
    <table style="width:100%">
    <tr>
        <td>
        <?php
        echo '<label style="text-transform:uppercase; class="\col-sm-10 control-label\"> Attendance:   ' . '<b>' . $attendance . '</label>';
        ?>
        </td>
        <td>OUT OF  <?php echo "<b>" . $session_days . "</b>"; ?></td>

        <td style="float: right">PROMOTED TO: <?php if (!empty($promote)) { echo '<b>Form ' . $promote . '</b>';} else { echo "<b>...........</b>";} ?></td>
    </tr>
    </table>
        

    <br>

    <div class="form-group">
        <label style="font-style:bold" class="col-sm-3 control-label">Conduct: </label>
        <?php
        echo '<text style="font-weight:bold" class="\col-sm-10 control-label\">' . $conduct;
        ?>
    </div>
    
    <br>

    <div class="form-group">
        <label style="font-style:bold" class="col-sm-3 control-label">Interest: </label>
        <?php
        echo '<text style="font-weight:bold" class="\col-sm-10 control-label\">' . $interest;
        ?>
    </div>
    
    <br>

    <div class="form-group">
        <label style="font-style:bold" class="col-sm-3 control-label">Headmaster's Remarks: </label>
        <?php
        echo '<text style="font-weight:bold" class="\col-sm-10 control-label\">' . $headmaster_remarks;
        ?>
    </div>

    <br><br>

    <div class="form-group">
        <label style="font-style:bold" class="control-label">Headmaster's Signature / Stamp: <b>.......................................</b> </label>

    </div>


</div>


<script type="text/javascript">

    jQuery(document).ready(function($)
    {
        var elem = $('#print');
        PrintElem(elem);
        Popup(data);

    });

    function PrintElem(elem)
    {
        Popup($(elem).html());
    }

    function Popup(data) 
    {
        var mywindow = window.open('', 'my div', 'height=400,width=600');
        mywindow.document.write('<html><head><title></title>');
        //mywindow.document.write('<link rel="stylesheet" href="assets/css/print.css" type="text/css" />');
        mywindow.document.write('</head><body >');
        //mywindow.document.write('<style>.print{border : 1px;}</style>');
        mywindow.document.write(data);
        mywindow.document.write('</body></html>');

        mywindow.document.close(); // necessary for IE >= 10
        mywindow.focus(); // necessary for IE >= 10

        mywindow.print();
        mywindow.close();

        return true;
    }
</script>