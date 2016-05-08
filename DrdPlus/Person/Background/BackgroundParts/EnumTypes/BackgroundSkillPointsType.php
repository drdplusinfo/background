<?php
namespace DrdPlus\Person\Background\BackgroundParts\EnumTypes;

use Doctrineum\Integer\IntegerEnumType;

class BackgroundSkillPointsType extends IntegerEnumType
{
    const BACKGROUND_SKILL_POINTS = 'background_skill_points';

    /**
     * @return string
     */
    public function getName()
    {
        return self::BACKGROUND_SKILL_POINTS;
    }
}
