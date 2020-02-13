<?php

namespace App\Http\Requests\Api\V1\Books;

use App\Rules\CategoryExists;
use App\Rules\Isbn;
use App\Rules\Iso4217;
use Illuminate\Foundation\Http\FormRequest;

class AddBookRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'author'         => ['required', 'string', 'min:3', 'max:50'],
            'title'          => ['required', 'string', 'min:3', 'max:50'],
            'isbn'           => ['required', new Isbn],
            'category'       => ['required', 'array', 'min:1', new CategoryExists],
            'price_amount'   => ['required', 'numeric', 'min:0'],
            'price_currency' => ['required', 'size:3', new Iso4217],
        ];
    }
}
