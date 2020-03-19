<?php declare(strict_types=1);


namespace Murphy\Tars\Command;

use Murphy\Tars\Util;
use Swoft\Config\Config;
use Swoft\Console\Annotation\Mapping\Command;
use Swoft\Console\Annotation\Mapping\CommandMapping;
use Swoft\Console\Annotation\Mapping\CommandOption;
use Swoft\Console\Input\Input;
use Swoft\Log\Helper\CLog;
use Tars\cmd\Command as TarsCommand;
use Tars\deploy\Deploy;

/**
 * Class Tars
 * @Command(name="tars")
 * @package Murphy\Tars\Command
 * @author  liruizhao<liruizhaoatphp@outlook.com>
 */
class Tars
{
    /**
     * Tars框架中的启动
     * @CommandMapping(name="run")
     * @CommandOption("cmd", type="string", default="start", desc="执行命令")
     * @CommandOption("config_path", short="cfg", default="string", desc="相关配置")
     * @param Input $input
     */
    public function commandRun(Input $input): void
    {
        $opts = $input->getOpts();

        $cmd = $opts['cmd'] ?? '';
        $cfg = $opts['config_path'] ?? $opts['cfg'] ?? '';

        [$hostname, $port, $appName, $serverName] = Util::parseTarsConfig($cfg);
        $class = new TarsCommand($cmd, $cfg);
        $class->run();
    }

    /**
     * Tars初始化脚本
     * @CommandMapping(name="init")
     * @param Input $input
     */
    public function commandInitialize(Input $input): void
    {
        file_put_contents(alias('@base') . '/index.php', file_get_contents(__DIR__ . '/stdio/_index.ctp'));
        file_put_contents(alias('@base') . 'config/tars.php', file_get_contents(__DIR__ . '/stdio/_tars_config.ctp'));
        file_put_contents(alias('@base') . '/service.php', file_get_contents(__DIR__ . '/stdio/_service.ctp'));
        CLog::info('initialize index script successful!');
    }

    /**
     * Tars配置相关发布命令
     * @CommandMapping(name="deploy")
     * @param Input $input
     */
    public function commandDeploy(Input $input): void
    {
        Deploy::run();
        CLog::info('deploy tars service successful!');
    }
}