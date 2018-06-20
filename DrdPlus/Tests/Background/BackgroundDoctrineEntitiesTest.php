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
    protected function setUp(): void
    {
        BackgroundEnumRegistrar::registerAll();
        parent::setUp();
    }

    /**
     * @return array
     * @throws \ReflectionException
     */
    protected function getDirsWithEntities(): array
    {
        $backgroundReflection = new \ReflectionClass(Background::class);

        return [\dirname($backgroundReflection->getFileName())];
    }

    protected function getExpectedEntityClasses(): array
    {
        return [Background::class];
    }

    protected function createEntitiesToPersist(): array
    {
        return [self::createBackgroundEntity()];
    }

    public static function createBackgroundEntity(): Background
    {
        return Background::createIt(
            FateCode::getIt(FateCode::COMBINATION_OF_PROPERTIES_AND_BACKGROUND),
            new PositiveIntegerObject(3),
            new PositiveIntegerObject(4),
            new PositiveIntegerObject(3),
            Tables::getIt()
        );
    }

}