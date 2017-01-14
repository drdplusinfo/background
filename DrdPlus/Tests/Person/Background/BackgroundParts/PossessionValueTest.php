<?php
namespace DrdPlus\Tests\Person\Background\BackgroundParts;

use DrdPlus\Person\Background\BackgroundParts\PossessionValue;
use DrdPlus\Person\Background\BackgroundParts\Ancestry;
use DrdPlus\Tables\Measurements\Price\Price;
use DrdPlus\Tests\Person\Background\BackgroundParts\Partials\AbstractHeritageDependentTest;

class PossessionValueTest extends AbstractHeritageDependentTest
{
    /**
     * @test
     * @dataProvider provideBackgroundPointsHeritageAndPrice
     * @param int $spentBackgroundPoints
     * @param int $ancestryValue
     * @param int $expectedPrice
     */
    public function I_can_get_belongings_price($spentBackgroundPoints, $ancestryValue, $expectedPrice)
    {
        $possessionValue = PossessionValue::getIt(
            $spentBackgroundPoints,
            $ancestry = $this->createHeritage($ancestryValue)
        );
        $price = $possessionValue->getBelongingsPrice();

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
        $ancestry = TestOfBrokenPossession::getIt($spentBackgroundPoints, $this->createHeritage(null));

        $ancestry->getBelongingsPrice();
    }
}

/** inner */
class TestOfBrokenPossession extends PossessionValue
{
    public static function getIt($spentBackgroundPoints, Ancestry $ancestry)
    {
        return self::getEnum($spentBackgroundPoints);
    }
}
