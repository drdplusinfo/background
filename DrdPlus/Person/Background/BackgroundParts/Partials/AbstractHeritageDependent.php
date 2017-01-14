<?php
namespace DrdPlus\Person\Background\BackgroundParts\Partials;

use DrdPlus\Person\Background\BackgroundParts\Ancestry;
use Granam\Integer\Tools\ToInteger;

abstract class AbstractHeritageDependent extends AbstractBackgroundAdvantage
{
    const MAX_POINTS_OVER_HERITAGE = 3;

    /**
     * @param int $spentBackgroundPoints
     * @param Ancestry $ancestry
     * @return AbstractHeritageDependent|\Doctrineum\Integer\IntegerEnum
     * @throws \Granam\Integer\Tools\Exceptions\Runtime
     */
    public static function getIt($spentBackgroundPoints, Ancestry $ancestry)
    {
        $spentBackgroundPoints = ToInteger::toInteger($spentBackgroundPoints);
        self::checkSpentBackgroundPointsLimits($spentBackgroundPoints);
        self::checkBackgroundPointsAgainstHeritage($spentBackgroundPoints, $ancestry);

        return self::getEnum($spentBackgroundPoints);
    }

    protected static function checkBackgroundPointsAgainstHeritage(
        $spentBackgroundPoints, Ancestry $ancestry
    )
    {
        if ($spentBackgroundPoints > ($ancestry->getSpentBackgroundPoints() + self::MAX_POINTS_OVER_HERITAGE)) {
            throw new Exceptions\TooMuchSpentBackgroundPoints(
                static::class . ' can not get more points than'
                . ' heritage background points + max used background points over those of heritage '
                . '(' . $ancestry->getSpentBackgroundPoints() . ' + ' . self::MAX_POINTS_OVER_HERITAGE . ')'
                . ' = ' . ($ancestry->getSpentBackgroundPoints() + self::MAX_POINTS_OVER_HERITAGE)
                . ', got ' . $spentBackgroundPoints
            );
        }
    }
}