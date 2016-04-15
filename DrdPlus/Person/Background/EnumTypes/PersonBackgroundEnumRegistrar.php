<?php
namespace DrdPlus\Person\Background\EnumTypes;

use DrdPlus\Person\Background\BackgroundParts\EnumTypes\BackgroundSkillPointsType;
use DrdPlus\Person\Background\BackgroundParts\EnumTypes\BelongingsValueType;
use DrdPlus\Person\Background\BackgroundParts\EnumTypes\HeritageType;

class PersonBackgroundEnumRegistrar
{
    public static function registerAll()
    {
        BackgroundPointsType::registerSelf();
        BackgroundSkillPointsType::registerSelf();
        BelongingsValueType::registerSelf();
        HeritageType::registerSelf();
    }
}
