<?php echo $header; ?>
<div class="main-panel">
    <div class="sec-head">
        <div class="sec-head-title">
            <h3><?php echo $text_form; ?></h3>
        </div>
        <div class="sec-head-btns">
            <button type="submit" form="form-customer" data-toggle="tooltip" title="<?php echo $button_save; ?>"
                class="btn btn-primary"><i class="fa fa-save"></i></button>
            <a href="<?php echo $cancel; ?>" data-toggle="tooltip" title="<?php echo $button_cancel; ?>"
                class="btn btn-primary"><i class="fa fa-reply"></i></a>
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
                <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form-user"
                    class="form-horizontal">
                    <ul class="nav nav-tabs">
                        <li class="active"><a href="#tab-general" data-toggle="tab">General</a></li>
                        <li><a href="#tab-data" data-toggle="tab">Data</a></li>
                    </ul>
                    <div class="tab-content">
                        <div class="tab-pane active" id="tab-general">
                            <ul class="nav nav-tabs" id="language">
                                <?php foreach ($languages as $lang) { ?>
                                <li><a href="#language<?php echo $lang['language_id'] ?>" data-toggle="tab"><img
                                            src="/vars/lang/be/<?php echo $lang['code']; ?>-<?php echo $lang['image']; ?>" />
                                        <?php echo $lang['name'] ?></a></li>
                                <?php } ?>
                            </ul>
                            <div class="tab-content">
                                <?php foreach ($languages as $lang) { ?>
                                <div class="tab-pane" id="language<?php echo $lang['language_id'] ?>">
                                    <div class="col-lg-6 col-md-6">
                                        <div class="form-group required">
                                            <label class="control-label"
                                                for="input-title<?php echo $lang['language_id'] ?>">
                                                Title
                                            </label>
                                            <input type="text"
                                                name="slider_description[<?php echo $lang['language_id'] ?>][title]"
                                                value="<?php echo isset($slider_description[$lang['language_id']]) ? $slider_description[$lang['language_id']]['title'] : ''; ?>"
                                                placeholder="Title"
                                                id="input-meta_title<?php echo $lang['language_id'] ?>"
                                                class="form-control" />
                                            <?php if (isset($error_title[$lang['language_id']])) { ?>
                                            <div class="text-danger">
                                                <?php echo $error_title[$lang['language_id']]; ?>
                                            </div>
                                            <?php } ?>
                                        </div>
                                    </div>

                                    <div class="col-lg-6 col-md-6">
                                        <div class="form-group required">
                                            <label class="control-label"
                                                for="input-title<?php echo $lang['language_id'] ?>">
                                                Second Title
                                            </label>
                                            <input type="text"
                                                name="slider_description[<?php echo $lang['language_id'] ?>][second_title]"
                                                value="<?php echo isset($slider_description[$lang['language_id']]) ? $slider_description[$lang['language_id']]['second_title'] : ''; ?>"
                                                placeholder="Second Title"
                                                id="input-second_title<?php echo $lang['language_id'] ?>"
                                                class="form-control" />
                                            <?php if (isset($error_second_title[$lang['language_id']])) { ?>
                                            <div class="text-danger">
                                                <?php echo $error_second_title[$lang['language_id']]; ?>
                                            </div>
                                            <?php } ?>
                                        </div>
                                    </div>
                                 
                                     <div class="col-lg-6 col-md-6">
                                        <div class="form-group required">
                                            <label class="control-label"
                                                for="input-description<?php echo $lang['language_id'] ?>">
                                                Description
                                            </label>
                                            <textarea
                                                name="slider_description[<?php echo $lang['language_id'] ?>][short_description]"
                                                rows="5" placeholder="Description"
                                                id="input-description<?php echo $lang['language_id'] ?>"
                                                class="form-control"><?php echo isset($slider_description[$lang['language_id']]) ? $slider_description[$lang['language_id']]['short_description'] : ''; ?></textarea>
                                            <?php if (isset($error_short_description[$lang['language_id']])) { ?>
                                            <div class="text-danger">
                                                <?php echo $error_short_description[$lang['language_id']]; ?>
                                            </div>
                                            <?php } ?>
                                        </div>
                                    </div> 
                                </div>
                                <?php } ?>
                            </div>
                        </div>
                        <div class="tab-pane" id="tab-data">

                         <div class="col-lg-6 col-md-6">
                            <div class="form-group required">
                                <label class="control-label" for="input-type">Content Type</label><br>
                                <label>
                                    <input type="radio" name="content_type" value="video" id="type-video" onchange="toggleContentType();" 
                                        <?php echo ($content_type === 'video') ? 'checked' : ''; ?>> Video
                                </label>
                                <label>
                                    <input type="radio" name="content_type" value="image" id="type-image" onchange="toggleContentType();" 
                                        <?php echo ($content_type === 'image') ? 'checked' : ''; ?>> Image
                                </label>
                            </div>
                            <?php if ($error_content_type) { ?>
                                <div class="text-danger">
                                    <?php echo $error_content_type; ?>
                                </div>
                            <?php } ?>
                        </div>

                    <div id="video-section" style="display: <?php echo ($content_type === 'video') ? 'block' : 'none'; ?>;">
                        <div class="col-lg-4 col-md-4">
                            <div class="form-group required">
                                <!-- <label class="control-label" for="input-video_url">Video URL</label> -->
                                <textarea name="video_url" placeholder="Video URL" id="input-video_url"
                                    class="form-control"><?php echo $video_url; ?></textarea>
                                <?php if ($error_video_url) { ?>
                                    <div class="text-danger">
                                        <?php echo $error_video_url; ?>
                                    </div>
                                <?php } ?>
                            </div>
                        </div>
                        <?php
                    if (!empty($video_url) && preg_match('/^(https?\:\/\/)?(www\.youtube\.com|youtu\.?be|vimeo\.com)\/.+$/', $video_url)) {
                        $embed_url = '';
                        if (strpos($video_url, 'youtube.com') !== false || strpos($video_url, 'youtu.be') !== false) {
                            // For YouTube URLs
                            parse_str(parse_url($video_url, PHP_URL_QUERY), $query_params);
                            if (!empty($query_params['v'])) {
                                $video_id = $query_params['v'];
                                $embed_url = "https://www.youtube.com/embed/$video_id";
                            } elseif (preg_match('/youtu\.be\/(.+)$/', $video_url, $matches)) {
                                $embed_url = "https://www.youtube.com/embed/" . $matches[1];
                            }
                        } elseif (strpos($video_url, 'vimeo.com') !== false) {
                            // For Vimeo URLs
                            if (preg_match('/vimeo\.com\/(\d+)/', $video_url, $matches)) {
                                $video_id = $matches[1];
                                $embed_url = "https://player.vimeo.com/video/$video_id";
                            }
                        }
                        ?>
                        <?php if (!empty($embed_url)) { ?>
                        <div class="col-lg-2 col-md-2">
                            <iframe id="trailer-iframe" src="<?php echo htmlspecialchars($embed_url); ?>" allowfullscreen
                                style="width: 100%; height: 100px; border: none;"></iframe>
                        </div>
                        <?php } ?>
                    <?php } ?>
                    </div>
                    <div id="image-section" style="display: <?php echo ($content_type === 'image') ? 'block' : 'none'; ?>;">
                        <div class="col-lg-4 col-md-4">
                            <div class="form-group required">
                                <label class="control-label" for="input-image">Slider Image (1600 x 830px)</label>
                                <input onchange="loadFile(event)" type="file" name="image" id="image"
                                    accept=".png,.jpg,.jpeg" style="display: block;">
                                <?php if ($error_image) { ?>
                                <div class="text-danger">
                                    <?php echo $error_image; ?>
                                </div>
                                <?php } ?>
                            </div>
                        </div>
<div class="col-lg-2 col-md-2" style="position: relative;">
    <img id="cimage" 
         src="../uploads/image/sliders/<?= $image ?: 'no_image.png' ?>" 
         style="width:100%; height:89px; margin-top:12px;">
    
    <!-- Existing image delete button -->
    <?php if (!empty($image)) { ?>
        <button type="button" class="btn btn-danger btn-sm delete-image-btn existing-delete"
            style="position:absolute; top:0; right:0;"
            onclick="deleteSliderImage('<?= $slider_id ?>')">
            <i class="fa fa-trash-o"></i>
        </button>
    <?php } ?>

    <!-- Preview delete button (hidden by default) -->
    <button type="button" class="btn btn-danger btn-sm delete-image-btn preview-delete"
        style="position:absolute; top:0; right:0; display:none;"
        onclick="deletePreviewImage()">
        <i class="fa fa-trash-o"></i>
    </button>

    <input type="hidden" id="hidden_image" name="hidden_image" value="<?= $image ?>">
</div>


                        </div>
                            <div class="col-lg-6 col-md-6">
                                <div class="form-group required">
                                    <label class="control-label" for="input-url">
                                        URL
                                    </label>
                                    <input type="text" name="url" value="<?php echo isset($url) ? $url : ''; ?>"
                                        class="form-control" placeholder="Enter URL" />
                                               <?php if ($error_url) { ?>
                                        <div class="text-danger">
                                            <?php echo $error_url; ?>
                                        </div>
                                        <?php } ?>
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-6">
                                <div class="form-group">
                                    <label class="control-label" for="input-sort_order">
                                        Sort Order
                                    </label>
                                    <input type="number" name="sort_order" value="<?php echo $sort_order; ?>"
                                        class="form-control" />
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-6">
                                <div class="form-group">
                                    <label class="control-label" for="input-status">
                                        Status
                                    </label>
                                    <select name="status" id="input-status" class="form-control">
                                        <?php if ($status) { ?>
                                        <option value="1" selected="selected">Active</option>
                                        <option value="0">Inactive</option>
                                        <?php } else { ?>
                                        <option value="1">Active</option>
                                        <option value="0" selected="selected">Inactive</option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-6 bottom-inline-btns">
                            <button type="submit" form="form-customer" data-toggle="tooltip" title="Save"
                                class="btn btn-success"> <i class="fa fa-save"></i> Submit</button>
                            <a href="<?php echo $cancel; ?>" data-toggle="tooltip" title="Cancel"
                                class="btn btn-danger"><i class="fa fa-reply"></i> Cancel</a>
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

<script>
function toggleContentType() {
    const videoSection = document.getElementById('video-section');
    const imageSection = document.getElementById('image-section');
    const isVideoSelected = document.getElementById('type-video').checked;

    if (isVideoSelected) {
        videoSection.style.display = 'block';
        imageSection.style.display = 'none';
    } else {
        videoSection.style.display = 'none';
        imageSection.style.display = 'block';
    }
}
</script>
<script type="text/javascript">
    $(document).ready(function() {
        <?php foreach ($languages as $lang) { ?>
            var lang = 'input-description<?php echo $lang['language_id']; ?>';
            var code = '<?php echo $lang["code"]; ?>';
            var textarea = document.getElementById(lang);
            if (textarea) { // Check if the textarea element exists
                CKEDITOR.replace(textarea, {
                    language: code,
                    basicEntities: false,
                });
            } else {
                console.error('Textarea with id ' + lang + ' not found.');
            }
        <?php } ?>
    });
</script>

<script>
var loadFile = function(event) {
    var output = document.getElementById('cimage');
    var file = event.target.files[0];
    var validExtensions = ['png', 'jpeg', 'jpg'];
    var maxSize = 2 * 1024 * 1024;
    var existingDeleteBtn = document.querySelector('.existing-delete');
    var previewDeleteBtn = document.querySelector('.preview-delete');
    var hiddenInput = document.getElementById('hidden_image');

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
            if (existingDeleteBtn) existingDeleteBtn.style.display = 'none';
            if (previewDeleteBtn) previewDeleteBtn.style.display = 'block';
            hiddenInput.value = '';
        }
    }
};

function deletePreviewImage() {
    const img = document.getElementById('cimage');
    const fileInput = document.getElementById('image');
    const hiddenInput = document.getElementById('hidden_image');
    const previewDeleteBtn = document.querySelector('.preview-delete');
    img.src = '../uploads/image/no-image.png';
    fileInput.value = '';
    hiddenInput.value = '';
    if (previewDeleteBtn) previewDeleteBtn.style.display = 'none';
}
</script>

<script>
function deleteSliderImage(slider_id) {
    if (confirm('Are you sure you want to delete this image?')) {
        fetch('<?php echo $deleteImage; ?>&slider_id=' + slider_id)
        .then(res => res.json())
        .then(data => {
            if (data.success) {
                const img = document.getElementById('cimage');
                img.src = '../uploads/image/no-image.png?' + new Date().getTime(); // prevent cache
                document.getElementById('hidden_image').value = '';
                const btn = document.querySelector('.delete-image-btn');
                if (btn) btn.style.display = 'none';
                // alert('Image deleted successfully.');
            } else {
                alert(data.error || 'Error deleting image.');
            }
        })
        .catch(err => {
            console.error('Error deleting slider image:', err);
            alert('Something went wrong while deleting the image.');
        });
    }
}
</script>

