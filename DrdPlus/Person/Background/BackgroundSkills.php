<?php
namespace DrdPlus\Person\Background;
use DrdPlus\Person\Background\Parts\AbstractHeritageDependent;
use DrdPlus\Tables\Tables;

/**
 * @method static BackgroundSkills getIt(BackgroundPoints $backgroundPoints, Heritage $heritage)
 */
class BackgroundSkills extends AbstractHeritageDependent
{
    const BACKGROUND_SKILLS = 'background_skills';

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
