<?php
namespace DrdPlus\Person\Background\BackgroundParts\Partials;

use Doctrineum\Integer\IntegerEnum;
use DrdPlus\Person\Background\BackgroundParts\Exceptions\UnexpectedBackgroundPoints;
use Granam\Integer\Tools\ToInteger;

abstract class AbstractBackgroundAdvantage extends IntegerEnum
{

    const MIN_BACKGROUND_POINTS = 0;
    const MAX_BACKGROUND_POINTS = 8;

    protected static function checkBackgroundPointsLimits($backgroundPoints)
    {
        $backgroundPoints = ToInteger::toInteger($backgroundPoints);
        if ($backgroundPoints < self::MIN_BACKGROUND_POINTS
            || $backgroundPoints > self::MAX_BACKGROUND_POINTS
        ) {
            throw new UnexpectedBackgroundPoints(
                'Background points has to be between ' . self::MIN_BACKGROUND_POINTS . ' and '
                . self::MAX_BACKGROUND_POINTS . ", got {$backgroundPoints}"
            );
        }
    }

    /**
     * Spent background points are the same as advantage level.
     *
     * @return int
     */
    public function getSpentBackgroundPoints()
    {
        return $this->getValue();
    }
}
