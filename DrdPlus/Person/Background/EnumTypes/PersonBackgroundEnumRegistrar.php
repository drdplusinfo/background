<?php
namespace DrdPlus\Person\Background\EnumTypes;

use DrdPlus\Person\Background\BackgroundParts\EnumTypes\BackgroundSkillPointsType;
use DrdPlus\Person\Background\BackgroundParts\EnumTypes\PossessionValueType;
use DrdPlus\Person\Background\BackgroundParts\EnumTypes\AncestryType;

class PersonBackgroundEnumRegistrar
{
    public static function registerAll()
    {
        BackgroundPointsType::registerSelf();
        BackgroundSkillPointsType::registerSelf();
        PossessionValueType::registerSelf();
        AncestryType::registerSelf();
    }
}