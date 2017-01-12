<?php
namespace DrdPlus\Person\Background;

use Doctrineum\Integer\IntegerEnum;
use DrdPlus\Codes\FateCode;
use DrdPlus\Tables\History\BackgroundPointsTable;

class BackgroundPoints extends IntegerEnum
{
    /**
     * @param FateCode $playerDecisionCode
     * @param BackgroundPointsTable $backgroundPointsTable
     * @return BackgroundPoints|IntegerEnum
     */
    public static function getIt(FateCode $playerDecisionCode, BackgroundPointsTable $backgroundPointsTable)
    {
        /** @noinspection ExceptionsAnnotatingAndHandlingInspection */
        return static::getEnum($backgroundPointsTable->getBackgroundPointsByPlayerDecision($playerDecisionCode));
    }
}