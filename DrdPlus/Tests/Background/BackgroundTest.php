<?php
namespace DrdPlus\Tests\Background;

use DrdPlus\Codes\History\FateCode;
use DrdPlus\Background\Background;
use DrdPlus\Background\BackgroundParts\SkillsFromBackground;
use DrdPlus\Background\BackgroundParts\Possession;
use DrdPlus\Background\BackgroundParts\Ancestry;
use DrdPlus\Background\BackgroundPoints;
use DrdPlus\Tables\History\BackgroundPointsTable;
use DrdPlus\Tables\Tables;
use Granam\Integer\PositiveInteger;
use Granam\Integer\PositiveIntegerObject;
use Granam\Tests\Tools\TestWithMockery;

class BackgroundTest extends TestWithMockery
{
    /**
     * @test
     * @dataProvider provideBackgroundPoints
     * @param FateCode $fateCode
     * @param int $forAncestrySpentBackgroundPoints
     * @param int $forBackgroundSkillPointsSpentBackgroundPoints
     * @param int $forBelongingsSpentBackgroundPoints
     */
    public function I_can_create_background(
        FateCode $fateCode,
        $forAncestrySpentBackgroundPoints,
        $forBackgroundSkillPointsSpentBackgroundPoints,
        $forBelongingsSpentBackgroundPoints
    )
    {
        $background = Background::createIt(
            $fateCode,
            Tables::getIt(),
            new PositiveIntegerObject($forAncestrySpentBackgroundPoints),
            new PositiveIntegerObject($forBelongingsSpentBackgroundPoints),
            new PositiveIntegerObject($forBackgroundSkillPointsSpentBackgroundPoints)
        );

        self::assertNull($background->getId());

        $backgroundPoints = $background->getBackgroundPoints();
        self::assertInstanceOf(BackgroundPoints::class, $backgroundPoints);
        self::assertSame((new BackgroundPointsTable())->getBackgroundPointsByPlayerDecision($fateCode), $backgroundPoints->getValue());

        $ancestry = $background->getAncestry();
        self::assertInstanceOf(Ancestry::class, $ancestry);
        $ancestrySpentBackgroundPoints = $ancestry->getSpentBackgroundPoints();
        self::assertInstanceOf(PositiveInteger::class, $ancestrySpentBackgroundPoints);
        self::assertSame($forAncestrySpentBackgroundPoints, $ancestrySpentBackgroundPoints->getValue());

        $backgroundSkillPoints = $background->getSkillsFromBackground();
        self::assertInstanceOf(SkillsFromBackground::class, $backgroundSkillPoints);
        $skillPointsSpentBackgroundPoints = $backgroundSkillPoints->getSpentBackgroundPoints();
        self::assertInstanceOf(PositiveInteger::class, $skillPointsSpentBackgroundPoints);
        self::assertSame(
            $forBackgroundSkillPointsSpentBackgroundPoints,
            $skillPointsSpentBackgroundPoints->getValue()
        );

        $possession = $background->getPossession();
        self::assertInstanceOf(Possession::class, $possession);
        $possessionSpentBackgroundPoints = $possession->getSpentBackgroundPoints();
        self::assertInstanceOf(PositiveInteger::class, $possessionSpentBackgroundPoints);
        self::assertSame($forBelongingsSpentBackgroundPoints, $possessionSpentBackgroundPoints->getValue());

        self::assertSame(
            $backgroundPoints->getValue()
            - $ancestry->getSpentBackgroundPoints()->getValue()
            - $backgroundSkillPoints->getSpentBackgroundPoints()->getValue()
            - $possession->getSpentBackgroundPoints()->getValue(),
            $background->getRemainingBackgroundPoints()
        );
    }

    public function provideBackgroundPoints()
    {
        return [
            [FateCode::getIt(FateCode::GOOD_BACKGROUND), 1, 1, 1],
        ];
    }

    /**
     * @test
     * @expectedException \DrdPlus\Background\Exceptions\TooMuchSpentBackgroundPoints
     */
    public function I_can_not_spent_more_than_available_points_in_total()
    {
        $backgroundPoints = BackgroundPoints::getIt(
            FateCode::getIt(FateCode::GOOD_BACKGROUND), new BackgroundPointsTable()
        );
        $pointsForAncestry = 6;
        $pointsForBackgroundSkillPoints = 5;
        $pointsForBelongings = 6;
        self::assertGreaterThan(
            $backgroundPoints->getValue(),
            $pointsForAncestry
            + $pointsForBackgroundSkillPoints
            + $pointsForBelongings
        );

        Background::createIt(
            FateCode::getIt(FateCode::GOOD_BACKGROUND),
            Tables::getIt(),
            new PositiveIntegerObject($pointsForAncestry),
            new PositiveIntegerObject($pointsForBelongings),
            new PositiveIntegerObject($pointsForBackgroundSkillPoints)
        );
    }
}