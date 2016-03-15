<?php
namespace DrdPlus\Tests\Person\Background;

use DrdPlus\Person\Background\BackgroundPoints;
use DrdPlus\Person\Background\Parts\AbstractBackgroundAdvantage;

abstract class AbstractTestOfBackgroundAdvantage extends AbstractTestOfEnum
{

    /**
     * @test
     * @dataProvider provideBackgroundPoints
     * @param int $pointsValue
     */
    public function I_can_get_background_points_value_back($pointsValue)
    {
        $points = $this->createBackgroundPoints($pointsValue);

        $sut = $this->createSut($points);
        self::assertSame($pointsValue, $sut->getValue()); // default enum value getter
        self::assertSame($pointsValue, $sut->getBackgroundPointsValue());
    }

    public function provideBackgroundPoints()
    {
        return [[0], [1], [2], [3], [4], [5], [6], [7], [8]];
    }

    /**
     * @test
     * @dataProvider provideInvalidBackgroundPoints
     * @expectedException \DrdPlus\Person\Background\Exceptions\UnexpectedBackgroundPoints
     * @param int $pointsValue
     */
    public function I_can_not_get_heritage_background_points_with_invalid_value($pointsValue)
    {
        $points = $this->createBackgroundPoints($pointsValue);
        /** @var BackgroundPoints $points */
        $this->createSut($points);
    }

    /**
     * @param BackgroundPoints $backgroundPoints
     * @return AbstractBackgroundAdvantage
     */
    abstract protected function createSut(BackgroundPoints $backgroundPoints);

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

    /**
     * @return AbstractBackgroundAdvantage
     */
    protected function getSutClass()
    {
        return parent::getSutClass();
    }
}
