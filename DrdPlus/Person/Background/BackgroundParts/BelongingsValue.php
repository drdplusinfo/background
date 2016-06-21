<?php
namespace DrdPlus\Person\Background\BackgroundParts;

use DrdPlus\Person\Background\BackgroundParts\Partials\AbstractHeritageDependent;
use DrdPlus\Tables\Measurements\Price\Price;

/**
 * @method static BelongingsValue getIt($spentBackgroundPoints, Heritage $heritage)
 */
class BelongingsValue extends AbstractHeritageDependent
{
    /**
     * @var Price
     */
    private $belongingsPrice;

    /**
     * @return Price
     */
    public function getBelongingsPrice()
    {
        if ($this->belongingsPrice === null) {
            $belongingsPrice = $this->calculatePrice($this->getValue());
            $this->belongingsPrice = new Price($belongingsPrice, Price::GOLD_COIN);
        }

        return $this->belongingsPrice;
    }

    private function calculatePrice($backgroundPoints)
    {
        switch ($backgroundPoints) {
            case 0 :
                return 1;
            case 1 :
                return 3;
            case 2 :
                return 10;
            case 3 :
                return 30;
            case 4 :
                return 100;
            case 5 :
                return 300;
            case 6 :
                return 1000;
            case 7 :
                return 3000;
            case 8 :
                return 10000;
            default :
                throw new Exceptions\UnexpectedBackgroundPoints(
                    "Expected background points from 0 to 8, got {$backgroundPoints}"
                );
        }
    }

}
