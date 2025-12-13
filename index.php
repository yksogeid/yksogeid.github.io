<?php

// 1. Config
session_start();
require_once 'app/config/config.php';

// 2. Core
require_once 'app/core/App.php';
require_once 'app/core/Controller.php';
require_once 'app/core/Database.php';

// 3. Start App
$app = new App();