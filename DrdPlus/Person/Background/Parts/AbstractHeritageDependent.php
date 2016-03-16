<?php
namespace DrdPlus\Person\Background\Parts;

use DrdPlus\Person\Background\BackgroundPoints;

abstract class AbstractHeritageDependent extends AbstractBackgroundAdvantage
{
    /**
     * @param BackgroundPoints $backgroundPoints
     *
     * @return static
     */
    public static function getIt(BackgroundPoints $backgroundPoints)
    {
        self::checkBackgroundPointsLimits($backgroundPoints);

        return self::getEnum($backgroundPoints->getValue());
    }
}
