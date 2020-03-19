<?php declare(strict_types=1);
/**
 * This file is part of Swoft.
 * @link     https://swoft.org
 * @document https://swoft.org/docs
 * @contact  group@swoft.org
 * @license  https://github.com/swoft-cloud/swoft/blob/master/LICENSE
 */

namespace App\Listener;

use Murphy\Tars\TarsManage;
use Swoft\Bean\Annotation\Mapping\Inject;
use Swoft\Event\Annotation\Mapping\Listener;
use Swoft\Event\EventHandlerInterface;
use Swoft\Event\EventInterface;
use Swoft\Server\SwooleEvent;

/**
 * Class RegisterServiceListener
 * @since 2.0
 * @Listener(event=SwooleEvent::START)
 */
class RegisterServiceListener implements EventHandlerInterface
{

    /**
     * @Inject()
     * @var TarsManage
     */
    private $tarsManage;

    /**
     * @param EventInterface $event
     */
    public function handle(EventInterface $event): void
    {
        $this->tarsManage->keepAlive();
    }
}
