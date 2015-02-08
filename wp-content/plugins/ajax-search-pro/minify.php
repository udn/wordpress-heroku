<?php
/**
 * PHP file to create the minified-scoped versions of the js files
 * User: Ernest Marcinko
 * Date: 2014.06.20.
 * Time: 10:43
 */

// define the $scope variable

parse_str($argv[1]);

$ds = DIRECTORY_SEPARATOR;
$dir = dirname(__FILE__).$ds."js".$ds."nomin".$ds;
$newdir = dirname(__FILE__).$ds."js".$ds."nomin-scoped".$ds;

$files = scandir($dir);
foreach($files as $file) {
    if ($file == "." || $file == "..") continue;
    $content = file_get_contents($dir.$file);
    $content = "(function(jQuery, $, window){\n".$content."\n})($scope, $scope, window);";
    @file_put_contents($newdir.$file, $content, FILE_TEXT);
}

