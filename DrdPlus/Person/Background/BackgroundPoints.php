<?php
namespace DrdPlus\Person\Background;

use Doctrineum\Integer\IntegerEnum;
use DrdPlus\Exceptionalities\Fates\ExceptionalityFate;
use DrdPlus\Exceptionalities\Fates\FateOfCombination;
use DrdPlus\Exceptionalities\Fates\FateOfExceptionalProperties;
use DrdPlus\Exceptionalities\Fates\FateOfGoodRear;

class BackgroundPoints extends IntegerEnum
{
    const BACKGROUND_POINTS = 'background_points';

    /**
     * @param ExceptionalityFate $fate
     * @return BackgroundPoints
     */
    public static function getIt(ExceptionalityFate $fate)
    {
        $backgroundPoints = static::determinePoints($fate);

        return static::getEnum($backgroundPoints);
    }

    const BACKGROUND_POINTS_FOR_FATE_OF_EXCEPTIONAL_PROPERTIES = 5;
    const BACKGROUND_POINTS_FOR_FATE_OF_COMBINATION = 10;
    const BACKGROUND_POINTS_FOR_FATE_OF_GOOD_REAR = 15;

    private static function determinePoints(ExceptionalityFate $fate)
    {
        switch ($fate::getCode()) {
            case FateOfExceptionalProperties::FATE_OF_EXCEPTIONAL_PROPERTIES :
                return self::BACKGROUND_POINTS_FOR_FATE_OF_EXCEPTIONAL_PROPERTIES;
            case FateOfCombination::FATE_OF_COMBINATION :
                return self::BACKGROUND_POINTS_FOR_FATE_OF_COMBINATION;
            case FateOfGoodRear::FATE_OF_GOOD_REAR :
                return self::BACKGROUND_POINTS_FOR_FATE_OF_GOOD_REAR;
            default :
                throw new Exceptions\UnknownFate("Unknown fate {$fate}");
        }
    }
}
