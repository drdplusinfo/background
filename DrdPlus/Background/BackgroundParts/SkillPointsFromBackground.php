<?php
namespace DrdPlus\Background\BackgroundParts;

use DrdPlus\Codes\History\ExceptionalityCode;
use DrdPlus\Codes\Skills\SkillTypeCode;
use DrdPlus\Background\BackgroundParts\Partials\AbstractAncestryDependent;
use DrdPlus\Professions\Profession;
use DrdPlus\Tables\Tables;
use Granam\Integer\PositiveInteger;

class SkillPointsFromBackground extends AbstractAncestryDependent
{
    /**
     * @param PositiveInteger $spentBackgroundPoints
     * @param Ancestry $ancestry
     * @param Tables $tables
     * @return SkillPointsFromBackground|AbstractAncestryDependent
     * @throws \DrdPlus\Background\Exceptions\TooMuchSpentBackgroundPoints
     */
    public static function getIt(PositiveInteger $spentBackgroundPoints, Ancestry $ancestry, Tables $tables): SkillPointsFromBackground
    {
        return self::createIt($spentBackgroundPoints, $ancestry, $tables);
    }

    /**
     * @return ExceptionalityCode
     */
    public static function getExceptionalityCode(): ExceptionalityCode
    {
        return ExceptionalityCode::getIt(ExceptionalityCode::SKILLS);
    }

    /**
     * @param Profession $profession
     * @param SkillTypeCode $skillTypeCode
     * @param Tables $tables
     * @return int
     */
    public function getSkillPoints(Profession $profession, SkillTypeCode $skillTypeCode, Tables $tables): int
    {
        /** @noinspection ExceptionsAnnotatingAndHandlingInspection */
        return $tables->getSkillsByBackgroundPointsTable()->getSkillPoints(
            $this->getSpentBackgroundPoints(),
            $profession->getCode(),
            $skillTypeCode
        );
    }

    /**
     * @param Profession $profession
     * @param Tables $tables
     * @return int
     */
    public function getPhysicalSkillPoints(Profession $profession, Tables $tables): int
    {
        return $this->getSkillPoints($profession, SkillTypeCode::getIt(SkillTypeCode::PHYSICAL), $tables);
    }

    /**
     * @param Profession $profession
     * @param Tables $tables
     * @return int
     */
    public function getPsychicalSkillPoints(Profession $profession, Tables $tables): int
    {
        return $this->getSkillPoints($profession, SkillTypeCode::getIt(SkillTypeCode::PSYCHICAL), $tables);
    }

    /**
     * @param Profession $profession
     * @param Tables $tables
     * @return int
     */
    public function getCombinedSkillPoints(Profession $profession, Tables $tables): int
    {
        return $this->getSkillPoints($profession, SkillTypeCode::getIt(SkillTypeCode::COMBINED), $tables);
    }
}