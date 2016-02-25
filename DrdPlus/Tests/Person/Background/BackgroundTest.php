<?php
namespace DrdPlus\Tests\Person\Background;

use DrdPlus\Person\Background\Background;
use DrdPlus\Person\Background\BackgroundPoints;
use Granam\Tests\Tools\TestWithMockery;

class BackgroundTest extends TestWithMockery
{
    /**
     * @test
     * @dataProvider provideBackgroundPoints
     * @param int $pointsValue
     */
    public function I_can_create_background_by_points_only($pointsValue)
    {
        $backgroundPoints = $this->createBackgroundPoints($pointsValue);
        $background = Background::getIt($backgroundPoints);

        $this->assertSame($backgroundPoints, $background->getBackgroundPoints());
        $backgroundSkills = $background->getBackgroundSkillPoints();
        $this->assertSame($pointsValue, $backgroundSkills->getBackgroundPointsValue());
        $belongingsValue = $background->getBelongingsValue();
        $this->assertSame($pointsValue, $belongingsValue->getBackgroundPointsValue());
        $heritage = $background->getHeritage();
        $this->assertSame($pointsValue, $heritage->getBackgroundPointsValue());
    }

    public function provideBackgroundPoints()
    {
        return [[0], [1], [2], [3], [4], [5], [6], [7], [8]];
    }

    /**
     * @param $value
     * @return \Mockery\MockInterface|BackgroundPoints
     */
    private function createBackgroundPoints($value)
    {
        $backgroundPoints = $this->mockery(BackgroundPoints::class);
        $backgroundPoints->shouldReceive('getValue')
            ->andReturn($value);

        return $backgroundPoints;
    }
}
