<?php echo $header; ?>
<div class="main-panel">
    <div class="sec-head">
        <div class="sec-head-title">
            <h3>Service Centers</h3>
        </div>
        <div class="sec-head-btns">
            <a href="<?php echo $add; ?>" class="btn bts89067 btn890-890-890 opt"> + Add Service Center </a>
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
                            <table id="nhealth-table" class="table table-striped table-bordered table-hover" width="100%"
                                cellspacing="0" cellpadding="0" border="0">
                                <thead>
                                    <tr> 
                                        <th>Service Center</th>
                                        <th>Country</th>
                                        <th>Department</th>
                                        <th>Contact Number</th>
                                        <th>Status</th>
                                        <th>Actions</th>
                                    </tr>
                                    <tr class="stdfilters">
                                        <th><input type="text" placeholder="Service Center"></th>
                                        <th><input type="text" placeholder="Country"></th>
                                         <th><input type="text" placeholder="Department"></th>
                                        <th><input type="text" placeholder="Contact Number"></th>
                                        <th id="drop-searc"></th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($service_centers as $service_center) { ?>
                                    <tr> 
                                        <td><?= $service_center['service_center_name'] ?></td>
                                        <td><?= $service_center['country_name'] ?></td>
                                         <td><?= $service_center['department'] ?></td>
                                        <td><?= $service_center['landline'] ?></td>
                                        <td>
                                        <div class="custom-control custom-switch">
                                                <input type="checkbox" class="custom-control-input status-toggle"
                                                    id="statusToggle<?php echo $service_center['service_center_id']; ?>"
                                                    <?php echo ($service_center['publish']) ? 'checked' : ''; ?>
                                                    data-status-id="<?php echo $service_center['service_center_id']; ?>">
                                                <label class="custom-control-label"
                                                    for="statusToggle<?php echo $service_center['service_center_id']; ?>">
                                                    <?php echo ($service_center['publish']) ? 'Active' : 'Inactive'; ?>
                                                </label>
                                            </div>
                                        </td>
                                        <td class="text-right">
                                            <a style="display: inline-block;" href="<?php echo $service_center['edit']; ?>"
                                                data-toggle="tooltip" title="<?php echo $button_edit; ?>"
                                                class="btn btn-primary"><i class="fa fa-pencil"></i></a>
                                            <form style="display: inline-block;"
                                                action="<?php echo $service_center['delete']; ?>" method="post"
                                                enctype="multipart/form-data"
                                                id="del_service_center<?php echo $service_center['service_center_id']; ?>">
                                                <input type="hidden" name="service_center_id"
                                                    value="<?php echo $service_center['service_center_id']; ?>">
                                                <button type="button" data-toggle="tooltip"
                                                    title="<?php echo $button_delete; ?>" class="btn btn-danger"
                                                    onClick='submitDeleteForm("del_service_center<?php echo $service_center['service_center_id']; ?>")'><i
                                                        class="fa fa-trash-o"></i></button>
                                            </form>
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
var table = $('#nhealth-table').DataTable({
    "language": {
        "emptyTable": "No record found."
    },
    "pageLength": 10,
    "ordering": true,
    "order": [],
    orderCellsTop: true,
    fixedHeader: true,
    buttons: false,
    "columnDefs": [
    { "orderable": false, "targets": [5] }
    ],
    initComplete: function() {
        var api = this.api();
        var i = 1;
        api.columns().eq(0).each(function(colIdx) {
            var column = this;

            if (i == 5) {
                var select = $('<select><option value="">Choose</option><option value=" Active ">Active</option><option value="Inactive">Inactive</option></select>')
                    .appendTo($('#drop-searc').empty())
                    .on('change', function() {
                        var val = $(this).val();
                        column.search(val, true, false).draw(true);
                    });
            } else {
                var cell = $('.stdfilters th').eq($(api.column(colIdx).header()).index());
                var title = $(cell).text();
                $('input', $('.stdfilters th').eq($(api.column(colIdx).header()).index()))
                    .off('keyup change')
                    .on('keyup change', function(e) {
                        e.stopPropagation();
                        $(this).attr('title', $(this).val());
                        var regexr = '({search})';
                        var cursorPosition = this.selectionStart;

                        setTimeout(() => {
                            api.column(colIdx)
                                .search((this.value != "") ? regexr.replace('{search}', '(((' + this.value + ')))') : "", this.value != "", this.value == "")
                                .draw();

                            $(this).focus()[0].setSelectionRange(cursorPosition, cursorPosition);
                        }, 0);
                    });
            }
            i++;
        });
    }
});
</script>
<script>
$(document).on('change', 'input[type="checkbox"]', function() {
    var checkbox = $(this);
    var statusLabel = checkbox.next('label');
    var serviceCenterId = checkbox.data('status-id');
    var newStatus = checkbox.is(':checked') ? 1 : 0;
    var newStatusText = newStatus ? 'Active' : 'Inactive';
    statusLabel.text(newStatusText);
    $('#loader').show();
    let data = {
        service_center_id: serviceCenterId,
        status: newStatus
    };
    $.ajax({
        url: '<?php echo $ajaxdservicecenterstatus; ?>',
        method: 'POST',
        data,
        success: function(response) {
            $('#loader').hide();
            if (response.success) {
                var row = $('#nhealth-table').DataTable().row(checkbox.closest('tr'));
                var rowData = row.data();
                rowData[4] =
                    '<div class="custom-control custom-switch"><input type="checkbox" class="custom-control-input status-toggle" id="statusToggle' +
                    serviceCenterId + '" ' + (newStatus ? 'checked' : '') + ' data-status-id="' + serviceCenterId +
                    '"> <label class="custom-control-label" for="statusToggle' + serviceCenterId + '">' +
                    newStatusText + '</label> </div>';
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
});
</script>
<?php echo $footer; ?>