<?php
final class router
{
    private $registry;
    private $db;
    private $config;
    private $requri;
    private $args = array();
    public $file;
    public $controller;
    public $action;
    public $c_p_index = 1;

    function __construct($registry)
    {
        $this->registry = $registry;
        $this->db = $registry->get('db');
        $this->config = $registry->get('config');
    }

    public function run()
    {
        $this->getController();

        if (!is_readable($this->file)) {
            $this->file = DIR_APP . '/controller/error404.php';
            $this->controller = 'error404';
        }

        require_once($this->file);

        // Clean controller name
        $this->controller = str_replace(array('-', '_', '&'), '', $this->controller);

        $class = 'Controller' . $this->controller;
        $controller = new $class($this->registry);

        $action = is_callable([$controller, $this->action]) ? $this->action : 'index';

        $controller->$action();
    }

    private function getController()
    {
        $croute = "";
        $this->c_p_index = 1;

        // Language prefix removal
        $fullurl = explode('/', ltrim($_SERVER['REQUEST_URI'], '/'), 2);
        $lang_short = str_replace("-", " ", $fullurl[0]);

        if ($lang_short == 'ar') {
            $this->requri = str_replace('ar/', '', $_SERVER['REQUEST_URI']);
        } elseif ($lang_short == 'en') {
            $this->requri = str_replace('en/', '', $_SERVER['REQUEST_URI']);
        } else {
            $this->requri = $_SERVER['REQUEST_URI'];
        }

        $this->requri = preg_replace('/\?.*/', '', $this->requri);
        $croute = trim($this->requri, "/");

        // Pagination check
        $curis = $croute ? explode("/", $croute) : [];
        foreach ($curis as $ks => $vl) {
            if ($vl == 'page') {
                $tmpcp = isset($curis[$ks + 1]) ? $curis[$ks + 1] : '';
                $croute = str_replace('/page/' . $tmpcp, '', $croute);
                $this->c_p_index = $tmpcp;
            }
        }

        $this->registry->set('pcUrls', $croute);
        $route = $this->getSEOurl($croute);
        $this->registry->set('bodyclass', $route);

        $route = ($route == 'admin') ? '' : $route;
        $parts = explode('/', $route);

        // Default controller = home
        $this->controller = !empty($parts[0]) ? $parts[0] : 'home';
        $this->action = isset($parts[1]) ? str_replace('-', '_', $parts[1]) : 'index';

        $this->registry->set('c_p_index', $this->c_p_index);
        $this->file = DIR_APP . 'controller/' . $this->controller . '.php';
    }

           public function getSEOurl($alias = "")
{
    if ($alias == 'admin') {
        return isset($_GET['controller']) ? $_GET['controller'] : '';
    }

    if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest') {
        return $alias;
    }

    if (empty($alias)) {
        return $alias;
    }

    // Break alias into parts
    $parts = explode('/', $alias);
    $lastPart = end($parts); // ✅ always use last slug (child)

    $slugs = '';
    $query = $this->db->query("SELECT slog_id, url, slog FROM aliases WHERE url = '" . $this->db->escape($lastPart) . "' LIMIT 1");

    if ($query->num_rows > 0) {
        $row = $query->row;
        $this->registry->set('slug_data', $row); // ✅ child slug_data hi set hoga

        // Category check
        if (strpos($row['slog'], 'category_id=') === 0) {
            $catId = (int) str_replace('category_id=', '', $row['slog']);
            $catQuery = $this->db->query("SELECT parent_id FROM category WHERE category_id = '" . $catId . "' LIMIT 1");
            if ($catQuery->num_rows > 0) {
                $parentId = (int) $catQuery->row['parent_id'];
                if ($parentId == 0) {
                    return 'maincategory'; 
                } else {
                    return 'maincategory/detail';
                }
            }
        }

        $slugs = $row['slog'];
    }

    // Set banners if exists
    $banners = $this->getAllBanners();
    if (isset($banners[$alias])) {
        $this->registry->set('banners', $banners[$alias]);
    }

    return !empty($slugs) ? $slugs : $alias;
}



    public function getAllBanners()
    {
        $routes = [];
        $sql = "SELECT b.*, bd.* 
                FROM banner b 
                LEFT JOIN banner_description bd ON bd.banner_id = b.banner_id 
                WHERE b.status = 1 AND bd.lang_id = '" . $this->config->get('config_language_id') . "'";

        $result = $this->db->query($sql);
        foreach ($result->rows as $r) {
            $routes[$r['url']] = [
                'meta_title'       => $r['meta_title'] ?? '',
                'meta_keyword'     => $r['meta_keyword'] ?? '',
                'meta_description' => $r['meta_description'] ?? '',
                'banner'           => $r['image'] ?? '',
                'description'      => $r['description'] ?? '',
                'title'            => $r['title'] ?? '',
            ];
        }
        return $routes;
    }
}
