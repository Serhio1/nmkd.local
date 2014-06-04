<?php

session_start();

require_once 'autoloader.php';
require_once 'vendor/autoload.php';

Container::init();
Container::get('router')->init();






