<?php
namespace DrdPlus\Person\Background\Parts;

use DrdPlus\Person\Background\BackgroundPoints;
use DrdPlus\Person\Background\Exceptions\UnexpectedBackgroundPoints;
use DrdPlus\Person\Background\Heritage;

abstract class AbstractHeritageDependent extends AbstractBackgroundAdvantage
{
    const MAX_POINTS_OVER_HERITAGE = 3;

    /**
     * @param BackgroundPoints $backgroundPoints
     * @param Heritage $heritage
     *
     * @return static
     */
    public static function getIt(BackgroundPoints $backgroundPoints, Heritage $heritage)
    {
        self::checkBackgroundPointsLimits($backgroundPoints);
        self::checkBackgroundPointsAgainstHeritage($backgroundPoints, $heritage);

        return self::getEnum($backgroundPoints->getValue());
    }

    protected static function checkBackgroundPointsAgainstHeritage(
        BackgroundPoints $points, Heritage $heritage
    )
    {
        if ($points->getValue() > ($heritage->getBackgroundPointsValue() + self::MAX_POINTS_OVER_HERITAGE)) {
            throw new UnexpectedBackgroundPoints(
                static::class . ' can not get more points then'
                . ' heritage background points + max used background points over those of heritage '
                . '(' . $heritage->getBackgroundPointsValue() . ' + ' . self::MAX_POINTS_OVER_HERITAGE . ')'
                . ' = ' . ($heritage->getBackgroundPointsValue() + self::MAX_POINTS_OVER_HERITAGE)
                . ', got ' . $points->getValue()
            );
        }
    }
}
