<?php
namespace DrdPlus\Tests\Background\BackgroundParts;

use DrdPlus\Background\Background;
use Granam\Tests\Exceptions\Tools\AbstractExceptionsHierarchyTest;

class ExceptionsHierarchyTest extends AbstractExceptionsHierarchyTest
{
    protected function getTestedNamespace()
    {
        return str_replace('\Tests', '', __NAMESPACE__);
    }

    protected function getRootNamespace()
    {
        $rootReflection = new \ReflectionClass(Background::class);

        return $rootReflection->getNamespaceName();
    }

}