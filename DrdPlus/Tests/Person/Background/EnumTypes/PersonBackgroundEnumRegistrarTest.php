<?php
namespace DrdPlus\Tests\Person\Background\EnumTypes;

use Doctrine\DBAL\Types\Type;
use DrdPlus\Person\Background\BackgroundParts\EnumTypes\BackgroundSkillPointsType;
use DrdPlus\Person\Background\BackgroundParts\EnumTypes\BelongingsValueType;
use DrdPlus\Person\Background\BackgroundParts\EnumTypes\HeritageType;
use DrdPlus\Person\Background\EnumTypes\BackgroundPointsType;
use DrdPlus\Person\Background\EnumTypes\PersonBackgroundEnumRegistrar;

class PersonBackgroundEnumRegistrarTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function I_can_register_all_enums_at_once()
    {
        PersonBackgroundEnumRegistrar::registerAll();

        self::assertTrue(Type::hasType(BackgroundPointsType::BACKGROUND_POINTS));
        self::assertTrue(Type::hasType(BackgroundSkillPointsType::BACKGROUND_SKILL_POINTS));
        self::assertTrue(Type::hasType(BelongingsValueType::BELONGINGS_VALUE));
        self::assertTrue(Type::hasType(HeritageType::HERITAGE));
    }
}
