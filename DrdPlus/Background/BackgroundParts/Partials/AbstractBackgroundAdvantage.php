<?php
namespace DrdPlus\Background\BackgroundParts\Partials;

use Doctrineum\Integer\IntegerEnum;
use DrdPlus\Codes\History\ExceptionalityCode;
use Granam\Integer\PositiveIntegerObject;

abstract class AbstractBackgroundAdvantage extends IntegerEnum
{
    /**
     * @return ExceptionalityCode
     * @throws \DrdPlus\Background\BackgroundParts\Partials\Exceptions\UnknownExceptionality
     */
    public static function getExceptionalityCode(): ExceptionalityCode
    {
        throw new Exceptions\UnknownExceptionality(
            'Exceptionality code is not known for ' . static::class
            . ' (have you forgot to overwrite method ' . __METHOD__ . ' ?)'
        );
    }

    private $spentBackgroundPoints;

    /**
     * Spent background points are the same as advantage level.
     *
     * @return PositiveIntegerObject
     */
    public function getSpentBackgroundPoints(): PositiveIntegerObject
    {
        if ($this->spentBackgroundPoints === null) {
            /** @noinspection ExceptionsAnnotatingAndHandlingInspection */
            $this->spentBackgroundPoints = new PositiveIntegerObject($this->getValue());
        }

        return $this->spentBackgroundPoints;
    }

}