<?php declare(strict_types=1);

$config_path = $argv[1];
$config_arg = '--config=';
$pos = strpos($config_path, $config_arg);
$config_path = substr($config_path, $pos + strlen($config_arg));
$cmd = strtolower($argv[2]);
$dir = __DIR__;

exec('which php', $whichPHPoutput, $whichPHPReturnVal);
if ($whichPHPoutput && $whichPHPoutput[0] ?? null) {
    $php_bin = $whichPHPoutput[0];
} else {
    throw new RuntimeException('Please install PHP environment first!');
}

if ($cmd === 'start') {
    $cmd = "$php_bin $dir/bin/swoft tars:run --cmd=$cmd --config_path=$config_path ";
    exec($cmd, $output, $return_var);
    if ($return_var === 0) {
        exec("$php_bin $dir/bin/swoft http:start -d", $output, $returnvar);
        if ($returnvar === 0) {
            $output = implode('', $output);
            if (file_get_contents(__DIR__ . '/runtime/swoft.pid')) {
                $pid = file_get_contents(__DIR__ . '/runtime/swoft.pid');
                // exec("ps -ax | awk '{ print $1 }' | grep -e \"^${pid}$\"", $output, $r);
                // var_dump($r);
            }
        }
    }
} else if ($cmd === 'stop') {
    $cmd = "$php_bin $dir/bin/swoft tars:run --cmd=$cmd --config_path=$config_path ";
    exec($cmd, $output, $return_var);
    if ($return_var === 0) {
        exec("$php_bin $dir/bin/swoft http:stop", $output, $returnvar);
        if ($returnvar === 0 && !file_exists(__DIR__ . '/runtime/swoft.pid')) {

        }
    }
}
