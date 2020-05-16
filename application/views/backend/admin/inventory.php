
            <a href="javascript:;" onclick="showAjaxModal('<?php echo base_url();?>index.php?modal/popup/modal_inventory_add/');" 
                class="btn btn-primary pull-right">
                <i class="entypo-plus-circled"></i>
                <?php echo get_phrase('add_new_item');?>
                </a> 
                <br><br>
               <table class="table table-bordered datatable" id="table_export">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th><div><?php echo get_phrase('name');?></div></th>
                            <th><div><?php echo get_phrase('quantity_stocked');?></div></th>
                            <th><div><?php echo get_phrase('last_stocked');?></div></th>
                            <th><div><?php echo get_phrase('current_quantity');?></div></th>
                            <th><div><?php echo get_phrase('unit');?></div></th>
                            <th><div><?php echo get_phrase('options');?></div></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            $count = 1; 
                           
                            $inventory   =   $this->db->get_where('inventory',array('school_id'=>$settings->id))->result_array();
                            foreach($inventory as $row):?>
                        <tr>
                            <td><?php echo $count++;?></td>
                            <td><?php echo $row['name'];?></td>
                            <td><?php echo $row['quantity'];?></td>
                            <td><?php echo $row['last_stocked'];?></td>
                            <td><?php echo $row['current_quantity'];?></td>
                            <td><?php echo $row['unit'];?></td>
                            <td>
                                
                                <div class="btn-group">
                                    <button type="button" class="btn btn-default btn-sm dropdown-toggle" data-toggle="dropdown">
                                        Action <span class="caret"></span>
                                    </button>
                                    <ul class="dropdown-menu dropdown-default pull-right" role="menu">
                                        
                                        <!-- inventory EDITING LINK -->
                                        <li>
                                            <a href="#" onclick="showAjaxModal('<?php echo base_url();?>index.php?modal/popup/modal_edit_item/<?php echo $row['id'];?>');">
                                                <i class="entypo-pencil"></i>
                                                    <?php echo get_phrase('edit');?>
                                                </a>
                                                        </li>
                                        <li class="divider"></li>
                                        
                                        <!-- inventory update LINK -->
                                        <li>
                                        <a href="#" onclick="showAjaxModal('<?php echo base_url();?>index.php?modal/popup/modal_update_inventory/<?php echo $row['id'];?>');">
                                                <i class="entypo-pencil"></i>
                                                    <?php echo get_phrase('update_stock');?>
                                                </a>
                                                        </li>
                                    </ul>
                                </div>
                                
                            </td>
                        </tr>
                        <?php endforeach;?>
                    </tbody>
                </table>



<!-----  DATA TABLE EXPORT CONFIGURATIONS ---->                      
<script type="text/javascript">

    jQuery(document).ready(function($)
    {
        

        var datatable = $("#table_export").dataTable({
            "sPaginationType": "bootstrap",
            "sDom": "<'row'<'col-xs-3 col-left'l><'col-xs-9 col-right'<'export-data'T>f>r>t<'row'<'col-xs-3 col-left'i><'col-xs-9 col-right'p>>",
            "oTableTools": {
                "aButtons": [
                    
                    {
                        "sExtends": "xls",
                        "mColumns": [1,2,3,4,5,6]
                    },
                    {
                        "sExtends": "pdf",
                        "mColumns": [1,2,3,4,5,6]
                    },
                    {
                        "sExtends": "print",
                        "fnSetText"    : "Press 'esc' to return",
                        "fnClick": function (nButton, oConfig) {
                            datatable.fnSetColumnVis(6, false);
                            
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

