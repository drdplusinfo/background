<?php
namespace DrdPlus\Person\Background;

use Doctrine\ORM\Mapping as ORM;
use Doctrineum\Entity\Entity;
use DrdPlus\Codes\History\FateCode;
use DrdPlus\Person\Background\BackgroundParts\BackgroundSkillPoints;
use DrdPlus\Person\Background\BackgroundParts\PossessionValue;
use DrdPlus\Person\Background\BackgroundParts\Ancestry;
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
     * @var Ancestry
     * @ORM\Column(type="ancestry")
     */
    private $ancestry;

    /**
     * @var BackgroundSkillPoints
     * @ORM\Column(type="background_skill_points")
     */
    private $backgroundSkillPoints;

    /**
     * @var PossessionValue
     * @ORM\Column(type="possession_value")
     */
    private $possessionValue;

    /**
     * @param FateCode $fateCode
     * @param BackgroundPointsTable $backgroundPointsTable
     * @param int $forAncestrySpentBackgroundPoints
     * @param int $forPossessionSpentBackgroundPoints
     * @param int $forBackgroundSkillPointsSpentBackgroundPoints
     * @return Background
     */
    public static function createIt(
        FateCode $fateCode,
        BackgroundPointsTable $backgroundPointsTable,
        $forAncestrySpentBackgroundPoints,
        $forPossessionSpentBackgroundPoints,
        $forBackgroundSkillPointsSpentBackgroundPoints
    )
    {
        $backgroundPoints = BackgroundPoints::getIt($fateCode, $backgroundPointsTable);
        $ancestry = Ancestry::getIt($forAncestrySpentBackgroundPoints);
        $backgroundSkillPoints = BackgroundSkillPoints::getIt($forBackgroundSkillPointsSpentBackgroundPoints, $ancestry);
        $possessionValue = PossessionValue::getIt($forPossessionSpentBackgroundPoints, $ancestry);

        return new static($backgroundPoints, $ancestry, $backgroundSkillPoints, $possessionValue);
    }

    private function __construct(
        BackgroundPoints $backgroundPoints,
        Ancestry $ancestry,
        BackgroundSkillPoints $backgroundSkillPoints,
        PossessionValue $possessionValue
    )
    {
        $this->checkSumOfSpentBackgroundPoints($backgroundPoints, $ancestry, $backgroundSkillPoints, $possessionValue);
        $this->backgroundPoints = $backgroundPoints;
        $this->ancestry = $ancestry;
        $this->backgroundSkillPoints = $backgroundSkillPoints;
        $this->possessionValue = $possessionValue;
    }

    private function checkSumOfSpentBackgroundPoints(
        BackgroundPoints $backgroundPoints,
        Ancestry $ancestry,
        BackgroundSkillPoints $backgroundSkillPoints,
        PossessionValue $possessionValue
    )
    {
        $sumOfSpentBackgroundPoints = $this->sumSpentPoints($ancestry, $backgroundSkillPoints, $possessionValue);
        if ($sumOfSpentBackgroundPoints > $backgroundPoints->getValue()) {
            throw new Exceptions\SpentTooMuchBackgroundPoints(
                "Available background points are {$backgroundPoints->getValue()},"
                . " sum of spent background points is {$sumOfSpentBackgroundPoints}"
            );
        }
    }

    private function sumSpentPoints(
        Ancestry $ancestry,
        BackgroundSkillPoints $backgroundSkillPoints,
        PossessionValue $possessionValue
    )
    {
        return $ancestry->getSpentBackgroundPoints() + $backgroundSkillPoints->getSpentBackgroundPoints()
            + $possessionValue->getSpentBackgroundPoints();
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
     * @return Ancestry
     */
    public function getAncestry()
    {
        return $this->ancestry;
    }

    /**
     * @return BackgroundSkillPoints
     */
    public function getBackgroundSkillPoints()
    {
        return $this->backgroundSkillPoints;
    }

    /**
     * @return PossessionValue
     */
    public function getPossessionValue()
    {
        return $this->possessionValue;
    }

    /**
     * @return int
     */
    public function getRemainingBackgroundPoints()
    {
        return $this->getBackgroundPoints()->getValue() - $this->sumSpentPoints(
                $this->getAncestry(), $this->getBackgroundSkillPoints(), $this->getPossessionValue()
            );
    }

}