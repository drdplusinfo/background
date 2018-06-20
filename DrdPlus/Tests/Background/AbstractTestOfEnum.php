<?php
namespace DrdPlus\Tests\Background;

use Doctrineum\Scalar\ScalarEnum;
use Doctrineum\Scalar\ScalarEnumType;
use Granam\Tests\Tools\TestWithMockery;

abstract class AbstractTestOfEnum extends TestWithMockery
{

    /**
     * @test
     * @throws \ReflectionException
     * @throws \Doctrine\DBAL\DBALException
     */
    public function I_can_use_it_as_an_enum(): void
    {
        $sutClass = self::getSutClass();
        self::assertTrue(\class_exists($sutClass), "Class $sutClass not found");
        self::assertTrue(
            \is_a($sutClass, ScalarEnum::class, true),
            "Class $sutClass should be child of " . ScalarEnum::class
        );

        $typeClass = $this->getEnumTypeClass();
        self::assertTrue(
            \class_exists($typeClass),
            "Expected enum type class $typeClass not found"
        );
        self::assertTrue(\is_a($typeClass, ScalarEnumType::class, true));
        $typeClass::registerSelf();

        self::assertTrue(ScalarEnumType::hasType($this->getEnumCode()));
    }

    /**
     * @return ScalarEnumType|string
     * @throws \ReflectionException
     */
    private function getEnumTypeClass()
    {
        $enumClassBaseName = $this->getEnumClassBasename();
        $enumTypeClassBasename = $enumClassBaseName . 'Type';

        $enumClass = self::getSutClass();
        $reflection = new \ReflectionClass($enumClass);
        $enumNamespace = $reflection->getNamespaceName();

        $enumTypeNamespace = $enumNamespace . '\\' . 'EnumTypes';

        return $enumTypeNamespace . '\\' . $enumTypeClassBasename;
    }

    private function getEnumClassBasename(): string
    {
        $enumClass = self::getSutClass();
        self::assertSame(1, \preg_match('~(?<basename>\w+$)~', $enumClass, $matches));

        return $matches['basename'];
    }

    private function getEnumCode(): string
    {
        $enumClassBaseName = $this->getEnumClassBasename();
        $underscored = \preg_replace('~([a-z])([A-Z])~', '$1_$2', $enumClassBaseName);

        return \strtolower($underscored);
    }
}