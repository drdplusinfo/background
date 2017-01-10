<?php
namespace DrdPlus\Tests\Person\Background;

use DrdPlus\Codes\PlayerDecisionCode;
use DrdPlus\Person\Background\Background;
use DrdPlus\Person\Background\BackgroundParts\BackgroundSkillPoints;
use DrdPlus\Person\Background\BackgroundParts\BelongingsValue;
use DrdPlus\Person\Background\BackgroundParts\Heritage;
use DrdPlus\Person\Background\BackgroundPoints;
use DrdPlus\Tables\History\BackgroundPointsTable;
use Granam\Tests\Tools\TestWithMockery;

class BackgroundTest extends TestWithMockery
{
    /**
     * @test
     * @dataProvider provideBackgroundPoints
     * @param PlayerDecisionCode $playerDecisionCode
     * @param int $forHeritageSpentBackgroundPoints
     * @param int $forBackgroundSkillPointsSpentBackgroundPoints
     * @param int $forBelongingsSpentBackgroundPoints
     */
    public function I_can_create_background(
        PlayerDecisionCode $playerDecisionCode,
        $forHeritageSpentBackgroundPoints,
        $forBackgroundSkillPointsSpentBackgroundPoints,
        $forBelongingsSpentBackgroundPoints
    )
    {
        $background = Background::createIt(
            $playerDecisionCode,
            $backgroundPointsTable = new BackgroundPointsTable(),
            $forHeritageSpentBackgroundPoints,
            $forBackgroundSkillPointsSpentBackgroundPoints,
            $forBelongingsSpentBackgroundPoints
        );

        self::assertNull($background->getId());

        $backgroundPoints = $background->getBackgroundPoints();
        self::assertInstanceOf(BackgroundPoints::class, $backgroundPoints);
        self::assertSame($backgroundPointsTable->getBackgroundPointsByPlayerDecision($playerDecisionCode), $backgroundPoints->getValue());

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

        self::assertSame(
            $backgroundPoints->getValue()
            - $heritage->getSpentBackgroundPoints()
            - $backgroundSkillPoints->getSpentBackgroundPoints()
            - $belongingsValue->getSpentBackgroundPoints(),
            $background->getRemainingBackgroundPoints()
        );
    }

    public function provideBackgroundPoints()
    {
        return [
            [PlayerDecisionCode::getIt(PlayerDecisionCode::GOOD_BACKGROUND), 1, 1, 1],
        ];
    }

    /**
     * @test
     * @expectedException \DrdPlus\Person\Background\Exceptions\SpentTooMuchBackgroundPoints
     */
    public function I_can_not_spent_more_than_available_points_in_total()
    {
        $backgroundPoints = BackgroundPoints::getIt(
            PlayerDecisionCode::getIt(PlayerDecisionCode::GOOD_BACKGROUND), new BackgroundPointsTable()
        );
        $pointsForHeritage = 6;
        $pointsForBackgroundSkillPoints = 5;
        $pointsForBelongings = 6;
        self::assertGreaterThan(
            $backgroundPoints->getValue(),
            $pointsForHeritage
            + $pointsForBackgroundSkillPoints
            + $pointsForBelongings
        );

        Background::createIt(
            PlayerDecisionCode::getIt(PlayerDecisionCode::GOOD_BACKGROUND),
            new BackgroundPointsTable(),
            $pointsForHeritage,
            $pointsForBackgroundSkillPoints,
            $pointsForBelongings
        );
    }
}