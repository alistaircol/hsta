<?php

namespace Tests\Unit;

use App\Rules\Isbn;
use App\Rules\Iso4217;
use PHPUnit\Framework\TestCase;
use Tests\CreatesApplication;

class AddBookValidationTest extends TestCase
{
    use CreatesApplication;

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
        $this->assertFalse($rule->passes('currency_code', 'ZZZ'));
        $this->assertFalse($rule->passes('currency_code', []));
    }
}
