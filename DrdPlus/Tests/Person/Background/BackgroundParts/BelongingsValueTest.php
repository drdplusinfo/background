<?php
namespace DrdPlus\Tests\Person\Background\BackgroundParts;

use DrdPlus\Person\Background\BackgroundParts\BelongingsValue;
use DrdPlus\Person\Background\BackgroundParts\Heritage;
use DrdPlus\Tables\Measurements\Price\Price;
use DrdPlus\Tests\Person\Background\BackgroundParts\Partials\AbstractHeritageDependentTest;

class BelongingsValueTest extends AbstractHeritageDependentTest
{
    /**
     * @test
     * @dataProvider provideBackgroundPointsHeritageAndPrice
     * @param int $spentBackgroundPoints
     * @param int $heritageValue
     * @param int $expectedPrice
     */
    public function I_can_get_belongings_price($spentBackgroundPoints, $heritageValue, $expectedPrice)
    {
        $belongingsValue = BelongingsValue::getIt(
            $spentBackgroundPoints,
            $heritage = $this->createHeritage($heritageValue)
        );
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
     * @param int $spentBackgroundPoints
     * @expectedException \DrdPlus\Person\Background\BackgroundParts\Exceptions\UnexpectedBackgroundPoints
     */
    public function I_can_not_get_belongings_price_with_broken_points($spentBackgroundPoints)
    {
        $heritage = TestOfBrokenBelongings::getIt($spentBackgroundPoints, $this->createHeritage(null));

        $heritage->getBelongingsPrice();
    }
}

/** inner */
class TestOfBrokenBelongings extends BelongingsValue
{
    public static function getIt($spentBackgroundPoints, Heritage $heritage)
    {
        return self::getEnum($spentBackgroundPoints);
    }
}
