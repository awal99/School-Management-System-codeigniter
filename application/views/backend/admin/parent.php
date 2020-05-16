<div class="row">
	<div class="col-md-12">
   <!-- <div class="card card-md bg-primary"><i><b>You can perform bulk parent addings only in the full package<br/>You are on the trial package</b></i></div>-->
    	<!------CONTROL TABS START------>
		<ul class="nav nav-tabs bordered">
			<li class="active">
            	<a href="#list" data-toggle="tab"><i class="entypo-menu"></i> 
					<?php echo get_phrase('parent_list');?>
                    	</a></li>
			<li>
            	<a href="#add" data-toggle="tab"><i class="entypo-plus-circled"></i>
					<?php echo get_phrase('add_parent');?>
                    	</a></li>

          <!--  <li>
            	<a href="#add_bulk" data-toggle="tab"><i class="entypo-plus-circled"></i>
					<?php// echo get_phrase('add_bulk_parent');?>
                    	</a></li> -->
		</ul>
    	<!------CONTROL TABS END------>
		<div class="tab-content">            
            <!----TABLE LISTING STARTS-->
            <div class="tab-pane box active" id="list">
               <table class="table table-bordered datatable" id="table_export">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th><div><?php echo get_phrase('name');?></div></th>
                            <th><div><?php echo get_phrase('email');?></div></th>
                            <th><div><?php echo get_phrase('phone');?></div></th>
                            <th><div><?php echo get_phrase('profession');?></div></th>
                            <th><div><?php echo get_phrase('options');?></div></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            $count = 1; 
                            $parents   =   $this->db->get_where('parent',array('school_id'=>$settings->id) )->result_array();
                            foreach($parents as $row):?>
                        <tr>
                            <td><?php echo $count++;?></td>
                            <td><?php echo $row['name'];?></td>
                            <td><?php echo $this->db->get_where('credentials',array('user_id'=>$row['parent_id'],'account'=>4))->row()->email;?></td>
                            <td><?php echo $row['phone'];?></td>
                            <td><?php echo $row['profession'];?></td>
                            <td>
                                
                                <div class="btn-group">
                                    <button type="button" class="btn btn-default btn-sm dropdown-toggle" data-toggle="dropdown">
                                        Action <span class="caret"></span>
                                    </button>
                                    <ul class="dropdown-menu dropdown-default pull-right" role="menu">
                                        
                                        <!-- teacher EDITING LINK -->
                                        <li>
                                            <a href="#" onclick="showAjaxModal('<?php echo base_url();?>index.php?modal/popup/modal_parent_edit/<?php echo $row['parent_id'];?>');">
                                                <i class="entypo-pencil"></i>
                                                    <?php echo get_phrase('edit');?>
                                                </a>
                                                        </li>
                                        <li class="divider"></li>
                                        
                                        <!-- teacher DELETION LINK -->
                                        <li>
                                            <a href="#" onclick="confirm_modal('<?php echo base_url();?>index.php?admin/parent/delete/<?php echo $row['parent_id'];?>');">
                                                <i class="entypo-trash"></i>
                                                    <?php echo get_phrase('delete');?>
                                                </a>
                                                        </li>
                                    </ul>
                                </div>
                                
                            </td>
                        </tr>
                        <?php endforeach;?>
                    </tbody>
                </table>
                </div>


			<!----CREATION FORM STARTS---->
			<div class="tab-pane box" id="add" style="padding: 5px">
                <div class="box-content">
                <div class="row">
                        <div class="col-md-12">
                            <div class="panel panel-primary" data-collapsed="0">
                                <div class="panel-heading">
                                    <div class="panel-title">
                                        <i class="entypo-plus-circled"></i>
                                        <?php echo get_phrase('add_parent');?>
                                    </div>
                                </div>
                                <div class="panel-body">
                                    
                                    <?php echo form_open(base_url() . 'index.php?admin/parent/create/' , array('class' => 'form-horizontal form-groups-bordered parentadd validate', 'enctype' => 'multipart/form-data'));?>
                                        
                                        <div class="form-group">
                                            <label for="field-1" class="col-sm-3 control-label"><?php echo get_phrase('name');?></label>
                                            
                                            <div class="col-sm-5">
                                                <input type="text" class="form-control" name="name" data-validate="required" data-message-required="<?php echo get_phrase('value_required');?>"  autofocus
                                                    value="">
                                            </div>
                                        </div>
                                        
                                        <div class="form-group">
                                            <label for="field-1" class="col-sm-3 control-label"><?php echo get_phrase('email');?></label>
                                            <div class="col-sm-5">
                                                <input type="email" class="form-control" name="email" value="" >
                                                <small><i class="email_note" style="color:red"></i></small>
                                            </div>
                                        </div>
                                        
                                        <div class="form-group">
                                            <label for="field-2" class="col-sm-3 control-label"><?php echo get_phrase('password');?></label>
                                            
                                            <div class="col-sm-5">
                                                <input type="password" class="form-control" name="password" value="">
                                            </div>
                                        </div>
                                        
                                        <div class="form-group">
                                            <label for="field-2" class="col-sm-3 control-label"><?php echo get_phrase('phone');?></label>
                                            
                                            <div class="col-sm-5">
                                                <input type="text" class="form-control" name="phone" value="" data-validate="required" data-message-required="<?php echo get_phrase('value_required');?>">
                                            </div>
                                        </div>
                                        
                                        <div class="form-group">
                                            <label for="field-2" class="col-sm-3 control-label"><?php echo get_phrase('address');?></label>
                                            
                                            <div class="col-sm-5">
                                                <input type="text" class="form-control" name="address" value="" data-validate="required" data-message-required="<?php echo get_phrase('value_required');?>">
                                            </div>
                                        </div>
                                        
                                        <div class="form-group">
                                            <label for="field-2" class="col-sm-3 control-label"><?php echo get_phrase('profession');?></label>
                                            
                                            <div class="col-sm-5">
                                                <input type="text" class="form-control" name="profession" value="">
                                            </div>
                                        </div>
                                        
                                        <div class="form-group">
                                            <div class="col-sm-offset-3 col-sm-5">
                                                <button type="submit" class="btn submit-btn btn-info" onclick=""><?php echo get_phrase('add_parent');?></button>
                                            </div>
                                        </div>
                                    <?php echo form_close();?>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>                
			</div>
			<!----CREATION FORM ENDS-->
            
            <!----BULK CREATION FORM STARTS---->
			<!-- <div class="tab-pane box" id="add_bulk" style="padding: 5px">
                <div class="box-content">
                <div class="row">
                    <div class="col-md-12">
                        <div class="panel panel-primary" data-collapsed="0">
                            <div class="panel-heading">
                                <div class="panel-title" >
                                    <i class="entypo-plus-circled"></i>
                                    <?php //echo get_phrase('parent_bulk_add_form');?>
                                </div>
                            </div>
                            <div class="panel-body">
                                
                                <?php //echo form_open(base_url() . 'index.php?admin/student_bulk_add/import_excel/' , array('class' => 'form-horizontal form-groups-bordered validate', 'enctype' => 'multipart/form-data'));?>
                    
                                    <div class="form-group">
                                        <label for="field-1" class="col-sm-3 control-label"><?php// echo get_phrase('select_excel_file');?></label>
                                        
                                        <div class="col-sm-5">
                                            <input type="file" name="userfile" class="form-control" data-validate="required" data-message-required="<?php// echo get_phrase('value_required');?>" disabled>
                                            <br>
                                        <a href="<?php //echo base_url();?>uploads/blank_parent_file.xlsx" target="_blank" 
                                                class="btn btn-info btn-sm"><i class="entypo-download"></i> Download blank excel file</a>
                                        </div>
                                    </div>
                                    
                                    <div class="form-group">
                                        <label for="field-2" class="col-sm-3 control-label"><?php //echo get_phrase('class');?></label>
                                        
                                        <div class="col-sm-5">
                                            <select name="class_id" class="form-control" data-validate="required" data-message-required="<?php// echo get_phrase('value_required');?>" disabled>
                                            <option value=""><?php// echo get_phrase('select');?></option>
                                            <?php 
                                                      /*   $classes = $this->db->get('class')->result_array();
                                                        foreach($classes as $row):
                                                            ?>
                                                            <option value="<?php echo $row['class_id'];?>">
                                                                    <?php echo $row['name'];?>
                                                                    </option>
                                                        <?php
                                                        endforeach; */
                                                ?>
                                        </select>
                                        </div> 
                                    </div>
                                    
                                    <div class="form-group">
                                        <div class="col-sm-offset-3 col-sm-5">
                                            <button type="submit" class="btn btn-info" disabled><?php //echo get_phrase('upload_and_import');?> </button>
                                        </div>
                                    </div>
                                <?php //echo form_close();?>
                            </div>
                        </div>
                    </div>
                </div>
                </div>                
			</div> -->
			<!----BULK CREATION FORM ENDS-->
            



		</div>
	</div>
</div>



<!-----  DATA TABLE EXPORT CONFIGURATIONS ---->                      
<script type="text/javascript">

$('.submit-btn').click(function(event){
    event.preventDefault();
    var count = jQuery('input[type="password"]').val().length;
	if(count > 0 && count < 8){
    alert('Password must be at least 8 characters or blank');
    return false;
    }
  
   var email = $('input[type="email"]').val();

   $.ajax({
       url: '<?php echo base_url();?>index.php?admin/check_email/'+ encodeURIComponent(email),
       dataType: 'json',
       success: function(response)
       {
           if(response.status=='invalid')
           {
               if(response.data != null)
               {
                   $('input[type="email"]').val(response.data);
                   $('.email_note').html("An email has been generated for you.  <button class='btn btn-primary getEmail' onclick='event.preventDefault();'>Get new email</button>");
               }else{
                   $('.email_note').html("This email already exist  <button class='btn btn-primary getEmail' onclick='event.preventDefault();'>Get email</button> ");

               }
           }else if(response.status=='valid'){
               
               $('.parentadd').submit();
           }

       },
      Error: function(err,status,messg){
          alert(status+" "+messg);
      }
   });
   
});

</script>


<!-----  PASSWORD CHECK ---->                      
<script type="text/javascript">

function checkpassword(){
	var count = jQuery('input[type="password"]').val().length;
	if(count > 0 && count < 8){
	alert('Password must be at least 8 characters or blank');
	event.preventDefault();
	}
}


	 jQuery(document).ready(function(e)
    {
        

        var datatable = $("#table_export").dataTable({
            "sPaginationType": "bootstrap",
            "sDom": "<'row'<'col-xs-3 col-left'l><'col-xs-9 col-right'<'export-data'T>f>r>t<'row'<'col-xs-3 col-left'i><'col-xs-9 col-right'p>>",
            "oTableTools": {
                "aButtons": [
                    
                    {
                        "sExtends": "xls",
                        "mColumns": [1,2,3,4,5]
                    },
                    {
                        "sExtends": "pdf",
                        "mColumns": [1,2,3,4,5]
                    },
                    {
                        "sExtends": "print",
                        "fnSetText"    : "Press 'esc' to return",
                        "fnClick": function (nButton, oConfig) {
                            datatable.fnSetColumnVis(5, false);
                            
                            this.fnPrint( true, oConfig );
                            
                            window.print();
                            
                            $(window).keyup(function(e) {
                                  if (e.which == 27) {
                                      datatable.fnSetColumnVis(5, true);
                                  }
                            });
                        },
                        
                    },
                ]
            },
            
        });
        
        $(".dataTables_wrapper select").select2({
            minimumResultsForSearch: -1
        });

    });
		

</script>

