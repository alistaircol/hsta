<?php

namespace App\Rules;

use App\Models\Category;
use Illuminate\Contracts\Validation\Rule;

class CategoryExists implements Rule
{
    private $all_categories;
    private $categories_not_found = [];
    private $message;

    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->all_categories = Category::all();
        $this->categories_not_found = [];
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
        if (!is_array($value) || empty($value)) {
            $this->message = 'Please provide a list of categories.';
            return false;
        }

        foreach ($value as $category_name) {
            if (!$this->all_categories->contains('name', $category_name)) {
                $this->categories_not_found[] = $category_name;
            }
        }

        $all_categories_found = count($this->categories_not_found) == 0;

        if (!$all_categories_found) {
            $this->message = 'The following categories do not exist: ' . implode(', ', $this->categories_not_found) . '.';
        }

        return $all_categories_found;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return $this->message;
    }
}
