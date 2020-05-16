<div class="row">
	<div class="col-md-12">
    
    	<!------CONTROL TABS START------>
		<ul class="nav nav-tabs bordered">
			<li class="active">
            	<a href="#list" data-toggle="tab"><i class="entypo-menu"></i> 
					<?php echo get_phrase('class_routine_list');?>
                    	</a></li>
		
		</ul>
    	<!------CONTROL TABS END------>
        
        
		<div class="tab-content">
       
            <!----TABLE LISTING STARTS-->
            <div class="tab-pane active" id="list">
				<div class="panel-group joined" id="accordion-test-2">
                	<?php 
					$toggle = true;
                     $class_name= $this->db->get_where('class',array('school_id'=>$settings->id,'class_id'=>$class_id))->row()->name;
						?>
                        
                
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                		<h4 class="panel-title">
                                    <a data-toggle="collapse" data-parent="#accordion-test-2" href="#collapse<?php if($section_id > 0){echo $section_id ;}else{echo 0;};?>">
                                        <i class="entypo-rss"></i> Class <?php echo $class_name.'.'; if($section_id > 0){echo '   Section : '.$this->db->get_where('section',array('section_id'=>$section_id))->row()->name;}?>
                                    </a>
                                    </h4>
                                <a href="<?php echo base_url();?>index.php?parents/class_routine_print_view/<?php echo $class_id;?>/<?php if($section_id > 0){echo $section_id;}else{echo 0;};?>" 
                                    class="btn btn-primary btn-xs pull-right" target="_blank">
                                    <i class="entypo-print"></i> <?php echo get_phrase('print');?>
                                 </a>
                                </div>
                               
                                <div id="collapse<?php if($section_id > 0){echo $section_id;}else{echo 0;};?>" class="panel-collapse collapse <?php if($toggle){echo 'in';$toggle=false;}?>">
                                    <div class="panel-body">
                                        <table cellpadding="0" cellspacing="0" border="0"  class="table table-bordered">
                                            <tbody>
                                                <?php 
                                                for($d=1;$d<=7;$d++):
                                                
                                                if($d==1)$day='sunday';
                                                else if($d==2)$day='monday';
                                                else if($d==3)$day='tuesday';
                                                else if($d==4)$day='wednesday';
                                                else if($d==5)$day='thursday';
                                                else if($d==6)$day='friday';
                                                else if($d==7)$day='saturday';
                                                ?>
                                                <tr class="gradeA">
                                                    <td width="100"><?php echo strtoupper($day);?></td>
                                                    <td>
                                                    	<?php

														$this->db->order_by("time_start", "asc");
                                                        $this->db->where('day' , $day);
                                                        if($row['section_id']>0){
                                                            $this->db->where('section_id' , $section_id );
                                                        }
                                                        $this->db->where('class_id' , $class_id);
                                                        
                                                        $this->db->where('school_id' , $settings->id);
														$routines	=	$this->db->get('class_routine')->result_array();
														foreach($routines as $row2):
														?>
														<div class="btn-group">
															<button class="btn btn-primary" >
                                                            <?php echo $this->db->get_where('subject',array('subject_id'=>$row2['subject_id']))->row()->name;?>
                                                                <?php
                                                                    if ($row2['time_start_min'] == 0 && $row2['time_end_min'] == 0) 
                                                                        echo '('.$row2['time_start'].'-'.$row2['time_end'].')';
                                                                    if ($row2['time_start_min'] != 0 || $row2['time_end_min'] != 0)
                                                                        echo '('.$row2['time_start'].':'.$row2['time_start_min'].'-'.$row2['time_end'].':'.$row2['time_end_min'].')';
                                                                ?>

                                                            </button>
															
														</div>
														<?php endforeach;?>

                                                    </td>
                                                </tr>
                                                <?php endfor;?>
                                                
                                            </tbody>
                                        </table>
                                        
                                    </div>
                                </div>
                            </div>
						
              
               
  				</div>
			</div>
            <!----TABLE LISTING ENDS---->
             
		</div>
	</div>
</div>