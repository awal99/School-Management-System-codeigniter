<?php
    $class_name    =   $this->db->get_where('class' , array('class_id' => $class_id,'school_id'=>$this->session->userdata('school')))->row()->name;
    $section_name  =   $this->db->get_where('section' , array('section_id' => $section_id, 'school_id'=>$this->session->userdata('school')))->row()->name;
    $system_name   =   $this->db->get_where('s_settings' , array('id'=>$this->session->userdata('school')))->row()->system_name;
    $running_year  =   $this->db->get_where('s_settings' , array('id'=>$this->session->userdata('school')))->row()->running_year;
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
        <img src="uploads/<?php echo $system_name; ?>/logo.png" style="max-height : 90px; float: left">
        <h3 style="font-weight: 100; text-transform: uppercase"><?php echo $system_name;?></h3>
        <p><?php echo get_phrase('time_table');?></p>
        <p><?php echo $class_name . " " . $section_name;?></p>
    </center>
    <br>
    <table style="width:100%; border-collapse:collapse;border: 1px solid #eee; margin-top: 10px;" border="1">
        <tbody>
            <?php 
                for($d=1;$d<=5;$d++):
                
                //if($d==1)$day='sunday';
                if($d==1)$day='monday';
                else if($d==2)$day='tuesday';
                else if($d==3)$day='wednesday';
                else if($d==4)$day='thursday';
                else if($d==5)$day='friday';
               //else if($d==7)$day='saturday';
                ?>
                <tr>
                    <td width="100"><?php echo strtoupper($day);?></td>
                    <td align="left">
                        <?php
                        $this->db->order_by("time_start", "asc");
                        $this->db->where('day' , $day);
                        if($section_id>0){
                            $this->db->where('section_id' , $section_id );
                        }
                        $this->db->where('class_id' , $class_id);

                        $this->db->where('school_id' , $this->session->userdata('school'));
                        $routines	=	$this->db->get('class_routine')->result_array();
                        foreach($routines as $row):
                        ?>
                            <div style="float:left; padding:8px; margin:5px; background-color:#eee;">
                                <?php echo "<center>" . $this->crud_model->get_subject_name_by_id($row['subject_id']);?>
                                <?php
                                    if ($row['time_start_min'] == 0 && $row['time_end_min'] == 0) 
                                        echo '<br>('.$row['time_start'].'-'.$row['time_end'].')';
                                    if ($row['time_start_min'] != 0 || $row['time_end_min'] != 0)
                                        echo '<br>('.$row['time_start'].':'.$row['time_start_min'].'-'.$row['time_end'].':'.$row['time_end_min'].')';
                                ?>
                            </div>
                        <?php endforeach;?>
                            </td>

                    
                </tr>
                <?php endfor;?>
        </tbody>
   </table>

<br>

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