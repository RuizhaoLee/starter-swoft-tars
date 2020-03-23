<?php declare(strict_types=1);
/**
 * This file is part of Swoft.
 * @link     https://swoft.org
 * @document https://swoft.org/docs
 * @contact  group@swoft.org
 * @license  https://github.com/swoft-cloud/swoft/blob/master/LICENSE
 */

namespace Murphy\Tars;

use Swoft;
use Swoft\SwoftComponent;

/**
 * Class AutoLoader
 * @since 2.0
 */
class AutoLoader extends SwoftComponent
{
    /**
     * Class constructor.
     */
    public function __construct()
    {
        parent::__construct();

        Swoft::setAlias('@root', dirname(alias('@base'), 2));
    }

    /**
     * @return array
     */
    public function getPrefixDirs(): array
    {
        return [
            __NAMESPACE__ => __DIR__,
        ];
    }

    /**
     * @return array
     */
    public function metadata(): array
    {
        return [];
    }

    public function beans(): array
    {
        return [
            'tarsService' => [
                'class' => bean(TarsService::class),
                'conf' => ''
            ]
        ];
    }
}
