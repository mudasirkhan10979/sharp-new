<?php echo $header; ?>

<div class="main-panel">

   <div class="sec-head">
      <div class="sec-head-title">
         <h3>Admin Users</h3>
      </div>
      <?php if(!$viewer){ ?>
      <div class="sec-head-btns">
         <a href="<?php echo $add; ?>" class="btn bts89067 btn890-890-890 opt"> + Add New User </a>
      </div>
      <?php } ?>
   </div>

   <div class="main-employee-box">
      <div class="employee-table-out-box">
         <div class="row">
            <div class="col-lg-12 col-md-12">
               <?php if ($error_warning) { ?>
                  <div class="alert alert-danger"><i class="fa fa-exclamation-circle"></i> <?php echo $error_warning; ?>
                     <button type="button" class="close" data-dismiss="alert">&times;</button>
                  </div>
               <?php } ?>
               <?php if ($success) { ?>
                  <div class="alert alert-success"><i class="fa fa-check-circle"></i> <?php echo $success; ?>
                     <button type="button" class="close" data-dismiss="alert">&times;</button>
                  </div>
               <?php } ?>
                  <div class="card">
                     <div class="card-bodys">
                        <table id="noir-tabale" class="table table-striped table-bordered table-hover" width="100%" cellspacing="0" cellpadding="0" border="0">
                           <thead class="head-table-rang">
                              <tr>
                                 <th>User Name</th>
                                 <th>Email</th>
                                 <!-- <th>Date Added</th> -->
                                 <!-- <th>Role</th> -->
                                 <th>Status</th>
                                 <th class="text-right">Action</th>
                              </tr>
                              <tr class="stdfilters">
                                 <th><input type="text" placeholder="User Name"></th>
                                 <th><input type="text" placeholder="Email"></th>
                                 <!-- <th><input type="date" placeholder="Date added"></th> -->
                                 <!-- <th></th> -->
                                 <th id="users"></th>
                                 <th></th>
                              </tr>
                           </thead>
                           <tbody>
                              <?php if ($users) { ?>
                                 <?php foreach ($users as $user) { ?>
                                    <tr class="stdfilters">
                                       <td><?php echo $user['username']; ?> </h5>
                                       </td>
                                       <td><?php echo $user['email']; ?> </h5>
                                       </td>
                                       <!-- <td><?php echo date('Y-m-d', strtotime($user['date'])); ?> </h5>
                                       </td> -->
                                       <!-- <td><?php echo $user['role']; ?></td> -->
                                       <td>
                                       <div class="custom-control custom-switch">
                                                    <input type="checkbox" class="custom-control-input status-toggle" id="statusToggle<?php echo $user['user_id']; ?>" <?php echo ($user['status']) ? 'checked' : ''; ?> data-status-id="<?php echo $user['user_id']; ?>">
                                                    <label class="custom-control-label" for="statusToggle<?php echo $user['user_id']; ?>">
                                                        <?php echo ($user['status']) ? 'Active' : 'Inactive'; ?>
                                          </label>
                                       </div>
                                       </td>
                                       <td class="text-right">
                                          <a style="display: inline-block;" href="<?php echo $user['edit']; ?>" data-toggle="tooltip" title="<?php echo $button_edit; ?>" class="btn btn-primary"><i class="<?php echo $button_edit_icon; ?>"></i></a>
                                         <?php if(!$viewer) { ?>
                                          <form style="display: inline-block;" action="<?= $user['delete'] ?>" method="post" enctype="multipart/form-data" id="del_item<?php echo $user['user_id']; ?>">
                                             <input type="hidden" name="user_id" value="<?php echo $user['user_id']; ?>">
                                             <button type="button" data-toggle="tooltip" title="Delete" class="btn btn-danger" onClick='submitDeleteForm("del_item<?php echo $user['user_id']; ?>")'><i class="fa fa-trash-o"></i></button>
                                          </form>
                                          <?php } ?>
                                       </td>
                                    </tr>
                                 <?php } ?>
                              <?php } else { ?>
                                 <tr>
                                    <td class="text-center" colspan="5"><?php echo $text_no_results; ?></td>
                                 </tr>
                              <?php } ?>
                           </tbody>
                        </table>
                     </div>
                  </div>
              
            </div>
         </div>
      </div>
   </div>
</div>

<!-- Loader HTML -->
<div id="loader" class="loader-overlay" style="display: none;">
    <div class="loader"></div>
</div>
<script type="text/javascript">
   function submitDeleteForm(formname) {
        var x = confirm("Are you sure you want to delete?");
        if (x) {
            $("#" + formname).submit();
        } else {
            return false;
        }
    } 
   // $('#noir-tabale thead tr').clone(true).addClass('stdfilters').appendTo('#noir-tabale thead');
   var table = $('#noir-tabale').DataTable({
      // dom: 'Bfrtip',
      "pageLength": 10,
      "ordering": true,
       "order": [],
      orderCellsTop: true,
      fixedHeader: true,
      buttons: false,
      "columnDefs": [
      { "orderable": false, "targets": [3] } // Disable sorting for the 3rd column (Actions)
      ],
      initComplete: function() {
         var api = this.api();
         var i = 1;
         api.columns().eq(0).each(function(colIdx) {
            var column = this;
            // alert(i);
            if (i == 4) {
               var select = $('<select><option value="">Choose</option><option value=" Active">Active</option><option value="Inactive">Inactive</option></select>')
                  .appendTo($('#users').empty())
                  .on('change', function() {
                     var val = $(this).val();
                     column.search(val, true, false)
                        .draw(true);
                  });
            } else {
               var cell = $('.stdfilters th').eq($(api.column(colIdx).header()).index());
               var title = $(cell).text();
               // $(cell).html('<input type="text" placeholder="' + title + '" />');
               $('input', $('.stdfilters th').eq($(api.column(colIdx).header()).index()))
                  .off('keyup change')
                  .on('keyup change', function(e) {
                     e.stopPropagation();
                     $(this).attr('title', $(this).val());
                     var regexr = '({search})';
                     var cursorPosition = this.selectionStart;
                     api
                        .column(colIdx)
                        .search((this.value != "") ? regexr.replace('{search}', '(((' + this.value + ')))') : "", this.value != "", this.value == "")
                        .draw();
                     $(this).focus()[0].setSelectionRange(cursorPosition, cursorPosition);
                     //  $(this).blur();
                  });
            }
            i = i + 1;
         });
      }
   });
   $('.btn-primary').mouseover(function() {
      $('thead .stdfilters input[type="text"]').blur();
   });
</script>

<script>
    $(document).on('change', 'input[type="checkbox"]', function() {
        var checkbox = $(this);
        var statusLabel = checkbox.next('label');
        var userId = checkbox.data('status-id');
        var newStatus = checkbox.is(':checked') ? 1 : 0;
        var newStatusText = newStatus ? 'Active' : 'Inactive';

        // Show loader
        $('#loader').show();

        // Delay to simulate loader display
        // setTimeout(function() {
            $.ajax({
                url: '<?php echo $ajaxadminuserstatus; ?>',
                method: 'POST',
                data: {
                    id: userId,
                    status: newStatus
                },
                success: function(response) {
                    $('#loader').hide();
                    if (response.success) {
                        var row = $('#noir-tabale').DataTable().row(checkbox.closest('tr'));
                        var rowData = row.data();
                        rowData[2] = '<div class="custom-control custom-switch"><input type="checkbox" class="custom-control-input status-toggle" id="statusToggle' + userId + '" ' + (newStatus ? 'checked' : '') + ' data-status-id="' + userId + '"> <label class="custom-control-label" for="statusToggle' + userId + '">' + newStatusText + '</label> </div>';
                        row.data(rowData).draw(false);
                    }
                },
                error: function(xhr, status, error) {
                    $('#loader').hide();
                    console.error('Error updating status:', error);
                    checkbox.prop('checked', !checkbox.is(':checked'));
                    statusLabel.text(checkbox.is(':checked') ? 'Active' : 'Inactive');
                }
            });
        // }, 3000); // 3 seconds delay
    });
</script>
<?php echo $footer; ?>