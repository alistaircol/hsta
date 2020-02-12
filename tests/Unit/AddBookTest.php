<?php

namespace Tests\Unit;

use App\Http\Requests\Api\V1\Books\AddBookRequest;
use App\Rules\Isbn;
use App\Rules\Iso4217;
use PHPUnit\Framework\TestCase;
use Tests\CreatesApplication;
use Illuminate\Support\Facades\Validator;

class AddBookTest extends TestCase
{
    use CreatesApplication;

    private $validator;
    private $rules;
    private $messages;

    public function setUp(): void
    {
        parent::setUp();

        // some weirdness due to RuntimeException: A facade root has not been set.
        $this->createApplication();
        $this->validator = app()->get('validator');
        $this->rules = (new AddBookRequest())->rules();
        $this->messages = (new AddBookRequest())->messages();
    }

    public function testInvalidBookValidation()
    {
        $request = [
            'author' => 'Valid',
            'title'  => 'Valid',
            'price_amount' => 12.99,
            'price_currency' => 'GBP',
            'isbn' => '9999999999999',
            'category' => 'PHP',
        ];

        $validator = $this->validator->make($request, $this->rules, $this->messages);
        $errors = $validator->messages()->toArray();

        $this->assertTrue($validator->fails());
        $this->assertArrayHasKey('isbn', $errors);
        $this->assertEquals('Please provide a valid ISBN.', $errors['isbn'][0]);

        $request = [
            'author' => 'Valid',
            'title'  => 'Valid',
            'price_amount' => 12.99,
            'price_currency' => '___',
            'isbn' => '9999999999999',
            'category' => 'PHP',
        ];

        $validator = $this->validator->make($request, $this->rules, $this->messages);
        $errors = $validator->messages()->toArray();

        $this->assertTrue($validator->fails());
        $this->assertArrayHasKey('price_currency', $errors);
        $this->assertEquals('Please provide 3 character currency code as per ISO 4217.', $errors['price_currency'][0]);


    }

    public function testIsbnRule()
    {
        $rule = new Isbn();

        // modern php
        $this->assertTrue($rule->passes('isbn', '9781491905012'));
        // effective java isbn-10 and isbn-13
        $this->assertTrue($rule->passes('isbn', '0321356683'));
        $this->assertTrue($rule->passes('isbn', '9780321356680'));

        $this->assertFalse($rule->passes('isbn', null));
        $this->assertFalse($rule->passes('isbn', false));
        $this->assertFalse($rule->passes('isbn', true));
        $this->assertFalse($rule->passes('isbn', []));
        $this->assertFalse($rule->passes('isbn', ''));
        $this->assertFalse($rule->passes('isbn', 'aaa'));
        $this->assertFalse($rule->passes('isbn', 'aaaaaaaaaaaaaaaaaaaaaaaaaa'));
        $this->assertFalse($rule->passes('isbn', '1234567890'));
        $this->assertFalse($rule->passes('isbn', '1234567890123'));
    }

    public function testIso4217CurrencyRule()
    {
        $rule = new Iso4217();

        $this->assertTrue($rule->passes('currency_code', 'GBP'));
        $this->assertTrue($rule->passes('currency_code', 'EUR'));
        $this->assertTrue($rule->passes('currency_code', 'USD'));

        $this->assertFalse($rule->passes('currency_code', null));
        $this->assertFalse($rule->passes('currency_code', false));
        $this->assertFalse($rule->passes('currency_code', true));
        $this->assertFalse($rule->passes('currency_code', '___'));
        $this->assertFalse($rule->passes('currency_code', '   '));
        $this->assertFalse($rule->passes('currency_code', 'aaaaaaaa'));
        $this->assertFalse($rule->passes('currency_code', []));
    }
}
