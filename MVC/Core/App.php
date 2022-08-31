<?php
class App
{
  protected $controller = 'Home';
  protected $action = 'Index';
  protected $parametres = [];
  protected $type = '';

  function __construct()
  {
    $url = $this->getUrl();
    $link = './MVC/Controllers/';

    if (file_exists($link . $url[0] . '.php')) {
      $this->controller = $url[0];
    }

    require_once($link . $this->controller . '.php');

    unset($url[0]);
    if (isset($url[1])) {
      if (method_exists($this->controller, $url[1])) {
        $this->action = $url[1];
      }
      unset($url[1]);
    }

    $this->controller = new $this->controller;
    $this->parametres = (!empty($url)) ? array_values($url) : [];
    call_user_func_array(array($this->controller, $this->action), $this->parametres);
  }

  private function getURL()
  {
    $url = isset($_GET['url']) ? explode('/', trim($_GET['url'], '/')) : [$this->controller, $this->action];
    return $url;
  }
}
