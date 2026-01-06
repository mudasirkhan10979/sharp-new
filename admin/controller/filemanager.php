<?php
class ControllerFilemanager extends Controller
{
    public function index()
    {


        if (isset($this->request->get['filter_name'])) {
            $filter_name = rtrim(str_replace('*', '', $this->request->get['filter_name']), '/');
        } else {
            $filter_name = '';
        }

        // Make sure we have the correct directory
        if (isset($this->request->get['directory'])) {
            $directory = rtrim(DIR_IMAGE . 'catalog/' . str_replace('*', '', $this->request->get['directory']), '/');
        } else {
            $directory = DIR_IMAGE . 'catalog';
        }

        if (isset($this->request->get['page'])) {
            $page = (int)$this->request->get['page'];
        } else {
            $page = 1;
        }

        $data['images'] = array();

        $this->load_model('tool/image');

        // Get the list of files and directories
        $files = glob($directory . '/' . $filter_name . '*');

        if ($files) {
            // Sort files and directories
            natcasesort($files);

            foreach ($files as $file) {
                if (is_file($file)) {
                    $name = basename($file);

                    $data['images'][] = array(
                        'thumb' => $this->model_tool_image->resize('catalog/' . $name, 100, 100),
                        'name'  => $name,
                        'type'  => 'image',
                        'path'  => 'catalog/' . $name,
                        'href'  => HTTP_CATALOG . 'uploads/image/catalog/' . $name
                    );
                }
            }
        }


        $data['heading_title']    = 'Image Manager';

        $data['token'] = $this->request->get['token'];
        $this->data = $data;
        $this->template = 'filemanger/filemanager.tpl';
        $this->zones = array(
            'header',
            'footer'
        );

        $this->response->setOutput($this->render());
    }

    public function upload()
    {
        $json = array();
        $file_directory = '';
        if (isset($this->request->get['directory'])) {
            $directory = rtrim(DIR_IMAGE . 'catalog/' . str_replace('*', '', $this->request->get['directory']), '/');
            $file_directory = HTTP_CATALOG . 'uploads/image/catalog/' . trim($this->request->get['directory'] . '/');
        } else {
            $directory = DIR_IMAGE . 'catalog';
            $file_directory = HTTP_CATALOG . 'uploads/image/catalog/';
        }

        if (!is_dir($directory)) {
            if (mkdir($directory, 0755, true)) {
            } else {
                $json['error'] = "Failed to create directory: $directory";
            }
        } elseif (!is_writable($directory)) {
            if (chmod($directory, 0755)) {
            } else {
                $json['error'] = "Failed to make the directory writable: $directory";
            }
        }

        if (!$json) {
            if (!empty($_FILES['upload']['name']) && is_file($_FILES['upload']['tmp_name'])) {
                $filename = basename(html_entity_decode($_FILES['upload']['name'], ENT_QUOTES, 'UTF-8'));

                if ((utf8_strlen($filename) < 3) || (utf8_strlen($filename) > 255)) {
                    $json['error'] = 'Warning: Invalid file name.';
                }

                $allowed_extensions = array('jpg', 'jpeg', 'gif', 'png', 'webp');
                if (!in_array(utf8_strtolower(utf8_substr(strrchr($filename, '.'), 1)), $allowed_extensions)) {
                    $json['error'] = 'Warning: Allowed file types are: ' . implode(', ', $allowed_extensions);
                }

                $allowed_types = array(
                    'image/jpeg',
                    'image/pjpeg',
                    'image/png',
                    'image/x-png',
                    'image/gif',
                    'image/jpg',
                    'image/webp'
                );
                if (!in_array($_FILES['upload']['type'], $allowed_types)) {
                    $json['error'] = 'Warning: Allowed file types are: ' . implode(', ', $allowed_types);
                }

                if ($_FILES['upload']['error'] != UPLOAD_ERR_OK) {
                    $json['error'] = 'Warning: File could not be uploaded for an unknown reason! ' . $_FILES['upload']['error'];
                }

                // Check file size (2 MB limit)
                $max_file_size = 2 * 1024 * 1024; // 2 MB in bytes
                if ($_FILES['upload']['size'] > $max_file_size) {
                    $json['error'] = 'Warning: File size must not exceed 2 MB.';
                }
            } else {
                $json['error'] = 'Warning: No file was uploaded!';
            }
        }

        if (!$json) {
            move_uploaded_file($_FILES['upload']['tmp_name'], $directory . '/' . $filename);

            $json['success'] = 'Success: ' . $filename . ' has been uploaded!';
            $json['url'] = $file_directory . $filename;
        }

        $data['heading_title'] = 'Image Manager';

        $this->response->addHeader('Content-Type: application/json');
        $this->response->setOutput(json_encode($json));
    }
}
