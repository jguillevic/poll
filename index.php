<?php
session_set_cookie_params(2592000); // Durée de vie des cookies de 2592000s = 30j.
require_once join(DIRECTORY_SEPARATOR,[ __DIR__, 'Resources', 'AppResources.php' ]);
use Resources\AppResources;
session_name(AppResources::$AppName);
session_start();

require_once join(DIRECTORY_SEPARATOR,[ __DIR__, 'AutoLoad.php' ]);

$fc = new FrontController();
$fc->Run();
?>