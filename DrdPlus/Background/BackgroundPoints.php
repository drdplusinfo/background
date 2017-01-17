<?php
namespace DrdPlus\Background;

use Doctrineum\Integer\IntegerEnum;
use DrdPlus\Codes\History\FateCode;
use DrdPlus\Tables\History\BackgroundPointsTable;

class BackgroundPoints extends IntegerEnum
{
    /**
     * @param FateCode $fateCode
     * @param BackgroundPointsTable $backgroundPointsTable
     * @return BackgroundPoints|IntegerEnum
     */
    public static function getIt(FateCode $fateCode, BackgroundPointsTable $backgroundPointsTable)
    {
        /** @noinspection ExceptionsAnnotatingAndHandlingInspection */
        return static::getEnum($backgroundPointsTable->getBackgroundPointsByPlayerDecision($fateCode));
    }
}