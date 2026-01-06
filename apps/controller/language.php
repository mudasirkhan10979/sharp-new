<?php
class ControllerLanguage extends Controller
{
    public function index()
    {
        $data['action'] = BASE_URL . 'language/save';

        $data['code'] = $this->session->data['language'];

        $this->load_model('language');

        $data['languages'] = array();

        $results = $this->model_language->getLanguages();

        foreach ($results as $result) {
            if ($result['status']) {
                $data['languages'][] = array(
                    'name' => $result['name'],
                    'code' => $result['code'],
                    'image'=> $result['image']
                );
            }
        }

        if (!isset($_SERVER['REQUEST_URI'])||$_SERVER['REQUEST_URI']=='/') {
            $data['redirect'] = BASE_URL . 'home';
        } else {
            $route = substr($_SERVER['REQUEST_URI'], 1);
            $data['redirect'] = BASE_URL . $route;
        }

        return $this->response->view('sharp/template/language.tpl', $data);
    }

    public function save()
    {
        if (isset($this->request->post['code'])) {
            $this->session->data['language'] = $this->request->post['code'];
        }

        if (isset($this->request->post['redirect'])) {
            $this->response->redirect($this->request->post['redirect']);
        } else {
            $this->response->redirect(BASE_URL . 'home');
        }
    }
}
