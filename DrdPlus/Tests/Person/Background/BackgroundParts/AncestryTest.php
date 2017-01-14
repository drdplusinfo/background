<?php
namespace DrdPlus\Tests\Person\Background\BackgroundParts;

use DrdPlus\Person\Background\BackgroundParts\Ancestry;
use DrdPlus\Tests\Person\Background\BackgroundParts\Partials\AbstractBackgroundAdvantageTest;

class AncestryTest extends AbstractBackgroundAdvantageTest
{
    protected function createSut($spentBackgroundPoints)
    {
        return Ancestry::getIt($spentBackgroundPoints);
    }

    /**
     * @test
     * @dataProvider provideBackgroundPointsWithHeritage
     * @param int $spentBackgroundPoints
     * @param string $expectedHeritageName
     */
    public function I_can_get_heritage_name_by_background_points($spentBackgroundPoints, $expectedHeritageName)
    {
        $ancestry = Ancestry::getIt($spentBackgroundPoints);
        self::assertSame($spentBackgroundPoints, $ancestry->getValue());
        self::assertSame($spentBackgroundPoints, $ancestry->getSpentBackgroundPoints());
        self::assertSame($expectedHeritageName, $ancestry->getHeritageName());
    }

    public function provideBackgroundPointsWithHeritage()
    {
        return [
            [0, 'foundling'],
            [1, 'orphan'],
            [2, 'from_incomplete_family'],
            [3, 'from_doubtfully_family'],
            [4, 'from_modest_family'],
            [5, 'from_wealthy_family'],
            [6, 'from_wealthy_and_influential_family'],
            [7, 'noble'],
            [8, 'noble_from_powerful_family'],
        ];
    }

    /**
     * @test
     * @dataProvider provideInvalidBackgroundPoints
     * @param int $spentHeritagePoints
     * @expectedException \DrdPlus\Person\Background\BackgroundParts\Exceptions\UnexpectedBackgroundPoints
     */
    public function I_can_not_get_heritage_name_with_broken_points($spentHeritagePoints)
    {
        $ancestry = TestOfBrokenAncestry::getIt($spentHeritagePoints);
        $ancestry->getHeritageName();
    }
}

/** inner */
class TestOfBrokenAncestry extends Ancestry
{
    public static function getIt($spentBackgroundPoints)
    {
        return self::getEnum($spentBackgroundPoints);
    }
}
