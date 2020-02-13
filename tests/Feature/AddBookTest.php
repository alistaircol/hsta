<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\Book;

class AddBookTest extends TestCase
{
    use RefreshDatabase;

    private $api_token = '123456789012345678901234567890123456789012345678901234567890';

    /**
     * Test adding a book works successfully
     *
     * @return void
     */
    public function testAddValidBook()
    {
        $this->seed();

        $this->assertDatabaseMissing('books', [
            'title' => 'Modern PHP: New Features and Good Practices',
        ]);

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $this->api_token,
            'Accept' => 'application/json',
        ])->json('PUT', 'api/v1/books', [
            'isbn' => '9781491905012',
            'author' => 'Josh Lockhart',
            'title' => 'Modern PHP: New Features and Good Practices',
            'category' => [
                'PHP',
            ],
            'price_currency' => 'GBP',
            'price_amount' => 18.99
        ]);

        $response->assertStatus(201);
        $response->assertSeeText('9781491905012');
        $response->assertSeeText('Modern PHP: New Features and Good Practices');
        $response->assertSeeText('Josh Lockhart');
        $response->assertSeeText('PHP');
        $response->assertSeeText(18.99);
        $response->assertSeeText('GBP');

        $this->assertDatabaseHas('books', [
            'title' => 'Modern PHP: New Features and Good Practices',
        ]);
    }

    /**
     * Test adding an invalid book with bad ISBN is unsuccessful
     *
     * @return void
     */
    public function testAddInvalidBook()
    {
        $this->seed();

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $this->api_token,
            'Accept' => 'application/json',
        ])->json('PUT', 'api/v1/books', [
            'isbn' => '978-INVALID-ISBN-1491905012',
            'author' => 'Josh Lockhart',
            'title' => 'Modern PHP: New Features and Good Practices',
            'category' => [
                'PHP',
            ],
            'price_currency' => 'GBP',
            'price_amount' => 18.99
        ]);

        $response->assertStatus(422);
        $response->assertSeeText('Please provide a valid ISBN.');
    }
}
