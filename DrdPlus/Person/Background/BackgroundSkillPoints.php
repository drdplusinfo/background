<?php
namespace DrdPlus\Person\Background;

use DrdPlus\Codes\SkillCodes;
use DrdPlus\Person\Background\Parts\AbstractHeritageDependent;
use DrdPlus\Tables\Tables;

/**
 * @method static BackgroundSkillPoints getIt(BackgroundPoints $backgroundPoints, Heritage $heritage)
 */
class BackgroundSkillPoints extends AbstractHeritageDependent
{
    const BACKGROUND_SKILL_POINTS = 'background_skill_points';

    /**
     * @param string $professionName
     * @param string $skillType
     * @param Tables $tables
     * @return int
     */
    public function getSkillPoints($professionName, $skillType, Tables $tables)
    {
        return $tables->getBackgroundSkillsTable()->getSkillPoints(
            $this->getBackgroundPointsValue(),
            $professionName,
            $skillType
        );
    }

    /**
     * @param string $professionName
     * @param Tables $tables
     * @return int
     */
    public function getPhysicalSkillPoints($professionName, Tables $tables)
    {
        return $this->getSkillPoints($professionName, SkillCodes::PHYSICAL, $tables);
    }
    /**
     * @param string $professionName
     * @param Tables $tables
     * @return int
     */
    public function getPsychicalSkillPoints($professionName, Tables $tables)
    {
        return $this->getSkillPoints($professionName, SkillCodes::PSYCHICAL, $tables);
    }

    /**
     * @param string $professionName
     * @param Tables $tables
     * @return int
     */
    public function getCombinedSkillPoints($professionName, Tables $tables)
    {
        return $this->getSkillPoints($professionName, SkillCodes::COMBINED, $tables);
    }
}
