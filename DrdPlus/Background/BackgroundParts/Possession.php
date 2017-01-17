<?php
namespace DrdPlus\Background\BackgroundParts;

use DrdPlus\Codes\History\ExceptionalityCode;
use DrdPlus\Background\BackgroundParts\Partials\AbstractAncestryDependent;
use DrdPlus\Tables\History\AncestryTable;
use DrdPlus\Tables\History\BackgroundPointsDistributionTable;
use DrdPlus\Tables\History\PossessionTable;
use DrdPlus\Tables\Measurements\Price\Price;
use Granam\Integer\PositiveInteger;

class Possession extends AbstractAncestryDependent
{
    /**
     * @param PositiveInteger $spentBackgroundPoints
     * @param Ancestry $ancestry
     * @param AncestryTable $ancestryTable
     * @param BackgroundPointsDistributionTable $backgroundPointsDistributionTable
     * @return Possession|AbstractAncestryDependent
     * @throws \DrdPlus\Background\Exceptions\TooMuchSpentBackgroundPoints
     */
    public static function getIt(
        PositiveInteger $spentBackgroundPoints,
        Ancestry $ancestry,
        AncestryTable $ancestryTable,
        BackgroundPointsDistributionTable $backgroundPointsDistributionTable
    )
    {
        return self::createIt(
            $spentBackgroundPoints,
            $ancestry,
            $ancestryTable,
            $backgroundPointsDistributionTable
        );
    }

    /**
     * @return ExceptionalityCode
     */
    public static function getExceptionalityCode()
    {
        return ExceptionalityCode::getIt(ExceptionalityCode::POSSESSION);
    }

    /**
     * @var Price
     */
    private $belongingsPrice;

    /**
     * @param PossessionTable $possessionTable
     * @return Price
     */
    public function getPrice(PossessionTable $possessionTable)
    {
        if ($this->belongingsPrice === null) {
            /** @noinspection ExceptionsAnnotatingAndHandlingInspection */
            $priceValue = $possessionTable->getPossessionAsGoldCoins($this->getSpentBackgroundPoints());
            $this->belongingsPrice = new Price($priceValue, Price::GOLD_COIN);
        }

        return $this->belongingsPrice;
    }

}