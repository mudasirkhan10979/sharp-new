<?php echo $header; ?>
<div class="main-panel">
    <div class="sec-head">
        <div class="sec-head-title">
            <h3>News & Events</h3>
        </div>
        <div class="sec-head-btns">
            <a href="<?php echo $add; ?>" class="btn bts89067 btn890-890-890 opt"> + Add News & Events </a>
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
                            <table class="table table-striped table-bordered table-hover" id="events-table" width="100%" cellspacing="0" cellpadding="0" border="0">
                                <thead>
                                    <tr>
                                        <th class="text-left">Title</th>
                                        <th class="text-left">Sort Order</th>
                                        <th class="text-left">Publish</th>
                                        <th class="text-right">Action</th>
                                    </tr>
                                    <tr class="stdfilters">
                                        <th><input type="text" placeholder="Title"></th>
                                        <th><input type="text" placeholder="Sort Order"></th>
                                       <th id="drop-searc"></th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if ($news_events) { 
                                        ?>
                                        <?php foreach ($news_events as $news_event) { ?>
                                            <tr class="stdfilters">
                                                <td class="text-left">
                                                    <?php echo $news_event['title']; ?>
                                                </td>
                                                <td class="text-left">
                                                    <?php echo $news_event['sort_order']; ?>
                                                </td>

                                                <td class="text-left">
                                                    <div class="custom-control custom-switch">
                                                        <input type="checkbox" class="custom-control-input status-toggle"
                                                            id="statusToggle<?php echo $news_event['news_event_id']; ?>"
                                                            <?php echo ($news_event['publish']) ? 'checked' : ''; ?>
                                                            data-status-id="<?php echo $news_event['news_event_id']; ?>">
                                                        <label class="custom-control-label"
                                                            for="statusToggle<?php echo $news_event['news_event_id']; ?>">
                                                            <?php echo ($news_event['publish']) ? 'Publish' : 'Unpublish'; ?>
                                                        </label>
                                                    </div>
                                                </td>
                                                <td class="text-right">
                                                    <a style="display: inline-block;" href="<?php echo $news_event['edit']; ?>" data-toggle="tooltip" title="<?php echo $button_edit; ?>" class="btn btn-primary"><i class="fa fa-pencil"></i></a>
                                                    <form style="display: inline-block;" action="<?php echo $news_event['delete']; ?>" method="post" enctype="multipart/form-data" id="del_news_events<?php echo $news_events['news_event_id']; ?>">
                                                        <input type="hidden" name="news_event_id" value="<?php echo $news_event['news_event_id']; ?>">
                                                        <button type="button" data-toggle="tooltip" title="<?php echo $news_event; ?>" class="btn btn-danger" onClick='submitDeleteForm("del_news_events<?php echo $news_events['news_event_id']; ?>")'><i class="fa fa-trash-o"></i></button>
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
// $('#events-table thead tr').clone(true).addClass('stdfilters').appendTo('#events-table thead');
var table = $('#events-table').DataTable({
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
    { "orderable": false, "targets": [3] } // Disable sorting for the 3rd column (Actions)
    ],
    initComplete: function() {
        var api = this.api();
        var i = 1;
        api.columns().eq(0).each(function(colIdx) {
            var column = this;

            if (i == 3) {
                var select = $('<select><option value="">Choose</option><option value=" Publish ">Publish</option><option value="Unpublish">Unpublish</option></select>')
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

                        // Using a timeout to ensure the DataTable's redraw happens after the cursor position is saved
                        setTimeout(() => {
                            api.column(colIdx)
                                .search((this.value != "") ? regexr.replace('{search}', '(((' + this.value + ')))') : "", this.value != "", this.value == "")
                                .draw();

                            // Restore the focus and cursor position
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
        var mediaId = checkbox.data('status-id');
        var newStatus = checkbox.is(':checked') ? 1 : 0;
        var newStatusText = newStatus ? 'Publish' : 'Unpublish';
        statusLabel.text(newStatusText);
        $('#loader').show();
        let data = {
            news_event_id: mediaId,
            publish: newStatus
        };
        $.ajax({
            url: '<?php echo $ajaxnewseventsstatus; ?>',
            method: 'POST',
            data,
            success: function(response) {
                $('#loader').hide();
                if (response.success) {
                    var row = $('#events-table').DataTable().row(checkbox.closest('tr'));
                    var rowData = row.data();
                    rowData[2] =
                        '<div class="custom-control custom-switch"><input type="checkbox" class="custom-control-input status-toggle" id="statusToggle' +
                        mediaId + '" ' + (newStatus ? 'checked' : '') + ' data-status-id="' +
                        mediaId + '"> <label class="custom-control-label" for="statusToggle' +
                        mediaId + '">' + newStatusText + '</label> </div>';
                    row.data(rowData).draw(false);
                } else {
                    checkbox.prop('checked', !checkbox.is(':checked'));
                    statusLabel.text(checkbox.is(':checked') ? 'Publish' : 'Unpublish');
                }
            },
            error: function(xhr, status, error) {
                $('#loader').hide();
                console.error('Error updating status:', error);
                checkbox.prop('checked', !checkbox.is(':checked'));
                statusLabel.text(checkbox.is(':checked') ? 'Publish' : 'Unpublish');
            }
        });
    });
</script>

<?php echo $footer; ?>