<?php

namespace App\Http\Requests\Movies;

use Illuminate\Foundation\Http\FormRequest;

class Update extends FormRequest
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
            'title' => [
                'sometimes',
                'required',
                'string',
                'max:255'
            ],
            'description' => [
                'sometimes',
                'required',
                'string'
            ],
            'release_date' => [
                'sometimes',
                'nullable',
                'date',
                'date_format:Y-m-d',
                'before:today'
            ],
            'watched' => [
                'sometimes',
                'nullable',
                'boolean',
            ],
            'genres' => [
                'sometimes',
                'required',
                'array'
            ],
            'genres.*' => [
                'required_with:genres',
                'integer',
                'exists:genres,id'
            ]
        ];
    }
}
