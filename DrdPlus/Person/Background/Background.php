<?php
namespace DrdPlus\Person\Background;

use Doctrine\ORM\Mapping as ORM;
use Doctrineum\Entity\Entity;
use DrdPlus\Codes\PlayerDecisionCode;
use DrdPlus\Person\Background\BackgroundParts\BackgroundSkillPoints;
use DrdPlus\Person\Background\BackgroundParts\BelongingsValue;
use DrdPlus\Person\Background\BackgroundParts\Heritage;
use DrdPlus\Tables\History\BackgroundPointsTable;
use Granam\Strict\Object\StrictObject;

/**
 * @ORM\Entity()
 */
class Background extends StrictObject implements Entity
{
    /**
     * @var int
     * @ORM\Id()
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue()
     */
    private $id;
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
     * @param PlayerDecisionCode $playerDecisionCode
     * @param BackgroundPointsTable $backgroundPointsTable
     * @param int $forHeritageSpentBackgroundPoints
     * @param int $forBackgroundSkillPointsSpentBackgroundPoints
     * @param int $forBelongingsSpentBackgroundPoints
     * @return Background
     */
    public static function createIt(
        PlayerDecisionCode $playerDecisionCode,
        BackgroundPointsTable $backgroundPointsTable,
        $forHeritageSpentBackgroundPoints,
        $forBackgroundSkillPointsSpentBackgroundPoints,
        $forBelongingsSpentBackgroundPoints
    )
    {
        $backgroundPoints = BackgroundPoints::getIt($playerDecisionCode, $backgroundPointsTable);
        $heritage = Heritage::getIt($forHeritageSpentBackgroundPoints);
        $backgroundSkillPoints = BackgroundSkillPoints::getIt($forBackgroundSkillPointsSpentBackgroundPoints, $heritage);
        $belongingsValue = BelongingsValue::getIt($forBelongingsSpentBackgroundPoints, $heritage);

        return new static($backgroundPoints, $heritage, $backgroundSkillPoints, $belongingsValue);
    }

    private function __construct(
        BackgroundPoints $backgroundPoints,
        Heritage $heritage,
        BackgroundSkillPoints $backgroundSkillPoints,
        BelongingsValue $belongingsValue
    )
    {
        $this->checkSumOfSpentBackgroundPoints($backgroundPoints, $heritage, $backgroundSkillPoints, $belongingsValue);
        $this->backgroundPoints = $backgroundPoints;
        $this->heritage = $heritage;
        $this->backgroundSkillPoints = $backgroundSkillPoints;
        $this->belongingsValue = $belongingsValue;
    }

    private function checkSumOfSpentBackgroundPoints(
        BackgroundPoints $backgroundPoints,
        Heritage $heritage,
        BackgroundSkillPoints $backgroundSkillPoints,
        BelongingsValue $belongingsValue
    )
    {
        $sumOfSpentBackgroundPoints = $this->sumSpentPoints($heritage, $backgroundSkillPoints, $belongingsValue);
        if ($sumOfSpentBackgroundPoints > $backgroundPoints->getValue()) {
            throw new Exceptions\SpentTooMuchBackgroundPoints(
                "Available background points are {$backgroundPoints->getValue()},"
                . " sum of spent background points is {$sumOfSpentBackgroundPoints}"
            );
        }
    }

    private function sumSpentPoints(
        Heritage $heritage,
        BackgroundSkillPoints $backgroundSkillPoints,
        BelongingsValue $belongingsValue
    )
    {
        return $heritage->getSpentBackgroundPoints() + $backgroundSkillPoints->getSpentBackgroundPoints()
            + $belongingsValue->getSpentBackgroundPoints();
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
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

    /**
     * @return int
     */
    public function getRemainingBackgroundPoints()
    {
        return $this->getBackgroundPoints()->getValue() - $this->sumSpentPoints(
                $this->getHeritage(), $this->getBackgroundSkillPoints(), $this->getBelongingsValue()
            );
    }

}