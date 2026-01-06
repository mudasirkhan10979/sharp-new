<?php echo $header; ?>
<script>
	$('.heading').html('<? echo $breadcrumbs[0]["text"]; ?>');
</script>

<div class="main-panel">
<div class="main-employee-box">

<div class="row">
	<div class="col-lg-12 col-md-12 ">
		<div class="float-right">
		
		<!-- <button type="button" class="btn bts89067 btn890-890-890 opt" data-toggle="modal" data-target=".bd-example-modal-lg">  + <?php //echo $button_add; ?> </button> -->
		
		<a href="<?php echo $add; ?>" class="btn bts89067 btn890-890-890 opt" >  + <?php echo $button_add; ?> </a>
		
		<a href="<?php echo $export; ?>" data-toggle="tooltip" title="<?php echo "Export"; ?>" class="btn btn-success"><i class="fa fa-download" aria-hidden="true"></i></a>
		
		<button type="button" data-toggle="tooltip" title="<?php echo $button_delete; ?>" class="btn btn-danger" onclick="confirm('<?php echo $text_confirm; ?>') ? $('#form-customer').submit() : false;"><i class="fa fa-trash-o"></i></button>
		
	  </div>
	</div>
	
</div>
	
 <div class="panel panel-default">
      <div class="panel-body">
        <div class="well">
          <div class="row">
            <div class="col-sm-5">
              <div class="form-group">
                <label class="control-label" for="input-key"><?php echo $afu_key; ?></label>
                <input type="text" name="filter_key" value="<?php echo $filter_key; ?>" placeholder="<?php echo $afu_key; ?>" id="input-key" class="form-control" />
              </div>
            </div>
            <div class="col-sm-5">
              <div class="form-group">
                <label class="control-label" for="input-date"><?php echo $column_createdon; ?></label>
                <input type="text" name="filter_date" value="<?php echo $filter_date; ?>" placeholder="<?php echo $column_createdon; ?>" id="input-date" class="form-control date" />
              </div>
            </div>
            <div class="col-sm-2">
              <div class="form-group">
                 <div class="form-group">
					<button type="button" id="button-filter" class="btn btn-primary pull-right"><i class="fa fa-search"></i> <?php echo $button_filter; ?></button>
				</div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  
<div class="employee-table-out-box table-cont8901">
   <div class="row">
      <div class="col-lg-12 col-md-12">
         <div class="card">
            <div class="card-bodys">
			 <form action="<?php echo $delete; ?>" method="post" enctype="multipart/form-data" id="form-customer">
               
			 <table class="table table-borderless mb-0" width="100%" cellspacing="0" cellpadding="0" border="0">
              <thead>
                <tr>
                  <td style="width: 1px;" class="text-center"><input type="checkbox" onclick="$('input[name*=\'selected\']').prop('checked', this.checked);" /></td>
                  <td class="text-left"><?php echo $afu_key; ?></td>
				  <td class="text-left"><?php echo $afu_column_name; ?></td>
                  <td class="text-left"><?php echo $afu_column_email; ?></td>
                  <td class="text-left"><?php echo $column_status; ?></td> 
                  <td class="text-left"><?php echo $column_createdon; ?></td>
                  <td class="text-right"><?php echo $column_action; ?></td>
                </tr>
              </thead>
              <tbody>
                <?php if ($affiliates) { ?>
                <?php foreach ($affiliates as $aff) { ?>
                <tr>
                  <td class="text-center"><?php if (in_array($aff['aff_id'], $selected)) { ?>
                    <input type="checkbox" name="selected[]" value="<?php echo $aff['aff_id']; ?>" checked="checked" />
                    <?php } else { ?>
                    <input type="checkbox" name="selected[]" value="<?php echo $aff['aff_id']; ?>" />
                    <?php } ?></td>
                  <td class="text-left"><?php echo $aff['license_key']; ?></td>
				  <td class="text-left"><?php echo ($aff['name'] ? $aff['name'] : '-'); ?></td>
                  <td class="text-left"><?php echo ($aff['email'] ? $aff['email'] : '-'); ?></td>
                  <td class="text-left">
					
					<div class="statusss">
					 <span class="<? echo ($aff['status'] == 1 ? 'circleesss' : 'circlee')?> "></span> 
					 <p><?php echo $aff['status_text']; ?></p>
				    </div>
														  
				  </td> 
				  <td class="text-left"><?php echo ($aff['date_added'] ? $aff['date_added'] : '-'); ?></td>
                  <td class="text-right">
					<a href="<?php echo $aff['edit']; ?>" data-toggle="tooltip" title="<?php echo $button_edit; ?>" class="btn btn-primary"><i class="fa fa-pencil"></i></a>
				  </td>
                </tr>
                <?php } ?>
                <?php } else { ?>
                <tr>
                  <td class="text-center" colspan="7"><?php echo $text_no_results; ?></td>
                </tr>
                <?php } ?>
              </tbody>
            </table>
			
			 </form>  
            </div>
         </div>
         <div class="paginationsss">
            <ul class="pagination">
               <li class="page-item disabled">
                  <span class="page-link "> <i class="fa fa-arrow-left" aria-hidden="true"></i> Prev</span>
               </li>
            </ul>
            <nav aria-label="...">
			   <!--
               <ul class="pagination  middle justify-content-center">
                  <li class="page-item disabled">
                     <a class="page-link show" href="#" tabindex="-1">1</a>
                  </li>
                  <li class="page-item "><a class="page-link one" href="#">2</a></li>
               </ul>
			   -->
			   
			   <?php echo $pagination; ?>
            </nav>
            <ul class="pagination">
               <li class="page-item">
                  <a class="page-link" href="#">Next <i class="fa fa-arrow-right" aria-hidden="true"></i></a>
               </li>
            </ul>
         </div>
      </div>
   </div>
</div>
</div>
</div>
  <script type="text/javascript"><!--
$('#button-filter').on('click', function() {
	url = '<?php echo $ajaxUrl; ?>/&token=<?php echo $token; ?>&aff_id=<?php echo $aff_id; ?>';
	
	var filter_key = $('input[name=\'filter_key\']').val();
	if (filter_key) {
		url += '&filter_key=' + encodeURIComponent(filter_key);
	}
	
	var filter_date = $('input[name=\'filter_date\']').val();
	if (filter_date) {
		url += '&filter_date=' + encodeURIComponent(filter_date);
	}
	
	location = url;
});
//--></script> 
  <script type="text/javascript"><!--
$('.date').datetimepicker({
	pickTime: false
});
//--></script></div> 
  <script type="text/javascript"><!--
$('.date').datetimepicker({
  pickTime: false
});

$('.time').datetimepicker({
  pickDate: false
});

$('.datetime').datetimepicker({
  pickDate: true,
  pickTime: true
});
//--></script>
<?php echo $footer; ?> 
