<?php
namespace DrdPlus\Background;

use Doctrineum\Integer\IntegerEnum;
use DrdPlus\Codes\History\FateCode;
use DrdPlus\Tables\Tables;

class BackgroundPoints extends IntegerEnum
{
    /**
     * @param FateCode $fateCode
     * @param Tables $tables
     * @return BackgroundPoints|IntegerEnum
     */
    public static function getIt(FateCode $fateCode, Tables $tables)
    {
        /** @noinspection ExceptionsAnnotatingAndHandlingInspection */
        return static::getEnum($tables->getBackgroundPointsTable()->getBackgroundPointsByPlayerDecision($fateCode));
    }
}