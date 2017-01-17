<?php
namespace DrdPlus\Background\BackgroundParts\EnumTypes;

use Doctrineum\Integer\IntegerEnumType;

class SkillsFromBackgroundType extends IntegerEnumType
{
    const SKILLS_FROM_BACKGROUND = 'skills_from_background';

    /**
     * @return string
     */
    public function getName()
    {
        return self::SKILLS_FROM_BACKGROUND;
    }
}