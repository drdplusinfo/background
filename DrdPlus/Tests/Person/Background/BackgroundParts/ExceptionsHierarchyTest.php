<?php
namespace DrdPlus\Tests\Person\Background\BackgroundParts;

use DrdPlus\Person\Background\Background;
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
