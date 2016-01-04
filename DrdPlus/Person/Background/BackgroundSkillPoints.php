<?php
namespace DrdPlus\Person\Background;

use DrdPlus\Codes\SkillCodes;
use DrdPlus\Person\Background\Parts\AbstractHeritageDependent;
use DrdPlus\Professions\Profession;
use DrdPlus\Tables\Tables;

/**
 * @method static BackgroundSkillPoints getIt(BackgroundPoints $backgroundPoints, Heritage $heritage)
 */
class BackgroundSkillPoints extends AbstractHeritageDependent
{
    const BACKGROUND_SKILL_POINTS = 'background_skill_points';

    /**
     * @param Profession $profession
     * @param string $skillType
     * @param Tables $tables
     * @return int
     */
    public function getSkillPoints(Profession $profession, $skillType, Tables $tables)
    {
        return $tables->getBackgroundSkillsTable()->getSkillPoints(
            $this->getBackgroundPointsValue(),
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
        return $this->getSkillPoints($profession, SkillCodes::PHYSICAL, $tables);
    }
    /**
     * @param Profession $profession
     * @param Tables $tables
     * @return int
     */
    public function getPsychicalSkillPoints(Profession $profession, Tables $tables)
    {
        return $this->getSkillPoints($profession, SkillCodes::PSYCHICAL, $tables);
    }

    /**
     * @param Profession $profession
     * @param Tables $tables
     * @return int
     */
    public function getCombinedSkillPoints(Profession $profession, Tables $tables)
    {
        return $this->getSkillPoints($profession, SkillCodes::COMBINED, $tables);
    }
}
