<?php
namespace App\tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class ControllerTest extends WebTestCase
{
    /**
     * @dataProvider urlProviderAccessiblePages
     * @param $url
     */
    public function testPageIsSuccessful($url)
    {
        $client = self::createClient();
        $client->request('GET', $url);
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
    }

    // Provide list of pages found with NOT connected User
    public function urlProviderAccessiblePages()
    {
        return [
            ['/'],
            ['/fiche-spot'],
            ['/faq'],
            ['/legalNotice'],
            ['/termsOfService'],
            ['/contact']
        ];
    }
}