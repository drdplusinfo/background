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
        $fateCode = $this->createFateCode();
        $backgroundPointsTable = $this->createBackgroundPointsTable($fateCode, 123);
        $backgroundPoints = BackgroundPoints::getIt($fateCode, $backgroundPointsTable);
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
     * @param FateCode $fateCode
     * @param int $backgroundPoints
     * @return \Mockery\MockInterface|BackgroundPointsTable
     */
    private function createBackgroundPointsTable(FateCode $fateCode, $backgroundPoints)
    {
        $backgroundPointsTable = $this->mockery(BackgroundPointsTable::class);
        $backgroundPointsTable->shouldReceive('getBackgroundPointsByPlayerDecision')
            ->with($fateCode)
            ->andReturn($backgroundPoints);

        return $backgroundPointsTable;
    }
}