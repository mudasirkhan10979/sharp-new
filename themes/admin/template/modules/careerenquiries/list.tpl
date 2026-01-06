<style>
.main-employee-box i.fa.fa-eye {
    right: 2px;
    top:1px;
}

.btn:not(:disabled):not(.disabled) {
    width: 30px;
}
a.btn.btn-primary {
    height: 23px;
}
</style>
<?php echo $header; ?>
<div class="main-panel">
   <div class="sec-head">
		<div class="sec-head-title">
			<h3>Career Enquiries</h3>
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
                     <?php $_SESSION['error_warning'] = null; } ?>
                     <?php if ($this->session->data['success']) { ?>
                        <div class="alert alert-success"><i class="fa fa-check-circle"></i>
                           <?php echo $this->session->data['success']; ?>
                           <button type="button" class="close" data-dismiss="alert">&times;</button>
                        </div>
                     <?php $this->session->data['success']= null; }  ?>
                     <table class="table table-striped table-bordered table-hover" width="100%" id="sharp-table" cellspacing="0" cellpadding="0" border="0">
                        <thead>
                           <tr>
                              <th>Name</th>
                              <th>Phone</th>
                              <th>Email</th>
                              <!-- <th>Career</th> -->
                              <th>Date</th>
                              <th>Action</th>
                           </tr>
                           <tr class="stdfilters">
                                    <th><input type="text" placeholder="Name"></th>
                                    <th><input type="text" placeholder="Phone"></th>
                                    <th><input type="email" placeholder="Email"></th>
                                    <!-- <th><input type="text" placeholder="Career"></th> -->
                                    <th><input type="date" placeholder="Date"></th>
                                    <th></th>
                            </tr>
                        </thead>
                        <tbody>
                           <?php
                           if ($careerenquiries) {
                              foreach ($careerenquiries as $enquiry) { ?>
                                 <tr>
                                    <td>
                                       <?= $enquiry['name'] ?>
                                    </td>
                                    <td>
                                       <?= $enquiry['phone'] ?>
                                    </td>
                                    <td>
                                       <?= $enquiry['email'] ?>
                                    </td>
                                    <!-- <td>
                                       <?= $enquiry['title'] ?>
                                    </td> -->
                                    <td>
                                       <?= $enquiry['date_added'] ?>
                                    </td>
                                    <td class="text-center">
                                       <a style="display: inline-block;" href="<?= $enquiry['detail'] ?>" data-toggle="tooltip" title="<?php echo $button_edit; ?>" class="btn btn-primary"><i class="fa fa-eye"></i></a>
                                       <form style="display: inline-block;" action="<?= $enquiry['delete'] ?>" method="post" enctype="multipart/form-data" id="del_item<?php echo $enquiry['enquiry_id']; ?>">
                                             <input type="hidden" name="enquiry_id" value="<?php echo $enquiry['enquiry_id']; ?>">
                                             <button type="button" data-toggle="tooltip" title="Delete" class="btn btn-danger" onClick='submitDeleteForm("del_item<?php echo $enquiry['enquiry_id']; ?>")'><i class="fa fa-trash-o"></i></button>
                                       </form>
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
        { "orderable": false, "targets": [4] } // Disable sorting for the 3rd column (Actions)
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