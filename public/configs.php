<?php
  define('DB_USER', 'gpmdate');
  define('DB_PASS', 'tshirt11');
  define('DB_NAME', 'gpmdate');
  define('DB_HOST', 'localhost');

  $public_directory = getcwd();
  $base_directory   = substr($public_directory, 0, -6);
  define('PUBLIC_DIR', $public_directory . '/');
  define('PRIVATE_DIR', $base_directory . 'private/');
  define('BASE_DIR', $base_directory);

  define('VIEW_DIR', PUBLIC_DIR . 'view/template/');
  define('CONTROLLER_DIR', PUBLIC_DIR . 'controller/');
  define('ASSETS_DIR', PUBLIC_DIR . 'assets/');
