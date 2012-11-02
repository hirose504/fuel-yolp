<?php

Autoloader::add_core_namespace('Yolp', false);

Autoloader::add_classes(array(
	'Yolp\\StaticMap' => __DIR__.'/classes/staticmap.php',
	'Yolp\\LocalSearch' => __DIR__.'/classes/localsearch.php',
	'Yolp\\Request' => __DIR__.'/classes/request.php',
	'Yolp\\Response_StaticMap' => __DIR__.'/classes/response/staticmap.php',
	'Yolp\\Response_LocalSearch' => __DIR__.'/classes/response/localsearch.php',
));
