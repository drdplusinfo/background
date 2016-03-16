<?php
namespace DrdPlus\Tests\Person\Background;

use DrdPlus\Person\Background\BackgroundPoints;
use DrdPlus\Person\Background\Heritage;
use DrdPlus\Person\Background\Parts\AbstractHeritageDependent;

class AbstractTestOfHeritageDependent extends AbstractTestOfBackgroundAdvantage
{
    protected function createSut(BackgroundPoints $backgroundPoints)
    {
        /** @var AbstractHeritageDependent $sutClass */
        $sutClass = $this->getSutClass();

        return $sutClass::getIt($backgroundPoints);
    }

    /**
     * @test
     * @dataProvider provideBackgroundPointsAndHeritage
     * @param int $pointsValue
     */
    public function I_can_create_it($pointsValue)
    {
        $backgroundPoints = $this->createBackgroundPoints($pointsValue);

        /** @var AbstractHeritageDependent $sutClass */
        $sutClass = $this->getSutClass();
        $sut = $sutClass::getIt($backgroundPoints);
        self::assertSame($backgroundPoints->getValue(), $sut->getValue());
        self::assertSame($backgroundPoints->getValue(), $sut->getBackgroundPointsValue());
    }

    public function provideBackgroundPointsAndHeritage()
    {
        return [
            [0, 0],
            [1, 0],
            [2, 0],
            [3, 0],
            [4, 4],
            [5, 3],
            [6, 3],
            [7, 4],
            [8, 8],
        ];
    }

    /**
     * @param $value
     * @return \Mockery\MockInterface|BackgroundPoints
     */
    protected function createBackgroundPoints($value)
    {
        $points = $this->mockery(BackgroundPoints::class);
        $points->shouldReceive('getValue')
            ->andReturn($value);

        return $points;
    }

    /**
     * @param $value
     * @return \Mockery\MockInterface|Heritage
     */
    protected function createHeritage($value)
    {
        $heritage = $this->mockery(Heritage::class);
        $heritage->shouldReceive('getValue')
            ->andReturn($value);
        $heritage->shouldReceive('getBackgroundPointsValue')
            ->andReturn($value);

        return $heritage;
    }

    /**
     * @return AbstractHeritageDependent
     */
    protected function getSutClass()
    {
        return parent::getSutClass();
    }

}
