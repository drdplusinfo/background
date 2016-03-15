<?php
namespace DrdPlus\Tests\Person\Background;

use DrdPlus\Person\Background\BackgroundPoints;
use DrdPlus\Person\Background\BelongingsValue;
use DrdPlus\Person\Background\Heritage;
use DrdPlus\Tables\Measurements\Price\Price;

class BelongingsValueTest extends AbstractTestOfHeritageDependent
{
    /**
     * @test
     * @dataProvider provideBackgroundPointsHeritageAndPrice
     * @param int $pointsValue
     * @param int $heritageValue
     * @param int $expectedPrice
     */
    public function I_can_get_belongings_price($pointsValue, $heritageValue, $expectedPrice)
    {
        $points = $this->createBackgroundPoints($pointsValue);
        $heritage = $this->createHeritage($heritageValue);

        $belongingsValue = BelongingsValue::getIt($points, $heritage);
        $price = $belongingsValue->getBelongingsPrice();

        self::assertInstanceOf(Price::class, $price);
        self::assertSame((float)$expectedPrice, $price->getGoldCoins());
        self::assertSame((float)$expectedPrice, $price->getValue()); // the base value is in gold already
    }

    public function provideBackgroundPointsHeritageAndPrice()
    {
        return [
            [0, 0, 1],
            [1, 0, 3],
            [2, 0, 10],
            [3, 0, 30],
            [4, 4, 100],
            [5, 3, 300],
            [6, 8, 1000],
            [7, 7, 3000],
            [8, 6, 10000],
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
        $heritage = TestOfBrokenBelongings::getIt($points, $this->createHeritage(null));

        $heritage->getBelongingsPrice();
    }
}

/** inner */
class TestOfBrokenBelongings extends BelongingsValue
{
    public static function getIt(BackgroundPoints $backgroundPoints, Heritage $heritage)
    {
        return self::getEnum($backgroundPoints->getValue());
    }
}
