<?php
namespace DrdPlus\Tests\Background;

use Doctrineum\Tests\Entity\AbstractDoctrineEntitiesTest;
use DrdPlus\Codes\History\FateCode;
use DrdPlus\Background\Background;
use DrdPlus\Background\EnumTypes\BackgroundEnumRegistrar;
use DrdPlus\Tables\Tables;
use Granam\Integer\PositiveIntegerObject;

class BackgroundDoctrineEntitiesTest extends AbstractDoctrineEntitiesTest
{
    protected function setUp()
    {
        BackgroundEnumRegistrar::registerAll();
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
            FateCode::getIt(FateCode::COMBINATION_OF_PROPERTIES_AND_BACKGROUND),
            new Tables(),
            new PositiveIntegerObject(3),
            new PositiveIntegerObject(4),
                new PositiveIntegerObject(3)
        );
    }

}