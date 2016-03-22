<?php
namespace DrdPlus\Tests\Person\Background;

use DrdPlus\Exceptionalities\Fates\ExceptionalityFate;
use DrdPlus\Exceptionalities\Fates\FateOfCombination;
use DrdPlus\Exceptionalities\Fates\FateOfExceptionalProperties;
use DrdPlus\Exceptionalities\Fates\FateOfGoodRear;
use DrdPlus\Person\Background\BackgroundPoints;

class BackgroundPointsTest extends AbstractTestOfEnum
{
    /**
     * @test
     * @dataProvider provideFateTypeAndBackgroundPoints
     * @param ExceptionalityFate $exceptionalityFate
     * @param int $expectedPoints
     */
    public function I_can_get_background_points_by_fate(ExceptionalityFate $exceptionalityFate, $expectedPoints)
    {
        $backgroundPoints = BackgroundPoints::getIt($exceptionalityFate);
        self::assertSame($expectedPoints, $backgroundPoints->getValue());
    }

    public function provideFateTypeAndBackgroundPoints()
    {
        return [
            [FateOfExceptionalProperties::getIt(), 5],
            [FateOfCombination::getIt(), 10],
            [FateOfGoodRear::getIt(), 15],
        ];
    }

    /**
     * @test
     * @expectedException \DrdPlus\Person\Background\Exceptions\UnknownFate
     */
    public function I_can_not_use_unknown_fate()
    {
        BackgroundPoints::getIt(UnknownFate::getIt());
    }
}

/** inner */
class UnknownFate extends FateOfGoodRear
{
}