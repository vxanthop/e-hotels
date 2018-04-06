<?php

spl_autoload_register(function ($_name) {
	$name = str_replace('\\', '/', $_name);

	if (file_exists('src/' . $name . '.php')) {
		require 'src/' . $name . '.php';
		return true;
	}

	return false;
});