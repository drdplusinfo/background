<?php
namespace DrdPlus\Tests\Person\Background\BackgroundParts\Partials;

use DrdPlus\Person\Background\BackgroundPoints;
use DrdPlus\Person\Background\BackgroundParts\Partials\AbstractBackgroundAdvantage;
use DrdPlus\Tests\Person\Background\AbstractTestOfEnum;

abstract class AbstractBackgroundAdvantageTest extends AbstractTestOfEnum
{

    /**
     * @test
     * @dataProvider provideSpentBackgroundPoints
     * @param int $spentBackgroundPoints
     */
    public function I_can_get_spent_background_points($spentBackgroundPoints)
    {
        $sut = $this->createSut($spentBackgroundPoints);
        self::assertSame($spentBackgroundPoints, $sut->getValue()); // default enum value getter
        self::assertSame($spentBackgroundPoints, $sut->getSpentBackgroundPoints());
    }

    public function provideSpentBackgroundPoints()
    {
        return [[0], [1], [2], [3], [4], [5], [6], [7], [8]];
    }

    /**
     * @test
     * @dataProvider provideInvalidBackgroundPoints
     * @expectedException \DrdPlus\Person\Background\BackgroundParts\Exceptions\UnexpectedBackgroundPoints
     * @param int $spentBackgroundPoints
     */
    public function I_can_not_get_heritage_background_points_with_invalid_value($spentBackgroundPoints)
    {
        $this->createSut($spentBackgroundPoints);
    }

    /**
     * @param $spentBackgroundPoints
     * @return AbstractBackgroundAdvantage
     */
    abstract protected function createSut($spentBackgroundPoints);

    /**
     * @param int $value
     * @return \Mockery\MockInterface|BackgroundPoints
     */
    protected function createBackgroundPoints($value)
    {
        $backgroundPoints = $this->mockery(BackgroundPoints::class);
        $backgroundPoints->shouldReceive('getValue')
            ->andReturn($value);

        return $backgroundPoints;
    }

    public function provideInvalidBackgroundPoints()
    {
        return [
            [-1],
            [9]
        ];
    }
}
