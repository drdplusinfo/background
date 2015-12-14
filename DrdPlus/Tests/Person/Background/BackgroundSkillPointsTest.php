<?php
namespace DrdPlus\Tests\Person\Background;

use DrdPlus\Codes\ProfessionCodes;
use DrdPlus\Codes\SkillCodes;
use DrdPlus\Person\Background\BackgroundSkillPoints;
use DrdPlus\Tables\Tables;

class BackgroundSkillPointsTest extends AbstractTestOfHeritageDependent
{
    /**
     * @test
     * @dataProvider provideSkillType
     */
    public function I_can_get_skill_points($skillType)
    {
        $backgroundPoints = $this->createBackgroundPoints($pointsValue = 7);
        $heritage = $this->createHeritage($heritageValue = 456);

        $backgroundSkills = BackgroundSkillPoints::getIt($backgroundPoints, $heritage);
        $tables = $this->mockery(Tables::class)
            ->shouldReceive('getBackgroundSkillsTable')
            ->atLeast()->once()
            ->andReturn($backgroundSkillsTable = $this->mockery(\stdClass::class))
            ->getMock();
        $backgroundSkillsTable->shouldReceive('getSkillPoints')
            ->with($pointsValue, ProfessionCodes::FIGHTER, $skillType)
            ->atLeast()->once()
            ->andReturn($result = 'foo')
            ->getMock();
        /** @var Tables $tables */
        $this->assertSame(
            $result,
            $backgroundSkills->getSkillPoints(ProfessionCodes::FIGHTER, $skillType, $tables)
        );
        switch ($skillType) {
            case SkillCodes::PHYSICAL :
                $this->assertSame(
                    $result,
                    $backgroundSkills->getPhysicalSkillPoints(ProfessionCodes::FIGHTER, $tables)
                );
                break;
            case SkillCodes::PSYCHICAL :
                $this->assertSame(
                    $result,
                    $backgroundSkills->getPsychicalSkillPoints(ProfessionCodes::FIGHTER, $tables)
                );
                break;
            case SkillCodes::COMBINED :
                $this->assertSame(
                    $result,
                    $backgroundSkills->getCombinedSkillPoints(ProfessionCodes::FIGHTER, $tables)
                );
                break;
        }
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
