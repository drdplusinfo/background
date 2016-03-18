<?php
namespace DrdPlus\Person\Background;

use Doctrine\ORM\Mapping as ORM;
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
     * @param BackgroundPoints $backgroundPoints
     * @return Background
     */
    public static function createIt(BackgroundPoints $backgroundPoints)
    {
        $heritage = Heritage::getIt($backgroundPoints);
        $backgroundSkillPoints = BackgroundSkillPoints::getIt($backgroundPoints, $heritage);
        $belongingsValue = BelongingsValue::getIt($backgroundPoints, $heritage);

        return new static($backgroundPoints, $heritage, $backgroundSkillPoints, $belongingsValue);
    }

    protected function __construct(
        BackgroundPoints $backgroundPoints,
        Heritage $heritage,
        BackgroundSkillPoints $backgroundSkillPoints,
        BelongingsValue $belongingsValue
    )
    {
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
