<?php
namespace DrdPlus\Tests\Background\BackgroundParts\Partials;

use DrdPlus\Codes\History\AncestryCode;
use DrdPlus\Background\BackgroundParts\Ancestry;
use DrdPlus\Background\BackgroundParts\SkillsFromBackground;
use DrdPlus\Background\BackgroundParts\Possession;
use DrdPlus\Background\BackgroundPoints;
use DrdPlus\Tables\History\AncestryTable;
use DrdPlus\Tables\Tables;
use Granam\Integer\PositiveInteger;
use Granam\Integer\PositiveIntegerObject;

abstract class AbstractAncestryDependentTest extends AbstractBackgroundAdvantageTest
{
    /**+
     * @param PositiveInteger $spentBackgroundPoints
     * @return \DrdPlus\Background\BackgroundParts\Partials\AbstractAncestryDependent|Possession|SkillsFromBackground
     */
    protected function createSutToTestSpentBackgroundPoints(PositiveInteger $spentBackgroundPoints)
    {
        /** @var Possession|SkillsFromBackground $sutClass */
        $sutClass = self::getSutClass();

        return $sutClass::getIt(
            $spentBackgroundPoints,
            $this->createAncestry(
                $spentBackgroundPoints->getValue() + 1 /* just for example */,
                AncestryCode::getIt(AncestryCode::NOBLE)
            ),
            Tables::getIt()
        );
    }

    /**
     * @param int $value
     * @param AncestryCode $ancestryCode
     * @return \Mockery\MockInterface|Ancestry
     */
    protected function createAncestry($value, AncestryCode $ancestryCode = null)
    {
        $ancestry = $this->mockery(Ancestry::class);
        $ancestry->shouldReceive('getValue')
            ->andReturn($value);
        $ancestry->shouldReceive('getSpentBackgroundPoints')
            ->andReturn($backgroundPoints = new PositiveIntegerObject($value));
        if ($ancestryCode === null) {
            $ancestryCode = (new AncestryTable())->getAncestryCodeByBackgroundPoints($backgroundPoints);
        }
        $ancestry->shouldReceive('getAncestryCode')
            ->andReturn($ancestryCode);

        return $ancestry;
    }

    /**
     * @test
     * @dataProvider provideBackgroundPointsAndAncestry
     * @param int $spentBackgroundPointsValue
     * @param int $ancestryBackgroundPoints
     */
    public function I_can_create_it(
        $spentBackgroundPointsValue,
        $ancestryBackgroundPoints
    )
    {
        /** @var Possession|SkillsFromBackground $sutClass */
        $sutClass = self::getSutClass();
        $sut = $sutClass::getIt(
            new PositiveIntegerObject($spentBackgroundPointsValue),
            $this->createAncestry($ancestryBackgroundPoints),
            Tables::getIt()
        );
        self::assertSame($spentBackgroundPointsValue, $sut->getValue());
        $spentBackgroundPoints = $sut->getSpentBackgroundPoints();
        self::assertInstanceOf(PositiveInteger::class, $spentBackgroundPoints);
        self::assertSame($spentBackgroundPointsValue, $spentBackgroundPoints->getValue());
        self::assertSame($spentBackgroundPoints, $sut->getSpentBackgroundPoints(), 'Expected same instance');
    }

    public function provideBackgroundPointsAndAncestry()
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
     * @test
     * @dataProvider provideTooMuchBackgroundPointsToAncestry
     * @expectedException \DrdPlus\Background\Exceptions\TooMuchSpentBackgroundPoints
     * @param int $spentBackgroundPoints
     * @param int $ancestryBackgroundPoints
     */
    public function I_can_not_spent_more_than_three_over_ancestry($spentBackgroundPoints, $ancestryBackgroundPoints)
    {
        /** @var Possession|SkillsFromBackground $sutClass */
        $sutClass = self::getSutClass();
        self::assertGreaterThan($ancestryBackgroundPoints + 3, $spentBackgroundPoints);
        self::assertLessThanOrEqual(8, $spentBackgroundPoints);
        $sutClass::getIt(
            new PositiveIntegerObject($spentBackgroundPoints),
            $this->createAncestry($ancestryBackgroundPoints),
            Tables::getIt()
        );
    }

    public function provideTooMuchBackgroundPointsToAncestry()
    {
        return [
            [4, 0],
            [5, 0],
            [6, 0],
            [7, 0],
            [8, 4],
            [7, 3],
        ];
    }
}