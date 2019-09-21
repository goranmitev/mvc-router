<?php
use PHPUnit\Framework\TestCase;

class PatientsMetricsTest extends TestCase
{
    private $http;

    public function setUp(): void
    {
        parent::setUp();
        $this->http = new GuzzleHttp\Client(['base_uri' => 'http://localhost:5555']);
    }

    public function testIndex()
    {
        $response = $this->http->request('GET', '/patients/2/metrics');

        $this->assertEquals(200, $response->getStatusCode());

        $contentType = $response->getHeaders()["Content-Type"][0];
        $this->assertEquals("application/json", $contentType);

        $body = $response->getBody()->getContents();
        $bodyJson = json_decode($body);
        $this->assertEquals(true, $bodyJson->success);
        $this->assertEquals(2, $bodyJson->patientId);
    }

    public function testGet()
    {
        $response = $this->http->request('GET', '/patients/2/metrics/abc');

        $this->assertEquals(200, $response->getStatusCode());

        $contentType = $response->getHeaders()["Content-Type"][0];
        $this->assertEquals("application/json", $contentType);

        $body = $response->getBody()->getContents();
        $bodyJson = json_decode($body);
        $this->assertEquals(true, $bodyJson->success);
        $this->assertEquals(2, $bodyJson->patientId);
        $this->assertEquals('abc', $bodyJson->metricId);
    }

    public function testPost()
    {
        $response = $this->http->request('POST', '/patients/2/metrics');

        $this->assertEquals(200, $response->getStatusCode());

        $contentType = $response->getHeaders()["Content-Type"][0];
        $this->assertEquals("application/json", $contentType);

        $body = $response->getBody()->getContents();
        $bodyJson = json_decode($body);
        $this->assertEquals(true, $bodyJson->success);
        $this->assertEquals(2, $bodyJson->patientId);
    }

    public function testPatch()
    {
        $response = $this->http->request('PATCH', '/patients/2/metrics/abc');

        $this->assertEquals(200, $response->getStatusCode());

        $contentType = $response->getHeaders()["Content-Type"][0];
        $this->assertEquals("application/json", $contentType);

        $body = $response->getBody()->getContents();
        $bodyJson = json_decode($body);
        $this->assertEquals(true, $bodyJson->success);
        $this->assertEquals(2, $bodyJson->patientId);
        $this->assertEquals('abc', $bodyJson->metricId);
    }

    public function testDelete()
    {
        $response = $this->http->request('DELETE', '/patients/2/metrics/abc');

        $this->assertEquals(200, $response->getStatusCode());

        $contentType = $response->getHeaders()["Content-Type"][0];
        $this->assertEquals("application/json", $contentType);

        $body = $response->getBody()->getContents();
        $bodyJson = json_decode($body);
        $this->assertEquals(true, $bodyJson->success);
        $this->assertEquals(2, $bodyJson->patientId);
        $this->assertEquals('abc', $bodyJson->metricId);
    }

    public function tearDown(): void
     {
        $this->http = null;
    }
}
