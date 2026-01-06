<?php
class ControllerCareerEnquiries extends Controller
{
    public function index()
    {
        $this->document->setTitle("Admin - Career Enquiries");
        $this->load_model('careerenquiries'); 
        
        $this->getList();
    }
    public function detail()
    {

        $this->document->setTitle("Admin - Career Enquiries");
        

        $this->getDetail();
    }
    public function delete()
    {
        $data = $this->language->getAll();
        $this->document->setTitle("Admin - Career Enquiries");
        $this->load_model('careerenquiries');
        $this->model_careerenquiries->deleteCareerEnquiry($this->request->post['enquiry_id']);
        $this->session->data['success'] = "Data Deleted Successfully !";
        $this->getList();
    }

    private function getList()
    {
        $url = '';
        $data['careerenquiries'] = array(); 
        $results = $this->model_careerenquiries->getCareerEnquiries();
        
        foreach ($results as $result) {
            $data['careerenquiries'][] = array(
            'enquiry_id'     => $result['enquiry_id'],
            'name'           => $result['name'],
            'title'          => $result['title'],
            'phone'          => $result['phone'],
            'email'          => $result['email'],
            'date_added'     => date('Y-m-d', strtotime($result['date_added'])),
            'detail'         => $this->link('careerenquiries/detail', 'token=' . $this->session->data['token'] . '&enquiry_id=' . $result['enquiry_id'] . $url, 'SSL'),
            'delete'         => $this->link('careerenquiries/delete', 'token=' . $this->session->data['token'] . $url, 'SSL')
        );
        
         }
   
        $data['token'] = $this->session->data['token'];
        $this->data = $data;
        $this->template = 'modules/careerenquiries/list.tpl';
        $this->zones = array(
            'header',
            'columnleft',
            'footer'
        );
        $this->response->setOutput($this->render());
    }
    private function getDetail()
    {
        $data = $this->language->getAll();
        $data['text_form'] = !isset($this->request->get['enquiry_id']) ? 'Career Enquiry Details' : '';

        $url = '';
    
        $data['cancel'] = $this->link('careerenquiries', 'token=' . $this->session->data['token'] . $url, 'SSL');
        $this->load_model('careerenquiries');
        if (isset($this->request->get['enquiry_id'])) {
            $enquiries = $this->model_careerenquiries->getCareerEnquiry($this->request->get['enquiry_id']);
        } else {
            $enquiries = array();
        }
        $data['enquiry_detail'] =  $enquiries;
        $this->data = $data;
        $this->template = 'modules/careerenquiries/detail.tpl';
        $this->zones = array(
            'header',
            'columnleft',
            'footer'
        );
        $this->response->setOutput($this->render());
    }

   
}
