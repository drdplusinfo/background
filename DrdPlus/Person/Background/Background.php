<?php
namespace DrdPlus\Person\Background;

use Doctrine\ORM\Mapping as ORM;
use DrdPlus\Exceptionalities\Fates\ExceptionalityFate;
use DrdPlus\Person\Background\BackgroundParts\BackgroundSkillPoints;
use DrdPlus\Person\Background\BackgroundParts\BelongingsValue;
use DrdPlus\Person\Background\BackgroundParts\Heritage;
use Granam\Strict\Object\StrictObject;

/**
 * @ORM\Table()
 * @ORM\Entity()
 */
class Background extends StrictObject
{
    /**
     * @var BackgroundPoints
     * @ORM\Column(type="background_points")
     */
    private $backgroundPoints;

    /**
     * @var Heritage
     * @ORM\Column(type="heritage")
     */
    private $heritage;

    /**
     * @var BackgroundSkillPoints
     * @ORM\Column(type="background_skill_points")
     */
    private $backgroundSkillPoints;

    /**
     * @var BelongingsValue
     * @ORM\Column(type="belongings_value")
     */
    private $belongingsValue;

    /**
     * @param ExceptionalityFate $exceptionalityFate,
     * @param int $forHeritageSpentBackgroundPoints,
     * @param int $forBackgroundSkillPointsSpentBackgroundPoints
     * @param int $forBelongingsSpentBackgroundPoints
     * @return Background
     */
    public static function createIt(
        ExceptionalityFate $exceptionalityFate,
        $forHeritageSpentBackgroundPoints,
        $forBackgroundSkillPointsSpentBackgroundPoints,
        $forBelongingsSpentBackgroundPoints
    )
    {
        $backgroundPoints = BackgroundPoints::getIt($exceptionalityFate);
        $heritage = Heritage::getIt($forHeritageSpentBackgroundPoints);
        $backgroundSkillPoints = BackgroundSkillPoints::getIt($forBackgroundSkillPointsSpentBackgroundPoints, $heritage);
        $belongingsValue = BelongingsValue::getIt($forBelongingsSpentBackgroundPoints, $heritage);

        return new static($backgroundPoints, $heritage, $backgroundSkillPoints, $belongingsValue);
    }

    protected function __construct(
        BackgroundPoints $backgroundPoints,
        Heritage $heritage,
        BackgroundSkillPoints $backgroundSkillPoints,
        BelongingsValue $belongingsValue
    )
    {
        // TODO check sum of used background points
        $this->backgroundPoints = $backgroundPoints;
        $this->heritage = $heritage;
        $this->backgroundSkillPoints = $backgroundSkillPoints;
        $this->belongingsValue = $belongingsValue;
    }

    /**
     * @return BackgroundPoints
     */
    public function getBackgroundPoints()
    {
        return $this->backgroundPoints;
    }

    /**
     * @return Heritage
     */
    public function getHeritage()
    {
        return $this->heritage;
    }

    /**
     * @return BackgroundSkillPoints
     */
    public function getBackgroundSkillPoints()
    {
        return $this->backgroundSkillPoints;
    }

    /**
     * @return BelongingsValue
     */
    public function getBelongingsValue()
    {
        return $this->belongingsValue;
    }

}
