<?php echo $header; ?>
<div class="main-panel">
    <div class="sec-head">
        <div class="sec-head-title">
            <h3>Front Menu</h3>
        </div>
            <div class="sec-head-btns">
                <a href="<?php echo $add; ?>" class="btn bts89067 btn890-890-890 opt"> + Add Front Menu</a>
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
                            <table class="table table-striped table-bordered table-hover" id="nhealth-table" width="100%" cellspacing="0" cellpadding="0" border="0">
                                <thead>
                                    <tr>
                                        <th class="text-left">Name</th>
                                        <th class="text-left">Region</th>
                                        <!-- <th class="text-left">Sort Order</th> -->
                                        <th class="text-left">Status</th>
                                        <th class="text-right">Action</th>
                                    </tr>
                                    <tr class="stdfilters">
                                        <th><input type="text" placeholder="Name"></th>
                                        <th><input type="text" placeholder="Region"></th>
                                        <!-- <th><input type="text" placeholder="Sort Order"></th> -->
                                        <th id="menu-status"></th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if ($menus) { ?>
                                        <?php foreach ($menus as $menu) { ?>
                                            <tr class="stdfilters">
                                                <td class="text-left">
                                                    <?php echo $menu['title']; ?>
                                                </td>
                                                <td class="text-left">
                                                    <?php echo $menu['region']; ?>
                                                </td>
                                                <!-- <td class="text-left">
                                                    <?php echo $menu['sort_order']; ?>
                                                </td> -->
                                                <td class="text-left">
                                                <div class="custom-control custom-switch">
                                                        <input type="checkbox" class="custom-control-input status-toggle" id="statusToggle<?php echo $menu['menu_id']; ?>" <?php echo ($menu['status']) ? 'checked' : ''; ?> data-status-id="<?php echo $menu['menu_id']; ?>">
                                                        <label class="custom-control-label" for="statusToggle<?php echo $menu['menu_id']; ?>">
                                                            <?php echo ($menu['status']) ? 'Active' : 'Inactive'; ?>
                                                        </label>
                                                    </div>
                                                </td>
                                                <td class="text-right">
                                                    <a style="display: inline-block;" href="<?php echo $menu['edit']; ?>" data-toggle="tooltip" title="<?php echo $button_edit; ?>" class="btn btn-primary eye_icon"><i class="<?php echo $button_edit_icon; ?>"></i></a>
                                                   
                                                        <form style="display: inline-block;" action="<?php echo $menu['delete']; ?>" method="post" enctype="multipart/form-data" id="del_slider<?php echo $menu['menu_id']; ?>">
                                                            <input type="hidden" name="menu_id" value="<?php echo $menu['menu_id']; ?>">
                                                            <button type="button" data-toggle="tooltip" title="<?php echo $button_delete; ?>" class="btn btn-danger" onClick='submitDeleteForm("del_slider<?php echo $menu['menu_id']; ?>")'><i class="fa fa-trash-o"></i></button>
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
       buttons: false,
         "columnDefs": [
        { "orderable": false, "targets": [2] } // Disable sorting for the 3rd column (Actions)
        ],
        initComplete: function() {

            var api = this.api();
            var i = 1;
            api.columns().eq(0).each(function(colIdx) {
                var column = this;
                // alert(i);
                if (i == 4) {
                    var select = $('<select><option value="">Choose</option><option value=" Active">Active</option><option value="Inactive">Inactive</option>')
                        .appendTo($('#menu-status').empty())
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
                            // $(this).blur();
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

        // $('.alert').remove();

        var checkbox = $(this);
        var statusLabel = checkbox.next('label');
        var menuId = checkbox.data('status-id');
        var newStatus = checkbox.is(':checked') ? 1 : 0;
        var newStatusText = newStatus ? 'Active' : 'Inactive';
        statusLabel.text(newStatusText);
        $('#loader').show();
        let data = {
            id: menuId,
            status: newStatus
        };
        $.ajax({
            url: '<?php echo $ajaxfrontmenustatus; ?>',
            method: 'POST',
            data,
            success: function(response) {
                if (response.success) {

                    if (response.success) {
                        $('#loader').hide();
                        // $('.card').before(
                        //     '<div class="alert alert-success"><i class="fa fa-check-circle"></i>' +
                        //     'Status updated successfully.' +
                        //     '<button type="button" class="close" data-dismiss="alert">&times;</button>' +
                        //     '</div>'
                        // );
                        var row = $('#nhealth-table').DataTable().row(checkbox.closest('tr'));
                        var rowData = row.data();
                        rowData[2] = '<div class="custom-control custom-switch"><input type="checkbox" class="custom-control-input status-toggle" id="statusToggle' + menuId + '" ' + (newStatus ? 'checked' : '') + ' data-status-id="' + menuId + '"> <label class="custom-control-label" for="statusToggle' + menuId + '">' + newStatusText + '</label> </div>';
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