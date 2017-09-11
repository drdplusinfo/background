<?php
namespace DrdPlus\Background\EnumTypes;

use Doctrineum\Integer\IntegerEnumType;

class BackgroundPointsType extends IntegerEnumType
{
    const BACKGROUND_POINTS = 'background_points';

    /**
     * @return string
     */
    public function getName(): string
    {
        return self::BACKGROUND_POINTS;
    }
}
