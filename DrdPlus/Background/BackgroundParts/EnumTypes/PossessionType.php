<?php
namespace DrdPlus\Background\BackgroundParts\EnumTypes;

use Doctrineum\Integer\IntegerEnumType;

class PossessionType extends IntegerEnumType
{
    const POSSESSION = 'possession';

    /**
     * @return string
     */
    public function getName(): string
    {
        return self::POSSESSION;
    }
}