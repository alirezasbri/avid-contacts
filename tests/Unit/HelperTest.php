<?php

namespace Tests\Unit;

use Tests\TestCase;

class HelperTest extends TestCase
{
    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function testJsonResponseHandlerStatusCode200()
    {
        $this->assertEquals(
            response()->json(['message' => 'success'], 200),
            jsonResponseHandler(200));
    }

    public function testJsonResponseHandlerStatusCode201()
    {
        $this->assertEquals(
            response()->json(['message' => 'created'], 201),
            jsonResponseHandler(201));
    }

    public function testJsonResponseHandlerStatusCode401()
    {
        $this->assertEquals(
            response()->json(['message' => 'unauthorized'], 401),
            jsonResponseHandler(401));
    }

    public function testJsonResponseHandlerStatusCode403()
    {
        $this->assertEquals(
            response()->json(['message' => 'unauthenticated'], 403),
            jsonResponseHandler(403));
    }

    public function testJsonResponseHandlerStatusCode404()
    {
        $this->assertEquals(
            response()->json(['message' => 'not found'], 404),
            jsonResponseHandler(404));
    }

    public function testAuthenticated()
    {
        $response = $this->withHeaders([
            'Content-Type' => 'application/json',
            'X-Requested-With' => 'XMLHttpRequest',
            'Authorization' => 'Bearer BwafPnjr6gYhlQiJxrv3tcuJUyw4ftnbIYf0dvvlXCzZest64miEZDfGA9jz'
        ])->get('/api/contacts');

        $response->assertStatus(200);
    }

    public function testUnauthenticated()
    {
        $response = $this->withHeaders([
            'Content-Type' => 'application/json',
            'X-Requested-With' => 'XMLHttpRequest',
            'Authorization' => 'Bearer BwafPnjr6gYhlQiJxrv3tcuJUyw4ftnbIYf0dvvlXCzZest64miEZDfGA9j'
        ])->get('/api/contacts');

        $response->assertStatus(302);
    }

    public function testUnauthorized()
    {
        $response = $this->withHeaders([
            'Content-Type' => 'application/json',
            'X-Requested-With' => 'XMLHttpRequest',
            'Authorization' => 'Bearer IoTwXXe7gPmNHKgSYWKYEnKjDd4kgAA7NldWVoG7nrJtrvAdDq5oehOiFlDc'
        ])->get('/api/contacts/8');

        $response->assertStatus(401);
    }

//    public function testUnauthorized()
//    {
//        $response->assertUnauthorized();
//        $response->assertStatus($code);
//        $response->assertNotFound();
//    }
}
