<?php
namespace DrdPlus\Person\Background\BackgroundParts;

use Doctrineum\Integer\IntegerEnum;
use DrdPlus\Person\Background\BackgroundParts\Partials\AbstractBackgroundAdvantage;

class Ancestry extends AbstractBackgroundAdvantage
{
    /**
     * @param int $spentBackgroundPoints

     * @return Ancestry|IntegerEnum
     */
    public static function getIt($spentBackgroundPoints)
    {
        static::checkSpentBackgroundPointsLimits($spentBackgroundPoints);

        return self::getEnum($spentBackgroundPoints);
    }

    const FOUNDLING = 'foundling';
    const ORPHAN = 'orphan';
    const FROM_INCOMPLETE_FAMILY = 'from_incomplete_family';
    const FROM_DOUBTFULLY_FAMILY = 'from_doubtfully_family';
    const FROM_MODEST_FAMILY = 'from_modest_family';
    const FROM_WEALTHY_FAMILY = 'from_wealthy_family';
    const FROM_WEALTHY_AND_INFLUENTIAL_FAMILY = 'from_wealthy_and_influential_family';
    const NOBLE = 'noble';
    const NOBLE_FROM_POWERFUL_FAMILY = 'noble_from_powerful_family';

    /**
     * @return string
     * @throws \DrdPlus\Person\Background\BackgroundParts\Exceptions\UnexpectedBackgroundPoints
     */
    public function getHeritageName()
    {
        switch ($this->getSpentBackgroundPoints()) {
            case 0 :
                return self::FOUNDLING;
            case 1 :
                return self::ORPHAN;
            case 2:
                return self::FROM_INCOMPLETE_FAMILY;
            case 3:
                return self::FROM_DOUBTFULLY_FAMILY;
            case 4:
                return self::FROM_MODEST_FAMILY;
            case 5:
                return self::FROM_WEALTHY_FAMILY;
            case 6:
                return self::FROM_WEALTHY_AND_INFLUENTIAL_FAMILY;
            case 7:
                return self::NOBLE;
            case 8:
                return self::NOBLE_FROM_POWERFUL_FAMILY;
            default :
                throw new Exceptions\UnexpectedBackgroundPoints(
                    "Unexpected background points for heritage: {$this->getSpentBackgroundPoints()}"
                );
        }
    }
}