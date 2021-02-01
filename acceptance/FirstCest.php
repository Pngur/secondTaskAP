<?php 

class FirstCest
{
    // tests
    public function tryToTest(AcceptanceTester $I) {
        $PAGE_COUNT = 3;
        $I->amOnPage('/');
        $I->see('Google');
        $I->fillField("//input[@class='gLFyf gsfi']", 'site:https://point.md/');
        $I->click('//div[@class="FPdoLc tfB0Bf"]//center//input[@name="btnK"]');
        $Actual_Titles = array();
        $Actual_Descriptions = array();
        $Actual_Urls = array();
        $Expected_Titles = array();
        $Expected_Descriptions = array();
        $Expected_Urls = array();
        $Pages = $I->grabMultiple("//table[@class='AaVjTc']//a[@class='fl']");
        for ($i = 0; $i < $PAGE_COUNT; $i++) {
            array_push($Actual_Titles, ...$I->grabMultiple("//div[@class='g']//h3[@class='LC20lb DKV0Md']//span"));
            array_push($Actual_Descriptions, ...$I->grabMultiple("//div[@class='g']//div[@class='IsZvec']//span[@class='aCOpRe']//span"));
            array_push($Actual_Urls, ...$I->grabMultiple("//div[@class='g']//div[@class='tF2Cxc']//div[@class='yuRUbf']/a", "href"));
            $I->click($Pages[$i]);
        }
        $Actual_result = $I->collectData($Actual_Titles, $Actual_Descriptions, $Actual_Urls);
        $I->saveCSVReport($Actual_result, "actual_google");
        for ($y = 0; $y < count($Actual_Urls); $y++) {
            $I->amOnUrl($Actual_Urls[$y]);
            array_push($Expected_Titles, $I->grabAttributeFrom('//title', 'innerHTML'));
            array_push($Expected_Descriptions, $I->grabAttributeFrom("/html/head/meta[@name='description']", "content"));
            array_push($Expected_Urls, $I->getCurrentUrl());
        }
        $Expected_point = $I->collectData($Expected_Titles, $Expected_Descriptions, $Expected_Urls);
        $I->saveCSVReport($Expected_point, "expected_point");
        $Result = [];
        array_push($Result, ...$I->compareResults($Expected_Titles, $Actual_Titles));
        array_push($Result, ...$I->compareResults($Expected_Descriptions, $Actual_Descriptions));
        array_push($Result, ...$I->compareResults($Expected_Urls, $Actual_Urls));
        $I->saveCSVReport($Result, "result");

    }
}
