<?php
namespace DrdPlus\Background\BackgroundParts;

use DrdPlus\Codes\History\AncestryCode;
use DrdPlus\Codes\History\ExceptionalityCode;
use DrdPlus\Background\BackgroundParts\Partials\AbstractBackgroundAdvantage;
use DrdPlus\Background\Exceptions\TooMuchSpentBackgroundPoints;
use DrdPlus\Tables\History\Exceptions\UnexpectedBackgroundPoints;
use DrdPlus\Tables\Tables;
use Granam\Integer\PositiveInteger;

class Ancestry extends AbstractBackgroundAdvantage
{
    /**
     * @param PositiveInteger $spentBackgroundPoints
     * @param Tables $tables
     * @return Ancestry|\Doctrineum\Integer\IntegerEnum
     * @throws \DrdPlus\Background\Exceptions\TooMuchSpentBackgroundPoints
     */
    public static function getIt(PositiveInteger $spentBackgroundPoints, Tables $tables)
    {
        try {
            $tables->getAncestryTable()->getAncestryCodeByBackgroundPoints($spentBackgroundPoints);
        } catch (UnexpectedBackgroundPoints $unexpectedBackgroundPoints) {
            throw new TooMuchSpentBackgroundPoints($unexpectedBackgroundPoints->getMessage());
        }

        return self::getEnum($spentBackgroundPoints);
    }

    /**
     * @return ExceptionalityCode
     */
    public static function getExceptionalityCode(): ExceptionalityCode
    {
        return ExceptionalityCode::getIt(ExceptionalityCode::ANCESTRY);
    }

    /**
     * @param Tables $tables
     * @return AncestryCode
     */
    public function getAncestryCode(Tables $tables): AncestryCode
    {
        /** @noinspection ExceptionsAnnotatingAndHandlingInspection */
        return $tables->getAncestryTable()->getAncestryCodeByBackgroundPoints($this->getSpentBackgroundPoints());
    }
}