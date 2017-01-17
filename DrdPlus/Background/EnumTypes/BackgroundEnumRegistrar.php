<?php
namespace DrdPlus\Background\EnumTypes;

use DrdPlus\Background\BackgroundParts\EnumTypes\SkillsFromBackgroundType;
use DrdPlus\Background\BackgroundParts\EnumTypes\PossessionType;
use DrdPlus\Background\BackgroundParts\EnumTypes\AncestryType;

class BackgroundEnumRegistrar
{
    public static function registerAll()
    {
        BackgroundPointsType::registerSelf();
        SkillsFromBackgroundType::registerSelf();
        PossessionType::registerSelf();
        AncestryType::registerSelf();
    }
}