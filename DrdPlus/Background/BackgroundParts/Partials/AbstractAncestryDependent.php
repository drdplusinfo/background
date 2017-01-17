<?php
namespace DrdPlus\Background\BackgroundParts\Partials;

use DrdPlus\Background\BackgroundParts\Ancestry;
use DrdPlus\Background\Exceptions\TooMuchSpentBackgroundPoints;
use DrdPlus\Tables\History\AncestryTable;
use DrdPlus\Tables\History\BackgroundPointsDistributionTable;
use Granam\Integer\PositiveInteger;

abstract class AbstractAncestryDependent extends AbstractBackgroundAdvantage
{
    /**
     * @param PositiveInteger $spentBackgroundPoints
     * @param Ancestry $ancestry
     * @param AncestryTable $ancestryTable
     * @param BackgroundPointsDistributionTable $backgroundPointsDistributionTable
     * @return AbstractAncestryDependent|\Doctrineum\Integer\IntegerEnum
     * @throws \DrdPlus\Background\Exceptions\TooMuchSpentBackgroundPoints
     */
    protected static function createIt(
        PositiveInteger $spentBackgroundPoints,
        Ancestry $ancestry,
        AncestryTable $ancestryTable,
        BackgroundPointsDistributionTable $backgroundPointsDistributionTable
    )
    {
        /** @noinspection ExceptionsAnnotatingAndHandlingInspection */
        $maxPointsToDistribute = $backgroundPointsDistributionTable->getMaxPointsToDistribute(
            static::getExceptionalityCode(),
            $ancestryTable,
            $ancestry->getAncestryCode($ancestryTable)
        );
        if ($maxPointsToDistribute < $spentBackgroundPoints->getValue()) {
            throw new TooMuchSpentBackgroundPoints(
                static::class . " can not use more points than $maxPointsToDistribute"
                . ' (' . ($maxPointsToDistribute - $ancestry->getSpentBackgroundPoints()->getValue()) . ' more than ancestry)'
                . ', got ' . $spentBackgroundPoints
            );
        }

        return self::getEnum($spentBackgroundPoints);
    }
}