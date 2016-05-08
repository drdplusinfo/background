<?php
namespace DrdPlus\Person\Background\BackgroundParts\EnumTypes;

use Doctrineum\Integer\IntegerEnumType;

class BelongingsValueType extends IntegerEnumType
{
    const BELONGINGS_VALUE = 'belongings_value';

    /**
     * @return string
     */
    public function getName()
    {
        return self::BELONGINGS_VALUE;
    }
}
