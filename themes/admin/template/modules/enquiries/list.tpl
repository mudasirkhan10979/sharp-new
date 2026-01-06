
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
         <h3>Enquiries</h3>
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
                    <?php if ($success) { ?>
                                <div class="alert alert-success"><i class="fa fa-check-circle"></i>
                                    <?php echo $success; ?>
                                    <button type="button" class="close" data-dismiss="alert">&times;</button>
                                </div>
                            <?php  }  ?>
                     <table class="table table-striped table-bordered table-hover" width="100%" id="sharp-table" cellspacing="0" cellpadding="0" border="0">
                        <thead>
                           <tr>
                              <th>Name</th>
                              <th>Email Address</th>
                              <th>Phone</th>
                              <th>Subject</th>
                              <!-- <th>Date</th> -->
                              <th>Enquiry From</th>
                              <th>Action</th>
                           </tr>
                           <tr class="stdfilters">
                              <th><input type="text"  placeholder="Name"></th>
                              <th><input type="email" placeholder="Email Address"></th>
                              <th><input type="text" placeholder="Phone"></th>
                              <th><input type="text"  placeholder="Subject"></th>
                              <th><input type="text" placeholder="Enquiry From"></th>
                              <!-- <th><input type="date" placeholder="Date"></th> -->
                              <th></th>
                           </tr>
                        </thead>
                        <tbody>
                           <?php
                           if ($enquiries) {
                              foreach ($enquiries as $enquiry) { ?>
                                 <tr>
                                    <td>
                                       <?= $enquiry['name'] ?>
                                    </td>
                                    <td>
                                       <?= $enquiry['email'] ?>
                                    </td>
                                    <td>
                                       <?= $enquiry['phone'] ?>
                                    </td>
                                     <td>
                                       <?= $enquiry['subject'] ?>
                                    </td> 
                                    <!-- <td>
                                       <?= $enquiry['date'] ?>
                                    </td> -->
                                    <td>
                                       <?= $enquiry['enquiry_from'] ?>
                                    </td>
                                    <td class="text-center">
                                       <a style="display: inline-block;" href="<?= $enquiry['edit'] ?>" data-toggle="tooltip" title="<?php echo $button_edit; ?>" class="btn btn-primary"><i class="fa fa-eye"></i></a>
                                       <?php if (!$viewer) { ?>
                                          <form style="display: inline-block;" action="<?= $enquiry['delete'] ?>" method="post" enctype="multipart/form-data" id="del_item<?php echo $enquiry['enquiry_id']; ?>">
                                             <input type="hidden" name="enquiry_id" value="<?php echo $enquiry['enquiry_id']; ?>">
                                             <button type="button" data-toggle="tooltip" title="Delete" class="btn btn-danger" onClick='submitDeleteForm("del_item<?php echo $enquiry['enquiry_id']; ?>")'><i class="fa fa-trash-o"></i></button>
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



    var table = $('#sharp-table').DataTable({
      "language": {
            "emptyTable": "No record found."
        },
         // dom: 'Bfrtip',
         "pageLength": 10,
         "ordering": true,
          "order": [],
         scrollX: true,
         orderCellsTop: true,
         fixedHeader: true,
         buttons: false,
         "columnDefs": [
        { "orderable": false, "targets": [5] } // Disable sorting for the 3rd column (Actions)
        ],
         initComplete: function () {
            
            var api = this.api();
            var i = 1;
            
            api.columns().eq(0).each(function (colIdx) {
               var column = this;

                  var cell = $('.stdfilters th').eq($(api.column(colIdx).header()).index());
                  var title = $(cell).text();
                  // $(cell).html('<input type="text" placeholder="' + title + '" />');
   
                     $('input', $('.stdfilters th').eq($(api.column(colIdx).header()).index()))
                     .off('keyup change')
                     .on('keyup change', function (e) {
                        e.stopPropagation();
                        $(this).attr('title', $(this).val());
                        var regexr = '({search})';
                        var cursorPosition = this.selectionStart;
                        api
                           .column(colIdx)
                           .search((this.value != "") ? regexr.replace('{search}', '(((' + this.value + ')))') : "", this.value != "", this.value == "")
                           .draw();
                        $(this).focus()[0].setSelectionRange(cursorPosition, cursorPosition);
                     });
               
               i = i+1;



            });
         }
      });
</script>

<?php echo $footer; ?>