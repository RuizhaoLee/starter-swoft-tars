<?php declare(strict_types=1);

namespace Murphy\Tars;

use RuntimeException;
use Swoft\Bean\Annotation\Mapping\Bean;
use Swoft\Log\Helper\CLog;
use Tars\report\ServerFSync;
use Tars\report\ServerInfo;
use Tars\Utils;

/**
 * Class TarsManage
 * @Bean()
 * @package Murphy\Tars
 * @author  liruizhao<liruizhaoatphp@outlook.com>
 */
class TarsManage
{
    /**
     * @return bool
     */
    public function keepAlive(): bool
    {
        $appName = env('APP_NAME', '');
        if (!$appName) {
            throw new RuntimeException('APP_NAME can\'t be empty');
        }

        $masterPid = getmypid();
        [$application, $serverName] = explode('.', $appName);

        $adapter = $appName . '.objAdapter';

        $nodeInfo = $this->getNodeInfo();
        if (empty($nodeInfo)) {
            CLog::error('keepAlive getNodeInfo fail');
            return false;
        }

        $host = $nodeInfo['host'];
        $port = $nodeInfo['port'];
        $objName = $nodeInfo['objName'];

        $serverInfo = new ServerInfo();
        $serverInfo->adapter = $adapter;
        $serverInfo->application = $application;
        $serverInfo->serverName = $serverName;
        $serverInfo->pid = $masterPid;

        $serverF = new ServerFSync($host, $port, $objName);
        $serverF->keepAlive($serverInfo);

        $adminServerInfo = new ServerInfo();
        $adminServerInfo->adapter = 'AdminAdapter';
        $adminServerInfo->application = $application;
        $adminServerInfo->serverName = $serverName;
        $adminServerInfo->pid = $masterPid;
        $serverF->keepAlive($adminServerInfo);

        CLog::info('Tars node service keepalive!');
        return true;
    }

    /**
     * 获取节点信息
     * @return array
     */
    public function getNodeInfo(): array
    {
        $conf = $this->getTarsConf();
        if (!empty($conf)) {
            $node = $conf['tars']['application']['server']['node'] ?? null;
            if ($node) {
                return Utils::parseNodeInfo($node);
            }
        }

        return [];
    }

    /**
     * 获取Tars平台下发的配置
     * @return array
     */
    public function getTarsConf(): array
    {
        $confFileName = sprintf('%s.config.con', env('APP_NAME'));
        $tars_conf = alias('@root') . '/conf/' . $confFileName;

        if (is_file($tars_conf)) {
            return Utils::parseFile($tars_conf);
        }

        CLog::error('get tars_conf file error : %s', $tars_conf);
        return [];
    }
}