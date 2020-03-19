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
    system($cmd, $return_var);
    if ($return_var === 0) {
        system("$php_bin $dir/bin/swoft http:start -d", $returnvar);
    }
} else if ($cmd === 'stop') {
    $cmd = "$php_bin $dir/bin/swoft tars:run --cmd=$cmd --config_path=$config_path ";
    system($cmd, $return_var);
    if ($return_var === 0) {
        system("$php_bin $dir/bin/swoft http:stop", $returnvar);
    }
}
