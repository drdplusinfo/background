<?php
namespace DrdPlus\Tests\Person\Background;

use Doctrineum\Tests\Entity\AbstractDoctrineEntitiesTest;
use DrdPlus\Exceptionalities\Fates\ExceptionalityFate;
use DrdPlus\Exceptionalities\Fates\FateOfCombination;
use DrdPlus\Person\Background\Background;
use DrdPlus\Person\Background\EnumTypes\PersonBackgroundEnumRegistrar;

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
            dirname($backgroundReflection->getFileName())
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
            self::createBackgroundEntity()
        ];
    }

    public static function createBackgroundEntity()
    {
        return Background::createIt(
            ExceptionalityFate::getItByCode(FateOfCombination::getCode()),
            3,
            3,
            4
        );
    }

}