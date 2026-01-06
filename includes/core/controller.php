<?php
abstract class Controller
{
    protected $registry;
    protected $id;
    protected $template;
    protected $zones = array();
    protected $data = array();
    protected $output;

    public function __construct($registry)
    {
        $this->registry = $registry;
    }

    public function __get($key)
    {
		
        return $this->registry->get($key);
    }

    public function __set($key, $value)
    {
        $this->registry->set($key, $value);
    }

    protected function redirect($iurl, $status = 302)
    {
		
        header('status:' . $status);
        header('Location:' . str_replace(array('&amp;', "\n", "\r"), array('&', '', ''), $iurl));
        exit();
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
    public function load_model($model)
    {
        $file  = DIR_APP . 'model/' . $model . '.php';
        $class = 'Model' . preg_replace('/[^a-zA-Z0-9]/', '', $model);
        if (file_exists($file)) {
            include_once($file);
            $this->registry->set('model_' . str_replace('/', '_', $model), new $class($this->registry));
        } else {
            exit('Error: Could not load model ' . $model . '!');
        }
    }
    public function load_controller($c = null, $f = null, $p = null)
    {
        $file  = DIR_APP . 'controller/' . $c . '.php';
        $class = 'Controller' . preg_replace('/[^a-zA-Z0-9]/', '', $c);
        if (file_exists($file)) {
            include_once($file);
            $controller = new $class($this->registry);
            if (is_callable(array($controller, $f)) == false) {
                $action = 'index';
            } else {
                $action = $f;
            }
            return $controller->$action($p);
        } else {
            exit('Error: Could not load controller ' . $model . '!');
        }
    }
    public function load_helper($helper)
    {
        $file = DIR_INC . 'helper/' . $helper . '.php';
        if (file_exists($file)) {
            include_once($file);
        }
    }
    public function getPcUrl()
    {
        return $this->registry->get('pcUrls');
    }
    public function getSlogData()
    {
        return $this->registry->get('slog_data');
    }
    public function getCP_index()
    {
        return $this->registry->get('c_p_index');
    }
    public function email_send($data, $template)
    {
        ob_start();
        extract($data);
        include DIR_EMAIL . $template . '/index.tpl';
        return ob_get_clean();
    }
    public function link($route, $args = '', $secure = false) {
		if (!$secure) {
			$url = HTTP_HOST;
		} else {
			$url = HTTPS_HOST;
		} 
		$url .= '?controller=' . $route; 
		if ($args) {
			$url .= str_replace('&', '&amp;', '&' . ltrim($args, '&'));
		}
		
		$url = str_replace(array('&amp;', "\n", "\r"), array('&', '', ''), $url);

		return $url;
	}
    public function getPortalSEOUrls($slugis,$queryid) { 
		$sql = "SELECT url FROM " . DB_PREFIX . "aliases WHERE slug='".$slugis."' and query ='" . (int)$queryid . "'";
		$query = $this->db->query($sql); 
		return ($query->row['url']!='') ? $query->row['url']:'/'.$slugis.'/'.$queryid;
	}
}
