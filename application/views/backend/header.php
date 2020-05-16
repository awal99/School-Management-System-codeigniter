<div class="row col-md-12 col-sm-12">
<?php   
		  $settings = $settings->row();
		
	   ?>
		<header class="col-md-4 col-xs-12 logo-env " center>
            <center>
			<!-- logo -->
			<div class="logo" style="">
				<a href="<?php echo base_url(); ?>">
					<img class="img-circle" src="uploads/<?php echo $settings->system_name; ?>/logo.png"  style="max-height:100px;"/>
				</a>
			</div>
			</center>
		</header>
		<h2 center class="sysname col-md-6 col-xs-12"><?php echo $settings->system_title;?></h2>
		
	<!-- Raw Links -->

	
</div>

<hr style="margin-top:0px; padding-top:7px" />

<script type="text/javascript">
	function get_session_changer()
	{
		$.ajax({
            url: '<?php echo base_url();?>index.php?admin/get_session_changer/',
            success: function(response)
            {
                jQuery('#session_static').html(response);
            }
        });
	}
</script>