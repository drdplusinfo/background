<?php
namespace DrdPlus\Tests\Person\Background;

use Doctrineum\Tests\Entity\AbstractDoctrineEntitiesTest;
use DrdPlus\Codes\PlayerDecisionCode;
use DrdPlus\Person\Background\Background;
use DrdPlus\Person\Background\EnumTypes\PersonBackgroundEnumRegistrar;
use DrdPlus\Tables\History\BackgroundPointsTable;

class PersonBackgroundDoctrineEntitiesTest extends AbstractDoctrineEntitiesTest
{
    protected function setUp()
    {
        PersonBackgroundEnumRegistrar::registerAll();
        parent::setUp();
    }

    protected function getDirsWithEntities()
    {
        $backgroundReflection = new \ReflectionClass(Background::class);

        return [
            dirname($backgroundReflection->getFileName()),
        ];
    }

    protected function getExpectedEntityClasses()
    {
        return [
            Background::class,
        ];
    }

    protected function createEntitiesToPersist()
    {
        return [
            self::createBackgroundEntity(),
        ];
    }

    public static function createBackgroundEntity()
    {
        return Background::createIt(
            PlayerDecisionCode::getIt(PlayerDecisionCode::COMBINATION_OF_PROPERTIES_AND_BACKGROUND),
            new BackgroundPointsTable(),
            3,
            3,
            4
        );
    }

}