<?php echo $header; ?>
<div class="main-panel">
    <div class="sec-head">
        <div class="sec-head-title">
            <h3>Products</h3>
        </div>
        <div class="sec-head-btns">
            <a href="<?php echo $add; ?>" class="btn bts89067 btn890-890-890 opt"> + Add product </a>
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
                            <table class="table table-striped table-bordered table-hover" id="sharp-table" width="100%" cellspacing="0" cellpadding="0" border="0">
                                <thead>
                                    <tr>
                                        <th class="text-left">Title</th>
                                        <th class="text-left">Product Serial Number</th>
                                        <th class="text-left">Category Name</th>
                                        <th class="text-left">Sort Order</th>
                                        <th class="text-left">Status</th>
                                        <th class="text-left">Featured</th>
                                        <th class="text-right">Action</th>
                                    </tr>
                                    <tr class="stdfilters">
                                    <th><input type="text" placeholder="Title"></th>
                                    <th><input type="text" placeholder="Product Serial Number"></th>
                                    <th><input type="text" placeholder="Category Name"></th>
                                    <th><input type="text" placeholder="Sort Order"></th>
                                    <th id="drop-searc"></th>
                                    <th id="drop-fsearc"></th>
                                    <th></th>
                                     </tr>
                                </thead>
                                <tbody>
                                    <?php if ($products) { ?>
                                    <?php foreach ($products as $product) { ?>
                                    <tr>
                                        <td class="text-left">
                                            <?php echo $product['name']; ?>
                                        </td>
                                        <td class="text-left">
                                            <?php echo $product['product_serial_number']; ?>
                                        </td>
                                        <td class="text-left">
                                            <?php echo $product['category_name']; ?>
                                        </td>
                                        <td class="text-left">
                                            <?php echo $product['sort_order']; ?>
                                        </td>
                                        <td class="text-left">
                                            <div class="custom-control custom-switch">
                                                <input type="checkbox" class="custom-control-input status-toggle"
                                                    id="statusToggle<?php echo $product['product_id']; ?>"
                                                    <?php echo ($product['status']) ? 'checked' : ''; ?>
                                                    data-status-id="<?php echo $product['product_id']; ?>">
                                                <label class="custom-control-label"
                                                    for="statusToggle<?php echo $product['product_id']; ?>">
                                                    <?php echo ($product['status']) ? 'Active' : 'Inactive'; ?>
                                                </label>
                                            </div>
                                        </td>
                                        <td class="text-left">
                                            <div class="custom-control custom-switch">
                                                <input type="checkbox" class="custom-control-input featured-toggle"
                                                    id="featuredToggle<?php echo $product['product_id']; ?>"
                                                    <?php echo ($product['featured']) ? 'checked' : ''; ?>
                                                    data-featured-id="<?php echo $product['product_id']; ?>">
                                                <label class="custom-control-label"
                                                    for="featuredToggle<?php echo $product['product_id']; ?>">
                                                    <?php echo ($product['featured']) ? 'Featured' : 'Unfeatured'; ?>
                                                </label>
                                            </div>
                                        </td>
                                        <td class="text-right">
                                            <a style="display: inline-block;" href="<?php echo $product['edit']; ?>"
                                                data-toggle="tooltip" title="<?php echo $button_edit; ?>"
                                                class="btn btn-primary"><i class="fa fa-pencil"></i></a>
                                            <form style="display: inline-block;"
                                                action="<?php echo $product['delete']; ?>" method="post"
                                                enctype="multipart/form-data"
                                                id="del_team<?php echo $product['product_id']; ?>">
                                                <input type="hidden" name="product_id"
                                                    value="<?php echo $product['product_id']; ?>">
                                                <button type="button" data-toggle="tooltip"
                                                    title="<?php echo $button_delete; ?>" class="btn btn-danger"
                                                    onClick='submitDeleteForm("del_team<?php echo $product['product_id']; ?>")'><i class="fa fa-trash-o"></i></button>
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
    var table = $('#sharp-table').DataTable({
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
            { "orderable": false, "targets": [4, 5, 6] }
        ],
        scrollX: true,
        initComplete: function () {
            var api = this.api();
            
            api.columns().eq(0).each(function (colIdx) {
                var column = this;
                var cell = $('.stdfilters th').eq($(api.column(colIdx).header()).index());
                
                if (colIdx === 4) {
                    var select = $('<select><option value="">Status</option><option value="Active">Active</option><option value="Inactive">Inactive</option></select>')
                        .appendTo($('#drop-searc').empty())
                        .on('change', function() {
                            var val = $(this).val();
                            column.search(val, true, false).draw(true);
                        });
                } 
                else if (colIdx === 5) {
                    var select = $('<select><option value="">All</option><option value="Featured">Featured</option><option value="Unfeatured">Unfeatured</option></select>')
                        .appendTo($('#drop-fsearc').empty())
                        .on('change', function() {
                            var val = $(this).val();
                            if (val === '') {

                                 column.search('', true, false).draw(true);
                            } else {

                                 var regex = '\ '+val+' \ ';
                                column.search(regex, true, false).draw(true);
                            }
                        });
                }
                else if (colIdx !== 6) {
                    $('input', $('.stdfilters th').eq($(api.column(colIdx).header()).index()))
                        .off('keyup change')
                        .on('keyup change', function (e) {
                            e.stopPropagation();
                            $(this).attr('title', $(this).val());
                            var regexr = '({search})';
                            var cursorPosition = this.selectionStart;
                            api.column(colIdx)
                                .search((this.value != "") ? regexr.replace('{search}', '(((' + this.value + ')))') : "", this.value != "", this.value == "")
                                .draw();
                            $(this).focus()[0].setSelectionRange(cursorPosition, cursorPosition);
                        });
                }
            });
        }
    });
</script>
<script>
    // Status toggle functionality
    $(document).on('change', '.status-toggle', function() {
        var checkbox = $(this);
        var statusLabel = checkbox.next('label');
        var productId = checkbox.data('status-id');
        var newStatus = checkbox.is(':checked') ? 1 : 0;
        var newStatusText = newStatus ? 'Active' : 'Inactive';
        statusLabel.text(newStatusText);
        $('#loader').show();
        
        let data = {
            product_id: productId,
            status: newStatus
        };
        
        $.ajax({
            url: '<?php echo $ajaxProductstatus; ?>',
            method: 'POST',
            data: data,
            success: function(response) {
                $('#loader').hide();
                if (response.success) {
                    // Update the DataTable row data
                    var row = $('#sharp-table').DataTable().row(checkbox.closest('tr'));
                    var rowData = row.data();
                    rowData[4] = '<div class="custom-control custom-switch"><input type="checkbox" class="custom-control-input status-toggle" id="statusToggle' + productId + '" ' + (newStatus ? 'checked' : '') + ' data-status-id="' + productId + '"> <label class="custom-control-label" for="statusToggle' + productId + '">' + newStatusText + '</label> </div>';
                    row.data(rowData).draw(false);
                } else {
                    // Revert the checkbox state if update failed
                    checkbox.prop('checked', !checkbox.is(':checked'));
                    statusLabel.text(checkbox.is(':checked') ? 'Active' : 'Inactive');
                    alert('Failed to update status');
                }
            },
            error: function(xhr, status, error) {
                $('#loader').hide();
                console.error('Error updating status:', error);
                // Revert the checkbox state on error
                checkbox.prop('checked', !checkbox.is(':checked'));
                statusLabel.text(checkbox.is(':checked') ? 'Active' : 'Inactive');
                alert('Error updating status');
            }
        });
    });

    // Featured toggle functionality
    $(document).on('change', '.featured-toggle', function() {
        var checkbox = $(this);
        var featuredLabel = checkbox.next('label');
        var productId = checkbox.data('featured-id');
        var newFeatured = checkbox.is(':checked') ? 1 : 0;
        var newFeaturedText = newFeatured ? 'Featured' : 'Unfeatured';
        featuredLabel.text(newFeaturedText);
        $('#loader').show();
        
        let data = {
            product_id: productId,
            featured: newFeatured
        };
        
        $.ajax({
            url: '<?php echo $ajaxProductfeatured; ?>',
            method: 'POST',
            data: data,
            success: function(response) {
                $('#loader').hide();
                if (response.success) {
                    // Update the DataTable row data
                    var row = $('#sharp-table').DataTable().row(checkbox.closest('tr'));
                    var rowData = row.data();
                    rowData[5] = '<div class="custom-control custom-switch"><input type="checkbox" class="custom-control-input featured-toggle" id="featuredToggle' + productId + '" ' + (newFeatured ? 'checked' : '') + ' data-featured-id="' + productId + '"> <label class="custom-control-label" for="featuredToggle' + productId + '">' + newFeaturedText + '</label> </div>';
                    row.data(rowData).draw(false);
                } else {
                    // Revert the checkbox state if update failed
                    checkbox.prop('checked', !checkbox.is(':checked'));
                    featuredLabel.text(checkbox.is(':checked') ? 'Featured' : 'Unfeatured');
                    alert('Failed to update featured status');
                }
            },
            error: function(xhr, status, error) {
                $('#loader').hide();
                console.error('Error updating featured status:', error);
                // Revert the checkbox state on error
                checkbox.prop('checked', !checkbox.is(':checked'));
                featuredLabel.text(checkbox.is(':checked') ? 'Featured' : 'Unfeatured');
                alert('Error updating featured status');
            }
        });
    });
</script>
<?php echo $footer; ?>
