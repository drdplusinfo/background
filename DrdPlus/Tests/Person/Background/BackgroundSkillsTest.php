<?php
namespace DrdPlus\Tests\Person\Background;

use DrdPlus\Codes\ProfessionCodes;
use DrdPlus\Codes\SkillCodes;
use DrdPlus\Person\Background\BackgroundSkills;
use DrdPlus\Tables\Tables;

class BackgroundSkillsTest extends AbstractTestOfHeritageDependent
{
    /**
     * @test
     */
    public function I_can_get_skill_points()
    {
        $backgroundPoints = $this->createBackgroundPoints($pointsValue = 7);
        $heritage = $this->createHeritage($heritageValue = 456);

        $backgroundSkills = BackgroundSkills::getIt($backgroundPoints, $heritage);
        $tables = $this->mockery(Tables::class)
            ->shouldReceive('getBackgroundSkillsTable')
            ->once()
            ->andReturn($backgroundSkillsTable = $this->mockery(\stdClass::class))
            ->getMock();
        $backgroundSkillsTable->shouldReceive('getSkillPoints')
            ->with($pointsValue, ProfessionCodes::FIGHTER, SkillCodes::COMBINED)
            ->once()
            ->andReturn($result = 'foo')
            ->getMock();
        /** @var Tables $tables */
        $this->assertSame(
            $result,
            $backgroundSkills->getSkillPoints(
                ProfessionCodes::FIGHTER,
                SkillCodes::COMBINED,
                $tables
            )
        );
    }
}
