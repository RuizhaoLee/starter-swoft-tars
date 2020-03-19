<?php declare(strict_types=1);

$config_path = $argv[1];
$config_arg = '--config=';
$pos = strpos($config_path, $config_arg);
$config_path = substr($config_path, $pos + strlen($config_arg));
$cmd = strtolower($argv[2]);

$dir = __DIR__;

if ($cmd === 'start') {
    $cmd = "/usr/bin/php $dir/bin/swoft tars:run --cmd=$cmd --config_path=$config_path";
    exec($cmd, $output);
}