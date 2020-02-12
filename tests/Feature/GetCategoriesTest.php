<?php

namespace Tests\Feature;

use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class GetCategoriesTest extends TestCase
{
    use RefreshDatabase;

    private $api_token = '123456789012345678901234567890123456789012345678901234567890';

    /**
     * List all categories.
     *
     * @return void
     */
    public function testListAllCategories()
    {
        $this->seed();

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $this->api_token,
            'Accept' => 'application/json',
        ])->json('GET', '/api/v1/categories');

        $response->assertStatus(200);
        $response->assertJsonCount(3);
        $response->assertSeeText('PHP');
        $response->assertSeeText('Javascript');
        $response->assertSeeText('Linux');
    }

    public function testListAllBooksWithinLinuxCategory()
    {
        $this->seed();

        $category_id = '34fa301d-f144-4f3e-928f-fef75fff039e';
        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $this->api_token,
            'Accept' => 'application/json',
        ])->json('GET', '/api/v1/categories/' . $category_id);

        $response->assertStatus(200);
        $response->assertJsonCount(2, 'books');
        $response->assertSeeText('9780596804848');
        $response->assertSeeText('9781118999875');
    }

    public function testListAllBooksWithinPhpCategory()
    {
        $this->seed();

        $category_id = '79e1b005-931c-42ab-915a-4fbd11ab7d7b';
        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $this->api_token,
            'Accept' => 'application/json',
        ])->json('GET', '/api/v1/categories/' . $category_id);

        $response->assertStatus(200);
        $response->assertJsonCount(1, 'books');
        $response->assertSeeText('9781491918661');
    }
}
