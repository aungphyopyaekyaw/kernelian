<?php

class App {

  public function appconf() {
    $config_file = DD . "/app/config/app.php";
      if(file_exists($config_file)) {
        $config = require_once $config_file;
      }
      else $config = null;
      
    return $config;

  }
}
