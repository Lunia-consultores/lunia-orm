<?php

namespace LuniaConsultores\LuniaOrm;

use Illuminate\Support\Facades\Facade;

/**
 * @see \LuniaConsultores\LuniaOrm\Skeleton\SkeletonClass
 */
class LuniaOrmFacade extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'lunia-orm';
    }
}
