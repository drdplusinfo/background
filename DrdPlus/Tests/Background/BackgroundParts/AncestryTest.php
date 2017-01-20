<?php
namespace DrdPlus\Tests\Background\BackgroundParts;

use DrdPlus\Background\BackgroundParts\Ancestry;
use DrdPlus\Tables\History\AncestryTable;
use DrdPlus\Tables\Tables;
use DrdPlus\Tests\Background\BackgroundParts\Partials\AbstractBackgroundAdvantageTest;
use Granam\Integer\PositiveInteger;
use Granam\Integer\PositiveIntegerObject;

class AncestryTest extends AbstractBackgroundAdvantageTest
{
    protected function createSutToTestSpentBackgroundPoints(PositiveInteger $spentBackgroundPoints)
    {
        return Ancestry::getIt($spentBackgroundPoints, Tables::getIt());
    }

    /**
     * @test
     */
    public function I_can_get_ancestry_code()
    {
        $tables = $this->createTablesWithAncestryTable(
            function (PositiveInteger $positiveInteger) {
                self::assertSame(6, $positiveInteger->getValue());

                return 'foo';
            }
        );

        $ancestry = Ancestry::getIt(new PositiveIntegerObject(6), $tables);
        self::assertSame(6, $ancestry->getValue());
        /** @var AncestryTable $ancestryTable */
        self::assertSame('foo', $ancestry->getAncestryCode($tables));
    }

    /**
     * @param \Closure $getAncestryCode
     * @return \Mockery\MockInterface|Tables
     */
    private function createTablesWithAncestryTable(\Closure $getAncestryCode)
    {
        $tables = $this->mockery(Tables::class);
        $tables->shouldReceive('getAncestryTable')
            ->andReturn($ancestryTable = $this->mockery(AncestryTable::class));
        $ancestryTable->shouldReceive('getAncestryCodeByBackgroundPoints')
            ->with($this->type(PositiveInteger::class))
            ->andReturnUsing($getAncestryCode);

        return $tables;
    }
}