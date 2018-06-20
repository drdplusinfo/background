<?php
namespace DrdPlus\Background;

use Doctrine\ORM\Mapping as ORM;
use Doctrineum\Entity\Entity;
use DrdPlus\Codes\History\FateCode;
use DrdPlus\Background\BackgroundParts\SkillPointsFromBackground;
use DrdPlus\Background\BackgroundParts\Possession;
use DrdPlus\Background\BackgroundParts\Ancestry;
use DrdPlus\Tables\Tables;
use Granam\Integer\PositiveInteger;
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
     * @var SkillPointsFromBackground
     * @ORM\Column(type="skill_points_from_background")
     */
    private $skillPointsFromBackground;

    /**
     * @var Possession
     * @ORM\Column(type="possession")
     */
    private $possession;

    /**
     * @param FateCode $fateCode
     * @param PositiveInteger $forAncestrySpentBackgroundPoints
     * @param PositiveInteger $forPossessionSpentBackgroundPoints
     * @param PositiveInteger $forSkillPointsSpentBackgroundPoints
     * @param Tables $tables
     * @return Background
     * @throws \DrdPlus\Background\Exceptions\TooMuchSpentBackgroundPoints
     */
    public static function createIt(
        FateCode $fateCode,
        PositiveInteger $forAncestrySpentBackgroundPoints,
        PositiveInteger $forPossessionSpentBackgroundPoints,
        PositiveInteger $forSkillPointsSpentBackgroundPoints,
        Tables $tables
    ): Background
    {
        $availableBackgroundPoints = BackgroundPoints::getIt($fateCode, $tables);
        $ancestry = Ancestry::getIt($forAncestrySpentBackgroundPoints, $tables);
        $backgroundSkillPoints = SkillPointsFromBackground::getIt($forSkillPointsSpentBackgroundPoints, $ancestry, $tables);
        $possession = Possession::getIt($forPossessionSpentBackgroundPoints, $ancestry, $tables);

        return new static(
            $availableBackgroundPoints,
            $ancestry,
            $backgroundSkillPoints,
            $possession
        );
    }

    /**
     * @param BackgroundPoints $backgroundPoints
     * @param Ancestry $ancestry
     * @param SkillPointsFromBackground $skillPointsFromBackground
     * @param Possession $possession
     * @throws \DrdPlus\Background\Exceptions\TooMuchSpentBackgroundPoints
     */
    private function __construct(
        BackgroundPoints $backgroundPoints,
        Ancestry $ancestry,
        SkillPointsFromBackground $skillPointsFromBackground,
        Possession $possession
    )
    {
        $this->checkSumOfSpentBackgroundPoints($backgroundPoints, $ancestry, $skillPointsFromBackground, $possession);
        $this->backgroundPoints = $backgroundPoints;
        $this->ancestry = $ancestry;
        $this->skillPointsFromBackground = $skillPointsFromBackground;
        $this->possession = $possession;
    }

    /**
     * @param BackgroundPoints $backgroundPoints
     * @param Ancestry $ancestry
     * @param SkillPointsFromBackground $backgroundSkillPoints
     * @param Possession $possessionValue
     * @throws \DrdPlus\Background\Exceptions\TooMuchSpentBackgroundPoints
     */
    private function checkSumOfSpentBackgroundPoints(
        BackgroundPoints $backgroundPoints,
        Ancestry $ancestry,
        SkillPointsFromBackground $backgroundSkillPoints,
        Possession $possessionValue
    ): void
    {
        $sumOfSpentBackgroundPoints = $this->sumSpentPoints($ancestry, $backgroundSkillPoints, $possessionValue);
        if ($sumOfSpentBackgroundPoints > $backgroundPoints->getValue()) {
            throw new Exceptions\TooMuchSpentBackgroundPoints(
                "Available background points are {$backgroundPoints->getValue()},"
                . " sum of spent background points is {$sumOfSpentBackgroundPoints}"
            );
        }
    }

    /**
     * @param Ancestry $ancestry
     * @param SkillPointsFromBackground $backgroundSkillPoints
     * @param Possession $possessionValue
     * @return int
     */
    private function sumSpentPoints(
        Ancestry $ancestry,
        SkillPointsFromBackground $backgroundSkillPoints,
        Possession $possessionValue
    ): int
    {
        return $ancestry->getSpentBackgroundPoints()->getValue()
            + $backgroundSkillPoints->getSpentBackgroundPoints()->getValue()
            + $possessionValue->getSpentBackgroundPoints()->getValue();
    }

    /**
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return BackgroundPoints
     */
    public function getBackgroundPoints(): BackgroundPoints
    {
        return $this->backgroundPoints;
    }

    /**
     * @return Ancestry
     */
    public function getAncestry(): Ancestry
    {
        return $this->ancestry;
    }

    /**
     * @return SkillPointsFromBackground
     */
    public function getSkillPointsFromBackground(): SkillPointsFromBackground
    {
        return $this->skillPointsFromBackground;
    }

    /**
     * @return Possession
     */
    public function getPossession(): Possession
    {
        return $this->possession;
    }

    /**
     * @return int
     */
    public function getRemainingBackgroundPoints(): int
    {
        return $this->getBackgroundPoints()->getValue() - $this->sumSpentPoints(
                $this->getAncestry(), $this->getSkillPointsFromBackground(), $this->getPossession()
            );
    }

}