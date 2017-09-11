<?php
namespace DrdPlus\Background\EnumTypes;

use DrdPlus\Background\BackgroundParts\EnumTypes\SkillPointsFromBackgroundType;
use DrdPlus\Background\BackgroundParts\EnumTypes\PossessionType;
use DrdPlus\Background\BackgroundParts\EnumTypes\AncestryType;

class BackgroundEnumRegistrar
{
    public static function registerAll(): void
    {
        BackgroundPointsType::registerSelf();
        SkillPointsFromBackgroundType::registerSelf();
        PossessionType::registerSelf();
        AncestryType::registerSelf();
    }
}