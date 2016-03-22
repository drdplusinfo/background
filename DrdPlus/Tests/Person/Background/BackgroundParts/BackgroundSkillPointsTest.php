<?php
namespace DrdPlus\Tests\Person\Background\BackgroundParts;

use DrdPlus\Codes\ProfessionCodes;
use DrdPlus\Codes\SkillCodes;
use DrdPlus\Person\Background\BackgroundParts\BackgroundSkillPoints;
use DrdPlus\Professions\Profession;
use DrdPlus\Tables\Tables;
use DrdPlus\Tests\Person\Background\BackgroundParts\Partials\AbstractHeritageDependentTest;

class BackgroundSkillPointsTest extends AbstractHeritageDependentTest
{
    /**
     * @test
     * @dataProvider provideSkillType
     * @param string $skillType
     */
    public function I_can_get_skill_points($skillType)
    {
        $backgroundSkillPoints = BackgroundSkillPoints::getIt(
            $spentBackgroundPoints = 7,
            $heritage = $this->createHeritage($heritageValue = 456)
        );
        $tables = $this->mockery(Tables::class)
            ->shouldReceive('getBackgroundSkillsTable')
            ->atLeast()->once()
            ->andReturn($backgroundSkillsTable = $this->mockery(\stdClass::class))
            ->getMock();
        $backgroundSkillsTable->shouldReceive('getSkillPoints')
            ->with($spentBackgroundPoints, ProfessionCodes::FIGHTER, $skillType)
            ->atLeast()->once()
            ->andReturn($result = 'foo')
            ->getMock();
        /** @var Tables $tables */
        self::assertSame(
            $result,
            $backgroundSkillPoints->getSkillPoints(
                $this->createProfession(ProfessionCodes::FIGHTER), $skillType, $tables
            )
        );
        switch ($skillType) {
            case SkillCodes::PHYSICAL :
                self::assertSame(
                    $result,
                    $backgroundSkillPoints->getPhysicalSkillPoints(
                        $this->createProfession(ProfessionCodes::FIGHTER),
                        $tables
                    )
                );
                break;
            case SkillCodes::PSYCHICAL :
                self::assertSame(
                    $result,
                    $backgroundSkillPoints->getPsychicalSkillPoints(
                        $this->createProfession(ProfessionCodes::FIGHTER),
                        $tables
                    )
                );
                break;
            case SkillCodes::COMBINED :
                self::assertSame(
                    $result,
                    $backgroundSkillPoints->getCombinedSkillPoints(
                        $this->createProfession(ProfessionCodes::FIGHTER),
                        $tables
                    )
                );
                break;
        }
    }

    /**
     * @param string $professionCode
     * @return \Mockery\MockInterface|Profession
     */
    private function createProfession($professionCode)
    {
        $profession = $this->mockery(Profession::class);
        $profession->shouldReceive('getValue')
            ->andReturn($professionCode);

        return $profession;
    }

    public function provideSkillType()
    {
        return [
            [SkillCodes::PHYSICAL],
            [SkillCodes::PSYCHICAL],
            [SkillCodes::COMBINED],
        ];
    }
}
