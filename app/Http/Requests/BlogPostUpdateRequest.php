<?php

namespace App\Http\Requests;

use App\Models\BlogPost;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\Rule;

/**
 * Class BlogPostUpdateRequest
 * @package App\Http\Requests
 */
class BlogPostUpdateRequest extends FormRequest
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
            'title' => 'required|min:3|max:250',
            'group' => 'nullable',
            'is_published' => 'required',
            'sort' => 'nullable',
            'slug' => 'nullable',
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
            'group.required' => ':attribute не може бути пустою',
            'group.in' => ':attribute недопустима',
        ];

    }

    /**
     * @return array
     */
    public function attributes()
    {
        return [
            'user_id' => 'Користувач',
            'title' => 'Заголовок',
            'group' => 'Назва групи',
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
