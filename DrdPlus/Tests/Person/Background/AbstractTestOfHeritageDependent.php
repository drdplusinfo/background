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
        $heritage = $this->createHeritage(8);

        return $sutClass::getIt($backgroundPoints, $heritage);
    }

    /**
     * @test
     * @dataProvider provideBackgroundPointsAndHeritage
     * @param int $pointsValue
     * @param int $heritageValue
     */
    public function I_can_create_it($pointsValue, $heritageValue)
    {
        $backgroundPoints = $this->createBackgroundPoints($pointsValue);
        $heritage = $this->createHeritage($heritageValue);

        /** @var AbstractHeritageDependent $sutClass */
        $sutClass = $this->getSutClass();
        $sut = $sutClass::getIt($backgroundPoints, $heritage);
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

    /**
     * @test
     * @dataProvider provideProhibitedBackgroundPointsToHeritage
     * @expectedException \LogicException
     * @param int $backgroundPointsValue
     * @param int $heritageValue
     */
    public function I_can_not_use_more_then_three_more_heritage_points($backgroundPointsValue, $heritageValue)
    {
        $backgroundPoints = $this->createBackgroundPoints($backgroundPointsValue);
        $heritage = $this->createHeritage($heritageValue);

        $sutClass = $this->getSutClass();
        $sutClass::getIt($backgroundPoints, $heritage);
    }

    public function provideProhibitedBackgroundPointsToHeritage()
    {
        return [
            [4, 0],
            [5, 1],
            [6, 2],
            [7, 3],
            [8, 4]
        ];
    }
}
