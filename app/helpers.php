<?php

if ( ! function_exists('base_path')) {
	function base_path (string $path): string  {
		return __DIR__ . '/..//' . ($path ? DIRECTORY_SEPARATOR . $path : $path);
	}
}

if ( ! function_exists('base_url')) {
    function base_url(string $url, bool $withFullPath = false): string {
        $basePath = '';    // 'basepath/'
        
        if($withFullPath) {
            $basePath = sprintf(
    			"%s://%s:%s/%s",
    			isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off' ? 'https' : 'http',
    			$_SERVER['SERVER_NAME'],
    			$_SERVER['SERVER_PORT'],
    			$basePath
    		);
        }
        
		return sprintf('%s/%s', $basePath, (substr($url, 0, 1) == '/')?substr($url, 1):$url);
    }
}