<?php

class App {

  public function appconf() {
    $config_file = DD . "/app/config/app.yaml";
      if(file_exists($config_file)) {
        $yaml_parser = new sfYamlParser;
        $config = $yaml_parser->parse(file_get_contents($config_file));
      }
      else $config = null;

    return $config;

  }
}
