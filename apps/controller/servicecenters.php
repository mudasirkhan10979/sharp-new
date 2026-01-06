<?php
class ControllerServiceCenters extends Controller
{
    private $error = array();

    public function __construct($registry)
    {
        parent::__construct($registry);
        $this->registry->set('pcUrls', 'service-centers');
    }

    public function index()
    {
        $data = array();
        $this->load_model('servicecenters');
        $this->load_model('page');

        $page_id = $this->registry->get('slug_data')['slog_id'];
        $page = $this->model_page->getPage($page_id);

        if (empty($page)) {
            $this->redirect(HTTPS_HOST . 'error404');
            exit;
        }

        $short_description = strip_tags(html_entity_decode($page['short_description'], ENT_QUOTES, 'UTF-8'));
        $image = !empty($page['banner_image']) ? BASE_URL . "uploads/image/pages/" . $page['banner_image'] : BASE_URL . "uploads/default_banner.jpg";

        $data['banner'] = [
            'title' => $page['name'],
            'short_description' => $short_description,
            'image' => $image
        ];

        // Meta
        $metaDescription = !empty($page['meta_description']) ? substr(strip_tags(html_entity_decode($page['meta_description'], ENT_QUOTES, 'UTF-8')), 0, 160) : substr($short_description, 0, 160);
        $this->document->setDescription($metaDescription);
        $this->document->setKeywords(!empty($page['meta_keyword']) ? $page['meta_keyword'] : $page['title']);
        $this->document->setTitle(!empty($page['meta_title']) ? $page['meta_title'] : $page['title']);

        $limit = 10;
        $pageNum = isset($this->request->get['page']) ? (int)$this->request->get['page'] : 1;

        // **Read filters from GET for pagination**
        $keyword = isset($this->request->get['keyword']) ? $this->request->get['keyword'] : '';
        $country_id = isset($this->request->get['country_id']) ? (int)$this->request->get['country_id'] : 0;

        $filterData = [
            'start' => ($pageNum - 1) * $limit,
            'limit' => $limit,
            'keyword' => $keyword,
            'country_id' => $country_id
        ];

        $servicecenters = $this->model_servicecenters->GetServiceCenters($filterData);
        $total = $this->model_servicecenters->getTotalServiceCenters($filterData);

        $pagination = new Pagination();
        $pagination->total = $total;
        $pagination->page = $pageNum;
        $pagination->limit = $limit;
        $pagination->url = HTTP_HOST . 'service-centers?page={page}&keyword=' . urlencode($keyword) . '&country_id=' . $country_id;

        $data['servicecenters'] = $servicecenters;
        $data['pagination'] = ($total > $limit) ? $pagination->render() : '';

        // Language Text
        $texts = ['text_search', 'text_keyword', 'text_no_record', 'text_country', 'text_departments', 'text_service_center_name', 'text_landline', 'text_addresss'];
        foreach ($texts as $text) {
            $data[$text] = $this->language->get($text);
        }

        $this->template = 'sharp/template/service-center.tpl';
        $this->data = $data;
        $this->zones = ['header', 'footer', 'menuinner'];
        $this->response->setOutput($this->render());
    }

    // AJAX Filter
    public function filter()
    {
        $this->load_model('servicecenters');

        $limit = 10;
        $page = isset($this->request->post['page']) ? (int)$this->request->post['page'] : 1;
        $keyword = isset($this->request->post['keyword']) ? $this->request->post['keyword'] : '';
        $country_id = isset($this->request->post['country_id']) ? (int)$this->request->post['country_id'] : 0;

        $filterData = [
            'start' => ($page - 1) * $limit,
            'limit' => $limit,
            'keyword' => $keyword,
            'country_id' => $country_id
        ];

        $servicecenters = $this->model_servicecenters->GetServiceCenters($filterData);
        $total = $this->model_servicecenters->getTotalServiceCenters($filterData);

        $pagination = new Pagination();
        $pagination->total = $total;
        $pagination->page = $page;
        $pagination->limit = $limit;
        $pagination->url = HTTP_HOST . 'servicecenters/filter?page={page}';

        ob_start();
        ?>
        <table class="table table-borderless">
            <thead>
                <tr>
                    <td>SR</td>
                    <td><?php echo $this->language->get('text_country'); ?></td>
                    <td><?php echo $this->language->get('text_departments'); ?></td>
                    <td><?php echo $this->language->get('text_service_center_name'); ?></td>
                    <td><?php echo $this->language->get('text_landline'); ?></td>
                    <td><?php echo $this->language->get('text_addresss'); ?></td>
                </tr>
            </thead>
            <tbody>
                <?php if ($servicecenters): ?>
                    <?php foreach ($servicecenters as $service): ?>
                        <tr>
                            <td><?php echo ($service['sr'] < 10 ? '0' . $service['sr'] : $service['sr']); ?></td>
                            <td><?php echo $service['country_name']; ?></td>
                            <td><?php echo $service['department']; ?></td>
                            <td><?php echo $service['service_center_name']; ?></td>
                            <td><?php echo $service['landline']; ?></td>
                            <td><?php echo html_entity_decode($service['address']); ?></td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr><td colspan="6"><?php echo $this->language->get('text_no_record'); ?></td></tr>
                <?php endif; ?>
            </tbody>
        </table>
        <?php echo ($total > $limit) ? $pagination->render() : ''; ?>
        <?php
        $this->response->setOutput(ob_get_clean());
    }
}
