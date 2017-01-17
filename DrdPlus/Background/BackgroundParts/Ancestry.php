<?php
namespace DrdPlus\Background\BackgroundParts;

use DrdPlus\Codes\History\AncestryCode;
use DrdPlus\Codes\History\ExceptionalityCode;
use DrdPlus\Background\BackgroundParts\Partials\AbstractBackgroundAdvantage;
use DrdPlus\Background\Exceptions\TooMuchSpentBackgroundPoints;
use DrdPlus\Tables\History\AncestryTable;
use Granam\Integer\PositiveInteger;

class Ancestry extends AbstractBackgroundAdvantage
{
    /**
     * @param PositiveInteger $spentBackgroundPoints
     * @param AncestryTable $ancestryTable
     * @return Ancestry|\Doctrineum\Integer\IntegerEnum
     * @throws \DrdPlus\Background\Exceptions\TooMuchSpentBackgroundPoints
     */
    public static function getIt(PositiveInteger $spentBackgroundPoints, AncestryTable $ancestryTable)
    {
        try {
            $ancestryTable->getAncestryCodeByBackgroundPoints($spentBackgroundPoints);
        } catch (\DrdPlus\Tables\History\Exceptions\UnexpectedBackgroundPoints $unexpectedBackgroundPoints) {
            throw new TooMuchSpentBackgroundPoints($unexpectedBackgroundPoints->getMessage());
        }

        return self::getEnum($spentBackgroundPoints);
    }

    /**
     * @return ExceptionalityCode
     */
    public static function getExceptionalityCode()
    {
        return ExceptionalityCode::getIt(ExceptionalityCode::ANCESTRY);
    }

    /**
     * @param AncestryTable $ancestryTable
     * @return AncestryCode
     */
    public function getAncestryCode(AncestryTable $ancestryTable)
    {
        /** @noinspection ExceptionsAnnotatingAndHandlingInspection */
        return $ancestryTable->getAncestryCodeByBackgroundPoints($this->getSpentBackgroundPoints());
    }
}