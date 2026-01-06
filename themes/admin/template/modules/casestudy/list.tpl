<?php echo $header; ?>
<div class="main-panel">
    <div class="sec-head">
        <div class="sec-head-title">
            <h3>Case Studies</h3>
        </div>
        <div class="sec-head-btns">
            <a href="<?php echo $add; ?>" class="btn bts89067 btn890-890-890 opt"> + Add Case Study </a>
        </div>
    </div>
    <div class="main-employee-box">
        <div class="employee-table-out-box">
            <div class="row">
                <div class="col-lg-12 col-md-12">
                <?php $_SESSION['error_warning'] = null;  ?>
                     <?php if ($success) { ?>
                        <div class="alert alert-success"><i class="fa fa-check-circle"></i>
                           <?php echo $success; ?>
                           <button type="button" class="close" data-dismiss="alert">&times;</button>
                        </div>
                     <?php  }  ?>
                    <div class="card">
                        <div class="card-bodys">
                            <table class="table table-striped table-bordered table-hover" id="case-study-table" width="100%" cellspacing="0" cellpadding="0" border="0">
                                <thead>
                                    <tr>
                                        <th class="text-left">Title</th>
                                        <th class="text-left">Sort Order</th>
                                        <th class="text-left">Status</th>
                                        <th class="text-right">Action</th>
                                    </tr>
                                    <tr class="stdfilters">
                                    <th><input type="text" placeholder="Title"></th>
                                    <th><input type="text" placeholder="Sort Order"></th>
                                    <th id="case-study"></th>
                                    <th></th>
                                     </tr>
                                </thead>
                                <tbody>
                                    <?php if ($case_studies) { ?>
                                    <?php foreach ($case_studies as $case_study) { ?>
                                    <tr class="stdfilters">
                                        <td class="text-left">
                                            <?php echo $case_study['title']; ?>
                                        </td>
                                        <td class="text-left">
                                            <?php echo $case_study['sort_order']; ?>
                                        </td>
                                      <td>
                                                <div class="custom-control custom-switch">
                                                    <input type="checkbox" class="custom-control-input status-toggle"
                                                        id="statusToggle<?php echo $case_study['case_study_id']; ?>"
                                                        <?php echo ($case_study['status']) ? 'checked' : ''; ?>
                                                        data-status-id="<?php echo $case_study['case_study_id']; ?>">
                                                    <label class="custom-control-label"
                                                        for="statusToggle<?php echo $case_study['case_study_id']; ?>">
                                                        <?php echo ($case_study['status']) ? 'Active' : 'Inactive'; ?>
                                                    </label>
                                                </div>
                                            </td>
                                        <td class="text-right">
                                            <a style="display: inline-block;" href="<?php echo $case_study['edit']; ?>"
                                                data-toggle="tooltip" title="<?php echo $button_edit; ?>"
                                                class="btn btn-primary"><i class="fa fa-pencil"></i></a>
                                            <form style="display: inline-block;"
                                                action="<?php echo $case_study['delete']; ?>" method="post"
                                                enctype="multipart/form-data"
                                                id="del_case_study<?php echo $case_study['case_study_id']; ?>">
                                                <input type="hidden" name="case_study_id"
                                                    value="<?php echo $case_study['case_study_id']; ?>">
                                                <button type="button" data-toggle="tooltip"
                                                    title="<?php echo $button_delete; ?>" class="btn btn-danger"
                                                    onClick='submitDeleteForm("del_case_study<?php echo $case_study['case_study_id']; ?>")'><i class="fa fa-trash-o"></i></button>
                                            </form>
                                        </td>
                                    </tr>
                                    <?php } ?>
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

<div id="loader" class="loader-overlay" style="display: none;">
    <div class="loader"></div>
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
    
</script>
<script type="text/javascript">
      // $('#case-study-table thead tr').clone(true).addClass('stdfilters').appendTo('#case-study-table thead');
      var table = $('#case-study-table').DataTable({
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
        { "orderable": false, "targets": [3] } // Disable sorting for the 3rd column (Actions)
        ],
         initComplete: function () {
            
            var api = this.api();
            var i = 1;
            api.columns().eq(0).each(function (colIdx) {
               var column = this;
               // alert(i);
               if (i == 3)
               {
                  var select = $('<select><option value="">Choose</option><option value=" Active">Active</option><option value="Inactive">Inactive</option></select>')
                           .appendTo($('#case-study').empty())
                           .on('change', function() {
                              var val = $(this).val();

                              column.search(val, true, false)
                                 .draw(true);
                           });

                        
               }else{
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
               }
               i = i+1;



            });
         }
      });
</script>

<script>
    $(document).on('change', 'input[type="checkbox"]', function() {

        // $('.alert').remove();

        var checkbox = $(this);
        var statusLabel = checkbox.next('label');
        var case_studyId = checkbox.data('status-id');
        var newStatus = checkbox.is(':checked') ? 1 : 0;
        var newStatusText = newStatus ? 'Active' : 'Inactive';
        statusLabel.text(newStatusText);
        $('#loader').show();
        let data = {
            case_study_id: case_studyId,
            status: newStatus
        };
        $.ajax({
            url: '<?php echo $ajaxcasestudystatus; ?>',
            method: 'POST',
            data,
            success: function(response) {
                $('#loader').hide();
                if (response.success) {
                    // $('.card').before(
                    //     '<div class="alert alert-success"><i class="fa fa-check-circle"></i>' +
                    //     'Status updated successfully.' +
                    //     '<button type="button" class="close" data-dismiss="alert">&times;</button>' +
                    //     '</div>'
                    // );
                    var row = $('#case-study-table').DataTable().row(checkbox.closest('tr'));
                    var rowData = row.data();
                    rowData[2] =
                        '<div class="custom-control custom-switch"><input type="checkbox" class="custom-control-input status-toggle" id="statusToggle' +
                        case_studyId + '" ' + (newStatus ? 'checked' : '') + ' data-status-id="' +
                        case_studyId + '"> <label class="custom-control-label" for="statusToggle' +
                        case_studyId + '">' + newStatusText + '</label> </div>';
                    row.data(rowData).draw(false);

                    console.log(response);
                } else {
                    checkbox.prop('checked', !checkbox.is(':checked'));
                    statusLabel.text(checkbox.is(':checked') ? 'Active' : 'Inactive');
                }

            },
            error: function(xhr, status, error) {
                $('#loader').hide();
                console.error('Error updating status:', error);

                checkbox.prop('checked', !checkbox.is(':checked'));
                statusLabel.text(checkbox.is(':checked') ? 'Active' : 'Inactive');
            }
        });
    });
</script>

<?php echo $footer; ?>
