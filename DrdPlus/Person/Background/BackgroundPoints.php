<?php
namespace DrdPlus\Person\Background;

use Doctrineum\Integer\IntegerEnum;
use DrdPlus\Codes\PlayerDecisionCode;
use DrdPlus\Tables\History\BackgroundPointsTable;

class BackgroundPoints extends IntegerEnum
{
    /**
     * @param PlayerDecisionCode $playerDecisionCode
     * @param BackgroundPointsTable $backgroundPointsTable
     * @return BackgroundPoints|IntegerEnum
     */
    public static function getIt(PlayerDecisionCode $playerDecisionCode, BackgroundPointsTable $backgroundPointsTable)
    {
        /** @noinspection ExceptionsAnnotatingAndHandlingInspection */
        return static::getEnum($backgroundPointsTable->getBackgroundPointsByPlayerDecision($playerDecisionCode));
    }
}