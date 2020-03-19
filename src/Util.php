<?php declare(strict_types=1);

namespace Murphy\Tars;

use Tars\Utils;

/**
 * Class Util
 * @package Murphy\Tars
 * @author  liruizhao<liruizhaoatphp@outlook.com>
 */
class Util
{
    /**
     * @param $cfg
     * @return array
     */
    public static function parseTarsConfig($cfg): array
    {
        $hostname = gethostname();
        $tarsConfig = Utils::parseFile($cfg);
        $tarsServerConf = $tarsConfig['tars']['application']['server'];
        $port = $tarsServerConf['listen'][0]['iPort'];
        $appName = $tarsServerConf['app'];
        $serverName = $tarsServerConf['server'];
        return [$hostname, $port, $appName, $serverName];
    }
}
