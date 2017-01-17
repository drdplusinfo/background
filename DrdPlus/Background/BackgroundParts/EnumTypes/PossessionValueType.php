<?php
namespace DrdPlus\Background\BackgroundParts\EnumTypes;

use Doctrineum\Integer\IntegerEnumType;

class PossessionValueType extends IntegerEnumType
{
    const POSSESSION_VALUE = 'possession_value';

    /**
     * @return string
     */
    public function getName()
    {
        return self::POSSESSION_VALUE;
    }
}