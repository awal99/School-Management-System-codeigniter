
               <table class="table table-bordered datatable" id="table_export">
                    <thead>
                        <tr>
                            <th width="80"><div><?php echo get_phrase('photo');?></div></th>
                            <th><div><?php echo get_phrase('name');?></div></th>
                            <th><div><?php echo get_phrase('email');?></div></th>
                            <th><div><?php echo get_phrase('Phone');?></div></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                               // $teachers	=	$this->db->get('teacher' )->result_array();
                                foreach($teachers as $row):?>
                        <tr>
                            <td><img src="<?php echo $this->crud_model->get_image_url($settings->system_name,'teacher',$row['teacher_id']);?>" class="img-circle" width="30" /></td>
                            <td><?php echo $row['name'];?></td>
                            <td><?php echo $this->db->get_where('credentials',array('user_id'=>$row['teacher_id'],'account'=>2))->row()->email;?></td>
                            <td><?php echo $row['phone']; ?>
                            
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

