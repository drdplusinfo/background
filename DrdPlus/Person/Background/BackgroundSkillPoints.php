<?php
namespace DrdPlus\Person\Background;
use DrdPlus\Person\Background\Parts\AbstractHeritageDependent;
use DrdPlus\Tables\Tables;

/**
 * @method static BackgroundSkillPoints getIt(BackgroundPoints $backgroundPoints, Heritage $heritage)
 */
class BackgroundSkillPoints extends AbstractHeritageDependent
{
    const BACKGROUND_SKILL_POINTS = 'background_skill_POINTS';

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
}
