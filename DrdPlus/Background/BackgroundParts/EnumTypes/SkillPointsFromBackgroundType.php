<?php
namespace DrdPlus\Background\BackgroundParts\EnumTypes;

use Doctrineum\Integer\IntegerEnumType;

class SkillPointsFromBackgroundType extends IntegerEnumType
{
    const SKILL_POINTS_FROM_BACKGROUND = 'skill_points_from_background';

    /**
     * @return string
     */
    public function getName(): string
    {
        return self::SKILL_POINTS_FROM_BACKGROUND;
    }
}