<?php
namespace DrdPlus\Background\BackgroundParts;

use DrdPlus\Codes\History\ExceptionalityCode;
use DrdPlus\Codes\Skills\SkillTypeCode;
use DrdPlus\Background\BackgroundParts\Partials\AbstractAncestryDependent;
use DrdPlus\Professions\Profession;
use DrdPlus\Tables\History\AncestryTable;
use DrdPlus\Tables\History\BackgroundPointsDistributionTable;
use DrdPlus\Tables\History\SkillsByBackgroundPointsTable;
use Granam\Integer\PositiveInteger;

class SkillsFromBackground extends AbstractAncestryDependent
{
    /**
     * @param PositiveInteger $spentBackgroundPoints
     * @param Ancestry $ancestry
     * @param AncestryTable $ancestryTable
     * @param BackgroundPointsDistributionTable $backgroundPointsDistributionTable
     * @return SkillsFromBackground|AbstractAncestryDependent
     * @throws \DrdPlus\Background\Exceptions\TooMuchSpentBackgroundPoints
     */
    public static function getIt(
        PositiveInteger $spentBackgroundPoints,
        Ancestry $ancestry,
        AncestryTable $ancestryTable,
        BackgroundPointsDistributionTable $backgroundPointsDistributionTable
    )
    {
        return self::createIt(
            $spentBackgroundPoints,
            $ancestry,
            $ancestryTable,
            $backgroundPointsDistributionTable
        );
    }

    /**
     * @return ExceptionalityCode
     */
    public static function getExceptionalityCode()
    {
        return ExceptionalityCode::getIt(ExceptionalityCode::SKILLS);
    }

    /**
     * @param Profession $profession
     * @param SkillTypeCode $skillTypeCode
     * @param SkillsByBackgroundPointsTable $skillsByBackgroundPointsTable
     * @return int
     */
    public function getSkillPoints(
        Profession $profession,
        SkillTypeCode $skillTypeCode,
        SkillsByBackgroundPointsTable $skillsByBackgroundPointsTable
    )
    {
        /** @noinspection ExceptionsAnnotatingAndHandlingInspection */
        return $skillsByBackgroundPointsTable->getSkillPoints(
            $this->getSpentBackgroundPoints(),
            $profession->getCode(),
            $skillTypeCode
        );
    }

    /**
     * @param Profession $profession
     * @param SkillsByBackgroundPointsTable $skillsByBackgroundPointsTable
     * @return int
     */
    public function getPhysicalSkillPoints(Profession $profession, SkillsByBackgroundPointsTable $skillsByBackgroundPointsTable)
    {
        return $this->getSkillPoints($profession, SkillTypeCode::getIt(SkillTypeCode::PHYSICAL), $skillsByBackgroundPointsTable);
    }

    /**
     * @param Profession $profession
     * @param SkillsByBackgroundPointsTable $skillsByBackgroundPointsTable
     * @return int
     */
    public function getPsychicalSkillPoints(Profession $profession, SkillsByBackgroundPointsTable $skillsByBackgroundPointsTable)
    {
        return $this->getSkillPoints($profession, SkillTypeCode::getIt(SkillTypeCode::PSYCHICAL), $skillsByBackgroundPointsTable);
    }

    /**
     * @param Profession $profession
     * @param SkillsByBackgroundPointsTable $skillsByBackgroundPointsTable
     * @return int
     */
    public function getCombinedSkillPoints(Profession $profession, SkillsByBackgroundPointsTable $skillsByBackgroundPointsTable)
    {
        return $this->getSkillPoints($profession, SkillTypeCode::getIt(SkillTypeCode::COMBINED), $skillsByBackgroundPointsTable);
    }
}