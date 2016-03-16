<?php
namespace DrdPlus\Tests\Person\Background;

use DrdPlus\Person\Background\BackgroundPoints;
use DrdPlus\Person\Background\BelongingsValue;
use DrdPlus\Tables\Measurements\Price\Price;

class BelongingsValueTest extends AbstractTestOfHeritageDependent
{
    /**
     * @test
     * @dataProvider provideBackgroundPointsHeritageAndPrice
     * @param int $pointsValue
     * @param int $expectedPrice
     */
    public function I_can_get_belongings_price($pointsValue, $expectedPrice)
    {
        $points = $this->createBackgroundPoints($pointsValue);

        $belongingsValue = BelongingsValue::getIt($points);
        $price = $belongingsValue->getBelongingsPrice();

        self::assertInstanceOf(Price::class, $price);
        self::assertSame((float)$expectedPrice, $price->getGoldCoins());
        self::assertSame((float)$expectedPrice, $price->getValue()); // the base value is in gold already
    }

    public function provideBackgroundPointsHeritageAndPrice()
    {
        return [
            [0, 1],
            [1, 3],
            [2, 10],
            [3, 30],
            [4, 100],
            [5, 300],
            [6, 1000],
            [7, 3000],
            [8, 10000],
        ];
    }
    /**
     * @test
     * @dataProvider provideInvalidBackgroundPoints
     * @param int $pointsValue
     * @expectedException \DrdPlus\Person\Background\Exceptions\UnexpectedBackgroundPoints
     */
    public function I_can_not_get_belongings_price_with_broken_points($pointsValue)
    {
        $points = $this->createBackgroundPoints($pointsValue);
        $heritage = TestOfBrokenBelongings::getIt($points);

        $heritage->getBelongingsPrice();
    }
}

/** inner */
class TestOfBrokenBelongings extends BelongingsValue
{
    public static function getIt(BackgroundPoints $backgroundPoints)
    {
        return self::getEnum($backgroundPoints->getValue());
    }
}
