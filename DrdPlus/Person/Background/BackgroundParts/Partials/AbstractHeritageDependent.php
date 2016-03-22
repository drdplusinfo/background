<?php
namespace DrdPlus\Person\Background\BackgroundParts\Partials;

use DrdPlus\Person\Background\BackgroundParts\Heritage;
use Granam\Integer\Tools\ToInteger;

abstract class AbstractHeritageDependent extends AbstractBackgroundAdvantage
{
    const MAX_POINTS_OVER_HERITAGE = 3;

    /**
     * @param int $spentBackgroundPoints
     * @param Heritage $heritage
     *
     * @return AbstractHeritageDependent
     */
    public static function getIt($spentBackgroundPoints, Heritage $heritage)
    {
        $spentBackgroundPoints = ToInteger::toInteger($spentBackgroundPoints);
        self::checkBackgroundPointsLimits($spentBackgroundPoints);
        self::checkBackgroundPointsAgainstHeritage($spentBackgroundPoints, $heritage);

        return self::getEnum($spentBackgroundPoints);
    }

    protected static function checkBackgroundPointsAgainstHeritage(
        $spentBackgroundPoints, Heritage $heritage
    )
    {
        if ($spentBackgroundPoints > ($heritage->getSpentBackgroundPoints() + self::MAX_POINTS_OVER_HERITAGE)) {
            throw new Exceptions\TooMuchSpentBackgroundPoints(
                static::class . ' can not get more points than'
                . ' heritage background points + max used background points over those of heritage '
                . '(' . $heritage->getSpentBackgroundPoints() . ' + ' . self::MAX_POINTS_OVER_HERITAGE . ')'
                . ' = ' . ($heritage->getSpentBackgroundPoints() + self::MAX_POINTS_OVER_HERITAGE)
                . ', got ' . $spentBackgroundPoints
            );
        }
    }
}
