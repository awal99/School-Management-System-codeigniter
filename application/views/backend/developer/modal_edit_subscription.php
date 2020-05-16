<hr>

<div class="row">
    <div class="col-md-12">
        <div class="panel panel-primary">
            <div class="panel-heading">
                <div class="panel-title">
                    <?php echo get_phrase('subscription');?>
                </div>
            </div>
            <div class="panel-body">
            
                    <?php echo form_open(base_url() . 'index.php?developer/school/subscription/'.$param2 , array('class' => 'form-horizontal form-groups-bordered validate','target'=>'_top'));?>
                        <div class="form-group">
                        <label  class="col-sm-3 control-label"><?php echo get_phrase('subscription');?></label>
                        <div class="col-sm-9">
                            <select name="subscription" class="form-control">
                                    <?php $subs	=	$this->db->get_where('s_settings' , array('id'=>$param2))->row()->subscription;?>
                                <option value="active" <?php if ($subs == 'active')echo 'selected';?>> active</option>
                                <option value="disabled" <?php if ($subs == 'disabled')echo 'selected';?>> disabled</option>
                            </select>
                        </div>
                        </div>

                        <div class="form-group">
                        <div class="col-sm-offset-3 col-sm-9">
                            <button type="submit" class="btn btn-info"><?php echo get_phrase('save');?></button>
                        </div>
                        </div>
                    </form>
                
            </div>
        </div>
    </div>
</div>

<hr>