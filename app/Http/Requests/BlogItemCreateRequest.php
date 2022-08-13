<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

/**
 * Class BlogItemCreateRequest
 * @package App\Http\Requests
 */
class BlogItemCreateRequest extends FormRequest
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
            'post_id' => 'required|exists:\App\Models\BlogPost,id',
            'title' => 'required|min:3|max:250',
            'is_published' => 'required|numeric',
            'brief_content' => 'nullable|string',
            'raw_content' => 'nullable|string',
        ];
    }

    /**
     * @return array
     */
    public function messages()
    {
        return [
            'title.required' => ':attribute не може бути пустим',
            'title.min' => ':attribute не може бути менше :min символів',
            'title.max' => ':attribute не може бути більше :max символів',

        ];

    }

    /**
     * @return array
     */
    public function attributes()
    {
        return [
            'title' => 'Заголовок',
        ];

    }

    /**
     * @param Validator $validator
     */
    protected function failedValidation(Validator $validator)
    {

        throw new HttpResponseException(response()->json($validator->errors(), 422));

    }
}
