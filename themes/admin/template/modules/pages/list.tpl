<?php echo $header; ?>
<div class="main-panel">
    <div class="sec-head">
        <div class="sec-head-title">
            <h3>CMS Pages</h3>
        </div>
        <div class="sec-head-btns">
            <a href="<?php echo $add; ?>" class="btn bts89067 btn890-890-890 opt"> + Add CMS Page</a>
        </div>
    </div>
    <div class="main-employee-box">
        <div class="employee-table-out-box">
            <div class="row">
             <div class="col-lg-12 col-md-12">
                      <div class="card">
                        <div class="card-bodys">
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
                                        <th>Title</th> 
                                        <th>Status</th>
                                        <th class="text-right">Actions</th>
                                    </tr>
                                    <tr class="stdfilters">
                                        <th><input type="text" placeholder="Title"></th> 
                                        <th id="drop-searc"></th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                              foreach ($pages as $page) { ?>
                                    <tr>
                                        <td>
                                            <?= $page['name'] ?>
                                        </td> 
                                        <td>
                                        <div class="custom-control custom-switch">
                                                    <input type="checkbox" class="custom-control-input status-toggle" id="statusToggle<?php echo $page['page_id']; ?>" <?php echo ($page['publish']) ? 'checked' : ''; ?> data-status-id="<?php echo $page['page_id']; ?>">
                                                        <label class="custom-control-label" for="statusToggle<?php echo $page['page_id']; ?>">
                                                            <?php echo ($page['publish']) ? 'Active' : 'Inactive'; ?>
                                                        </label>
                                                    </div>
                                        </td>
                                        <td class="text-right">
                                            <a style="display: inline-block;" href="<?php echo $page['edit']; ?>"
                                                data-toggle="tooltip" title="<?php echo $button_edit; ?>"
                                                class="btn btn-primary"><i class="fa fa-pencil"></i></a>
                                            <form style="display: inline-block;"
                                                action="<?php echo $page['delete']; ?>" method="post"
                                                enctype="multipart/form-data"
                                                id="del_slider<?php echo $page['page_id']; ?>">
                                                <input type="hidden" name="page_id"
                                                    value="<?php echo $page['page_id']; ?>">
                                                <button type="button" data-toggle="tooltip"
                                                    title="<?php echo $button_delete; ?>" class="btn btn-danger"
                                                    onClick='submitDeleteForm("del_slider<?php echo $page['page_id']; ?>")'><i class="fa fa-trash-o"></i></button>
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
// $('#nhealth-table thead tr').clone(true).addClass('stdfilters').appendTo('#nhealth-table thead');
var table = $('#nhealth-table').DataTable({
     "language": {
            "emptyTable": "No record found."
        },
    // dom: 'Bfrtip',
    "pageLength": 10,
    "ordering": false,
    orderCellsTop: true,
    fixedHeader: true,
    scrollX: true,
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
                        $(this).attr('title', $(this).val());
                        var regexr = '({search})';
                        var cursorPosition = this.selectionStart;
                        api
                            .column(colIdx)
                            .search((this.value != "") ? regexr.replace('{search}', '(((' + this
                                .value + ')))') : "", this.value != "", this.value == "")
                            .draw();
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

        // $('.alert').remove();

        var checkbox = $(this);
        var statusLabel = checkbox.next('label');
        var pagId = checkbox.data('status-id');
        var newStatus = checkbox.is(':checked') ? 1 : 0;
        var newStatusText = newStatus ? 'Active' : 'Inactive';
        statusLabel.text(newStatusText);
        $('#loader').show();
        let data = {
            id: pagId,
            status: newStatus
        };
        $.ajax({
            url: '<?php echo $ajaxcmsstatus; ?>',
            method: 'POST',
            data,
            success: function(response) {
                $('#loader').hide();
                if (response.success) {

                    if (response.success) {

                        // $('.card').before(
                        //     '<div class="alert alert-success"><i class="fa fa-check-circle"></i>' +
                        //     'Status updated successfully.' +
                        //     '<button type="button" class="close" data-dismiss="alert">&times;</button>' +
                        //     '</div>'
                        // );
                        var row = $('#nhealth-table').DataTable().row(checkbox.closest('tr'));
                        var rowData = row.data();
                        rowData[1] = '<div class="custom-control custom-switch"><input type="checkbox" class="custom-control-input status-toggle" id="statusToggle' + pagId + '" ' + (newStatus ? 'checked' : '') + ' data-status-id="' + pagId + '"> <label class="custom-control-label" for="statusToggle' + pagId + '">' + newStatusText + '</label> </div>';
                        row.data(rowData).draw(false);
                    }
                    console.log(response);
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