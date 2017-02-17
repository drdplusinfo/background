<?php
namespace DrdPlus\Tests\Background\BackgroundParts;

use DrdPlus\Background\Background;
use Granam\Tests\ExceptionsHierarchy\Exceptions\AbstractExceptionsHierarchyTest;

class BackgroundPartsExceptionsHierarchyTest extends AbstractExceptionsHierarchyTest
{
    /**
     * @return string
     */
    protected function getTestedNamespace()
    {
        return str_replace('\Tests', '', __NAMESPACE__);
    }

    /**
     * @return string
     */
    protected function getRootNamespace()
    {
        $rootReflection = new \ReflectionClass(Background::class);

        return $rootReflection->getNamespaceName();
    }

}