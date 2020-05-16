
            
            <table class="table table-bordered datatable" id="table_export">
                    <thead>
                        <tr>
                            <th><div><?php echo get_phrase('roll');?></div></th>
                            <th><div><?php echo get_phrase('photo');?></div></th>
                            <th><div><?php echo get_phrase('name');?></div></th>
                            <th><div><?php echo get_phrase('options');?></div></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                                $students   =   $this->db->get_where('enroll' , array('school_id'=>$settings->id,'class_id'=>$class_id,'year'=>$settings->running_year))->result_array();
                                foreach($students as $row):?>
                        <tr>
                            <td><?php echo $this->db->get_where('student',array('student_id'=>$row['student_id']))->row()->roll;?></td>
                            <td align="center"><img src="<?php echo $this->crud_model->get_image_url($settings->system_name,'student',$row['student_id']);?>" class="img-circle" width="30" /></td>
                            <td><?php echo $this->db->get_where('student',array('student_id'=>$row['student_id']))->row()->name;?></td>
                            <td>
                                    <a href="<?php echo base_url();?>index.php?teacher/modal_student_marksheet/<?php echo urlencode($row['student_id']);?>" class="btn btn-default" >
                                      <i class="entypo-chart-bar"></i>
                                          <?php echo get_phrase('view_marksheet');?>
                                    </a>
                                
                                
                            </td>
                        </tr>
                        <?php endforeach;?>
                    </tbody>
                </table>


<!-----  DATA TABLE EXPORT CONFIGURATIONS ---->                      
<script type="text/javascript">

	jQuery(document).ready(function($)
	{
		

		var datatable = $("#table_export").dataTable();
		
		$(".dataTables_wrapper select").select2({
			minimumResultsForSearch: -1
		});
	});
		
</script>