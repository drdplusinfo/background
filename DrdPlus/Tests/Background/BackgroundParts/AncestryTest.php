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
        $tables = $this->createTables();
        $tables->shouldReceive('getAncestryTable')
            ->andReturn($ancestryTable = $this->mockery(AncestryTable::class));
        $ancestryTable->shouldReceive('getAncestryCodeByBackgroundPoints')
            ->with($this->type(PositiveInteger::class))
            ->andReturnUsing(function (PositiveInteger $positiveInteger) {
                self::assertSame(6, $positiveInteger->getValue());

                return 'foo';
            });
        $ancestry = Ancestry::getIt(new PositiveIntegerObject(6), $tables);
        self::assertSame(6, $ancestry->getValue());
        /** @var AncestryTable $ancestryTable */
        self::assertSame('foo', $ancestry->getAncestryCode($tables));
    }

    /**
     * @return \Mockery\MockInterface|Tables
     */
    private function createTables()
    {
        return $this->mockery(Tables::class);
    }
}