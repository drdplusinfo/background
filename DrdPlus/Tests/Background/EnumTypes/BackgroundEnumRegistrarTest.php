<?php
namespace DrdPlus\Tests\Background\EnumTypes;

use Doctrine\DBAL\Types\Type;
use DrdPlus\Background\BackgroundParts\EnumTypes\SkillsFromBackgroundType;
use DrdPlus\Background\BackgroundParts\EnumTypes\PossessionType;
use DrdPlus\Background\BackgroundParts\EnumTypes\AncestryType;
use DrdPlus\Background\EnumTypes\BackgroundPointsType;
use DrdPlus\Background\EnumTypes\BackgroundEnumRegistrar;

class BackgroundEnumRegistrarTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function I_can_register_all_enums_at_once()
    {
        BackgroundEnumRegistrar::registerAll();

        self::assertTrue(Type::hasType(BackgroundPointsType::BACKGROUND_POINTS));
        self::assertTrue(Type::hasType(SkillsFromBackgroundType::SKILLS_FROM_BACKGROUND));
        self::assertTrue(Type::hasType(PossessionType::POSSESSION));
        self::assertTrue(Type::hasType(AncestryType::ANCESTRY));
    }
}