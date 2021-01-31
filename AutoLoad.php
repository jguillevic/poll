<?php
require_once join(DIRECTORY_SEPARATOR,[ __DIR__, 'vendor', 'autoload.php' ]);

spl_autoload_register(function($className) {
	$file = $className . '.php';
	if (file_exists($file)) {
		require_once $file;
    }
});