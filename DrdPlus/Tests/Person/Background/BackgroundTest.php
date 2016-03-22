<?php
namespace DrdPlus\Tests\Person\Background;

use DrdPlus\Exceptionalities\Fates\ExceptionalityFate;
use DrdPlus\Exceptionalities\Fates\FateOfGoodRear;
use DrdPlus\Person\Background\Background;
use DrdPlus\Person\Background\BackgroundParts\BackgroundSkillPoints;
use DrdPlus\Person\Background\BackgroundParts\BelongingsValue;
use DrdPlus\Person\Background\BackgroundParts\Heritage;
use DrdPlus\Person\Background\BackgroundPoints;
use Granam\Tests\Tools\TestWithMockery;

class BackgroundTest extends TestWithMockery
{
    /**
     * @test
     * @dataProvider provideBackgroundPoints
     *
     * @param ExceptionalityFate $exceptionalityFate
     * @param int $forHeritageSpentBackgroundPoints ,
     * @param int $forBackgroundSkillPointsSpentBackgroundPoints ,
     * @param int $forBelongingsSpentBackgroundPoints
     */
    public function I_can_create_background(
        ExceptionalityFate $exceptionalityFate,
        $forHeritageSpentBackgroundPoints,
        $forBackgroundSkillPointsSpentBackgroundPoints,
        $forBelongingsSpentBackgroundPoints
    )
    {
        $background = Background::createIt(
            $exceptionalityFate,
            $forHeritageSpentBackgroundPoints,
            $forBackgroundSkillPointsSpentBackgroundPoints,
            $forBelongingsSpentBackgroundPoints
        );

        $backgroundPoints = $background->getBackgroundPoints();
        self::assertInstanceOf(BackgroundPoints::class, $backgroundPoints);
        self::assertSame(
            BackgroundPoints::POINTS_FOR_FATE_OF_GOOD_REAR,
            $backgroundPoints->getValue()
        );

        $heritage = $background->getHeritage();
        self::assertInstanceOf(Heritage::class, $heritage);
        self::assertSame($forHeritageSpentBackgroundPoints, $heritage->getSpentBackgroundPoints());

        $backgroundSkillPoints = $background->getBackgroundSkillPoints();
        self::assertInstanceOf(BackgroundSkillPoints::class, $backgroundSkillPoints);
        self::assertSame(
            $forBackgroundSkillPointsSpentBackgroundPoints,
            $backgroundSkillPoints->getSpentBackgroundPoints()
        );

        $belongingsValue = $background->getBelongingsValue();
        self::assertInstanceOf(BelongingsValue::class, $belongingsValue);
        self::assertSame($forBelongingsSpentBackgroundPoints, $belongingsValue->getSpentBackgroundPoints());
    }

    public function provideBackgroundPoints()
    {
        return [
            [FateOfGoodRear::getIt(), 1, 1, 1],
        ];
    }
}