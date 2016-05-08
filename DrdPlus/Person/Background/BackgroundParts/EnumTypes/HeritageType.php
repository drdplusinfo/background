<?php
namespace DrdPlus\Person\Background\BackgroundParts\EnumTypes;

use Doctrineum\Integer\IntegerEnumType;

class HeritageType extends IntegerEnumType
{
    const HERITAGE = 'heritage';

    /**
     * @return string
     */
    public function getName()
    {
        return self::HERITAGE;
    }
}
