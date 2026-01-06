<style>

   /* Custom styling for the export button */
   .custom-export-button {
      background-color: #01667C !important;
      border: none;
      color: white !important;
      padding: 10px 20px !important;
      text-align: center !important;
      text-decoration: none !important;
      display: inline-block !important;
      font-size: 16px !important;
      margin: 4px 2px !important;
      cursor: pointer;
      border-radius: 8px;
   }

   .custom-export-button:hover {
      background-color: #045d6d !important;

   }
</style>
<?php echo $header; ?>
<div class="main-panel">
   <div class="sec-head">
      <div class="sec-head-title">
         <h3>Subscriptions</h3>
      </div>
   </div>
   <div class="main-employee-box">
      <div class="employee-table-out-box">
         <div class="row">
            <div class="col-lg-12 col-md-12">
               <div class="card">
                  <div class="card-bodys">
                  <?php if ($error_warning) { ?>
                            <div class="alert alert-danger"><i class="fa fa-exclamation-circle"></i>
                                <?php echo $error_warning; ?>
                                <button type="button" class="close" data-dismiss="alert">&times;</button>
                            </div>
                            <?php $_SESSION['error_warning'] = null;
                         } ?>
                        <?php $_SESSION['error_warning'] = null;  ?>
                        <?php if ($success) { ?>
                        <div class="alert alert-success"><i class="fa fa-check-circle"></i>
                           <?php echo $success; ?>
                           <button type="button" class="close" data-dismiss="alert">&times;</button>
                           </div>
                         <?php  }  ?>
                     <table class="table table-striped table-bordered table-hover" width="100%" id="nhealth-table" cellspacing="0" cellpadding="0" border="0">
                        <thead>
                           <tr> 
                              <th>Name</th> 
                              <th>Email Address</th> 
                              <th>Action</th>
                           </tr>
                           <tr class="stdfilters"> 
                              <th><input type="text" placeholder="Name"></th> 
                              <th><input type="email" placeholder="Email Address"></th> 
                              <th></th>
                           </tr>
                        </thead>
                        <tbody>
                           <?php
                           if ($newsletters) {
                              foreach ($newsletters as $newsletter) { ?>
                                 <tr> 
                                    <td>
                                       <?= $newsletter['name'] ?>
                                    </td>
                                    <td>
                                       <?= $newsletter['email'] ?>
                                    </td> 
                                    <td class="text-center"> 
                                       <?php if (!$viewer) { ?>
                                          <form style="display: inline-block;" action="<?= $newsletter['delete'] ?>" method="post" enctype="multipart/form-data" id="del_item<?php echo $newsletter['newsletter_id']; ?>">
                                             <input type="hidden" name="newsletter_id" value="<?php echo $newsletter['newsletter_id']; ?>">
                                             <button type="button" data-toggle="tooltip" title="Delete" class="btn btn-danger" onClick='submitDeleteForm("del_item<?php echo $newsletter['newsletter_id']; ?>")'><i class="fa fa-trash-o"></i></button>
                                          </form>
                                       <?php } ?>
                                    </td>
                                 </tr>
                           <?php }
                           } ?>

                        </tbody>
                     </table>
                  </div>
               </div>
            </div>
         </div>
      </div>
   </div>
</div>
<script language="javascript" type="text/javascript">
   function submitDeleteForm(formname) {
      var x = confirm("Are you sure you want to delete?");
      if (x) {
         $("#" + formname).submit();
      } else {
         return false;
      }
   }
   var table = $('#nhealth-table').DataTable({
      "language": {
         "emptyTable": "No record found."
      },
      "pageLength": 10,
      "ordering": true,
       "order": [],
      orderCellsTop: true,
      fixedHeader: true,
      scrollX: true,
      dom: 'Bfrtip',
      buttons: [{
         extend: 'excelHtml5',
         className: 'custom-export-button',
         text: 'Export to Excel',
         exportOptions: {
            columns: ':not(:last)'
         }
      }],
      drawCallback: function(oSettings) {
         var rows = this.fnGetNodes();
         if (rows.length === 0) {
            $('.dt-buttons').hide();
            $('.dataTables_paginate').hide();
         }
         if (oSettings._iDisplayLength >= oSettings.fnRecordsDisplay()) {
            $(oSettings.nTableWrapper).find('.dataTables_paginate').hide();
         }
      }, // Add comma here
      "columnDefs": [
        { "orderable": false, "targets": [1] } // Disable sorting for the 3rd column (Actions)
        ],
      initComplete: function() {
         var api = this.api();
         var i = 1;
         api.columns().eq(0).each(function(colIdx) {
            var column = this;
            var cell = $('.stdfilters th').eq($(api.column(colIdx).header()).index());
            var title = $(cell).text();
            $('input', $('.stdfilters th').eq($(api.column(colIdx).header()).index()))
               .off('keyup change')
               .on('keyup change', function(e) {
                  e.stopPropagation();
                  $(this).attr('title', $(this).val());
                  var cursorPosition = this.selectionStart;
                  var searchValue = this.value.trim(); // Trim extra spaces
                  api
                     .column(colIdx)
                     .search(searchValue)
                     .draw();
                  $(this).focus()[0].setSelectionRange(cursorPosition, cursorPosition);
               });
            i = i + 1;
         });
      } // Remove unnecessary comma here
   }); // Add closing parentheses here

   $('.btn-primary').mouseover(function() {
      $('thead .stdfilters input[type="text"]').blur();
   });
   var exportButton = $('.buttons-excel');
   exportButton.addClass('custom-export-button');
   $('#exportButtonContainer').append(exportButton);
</script>
<?php echo $footer; ?>