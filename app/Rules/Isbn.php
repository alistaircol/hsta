<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use Nicebooks\Isbn\IsbnTools;

class Isbn implements Rule
{
    private $isbn_tool;

    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->isbn_tool = new IsbnTools();
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        if (is_array($value)) {
            return false;
        }
        $value = strval($value);
        return $this->isbn_tool->isValidIsbn($value);
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'Please provide a valid ISBN.';
    }
}
