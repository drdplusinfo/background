<?php
namespace DrdPlus\Tests\Person\Background;

use Doctrineum\Scalar\ScalarEnum;
use Doctrineum\Scalar\ScalarEnumType;
use Granam\Tests\Tools\TestWithMockery;

abstract class AbstractTestOfEnum extends TestWithMockery
{

    /**
     * @test
     */
    public function I_can_use_it_as_an_enum()
    {
        $sutClass = $this->getSutClass();
        self::assertTrue(is_a($sutClass, ScalarEnum::class, true));

        $typeClass = $this->getEnumTypeClass();
        self::assertTrue(class_exists($typeClass));
        self::assertTrue(is_a($typeClass, ScalarEnumType::class, true));
        $typeClass::registerSelf();

        self::assertTrue(ScalarEnumType::hasType($this->getEnumCode()));
    }

    /**
     * @return ScalarEnumType
     */
    private function getEnumTypeClass()
    {
        $enumClassBaseName = $this->getEnumClassBasename();
        $enumTypeClassBasename = $enumClassBaseName . 'Type';

        $enumClass = $this->getSutClass();
        $reflection = new \ReflectionClass($enumClass);
        $enumNamespace = $reflection->getNamespaceName();

        $enumTypeNamespace = $enumNamespace . '\\' . 'EnumTypes';

        return $enumTypeNamespace . '\\' . $enumTypeClassBasename;
    }

    private function getEnumClassBasename()
    {
        $enumClass = $this->getSutClass();
        preg_match('~(?<basename>\w+$)~', $enumClass, $matches);

        return $matches['basename'];
    }

    private function getEnumCode()
    {
        $enumClassBaseName = $this->getEnumClassBasename();
        $underscored = preg_replace('~([a-z])([A-Z])~', '$1_$2', $enumClassBaseName);

        return strtolower($underscored);
    }

    /**
     * @return ScalarEnum|string
     */
    protected function getSutClass()
    {
        return preg_replace('~[\\\]Tests([\\\].+)Test$~', '$1', static::class);
    }
}
