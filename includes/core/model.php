<?php
abstract class Model {
	protected $registry;
	protected $id;
    protected $template;
    protected $zones = array();
    protected $data = array();
    protected $output;
	
	public function __construct($registry) {
		$this->registry = $registry;
	}
	
	public function __get($key) {
		return $this->registry->get($key);
	}
	
	public function __set($key, $value) {
		$this->registry->set($key, $value);
	}
	public function load_model($model) {
		$file  = DIR_APP . 'model/' . $model . '.php';
        $class = 'Model' . preg_replace('/[^a-zA-Z0-9]/', '', $model);
        if (file_exists($file)) {
            include_once($file);
            $this->registry->set('model_' . str_replace('/', '_', $model), new $class($this->registry));
        } else {
            exit('Error: Could not load model ' . $model . '!');
        }
    }

	public function email_send($data, $template)
	{
		
		ob_start();
        extract($data);
		
		include '/themes/nhealth/template/mail/'. $template;
		echo "<pre>";print_r(ob_get_clean());exit;
        return ob_get_clean();
	}
	protected function getPageZone($zone, $args = array())
    {

        $parts = explode('/', $zone);
        $controller = isset($parts[0]) ? $parts[0] : '';
		
        if ($controller != "") {
            $action = isset($parts[1]) ? $parts[1] : 'index';
            $zonefile = DIR_APP . '/controller/' . $controller . '.php';
            
            if (is_readable($zonefile) == true) {
                require_once($zonefile);
                $class = 'Controller' . $controller;
                $controller = new $class($this->registry);
                if (is_callable(array($controller, $action)) == false) {
                    $action = 'index';
                }
                $controller->$action();
                /*** run the action ***/
                $this->data[$controller->id] = $controller->output;
            }
        }
    }

    protected function render()
    {
        foreach ($this->zones as $z) {
            $this->getPageZone($z);  // get all the other zones
        }
        if (file_exists(DIR_TEMPLATE . $this->template)) {
            extract($this->data);
            ob_start();
            require(DIR_TEMPLATE . $this->template);
            $this->output = ob_get_contents();
            ob_end_clean();
            return $this->output;
        } else {
            trigger_error('Error: Could not load template ' . DIR_TEMPLATE . $this->template . '!');
            exit();
        }
    }
}