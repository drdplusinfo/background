<?php
namespace DrdPlus\Tests\Background\BackgroundParts;

use DrdPlus\Codes\History\AncestryCode;
use DrdPlus\Codes\ProfessionCode;
use DrdPlus\Codes\Skills\SkillTypeCode;
use DrdPlus\Background\BackgroundParts\SkillsFromBackground;
use DrdPlus\Professions\Profession;
use DrdPlus\Tables\History\AncestryTable;
use DrdPlus\Tables\History\BackgroundPointsDistributionTable;
use DrdPlus\Tables\History\SkillsByBackgroundPointsTable;
use DrdPlus\Tests\Background\BackgroundParts\Partials\AbstractAncestryDependentTest;
use Granam\Integer\PositiveInteger;
use Granam\Integer\PositiveIntegerObject;

class SkillsFromBackgroundTest extends AbstractAncestryDependentTest
{

    /**
     * @test
     * @dataProvider provideSkillType
     * @param string $skillTypeName
     */
    public function I_can_get_skill_points($skillTypeName)
    {
        $skillType = SkillTypeCode::getIt($skillTypeName);
        $backgroundSkillPoints = SkillsFromBackground::getIt(
            $spentBackgroundPoints = new PositiveIntegerObject(7),
            $ancestry = $this->createAncestry($ancestryValue = 456, AncestryCode::getIt(AncestryCode::NOBLE)),
            new AncestryTable(),
            new BackgroundPointsDistributionTable()
        );
        $skillsByBackgroundPointsTable = $this->mockery(SkillsByBackgroundPointsTable::class);
        $professionCode = ProfessionCode::getIt(ProfessionCode::FIGHTER);
        $result = 'foo';
        /** @noinspection PhpUnusedParameterInspection */
        $skillsByBackgroundPointsTable->shouldReceive('getSkillPoints')
            ->with($this->type(PositiveInteger::class), $professionCode, $skillType)
            ->atLeast()->once()
            ->andReturnUsing(
                function (PositiveInteger $givenSpentBackgroundPoints, ProfessionCode $professionCode, SkillTypeCode $skillTypeCode)
                use ($spentBackgroundPoints, $result) {
                    self::assertEquals($spentBackgroundPoints, $givenSpentBackgroundPoints);

                    return $result;
                })
            ->getMock();
        /** @var SkillsByBackgroundPointsTable $skillsByBackgroundPointsTable */
        self::assertSame(
            $result,
            $backgroundSkillPoints->getSkillPoints(
                $this->createProfession(ProfessionCode::FIGHTER, $professionCode),
                $skillType,
                $skillsByBackgroundPointsTable
            )
        );
        switch ($skillTypeName) {
            case SkillTypeCode::PHYSICAL :
                self::assertSame(
                    $result,
                    $backgroundSkillPoints->getPhysicalSkillPoints(
                        $this->createProfession(ProfessionCode::FIGHTER, $professionCode),
                        $skillsByBackgroundPointsTable
                    )
                );
                break;
            case SkillTypeCode::PSYCHICAL :
                self::assertSame(
                    $result,
                    $backgroundSkillPoints->getPsychicalSkillPoints(
                        $this->createProfession(ProfessionCode::FIGHTER, $professionCode),
                        $skillsByBackgroundPointsTable
                    )
                );
                break;
            case SkillTypeCode::COMBINED :
                self::assertSame(
                    $result,
                    $backgroundSkillPoints->getCombinedSkillPoints(
                        $this->createProfession(ProfessionCode::FIGHTER, $professionCode),
                        $skillsByBackgroundPointsTable
                    )
                );
                break;
        }
    }

    /**
     * @param string $professionName
     * @param ProfessionCode $professionCode
     * @return \Mockery\MockInterface|Profession
     */
    private function createProfession($professionName, ProfessionCode $professionCode = null)
    {
        $profession = $this->mockery(Profession::class);
        $profession->shouldReceive('getValue')
            ->andReturn($professionName);
        $profession->shouldReceive('getCode')
            ->andReturn($professionCode !== null
                ? $professionCode
                : ProfessionCode::getIt($professionName)
            );

        return $profession;
    }

    public function provideSkillType()
    {
        return array_map(
            function ($value) {
                return [$value];
            },
            SkillTypeCode::getPossibleValues()
        );
    }
}