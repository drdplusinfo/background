<?php
namespace DrdPlus\Person\Background\EnumTypes;

use Doctrineum\Integer\IntegerEnumType;

class BackgroundPointsType extends IntegerEnumType
{
    const BACKGROUND_POINTS = 'background_points';

    /**
     * @return string
     */
    public function getName()
    {
        return self::BACKGROUND_POINTS;
    }
}
