<?php echo $header; ?>
<div class="main-panel">
    <div class="sec-head">
        <div class="sec-head-title">
            <h3>Awards</h3>
        </div>
        <div class="sec-head-btns">
            <a href="<?php echo $add; ?>" class="btn bts89067 btn890-890-890 opt"> + Add Award </a>
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
                            <table id="award-table" class="table table-striped table-bordered table-hover" width="100%"
                                cellspacing="0" cellpadding="0" border="0">
                                <thead>
                                    <tr> 
                                        <th>Title</th>
                                        <th>Sort Order</th>
                                        <th>Status</th>
                                        <th>Actions</th>
                                    </tr>
                                    <tr class="stdfilters">
                                        <th><input type="text" placeholder="Title"></th> 
                                        <th><input type="text" placeholder="Sort Order"></th>
                                        <th id="drop-searc"></th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                     foreach ($awards as $award) { ?>
                                    <tr> 
                                        <td>
                                            <?= $award['title'] ?>
                                        </td>
                                        <td>
                                            <?= $award['sort_order'] ?>
                                        </td>
                                        <td>
                                        <div class="custom-control custom-switch">
                                                    <input type="checkbox" class="custom-control-input status-toggle"
                                                        id="statusToggle<?php echo $award['award_id']; ?>"
                                                        <?php echo ($award['status']) ? 'checked' : ''; ?>
                                                        data-status-id="<?php echo $award['award_id']; ?>">
                                                    <label class="custom-control-label"
                                                        for="statusToggle<?php echo $award['award_id']; ?>">
                                                        <?php echo ($award['status']) ? 'Active' : 'Inactive'; ?>
                                                    </label>
                                                </div>
                                        </td>
                                        <td class="text-right">
                                            <?php if ($this->user->hasPermission('modify', 'awards')) { ?>
                                            <a style="display: inline-block;" href="<?php echo $award['edit']; ?>"
                                                data-toggle="tooltip" title="<?php echo $button_edit; ?>"
                                                class="btn btn-primary"><i class="fa fa-pencil"></i></a>
                                            <form style="display: inline-block;"
                                                action="<?php echo $award['delete']; ?>" method="post"
                                                enctype="multipart/form-data"
                                                id="del_award<?php echo $award['award_id']; ?>">
                                                <input type="hidden" name="award_id"
                                                    value="<?php echo $award['award_id']; ?>">
                                                <button type="button" data-toggle="tooltip"
                                                    title="<?php echo $button_delete; ?>" class="btn btn-danger"
                                                    onClick='submitDeleteForm("del_award<?php echo $award['award_id']; ?>")'><i
                                                        class="fa fa-trash-o"></i></button>
                                                </form>
                                            <?php }?>
                                        </td>
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
// $('#award-table thead tr').clone(true).addClass('stdfilters').appendTo('#award-table thead');
var table = $('#award-table').DataTable({
    "language": {
            "emptyTable": "No record found."
        },
    // dom: 'Bfrtip',
    "pageLength": 10,
    "ordering": false,
    orderCellsTop: true,
    fixedHeader: true,
    buttons: false,
    initComplete: function() {
        var api = this.api();
        var i = 1;
        api.columns().eq(0).each(function(colIdx) {
            var column = this;
            // alert(i);
            if (i == 3) {
                var select = $(
                        '<select><option value="">Choose</option><option value=" Active ">Active</option><option value="Inactive">Inactive</option></select>'
                        )
                    .appendTo($('#drop-searc').empty())
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
                        var val = $(this).val();
                        column.search(val, true, false).draw(true); 
                        var cursorPosition = this.selectionStart;
                        $(this).focus()[0].setSelectionRange(cursorPosition, cursorPosition);
                    });
            }
            i = i + 1;
        });
    }
});
</script>
<script>
    $(document).on('change', 'input[type="checkbox"]', function() {
        var checkbox = $(this);
        var statusLabel = checkbox.next('label');
        var awardId = checkbox.data('status-id');
        var newStatus = checkbox.is(':checked') ? 1 : 0;
        var newStatusText = newStatus ? 'Active' : 'Inactive';
        console.log(awardId);
        statusLabel.text(newStatusText);
        $('#loader').show();
        let data = {
            award_id: awardId,
            status: newStatus
        };
        $.ajax({
            url: '<?php echo $ajaxawardstatus; ?>',
            method: 'POST',
            data,
            success: function(response) {
                $('#loader').hide();
                if (response.success) {
                    var row = $('#award-table').DataTable().row(checkbox.closest('tr'));
                    var rowData = row.data();
                    rowData[2] =
                        '<div class="custom-control custom-switch"><input type="checkbox" class="custom-control-input status-toggle" id="statusToggle' +
                        awardId + '" ' + (newStatus ? 'checked' : '') + ' data-status-id="' +
                        awardId + '"> <label class="custom-control-label" for="statusToggle' +
                        awardId + '">' + newStatusText + '</label> </div>';
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