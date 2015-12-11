<?php
namespace DrdPlus\Person\Background;
use DrdPlus\Person\Background\Parts\AbstractHeritageDependent;

/**
 * @method static BackgroundSkills getIt(BackgroundPoints $backgroundPoints, Heritage $heritage)
 */
class BackgroundSkills extends AbstractHeritageDependent
{
    const BACKGROUND_SKILLS = 'background_skills';
}
