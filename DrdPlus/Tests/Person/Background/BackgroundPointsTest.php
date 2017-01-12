<?php
namespace DrdPlus\Tests\Person\Background;

use DrdPlus\Codes\FateCode;
use DrdPlus\Person\Background\BackgroundPoints;
use DrdPlus\Tables\History\BackgroundPointsTable;

class BackgroundPointsTest extends AbstractTestOfEnum
{
    /**
     * @test
     */
    public function I_can_get_background_points_by_fate()
    {
        $playerDecisionCode = $this->createFateCode();
        $backgroundPointsTable = $this->createBackgroundPointsTable($playerDecisionCode, 123);
        $backgroundPoints = BackgroundPoints::getIt($playerDecisionCode, $backgroundPointsTable);
        self::assertSame(123, $backgroundPoints->getValue());
    }

    /**
     * @return \Mockery\MockInterface|FateCode
     */
    private function createFateCode()
    {
        return $this->mockery(FateCode::class);
    }

    /**
     * @param FateCode $playerDecisionCode
     * @param int $backgroundPoints
     * @return \Mockery\MockInterface|BackgroundPointsTable
     */
    private function createBackgroundPointsTable(FateCode $playerDecisionCode, $backgroundPoints)
    {
        $backgroundPointsTable = $this->mockery(BackgroundPointsTable::class);
        $backgroundPointsTable->shouldReceive('getBackgroundPointsByPlayerDecision')
            ->with($playerDecisionCode)
            ->andReturn($backgroundPoints);

        return $backgroundPointsTable;
    }
}