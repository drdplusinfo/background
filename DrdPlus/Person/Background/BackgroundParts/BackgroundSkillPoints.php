<?php
namespace DrdPlus\Person\Background\BackgroundParts;

use DrdPlus\Codes\SkillTypeCode;
use DrdPlus\Person\Background\BackgroundParts\Partials\AbstractHeritageDependent;
use DrdPlus\Professions\Profession;
use DrdPlus\Tables\Tables;

/**
 * @method static BackgroundSkillPoints getIt($spentBackgroundPoints, Heritage $heritage)
 */
class BackgroundSkillPoints extends AbstractHeritageDependent
{
    /**
     * @param Profession $profession
     * @param string $skillType
     * @param Tables $tables
     * @return int
     */
    public function getSkillPoints(Profession $profession, $skillType, Tables $tables)
    {
        return $tables->getBackgroundSkillsTable()->getSkillPoints(
            $this->getSpentBackgroundPoints(),
            $profession->getValue(),
            $skillType
        );
    }

    /**
     * @param Profession $profession
     * @param Tables $tables
     * @return int
     */
    public function getPhysicalSkillPoints(Profession $profession, Tables $tables)
    {
        return $this->getSkillPoints($profession, SkillTypeCode::PHYSICAL, $tables);
    }
    /**
     * @param Profession $profession
     * @param Tables $tables
     * @return int
     */
    public function getPsychicalSkillPoints(Profession $profession, Tables $tables)
    {
        return $this->getSkillPoints($profession, SkillTypeCode::PSYCHICAL, $tables);
    }

    /**
     * @param Profession $profession
     * @param Tables $tables
     * @return int
     */
    public function getCombinedSkillPoints(Profession $profession, Tables $tables)
    {
        return $this->getSkillPoints($profession, SkillTypeCode::COMBINED, $tables);
    }
}
