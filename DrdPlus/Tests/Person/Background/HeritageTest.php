<?php
namespace DrdPlus\Tests\Person\Background;

use DrdPlus\Person\Background\BackgroundPoints;
use DrdPlus\Person\Background\Heritage;

class HeritageTest extends AbstractTestOfBackgroundAdvantage
{
    /**
     * @test
     * @dataProvider provideBackgroundPointsWithHeritage
     * @param int $pointsValue
     * @param string $expectedHeritageName
     */
    public function I_can_get_heritage_name_by_background_points($pointsValue, $expectedHeritageName)
    {
        $points = BackgroundPoints::getEnum($pointsValue);
        /** @var BackgroundPoints $points */
        $heritage = Heritage::getIt($points);
        $this->assertSame($pointsValue, $heritage->getValue());
        $this->assertSame($pointsValue, $heritage->getBackgroundPointsValue());
        $this->assertSame($expectedHeritageName, $heritage->getHeritageName());
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

    protected function createSut(BackgroundPoints $backgroundPoints)
    {
        return Heritage::getIt($backgroundPoints);
    }

    /**
     * @test
     * @dataProvider provideInvalidBackgroundPoints
     * @param int $pointsValue
     * @expectedException \DrdPlus\Person\Background\Exceptions\UnexpectedBackgroundPoints
     */
    public function I_can_not_get_heritage_name_with_broken_points($pointsValue)
    {
        $points = BackgroundPoints::getEnum($pointsValue);
        /** @var BackgroundPoints $points */
        $heritage = TestOfBrokenHeritage::getIt($points);

        $heritage->getHeritageName();
    }
}

/** inner */
class TestOfBrokenHeritage extends Heritage
{
    public static function getIt(BackgroundPoints $backgroundPoints)
    {
        return self::getEnum($backgroundPoints->getValue());
    }
}
