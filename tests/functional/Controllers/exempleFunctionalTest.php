<?php 
/*use Silex\WebTestCase;

class ImportControllerTest extends WebTestCase
{
	private static $_app = null;

	public static function setUpBeforeClass()
    {
        $app = new Silex\Application();

		require_once __DIR__ . '/../../../resources/config/test.php';
		require_once __DIR__ . '/../../../src/loader.php';

			
		$app["swiftmailer.transport"] = new \Swift_Transport_NullTransport($app['swiftmailer.transport.eventdispatcher']);

		self::$_app = $app;
    }

	public function createApplication()
    {
        return self::$_app;
    }

	private function _testImportReturn($crawler, $file)
	{
		$this->assertCount(1, $crawler->filter('.table>tbody>tr>td:first-child:contains(' . $file . ')'));
		$this->assertCount(1, $crawler->filter('.table>tbody>tr>td:last-child:contains("OK")'));
	}

	public function testDemandeImport()
	{
	    $client = $this->createClient();
	    $crawler = $client->request('GET', '/import/2013/01/opticDemande/update');

	    // fwrite(STDOUT,$client->getResponse());
	    // $this->fail($client->getResponse());

	    $this->assertTrue($client->getResponse()->isSuccessful());
	    $this->assertTrue($client->getResponse()->isOk());

	    $this->_testImportReturn($crawler, 'opticDemande');
	}

}*/