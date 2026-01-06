<?php echo $header; ?>
<div class="main-panel">
    <div class="sec-head">
        <div class="sec-head-title">
            <h3><?php echo $text_form; ?></h3>
        </div>
        <div class="sec-head-btns">
            <button type="submit" form="form-customer" data-toggle="tooltip" title="<?php echo $button_save; ?>" class="btn btn-primary"><i class="fa fa-save"></i></button>
            <a href="<?php echo $cancel; ?>" data-toggle="tooltip" title="<?php echo $button_cancel; ?>" class="btn btn-primary"><i class="fa fa-reply"></i></a>
        </div>
    </div>
    <div class="main-employee-box">
        <div class="row">
            <div class="col-lg-12 col-md-12">
                <?php if ($error_warning) { ?>
                    <div class="alert alert-danger"><i class="fa fa-exclamation-circle"></i>
                        <?php echo $error_warning; ?>
                        <button type="button" class="close" data-dismiss="alert">&times;</button>
                    </div>
                <?php $_SESSION['error_warning'] = null;
                } ?>
                <?php if ($this->session->data['success']) { ?>
                    <div class="alert alert-success"><i class="fa fa-check-circle"></i>
                        <?php echo $this->session->data['success']; ?>
                        <button type="button" class="close" data-dismiss="alert">&times;</button>
                    </div>
                <?php $this->session->data['success'] = null;
                }  ?>
                <?php $css = 'style="border-color: red;"'; ?>
                <?php $css1 = 'style="outline: 1px solid rgb(255 0 0 / 100%);"'; ?>
                <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form-user" class="form-horizontal">
                    <div class="col-lg-6 col-md-6">
                        <div class="form-group required">
                            <label class="control-label" for="input-theme">
                                Theme
                            </label>
                            <select name="theme" id="input-theme" class="form-control">
                                <option value="">Select Theme</option>
                                <?php foreach ($themes as $key => $value) {  ?>
                                    <option value="<?php echo $key; ?>" <?php echo ($key == $theme) ? 'selected' : ''; ?>><?php echo $value; ?></option>
                                <?php } ?>
                            </select>
                            <?php if (isset($error_theme)) { ?>
                                <div class="text-danger">
                                    <?php echo $error_theme; ?>
                                </div>
                            <?php } ?>
                        </div>
                    </div>
                    <ul class="nav nav-tabs">
                        <li class="active"><a href="#tab-general" data-toggle="tab">General</a></li>
                        <li><a href="#tab-data" data-toggle="tab">Data</a></li>
                    </ul>
                    <div class="tab-content">
                        <div class="tab-pane active" id="tab-general">
                            <ul class="nav nav-tabs" id="language">
                                <?php foreach ($languages as $lang) { ?>
                                    <li><a href="#language<?php echo $lang['language_id'] ?>" data-toggle="tab"><img src="/vars/lang/be/<?php echo $lang['code']; ?>-<?php echo $lang['image']; ?>" />
                                            <?php echo $lang['name'] ?></a></li>
                                <?php } ?>
                            </ul>
                            <div class="tab-content">
                                <?php foreach ($languages as $lang) { ?>
                                    <div class="tab-pane" id="language<?php echo $lang['language_id'] ?>">
                                        <div class="col-lg-6 col-md-6">
                                            <div class="form-group required">
                                                <label class="control-label" for="input-name<?php echo $lang['language_id'] ?>">
                                                    Title
                                                </label>
                                                <input type="text" name="pages_description[<?php echo $lang['language_id'] ?>][name]" value="<?php echo isset($pages_description[$lang['language_id']]) ? $pages_description[$lang['language_id']]['name'] : ''; ?>" placeholder="Title" id="input-name<?php echo $lang['language_id'] ?>" class="form-control" />
                                                <?php if (isset($error_pagestitle[$lang['language_id']])) { ?>
                                                    <div class="text-danger">
                                                        <?php echo $error_pagestitle[$lang['language_id']]; ?>
                                                    </div>
                                                <?php } ?>
                                            </div>
                                        </div>
                                        <div class="col-lg-6 col-md-6" id="short_description-div<?php echo $lang['language_id'] ?>">
                                            <div class="form-group required">
                                                <label class="control-label" for="input-short_description<?php echo $lang['language_id'] ?>">
                                                    Short Description
                                                </label>
                                                <textarea name="pages_description[<?php echo $lang['language_id'] ?>][short_description]" rows="5" placeholder="Short Description" id="input-short_description<?php echo $lang['language_id'] ?>" class="form-control"><?php echo isset($pages_description[$lang['language_id']]) ? $pages_description[$lang['language_id']]['short_description'] : ''; ?></textarea>
                                                <?php if (isset($error_pagesdesc[$lang['language_id']])) { ?>
                                                    <div class="text-danger">
                                                        <?php echo $error_pagesdesc[$lang['language_id']]; ?>
                                                    </div>
                                                <?php } ?>
                                            </div>
                                        </div>
                                        <div class="col-lg-6 col-md-6" id="texteditor-<?php echo $lang['language_id'] ?>">
                                            <div class="form-group">
                                                <label class="control-label" for="input-pages_description<?php echo $lang['language_id'] ?>">
                                                    Description
                                                </label>
                                                <textarea name="pages_description[<?php echo $lang['language_id'] ?>][description]" placeholder="Description" id="input-description<?php echo $lang['language_id'] ?>" class="form-control"> <?php echo isset($pages_description[$lang['language_id']]) ?
                                                                                                                                                                                                                                                    $pages_description[$lang['language_id']]['description'] : ''; ?></textarea>
                                            </div>
                                        </div>
                                        <div class="col-lg-6 col-md-6">
                                            <div class="form-group">
                                                <label class="control-label" for="input-name<?php echo $lang['language_id'] ?>">
                                                    Meta Title
                                                </label>
                                                <input type="text" name="pages_description[<?php echo $lang['language_id'] ?>][meta_title]" value="<?php echo isset($pages_description[$lang['language_id']]) ? $pages_description[$lang['language_id']]['meta_title'] : ''; ?>" placeholder="Meta Title" id="input-meta_title<?php echo $lang['language_id'] ?>" class="form-control" />
                                            </div>
                                        </div>

                                        <div class="col-lg-6 col-md-6">
                                            <div class="form-group">
                                                <label class="control-label" for="input-meta_description<?php echo $lang['language_id'] ?>">
                                                    Meta Description
                                                </label>
                                                <input type="text" name="pages_description[<?php echo $lang['language_id'] ?>][meta_description]" value="<?php echo isset($pages_description[$lang['language_id']]) ? $pages_description[$lang['language_id']]['meta_description'] : ''; ?>" placeholder="Meta Description" id="input-meta_description<?php echo $lang['language_id'] ?>" class="form-control" />
                                            </div>
                                        </div>

                                        <div class="col-lg-6 col-md-6">
                                            <div class="form-group">
                                                <label class="control-label" for="input-name<?php echo $lang['language_id'] ?>">
                                                    Meta Keyword
                                                </label>
                                                <input type="text" name="pages_description[<?php echo $lang['language_id'] ?>][meta_keyword]" value="<?php echo isset($pages_description[$lang['language_id']]) ? $pages_description[$lang['language_id']]['meta_keyword'] : ''; ?>" placeholder="Meta Keyword" id="input-name<?php echo $lang['language_id'] ?>" class="form-control" />
                                            </div>
                                        </div>

                                    </div>
                                <?php } ?>
                            </div>
                        </div>
                        <div class="tab-pane" id="tab-data">

                            <div class="col-lg-6 col-md-6">
                                <div class="form-group">
                                    <label class="control-label" for="input-seo_url">
                                        Seo Url
                                    </label>
                                    <input type="text" name="seo_url" value="<?php echo $seo_url; ?>" class="form-control" />
                                </div>
                                <?php if (isset($error_seo_url)) { ?>
                                    <div class="text-danger">
                                        <?php echo $error_seo_url; ?>
                                    </div>
                                <?php } ?>
                            </div>
                            <div class="col-lg-6 col-md-6">
                                <div class="form-group">
                                    <label class="control-label" for="input-sort_order">
                                        Sort Order
                                    </label>
                                    <input type="number" pattern="\d+(\.\d+)?" name="sort_order" value="<?php echo $sort_order; ?>" class="form-control" />
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-6">
                                <div class="form-group">
                                    <label class="control-label" for="input-publish">
                                        Status
                                    </label>
                                    <select name="publish" id="input-publish" class="form-control">
                                        <?php if ($publish) { ?>
                                            <option value="1" selected="selected">Active</option>
                                            <option value="0">Inactive</option>
                                        <?php } else { ?>
                                            <option value="1">Active</option>
                                            <option value="0" selected="selected">Inactive</option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>
                            <div class="row col-md-12" id="banner-div">
                                <div class="col-md-6">
                                    <div class="form-group required">
                                        <label class="control-label" for="input-banner_image">Banner (1600 × 730px)</label>
                                        <input onchange="loadFile(event)" type="file" name="banner_image" id="banner_image" accept=".png,.jpg,.jpeg" style="display: block;">
                                    </div>
                                    <?php if ($error_pagesimg) { ?>
                                        <div class="text-danger">
                                            <?php echo $error_pagesimg; ?>
                                        </div>
                                    <?php } ?>
                                </div>
                                <div class="col-lg-2 col-md-2 ">
                                    <?php if ($banner_image) { ?>
                                     <button type="button" class="btn btn-danger btn-sm delete-image-btn"
                                        style="position:absolute; top:0; right:0;"
                                        onclick="deletePageImage('<?= $page_id ?>')">
                                        <i class="fa fa-trash-o"></i>
                                    </button>
                                        <img id="bimage" src="../uploads/image/pages/<?= $banner_image ?>" style="width: 100%; height: 89px;margin-top: 12px;">
                                    <?php } else { ?>
                                        <img id="bimage" src="../uploads/image/no-image.png" style="width: 100%; height: 89px;margin-top: 12px;">
                                    <?php } ?>
                                 <input type="hidden" id="hidden_image" name="hidden_image" value="<?= $banner_image ?>">
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-6 bottom-inline-btns">
                            <button type="submit" form="form-customer" data-toggle="tooltip" title="Save" class="btn btn-success"> <i class="fa fa-save"></i> Submit</button>
                            <a href="<?php echo $cancel; ?>" data-toggle="tooltip" title="Cancel" class="btn btn-danger"><i class="fa fa-reply"></i> Cancel</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    $('#language a:first').tab('show');
</script>
<?php echo $footer; ?>
<!-- 
<script>
    var loadFile = function(event) {
        var file = event.target.files[0];
        var output = document.getElementById('bimage');
        var validExtensions = ['png', 'jpeg', 'jpg'];
        var maxSize = 2 * 1024 * 1024;

        if (file) {
            var extension = file.name.split('.').pop().toLowerCase();
            if (validExtensions.indexOf(extension) === -1 || file.size > maxSize) {
                event.target.value = '';
                alert('Please select a valid file (PNG, JPEG, JPG) less than 2 MB.');
                return false;
            } else {
                output.src = URL.createObjectURL(file);
                output.onload = function() {
                    URL.revokeObjectURL(output.src);
                };
            }
        }
    };

    $(document).ready(function() {
        var themeValue = $('#input-theme').val();
        if (themeValue != 'pages') {
            <?php foreach ($languages as $lang) { ?>
                $('#texteditor-<?php echo $lang['language_id'] ?>').hide();
                $('#short_description-div<?php echo $lang['language_id'] ?>').show();

            <?php } ?>
            $('#banner-div').show();
        } else {
            <?php foreach ($languages as $lang) { ?>

                $('#texteditor-<?php echo $lang['language_id'] ?>').show();

                var lang = 'input-description<?php echo $lang['language_id'] ?>';
                var code = '<?php echo $lang["code"] ?>';
                var textarea = document.getElementById(lang);
                CKEDITOR.replace(textarea, {
                    language: code,
                    basicEntities: false
                });
                $('#short_description-div<?php echo $lang['language_id'] ?>').hide();

            <?php } ?>
            $('#banner-div').hide();
        }

        $('#input-theme').change(function() {
            var triggerValue = $(this).val();
            console.log(triggerValue);
            if (triggerValue != 'pages') {
                <?php foreach ($languages as $lang) { ?>
                    $('#texteditor-<?php echo $lang['language_id'] ?>').hide();
                    $('#short_description-div<?php echo $lang['language_id'] ?>').show();
                <?php } ?>
                $('#banner-div').show();
            } else {
                <?php foreach ($languages as $lang) { ?>

                    $('#texteditor-<?php echo $lang['language_id'] ?>').show();
                    $('#short_description-div<?php echo $lang['language_id'] ?>').hide();
                    var lang = 'input-description<?php echo $lang['language_id'] ?>';
                    var code = '<?php echo $lang["code"] ?>';
                    var textarea = document.getElementById(lang);
                    CKEDITOR.replace(textarea, {
                        language: code,
                        basicEntities: false
                    });

                <?php } ?>
                $('#banner-div').hide();
            }
        });

    });
</script> -->



<script>
    var loadFile = function(event) {
        var file = event.target.files[0];
        var output = document.getElementById('bimage');
        var validExtensions = ['png', 'jpeg', 'jpg'];
        var maxSize = 5 * 1024 * 1024;

        if (file) {
            var extension = file.name.split('.').pop().toLowerCase();
            if (validExtensions.indexOf(extension) === -1 || file.size > maxSize) {
                event.target.value = '';
                alert('Please select a valid file (PNG, JPEG, JPG) less than 5 MB.');
                return false;
            } else {
                output.src = URL.createObjectURL(file);
                output.onload = function() {
                    URL.revokeObjectURL(output.src);
                };
            }
        }
    };
</script>
<script>
    $(document).ready(function() {
        var themeValue = $('#input-theme').val();
        // Add condition for 'generalpages' here
        if (themeValue == 'generalpages') {
            <?php foreach ($languages as $lang) { ?>
                $('#texteditor-<?php echo $lang['language_id'] ?>').show();
                var lang = 'input-description<?php echo $lang['language_id'] ?>';
                var code = '<?php echo $lang["code"] ?>';
                var textarea = document.getElementById(lang);
                if (textarea) {
                    var editor = CKEDITOR.replace(textarea, {
                        language: code,
                        basicEntities: false,
                        extraAllowedContent: 'style',
                        allowedContent: true,
                        filebrowserUploadUrl: '/admin/?controller=filemanager/upload&token=<?php echo $token; ?>&directory=pages',
                        height: 400,
                        fileTools_requestHeaders: {
                            'X-Requested-With': 'XMLHttpRequest'
                        }
                    });
                    editor.on('fileUploadResponse', function(evt) {
                        var fileLoader = evt.data.fileLoader;
                        evt.stop();
                        var xhr = evt.data.fileLoader.xhr;
                        var response = JSON.parse(xhr.responseText);
                        if (response.success) {
                            evt.data.url = response.url;
                        } else {
                            alert('Error: ' + (response.error || 'Unknown error'));
                        }
                    });
                }
                $('#short_description-div<?php echo $lang['language_id'] ?>').show();
            <?php } ?>
            $('#banner-div').show();
        } else if (themeValue != 'pages') {
            <?php foreach ($languages as $lang) { ?>
                $('#texteditor-<?php echo $lang['language_id'] ?>').hide();
                $('#short_description-div<?php echo $lang['language_id'] ?>').show();
            <?php } ?>
            $('#banner-div').show();
        } else {
            <?php foreach ($languages as $lang) { ?>
                $('#texteditor-<?php echo $lang['language_id'] ?>').show();
                var lang = 'input-description<?php echo $lang['language_id'] ?>';
                var code = '<?php echo $lang["code"] ?>';
                var textarea = document.getElementById(lang);
                if (textarea) {
                    var editor = CKEDITOR.replace(textarea, {
                        language: code,
                        basicEntities: false,
                        extraAllowedContent: 'style',
                        allowedContent: true,
                        filebrowserUploadUrl: '/admin/?controller=filemanager/upload&token=<?php echo $token; ?>&directory=pages',
                        height: 400,
                        fileTools_requestHeaders: {
                            'X-Requested-With': 'XMLHttpRequest'
                        }
                    });
                    editor.on('fileUploadResponse', function(evt) {
                        var fileLoader = evt.data.fileLoader;
                        evt.stop();
                        var xhr = evt.data.fileLoader.xhr;
                        var response = JSON.parse(xhr.responseText);
                        if (response.success) {
                            evt.data.url = response.url;
                        } else {
                            alert('Error: ' + (response.error || 'Unknown error'));
                        }
                    });
                }

                $('#short_description-div<?php echo $lang['language_id'] ?>').hide();
            <?php } ?>
            $('#banner-div').hide();
        }
        // Add condition for 'generalpages' here as well
        $('#input-theme').change(function() {
            var triggerValue = $(this).val();
            if (triggerValue == 'generalpages') {
                <?php foreach ($languages as $lang) { ?>
                    $('#texteditor-<?php echo $lang['language_id'] ?>').show();
                    var lang = 'input-description<?php echo $lang['language_id'] ?>';
                    var code = '<?php echo $lang["code"] ?>';
                    var textarea = document.getElementById(lang);
                    if (textarea) {
                        var editor = CKEDITOR.replace(textarea, {
                            language: code,
                            basicEntities: false,
                            extraAllowedContent: 'style',
                            allowedContent: true,
                            filebrowserUploadUrl: '/admin/?controller=filemanager/upload&token=<?php echo $token; ?>&directory=pages',
                            height: 400,
                            fileTools_requestHeaders: {
                                'X-Requested-With': 'XMLHttpRequest'
                            }
                        });
                        editor.on('fileUploadResponse', function(evt) {
                            var fileLoader = evt.data.fileLoader;
                            evt.stop();
                            var xhr = evt.data.fileLoader.xhr;
                            var response = JSON.parse(xhr.responseText);
                            if (response.success) {
                                evt.data.url = response.url;
                            } else {
                                alert('Error: ' + (response.error || 'Unknown error'));
                            }
                        });
                    }

                    $('#short_description-div<?php echo $lang['language_id'] ?>').show();
                <?php } ?>
                $('#banner-div').show();
            } else if (triggerValue != 'pages') {
                <?php foreach ($languages as $lang) { ?>
                    $('#texteditor-<?php echo $lang['language_id'] ?>').hide();
                    $('#short_description-div<?php echo $lang['language_id'] ?>').show();
                <?php } ?>
                $('#banner-div').show();
            } else {
                <?php foreach ($languages as $lang) { ?>
                    $('#texteditor-<?php echo $lang['language_id'] ?>').show();
                    var lang = 'input-description<?php echo $lang['language_id'] ?>';
                    var code = '<?php echo $lang["code"] ?>';
                    var textarea = document.getElementById(lang);
                    if (textarea) {
                        var editor = CKEDITOR.replace(textarea, {
                            language: code,
                            basicEntities: false,
                            extraAllowedContent: 'style',
                            allowedContent: true,
                            filebrowserUploadUrl: '/admin/?controller=filemanager/upload&token=<?php echo $token; ?>&directory=pages',
                            height: 400,
                            fileTools_requestHeaders: {
                                'X-Requested-With': 'XMLHttpRequest'
                            }
                        });
                        editor.on('fileUploadResponse', function(evt) {
                            var fileLoader = evt.data.fileLoader;
                            evt.stop();
                            var xhr = evt.data.fileLoader.xhr;
                            var response = JSON.parse(xhr.responseText);
                            if (response.success) {
                                evt.data.url = response.url;
                            } else {
                                alert('Error: ' + (response.error || 'Unknown error'));
                            }
                        });
                    }
                    $('#short_description-div<?php echo $lang['language_id'] ?>').hide();
                <?php } ?>
                $('#banner-div').hide();
            }
        });
    });
</script>

<script>
function deletePageImage(page_id) {
    if (confirm('Are you sure you want to delete this image?')) {
        fetch('<?php echo $deleteImage; ?>&page_id=' + page_id)
        .then(res => res.json())
        .then(data => {
            if (data.success) {
                const img = document.getElementById('bimage');
                img.src = '../uploads/no_image.png?' + new Date().getTime(); // prevent cache
                document.getElementById('hidden_image').value = '';
                const btn = document.querySelector('.delete-image-btn');
                if (btn) btn.style.display = 'none';
                // alert('Image deleted successfully.');
            } else {
                alert(data.error || 'Error deleting image.');
            }
        })
        .catch(err => {
            console.error('Error deleting Page image:', err);
            alert('Something went wrong while deleting the image.');
        });
    }
}
</script>