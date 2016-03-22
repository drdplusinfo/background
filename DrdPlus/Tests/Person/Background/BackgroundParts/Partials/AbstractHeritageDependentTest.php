<?php
namespace DrdPlus\Tests\Person\Background\BackgroundParts\Partials;

use DrdPlus\Person\Background\BackgroundParts\Heritage;
use DrdPlus\Person\Background\BackgroundParts\Partials\AbstractHeritageDependent;
use DrdPlus\Person\Background\BackgroundPoints;

abstract class AbstractHeritageDependentTest extends AbstractBackgroundAdvantageTest
{
    protected function createSut($spentBackgroundPoints)
    {
        /** @var AbstractHeritageDependent $sutClass */
        $sutClass = $this->getSutClass();

        return $sutClass::getIt($spentBackgroundPoints, $this->createHeritage($spentBackgroundPoints));
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
        $heritage->shouldReceive('getSpentBackgroundPoints')
            ->andReturn($value);

        return $heritage;
    }

    /**
     * @test
     * @dataProvider provideBackgroundPointsAndHeritage
     * @param int $spentBackgroundPoints
     * @param int $heritageBackgroundPoints
     */
    public function I_can_create_it($spentBackgroundPoints, $heritageBackgroundPoints)
    {
        /** @var AbstractHeritageDependent $sutClass */
        $sutClass = $this->getSutClass();
        $sut = $sutClass::getIt($spentBackgroundPoints, $this->createHeritage($heritageBackgroundPoints));
        self::assertSame($spentBackgroundPoints, $sut->getValue());
        self::assertSame($spentBackgroundPoints, $sut->getSpentBackgroundPoints());
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

}
