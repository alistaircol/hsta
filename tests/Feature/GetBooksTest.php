<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class GetBooksTest extends TestCase
{
    use RefreshDatabase;

    private $api_token = '123456789012345678901234567890123456789012345678901234567890';

    /**
     * Test search on books with author returns results.
     *
     * @return void
     */
    public function testSearchAuthorRobinNixonReturnsTwoBooks()
    {
        $this->seed();

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $this->api_token,
            'Accept' => 'application/json',
        ])->json('POST', 'api/v1/books', [
            'author' => 'Robin Nixon',
        ]);

        $response->assertStatus(200);
        $response->assertJsonCount(2);
        $response->assertSeeText('9781491918661');
        $response->assertSeeText('9780596804848');
    }

    public function testSearchAuthorChristoperNegusReturnsOneBook()
    {
        $this->seed();

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $this->api_token,
            'Accept' => 'application/json',
        ])->json('POST', 'api/v1/books', [
            'author' => 'Christopher Negus',
        ]);

        $response->assertStatus(200);
        $response->assertJsonCount(1);
        $response->assertSeeText('9781118999875');
    }

    public function testListAllBooksWithinLinuxCategory()
    {
        $this->seed();

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $this->api_token,
            'Accept' => 'application/json',
        ])->json('POST', 'api/v1/books', [
            'category' => 'Linux',
        ]);

        $response->assertStatus(200);
        $response->assertJsonCount(2);
        $response->assertSeeText('9780596804848');
        $response->assertSeeText('9781118999875');
    }

    public function testListAllBooksWithinPhpCategory()
    {
        $this->seed();

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $this->api_token,
            'Accept' => 'application/json',
        ])->json('POST', 'api/v1/books', [
            'category' => 'PHP',
        ]);

        $response->assertStatus(200);
        $response->assertJsonCount(1);
        $response->assertSeeText('9781491918661');
    }

    public function testListAllBooksByAuthorRobinNixonInCategoryLinux()
    {
        $this->seed();

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $this->api_token,
            'Accept' => 'application/json',
        ])->json('POST', 'api/v1/books', [
            'author' => 'Robin Nixon',
            'category' => 'Linux',
        ]);

        $response->assertStatus(200);
        $response->assertJsonCount(1);
        $response->assertSeeText('9780596804848');
    }

}
