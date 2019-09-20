<?php
use PHPUnit\Framework\TestCase;

class PatientsTest extends TestCase
{
    private $http;

    public function setUp(): void
    {
        parent::setUp();
        $this->http = new GuzzleHttp\Client(['base_uri' => 'http://localhost:8000']);
    }

    public function testIndex()
    {
        $response = $this->http->request('GET', 'patients');

        $this->assertEquals(200, $response->getStatusCode());

        $contentType = $response->getHeaders()["Content-Type"][0];
        $this->assertEquals("application/json", $contentType);


        $body = $response->getBody()->getContents();
        $this->assertStringContainsString('index', $body);
    }

    public function testGet()
    {
        $response = $this->http->request('GET', 'patients/6');

        $this->assertEquals(200, $response->getStatusCode());

        $contentType = $response->getHeaders()["Content-Type"][0];
        $this->assertEquals("application/json", $contentType);

        $body = $response->getBody()->getContents();
        $this->assertStringContainsString('get', $body);
    }

    public function testPost()
    {
        $response = $this->http->request('POST', 'patients');

        $this->assertEquals(200, $response->getStatusCode());

        $contentType = $response->getHeaders()["Content-Type"][0];
        $this->assertEquals("application/json", $contentType);

        $body = $response->getBody()->getContents();
        $this->assertStringContainsString('created', $body);
    }

    public function testPatch()
    {
        $response = $this->http->request('PATCH', 'patients/5');

        $this->assertEquals(200, $response->getStatusCode());

        $contentType = $response->getHeaders()["Content-Type"][0];
        $this->assertEquals("application/json", $contentType);

        $body = $response->getBody()->getContents();
        $this->assertStringContainsString('updated', $body);
    }

    public function testDelete()
    {
        $response = $this->http->request('DELETE', 'patients/5');

        $this->assertEquals(200, $response->getStatusCode());

        $contentType = $response->getHeaders()["Content-Type"][0];
        $this->assertEquals("application/json", $contentType);

        $body = $response->getBody()->getContents();
        $this->assertStringContainsString('deleted', $body);
    }

    public function tearDown(): void
     {
        $this->http = null;
    }
}
