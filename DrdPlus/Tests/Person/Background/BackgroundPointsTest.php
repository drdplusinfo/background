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
     * @dataProvider provideFateTypeAndPoints
     * @param string $fateType
     * @param int $expectedPoints
     */
    public function I_can_get_background_points_by_fate($fateType, $expectedPoints)
    {
        $backgroundPoints = BackgroundPoints::getIt($this->createFate($fateType));
        $this->assertSame($expectedPoints, $backgroundPoints->getValue());
    }

    public function provideFateTypeAndPoints()
    {
        return [
            [FateOfExceptionalProperties::FATE_OF_EXCEPTIONAL_PROPERTIES, 5],
            [FateOfCombination::FATE_OF_COMBINATION, 10],
            [FateOfGoodRear::FATE_OF_GOOD_REAR, 15],
        ];
    }

    /**
     * @param string $fateType
     * @return ExceptionalityFate
     */
    private function createFate($fateType)
    {
        $fate = $this->mockery(ExceptionalityFate::class);
        $fate->shouldReceive('getCode')
            ->andReturn($fateType);

        return $fate;
    }

    /**
     * @test
     * @expectedException \DrdPlus\Person\Background\Exceptions\UnknownFate
     */
    public function I_can_not_use_unknown_fate()
    {
        BackgroundPoints::getIt($this->createFate('invalid fate code'));
    }
}
