<?php
namespace DrdPlus\Tests\Background;

use Granam\Tests\ExceptionsHierarchy\Exceptions\AbstractExceptionsHierarchyTest;

class BackgroundExceptionsHierarchyTest extends AbstractExceptionsHierarchyTest
{
    /**
     * @return string
     */
    protected function getTestedNamespace(): string
    {
        return $this->getRootNamespace();
    }

    /**
     * @return string
     */
    protected function getRootNamespace(): string
    {
        return \str_replace('\Tests', '', __NAMESPACE__);
    }

}