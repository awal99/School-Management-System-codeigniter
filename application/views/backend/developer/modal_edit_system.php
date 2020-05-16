<hr />

<div class="row">

<?php echo form_open(base_url() . 'index.php?developer/school/edit' , 
array('class' => 'form-horizontal form-groups-bordered validate','target'=>'_top'));?>
    <div class="col-md-12">
        
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
         <div class="col-md-12">
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
