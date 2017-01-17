<?php
namespace DrdPlus\Tests\Background\BackgroundParts;

use DrdPlus\Background\BackgroundParts\Ancestry;
use DrdPlus\Tables\History\AncestryTable;
use DrdPlus\Tests\Background\BackgroundParts\Partials\AbstractBackgroundAdvantageTest;
use Granam\Integer\PositiveInteger;
use Granam\Integer\PositiveIntegerObject;

class AncestryTest extends AbstractBackgroundAdvantageTest
{
    protected function createSutToTestSpentBackgroundPoints(PositiveInteger $spentBackgroundPoints)
    {
        return Ancestry::getIt($spentBackgroundPoints, new AncestryTable());
    }

    /**
     * @test
     */
    public function I_can_get_ancestry_code()
    {
        $ancestry = Ancestry::getIt(new PositiveIntegerObject(6), new AncestryTable());
        self::assertSame(6, $ancestry->getValue());
        $ancestryTable = $this->mockery(AncestryTable::class);
        $ancestryTable->shouldReceive('getAncestryCodeByBackgroundPoints')
            ->with($this->type(PositiveInteger::class))
            ->andReturnUsing(function (PositiveInteger $positiveInteger) {
                self::assertSame(6, $positiveInteger->getValue());

                return 'foo';
            });
        /** @var AncestryTable $ancestryTable */
        self::assertSame('foo', $ancestry->getAncestryCode($ancestryTable));
    }
}