<?php
namespace DrdPlus\Person\Background;

use Doctrineum\Integer\IntegerEnum;
use DrdPlus\Codes\FateCode;
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
        return static::getEnum($backgroundPointsTable->getBackgroundPointsByFate($fateCode));
    }
}