<?php 
	 $class_name    =   $this->db->get_where('class' , array('class_id' => $class_id,'school_id'=>$this->session->userdata('school')))->row()->name;
     $section_name  =   $this->db->get_where('section' , array('section_id' => $section_id, 'school_id'=>$this->session->userdata('school')))->row()->name;
     $system_name   =   $this->db->get_where('s_settings' , array('id'=>$this->session->userdata('school')))->row()->system_name;
     $running_year  =   $this->db->get_where('s_settings' , array('id'=>$this->session->userdata('school')))->row()->running_year;
        if($month == 1) $m = 'January';
        else if($month == 2) $m='February';
        else if($month == 3) $m='March';
        else if($month == 4) $m='April';
        else if($month == 5) $m='May';
        else if($month == 6) $m='June';
        else if($month == 7) $m='July';
        else if($month == 8) $m='August';
        else if($month == 9) $m='September';
        else if($month == 10) $m='October';
        else if($month == 11) $m='November';
        else if($month == 12) $m='December';
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

	<center>

        <img src="uploads/<?php echo $system_name; ?>/logo.png"  style="max-height:100px; float:left" />

        <?php echo '<p style="text-transform: uppercase; font-size: 22px; font-weight: bold; line-height: 8px">' . $system_name . "</p>" ?>
		
		<p style="font-size: 20px; font-weight: bold;">Attendance Sheet<br>
		<?php echo $class_name . ' '. $section_name;?></p>
        <h4><?php echo $m . " " . date(Y);?></h4>
	</center>
        
          <table border="1" style="width:100%; border-collapse:collapse;border: 1px solid #ccc; margin-top: 10px;">
                <thead>
                    <tr>
                        <td style="text-align: center;">
    <?php echo get_phrase('students'); ?> <i class="entypo-down-thin"></i> | <?php echo get_phrase('date'); ?> <i class="entypo-right-thin"></i>
                        </td>
    <?php
    $year = explode('-', $running_year);
    $days = cal_days_in_month(CAL_GREGORIAN, $month, $year[0]);
    for ($i = 1; $i <= $days; $i++) {
        ?>
                            <td style="text-align: center;"><?php echo $i; ?></td>
                    <?php } ?>

                    </tr>
                </thead>

                <tbody>
                            <?php
                            $data = array();
                            if(!empty($section_id)){
                                $students = $this->db->get_where('enroll', array('class_id' => $class_id, 'year' => $this->session->userdata('running_year'), 'section_id' => $section_id))->result_array();
                             }else{
                                $students = $this->db->get_where('enroll', array('class_id' => $class_id, 'year' => $this->session->userdata('running_year')))->result_array();    
                             }

                            foreach ($students as $row):
                                ?>
                        <tr>
                            <td style="text-align: center;">
                            <?php echo $this->db->get_where('student', array('student_id' => $row['student_id']))->row()->name; ?>
                            </td>
                            <?php
                            $status = 0;
                            for ($i = 1; $i <= $days; $i++) {
                                //$timestamp = strtotime($i . '-' . $month . '-' . $year[0]);
                                $timestamp = $year[0].'-'.$month.'-'.$i;
                                //$this->db->group_by('timestamp');
                               // $attendance = $this->db->get_where('attendance', array('section_id' => $section_id, 'class_id' => $class_id, 'year' => $running_year, 'timestamp' => $timestamp, 'student_id' => $row['student_id']))->result_array();
                               $this->db->group_by('date');
                                $this->db->group_by('attendance_id');
                               if(!empty($section_id)){
                                $attendance = $this->db->get_where('attendance', array('section_id' => $section_id, 'class_id' => $class_id, 'year' => $this->session->userdata('running_year'), 'date' => $timestamp, 'student_id' => $row['student_id']))->result_array();
                               }else{
                                $attendance = $this->db->get_where('attendance', array('class_id' => $class_id, 'year' => $this->session->userdata('running_year'), 'date' => $timestamp, 'student_id' => $row['student_id']))->result_array();
                               }


                                foreach ($attendance as $row1):
                                    $month_dummy = date('m', $row1['timestamp']);
                                    if ($i == $month_dummy)
                                        ;
                                    $status = $row1['status'];
                                endforeach;
                                ?>
                                <td style="text-align: center;" data-class="">
            <?php if ($status == 1) { ?>
                                    <div style="color: #005228">P</div>
                            <?php } else if ($status == 2) { ?>
                                    <div style="color: #ff3030">A</div>
            <?php }$status=0; ?>
                                </td>

        <?php } ?>
    <?php endforeach; ?>

                    </tr>

    <?php ?>

                </tbody>
            </table>
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