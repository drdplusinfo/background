<?php
namespace DrdPlus\Tests\Person\Background;

use DrdPlus\Codes\PlayerDecisionCode;
use DrdPlus\Person\Background\BackgroundPoints;
use DrdPlus\Tables\History\BackgroundPointsTable;

class BackgroundPointsTest extends AbstractTestOfEnum
{
    /**
     * @test
     */
    public function I_can_get_background_points_by_fate()
    {
        $playerDecisionCode = $this->createPlayerDecisionCode();
        $backgroundPointsTable = $this->createBackgroundPointsTable($playerDecisionCode, 123);
        $backgroundPoints = BackgroundPoints::getIt($playerDecisionCode, $backgroundPointsTable);
        self::assertSame(123, $backgroundPoints->getValue());
    }

    /**
     * @return \Mockery\MockInterface|PlayerDecisionCode
     */
    private function createPlayerDecisionCode()
    {
        return $this->mockery(PlayerDecisionCode::class);
    }

    /**
     * @param PlayerDecisionCode $playerDecisionCode
     * @param int $backgroundPoints
     * @return \Mockery\MockInterface|BackgroundPointsTable
     */
    private function createBackgroundPointsTable(PlayerDecisionCode $playerDecisionCode, $backgroundPoints)
    {
        $backgroundPointsTable = $this->mockery(BackgroundPointsTable::class);
        $backgroundPointsTable->shouldReceive('getBackgroundPointsByPlayerDecision')
            ->with($playerDecisionCode)
            ->andReturn($backgroundPoints);

        return $backgroundPointsTable;
    }
}