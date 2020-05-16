<link rel="stylesheet" href="assets/js/jquery-ui/css/no-theme/jquery-ui-1.10.3.custom.min.css">
<link rel="stylesheet" href="assets/css/font-icons/entypo/css/entypo.css">
<link rel="stylesheet" href="http://fonts.googleapis.com/css?family=Noto+Sans:400,700,400italic">
<link rel="stylesheet" href="assets/css/bootstrap.css">
<link rel="stylesheet" href="assets/css/neon-core.css">
<link rel="stylesheet" href="assets/css/neon-theme.css">
<link rel="stylesheet" href="assets/css/neon-forms.css">

<link rel="stylesheet" href="assets/css/custom.css">


<script src="assets/js/jquery-1.11.0.min.js"></script>

        <!--[if lt IE 9]><script src="assets/js/ie8-responsive-file-warning.js"></script><![endif]-->

<!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
<!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
<![endif]-->
<link rel="shortcut icon" href="assets/images/favicon.png">
<link rel="stylesheet" href="assets/css/font-icons/font-awesome/css/font-awesome.min.css">

<link rel="stylesheet" href="assets/js/vertical-timeline/css/component.css">
<link rel="stylesheet" href="assets/js/datatables/responsive/css/datatables.responsive.css">


<!--Amcharts-->
<script src="<?php echo base_url();?>assets/js/amcharts/amcharts.js" type="text/javascript"></script>
<script src="<?php echo base_url();?>assets/js/amcharts/pie.js" type="text/javascript"></script>
<script src="<?php echo base_url();?>assets/js/amcharts/serial.js" type="text/javascript"></script>
<script src="<?php echo base_url();?>assets/js/amcharts/gauge.js" type="text/javascript"></script>
<script src="<?php echo base_url();?>assets/js/amcharts/funnel.js" type="text/javascript"></script>
<script src="<?php echo base_url();?>assets/js/amcharts/radar.js" type="text/javascript"></script>
<script src="<?php echo base_url();?>assets/js/amcharts/exporting/amexport.js" type="text/javascript"></script>
<script src="<?php echo base_url();?>assets/js/amcharts/exporting/rgbcolor.js" type="text/javascript"></script>
<script src="<?php echo base_url();?>assets/js/amcharts/exporting/canvg.js" type="text/javascript"></script>
<script src="<?php echo base_url();?>assets/js/amcharts/exporting/jspdf.js" type="text/javascript"></script>
<script src="<?php echo base_url();?>assets/js/amcharts/exporting/filesaver.js" type="text/javascript"></script>
<script src="<?php echo base_url();?>assets/js/amcharts/exporting/jspdf.plugin.addimage.js" type="text/javascript"></script>

<script>
    function checkDelete()
    {
        var chk=confirm("Are You Sure To Delete This !");
        if(chk)
        {
          return true;  
        }
        else{
            return false;
        }
    }
</script>



<div class="row">
	<div class="col-md-10 col-md-offset-1">
    
    	<!------CONTROL TABS START------>
		<ul class="nav nav-tabs bordered">
			<li class="active">
            	<a href="#list" data-toggle="tab"><i class="entypo-menu"></i> 
					<?php echo get_phrase('available_schools');?>
                    	</a></li>
			<li>
            	<a href="#add" data-toggle="tab"><i class="entypo-plus-circled"></i>
					<?php echo get_phrase('add_school');?>
                    	</a></li>

            <li>
            	<a href="#admins" data-toggle="tab"><i class="entypo-plus-circled"></i>
					<?php echo get_phrase('list_admin');?>
                    	</a></li>
		</ul>
    	<!------CONTROL TABS END------>
        
	
		<div class="tab-content">
            <!----TABLE LISTING STARTS-->
            <div class="tab-pane box <?php if(!isset($edit_data))echo 'active';?>" id="list">
                <table cellpadding="0" cellspacing="0" border="0" class="table table-bordered datatable" id="table_export">
                	<thead>
                		<tr>
                    		<th><div><?php echo get_phrase('school_name');?></div></th>
                    		<th><div><?php echo get_phrase('system_title');?></div></th>
                    		<th><div><?php echo get_phrase('email');?></div></th>
                    		<th><div><?php echo get_phrase('address');?></div></th>
                            <th><div><?php echo get_phrase('contact');?></div></th>
                            <th><div><?php echo get_phrase('subscription');?></div></th>
                            <th><div><?php echo get_phrase('options');?></div></th>
						</tr>
					</thead>
                    <tbody>

                        <?php 
                        $count = 1;
                        $schools = $this->db->get('s_settings')->result_array();
                        foreach($schools as $row):?>
                        <tr>
							<td><?php echo $row['system_name'];?></td>
							<td><?php echo $row['system_title'];?></td>
							<td><?php echo $row['system_email'];?></td>
                            <td><?php echo $row['address'];?></td>
                            <td><?php echo $row['phone'];?></td>
                            <td><?php echo $row['subscription'];?></td>
							<td>
                            <div class="btn-group">
                                <button type="button" class="btn btn-default btn-sm dropdown-toggle" data-toggle="dropdown">
                                    Action <span class="caret"></span>
                                </button>
                                <ul class="dropdown-menu dropdown-default pull-right" role="menu">
                                    
                                    <!-- EDITING LINK -->
                                    <!-- <li>
                                        <a href="#" onclick="showAjaxModal('<?php //echo base_url();?>index.php?developer/popup/modal_edit_system/<?php// echo $row['id'];?>');" >
                                            <i class="entypo-pencil"></i>
                                                <?php// echo get_phrase('edit');?>
                                            </a>
                                                    </li>
                                    <li class="divider"></li> -->
                                    <!-- subscription -->
                                     <li>
                                        <a href="#" onclick="showAjaxModal('<?php echo base_url();?>index.php?developer/popup/modal_edit_subscription/<?php echo $row['id'];?>');">
                                            <i class="entypo-tag"></i>
                                                <?php echo get_phrase('subscription');?>
                                            </a>
                                                </li>
                                    <li class="divider"></li>
                                    <!-- DELETION LINK -->
                                    <li>
                                        <a href="#" onclick="confirm_modal('<?php echo base_url();?>index.php?developer/school/delete/<?php echo $row['id'];?>');">
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
            <!----TABLE LISTING ENDS--->
            
            
			<!----CREATION FORM STARTS---->
			<div class="tab-pane box" id="add" style="padding: 5px">
                <div class="box-content">
                
                <hr />

                    <div class="row">
                    
                    <?php echo form_open(base_url() . 'index.php?developer/school/create' , 
                    array('class' => 'form-horizontal form-groups-bordered validate','target'=>'_top'));?>
                        <div class="col-md-6">
                            
                            <div class="panel panel-primary" >
                            
                                <div class="panel-heading">
                                    <div class="panel-title">
                                        <?php echo get_phrase('system_settings');?>
                                    </div>
                                </div>
                                
                                <div class="panel-body">
                                    
                                <div class="form-group">
                                    <label  class="col-sm-3 control-label"><?php echo get_phrase('school_name');?></label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control" name="system_name" 
                                            value="" required> 
                                    </div>
                                </div>
                                    
                                <div class="form-group">
                                    <label  class="col-sm-3 control-label"><?php echo get_phrase('system_title');?></label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control" name="system_title" 
                                            value="" required>
                                    </div>
                                </div>
                                    
                                <div class="form-group">
                                    <label  class="col-sm-3 control-label"><?php echo get_phrase('address');?></label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control" name="address" 
                                            value="">
                                    </div>
                                </div>
                                    
                                <div class="form-group">
                                    <label  class="col-sm-3 control-label"><?php echo get_phrase('phone');?></label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control" name="phone" 
                                            value="" required>
                                    </div>
                                </div>
                                    
                                <div class="form-group">
                                    <label  class="col-sm-3 control-label"><?php echo get_phrase('paypal_email');?></label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control" name="paypal_email" 
                                            value="">
                                    </div>
                                </div>
                                    
                                <div class="form-group">
                                    <label  class="col-sm-3 control-label"><?php echo get_phrase('currency');?></label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control" name="currency" 
                                            value="">
                                    </div>
                                </div>
                                    
                                <div class="form-group">
                                    <label  class="col-sm-3 control-label"><?php echo get_phrase('system_email');?></label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control" name="system_email" 
                                            value="" required>
                                    </div>
                                </div>
                                    
                                <div class="form-group">
                                    <label  class="col-sm-3 control-label"><?php echo get_phrase('language');?></label>
                                    <div class="col-sm-9">
                                        <select name="language" class="form-control">
                                                <?php
                                                    $fields = $this->db->list_fields('language');
                                                    foreach ($fields as $field)
                                                    {
                                                        if ($field == 'phrase_id' || $field == 'phrase')continue;
                                                        
                                                        $current_default_language	=	$this->db->get_where('settings' , array('type'=>'language'))->row()->description;
                                                        ?>
                                                        <option value="<?php echo $field;?>"
                                                            <?php if ($current_default_language == $field)echo 'selected';?>> <?php echo $field;?> </option>
                                                        <?php
                                                    } 
                                                    ?>
                                        </select>
                                    </div>
                                </div>
                                    
                                <div class="form-group">
                                    <label  class="col-sm-3 control-label"><?php echo get_phrase('text_align');?></label>
                                    <div class="col-sm-9">
                                        <select name="text_align" class="form-control">
                                                <?php $text_align	=	$this->db->get_where('settings' , array('type'=>'text_align'))->row()->description;?>
                                            <option value="left-to-right" <?php if ($text_align == 'left-to-right')echo 'selected';?>> left-to-right</option>
                                            <option value="right-to-left" <?php if ($text_align == 'right-to-left')echo 'selected';?>> right-to-left</option>
                                        </select>
                                    </div>
                                </div>
                                
                                <div class="form-group">
                                    <div class="col-sm-offset-3 col-sm-9">
                                        <button type="submit" class="btn btn-info"><?php echo get_phrase('save');?></button>
                                    </div>
                                </div>
                                    
                                </div>
                            
                            </div>
                        
                        </div>
                    <?php echo form_close();?>

                    <?php 
                    // $skin = $this->db->get_where('settings' , array(
                    //    'type' => 'skin_colour'
                    //  ))->row()->description;
                    ?>

                        <div class="row">
                            <?php echo form_open(base_url() . 'index.php?developer/school/upload_logo' , array(
                            'class' => 'form-horizontal form-groups-bordered validate','target'=>'_top' , 'enctype' => 'multipart/form-data'));?>
                             <div class="col-md-6">
                            <div class="panel panel-primary" >
                            
                                <div class="panel-heading">
                                    <div class="panel-title">
                                        <?php echo get_phrase('upload_logo');?>
                                    </div>
                                </div>
                                
                                <div class="panel-body">
                                    
                                    
                                    <div class="form-group">
                                        <label for="field-1" class="col-sm-3 control-label"><?php echo get_phrase('photo');?></label>
                                        
                                        <div class="col-sm-9">
                                            <div class="fileinput fileinput-new" data-provides="fileinput">
                                                <div class="fileinput-new thumbnail" style="width: 100px; height: 100px;" data-trigger="fileinput">
                                                    <img src="<?php echo base_url();?>uploads/logo.png" alt="...">
                                                </div>
                                                <div class="fileinput-preview fileinput-exists thumbnail" style="max-width: 200px; max-height: 150px"></div>
                                                <div>
                                                    <span class="btn btn-white btn-file">
                                                        <span class="fileinput-new">Select image</span>
                                                        <span class="fileinput-exists">Change</span>
                                                        <input type="file" name="userfile" accept="image/*">
                                                    </span>
                                                    <a href="#" class="btn btn-orange fileinput-exists" data-dismiss="fileinput">Remove</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    
                                    <div class="form-group">
                                    <div class="col-sm-offset-3 col-sm-9">
                                        <button type="submit" class="btn btn-info"><?php echo get_phrase('upload');?></button>
                                    </div>
                                    </div>
                                    
                                </div>
                            
                            </div>

                            <?php echo form_close();?>
                            
                        
                        </div>

                    </div>

                       
                </div>                
			</div>
            </div>
			<!----CREATION FORM ENDS-->


            <!----LIST ADMINS STARTS---->
			<div class="tab-pane box" id="admins" style="padding: 5px">
            <div class="box-content">
                	  
                <!-- <div class="tab-pane box <?php// if(!isset($edit_data))echo 'active';?>" id="admins">-->
                <a href="javascript:;" onclick="showAjaxModal('<?php echo base_url();?>index.php?developer/popup/modal_add_admin/');" 
            	class="btn btn-primary pull-right">
                <i class="entypo-plus-circled"></i>
            	<?php echo get_phrase('add_new_admin');?>
                </a> 
                <br></br>
                    <table cellpadding="0" cellspacing="0" border="0" class="table table-bordered datatable" id="table_export">
                        <thead>
                            <tr>
                                <th><div><?php echo get_phrase('name');?></div></th>
                                <th><div><?php echo get_phrase('email');?></div></th>
                                <th><div><?php echo get_phrase('school');?></div></th>
                                <th><div><?php echo get_phrase('options');?></div></th>
                            </tr>
                        </thead>
                        <tbody>

                            <?php 
                            $count = 1;
                            $this->db->select('admin.admin_id,admin.name,credentials.email,s_settings.system_name');
                            $this->db->from('admin');
                            $this->db->join('credentials','credentials.user_id=admin.admin_id ','left');
                            $this->db->join('s_settings','s_settings.id=admin.school_id','left');
                            $admins =  $this->db->get()->result_array();
                            foreach($admins as $row):?>
                            <tr>
                                <td><?php echo $row['name'];?></td>
                                <td><?php echo $row['email'];?></td>
                                <td><?php echo $row['system_name'];?></td>
                                <td>
                                <div class="btn-group">
                                    <button type="button" class="btn btn-default btn-sm dropdown-toggle" data-toggle="dropdown">
                                        Action <span class="caret"></span>
                                    </button>
                                    <ul class="dropdown-menu dropdown-default pull-right" role="menu">
                                        
                                        <!-- EDITING LINK -->
                                        <li>
                                            <a href="#" onclick="showAjaxModal('<?php echo base_url();?>index.php?developer/popup/modal_edit_admin/<?php echo $row['id'];?>');" >
                                                <i class="entypo-pencil"></i>
                                                    <?php echo get_phrase('edit');?>
                                                </a>
                                                        </li>
                                        <li class="divider"></li>
        
                                        <!-- DELETION LINK -->
                                        <li>
                                            <a href="#" onclick="confirm_modal('<?php echo base_url();?>index.php?developer/school/delete/<?php echo $row['id'];?>');">
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

                                
			</div>
			<!----LIST ADMINS ENDS-->
            
		</div>
	</div>
</div>


    <script type="text/javascript">
	function showAjaxModal(url)
	{
		// SHOWING AJAX PRELOADER IMAGE
		jQuery('#modal_ajax .modal-body').html('<div style="text-align:center;margin-top:200px;"><img src="assets/images/preloader.gif" /></div>');
		
		// LOADING THE AJAX MODAL
		jQuery('#modal_ajax').modal('show', {backdrop: 'true'});
		
		// SHOW AJAX RESPONSE ON REQUEST SUCCESS
		$.ajax({
			url: url,
			success: function(response)
			{
				jQuery('#modal_ajax .modal-body').html(response);
			}
		});
	}
	</script>
    
    <!-- (Ajax Modal)-->
    <div class="modal fade" id="modal_ajax">
        <div class="modal-dialog">
            <div class="modal-content">
                
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title"><?php echo $system_name;?></h4>
                </div>
                
                <div class="modal-body" style="height:500px; overflow:auto;">
                
                    
                    
                </div>
                
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
    
    
    
    
    <script type="text/javascript">
	function confirm_modal(delete_url)
	{
		jQuery('#modal-4').modal('show', {backdrop: 'static'});
		document.getElementById('delete_link').setAttribute('href' , delete_url);
	}
	</script>
    
    <!-- (Normal Modal)-->
    <div class="modal fade" id="modal-4">
        <div class="modal-dialog">
            <div class="modal-content" style="margin-top:100px;">
                
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title" style="text-align:center;">Are you sure to delete this information ?</h4>
                </div>
                
                
                <div class="modal-footer" style="margin:0px; border-top:0px; text-align:center;">
                    <a href="#" class="btn btn-danger" id="delete_link"><?php echo get_phrase('delete');?></a>
                    <button type="button" class="btn btn-info" data-dismiss="modal"><?php echo get_phrase('cancel');?></button>
                </div>
            </div>
        </div>
    </div>


<link rel="stylesheet" href="assets/js/datatables/responsive/css/datatables.responsive.css">
	<link rel="stylesheet" href="assets/js/select2/select2-bootstrap.css">
	<link rel="stylesheet" href="assets/js/select2/select2.css">

   	<!-- Bottom Scripts -->
	<script src="assets/js/gsap/main-gsap.js"></script>
	<script src="assets/js/jquery-ui/js/jquery-ui-1.10.3.minimal.min.js"></script>
	<script src="assets/js/bootstrap.js"></script>
	<script src="assets/js/joinable.js"></script>
	<script src="assets/js/resizeable.js"></script>
	<script src="assets/js/neon-api.js"></script>
	<script src="assets/js/toastr.js"></script>
    <script src="assets/js/jquery.validate.min.js"></script>
	<script src="assets/js/fullcalendar/fullcalendar.min.js"></script>
    <script src="assets/js/bootstrap-datepicker.js"></script>
    <script src="assets/js/fileinput.js"></script>
    
    <script src="assets/js/jquery.dataTables.min.js"></script>
	<script src="assets/js/datatables/TableTools.min.js"></script>
	<script src="assets/js/dataTables.bootstrap.js"></script>
	<script src="assets/js/datatables/jquery.dataTables.columnFilter.js"></script>
	<script src="assets/js/datatables/lodash.min.js"></script>
	<script src="assets/js/datatables/responsive/js/datatables.responsive.js"></script>
    <script src="assets/js/select2/select2.min.js"></script>
    
	<script src="assets/js/neon-calendar.js"></script>
	<script src="assets/js/neon-chat.js"></script>
	<script src="assets/js/neon-custom.js"></script>
	<script src="assets/js/neon-demo.js"></script>

<!-- SHOW TOASTR NOTIFIVATION -->
<?php if ($this->session->flashdata('flash_message') != ""):?>

<script type="text/javascript">
	toastr.success('<?php echo $this->session->flashdata("flash_message");?>');
</script>

<?php endif;?>
