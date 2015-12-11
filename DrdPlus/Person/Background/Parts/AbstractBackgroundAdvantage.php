<?php
namespace DrdPlus\Person\Background\Parts;

use Doctrineum\Integer\IntegerEnum;
use DrdPlus\Person\Background\BackgroundPoints;
use DrdPlus\Person\Background\Exceptions\UnexpectedBackgroundPoints;

abstract class AbstractBackgroundAdvantage extends IntegerEnum
{

    const MIN_BACKGROUND_POINTS = 0;
    const MAX_BACKGROUND_POINTS = 8;

    protected static function checkBackgroundPointsLimits(BackgroundPoints $backgroundPoints)
    {
        if ($backgroundPoints->getValue() < self::MIN_BACKGROUND_POINTS
            || $backgroundPoints->getValue() > self::MAX_BACKGROUND_POINTS
        ) {
            throw new UnexpectedBackgroundPoints(
                'Background points has to be between ' . self::MIN_BACKGROUND_POINTS . ' and '
                . self::MAX_BACKGROUND_POINTS . ", got {$backgroundPoints->getValue()}"
            );
        }
    }

    /**
     * @return int
     */
    public function getBackgroundPointsValue()
    {
        return $this->getValue();
    }
}
