<?php declare(strict_types=1);


namespace Murphy\Tars\Crontab;

use Murphy\Tars\TarsManage;
use Swoft\Bean\Annotation\Mapping\Inject;
use Swoft\Crontab\Annotaion\Mapping\Cron;
use Swoft\Crontab\Annotaion\Mapping\Scheduled;
use Swoft\Log\Helper\CLog;

/**
 * Class TarsKeepAliveTask
 * @Scheduled("tarsKeepAlive")
 * @package App\Task\Crontab
 */
class TarsKeepAliveTask
{

    /**
     * @Inject()
     * @var TarsManage
     */
    private $tarsManage;

    /**
     * 每30s上报一次服务存活心跳
     * @Cron("30 * * * * *")
     * @return bool
     */
    public function keepAliveTask(): bool
    {
        return $this->tarsManage->keepAlive();
    }
}
