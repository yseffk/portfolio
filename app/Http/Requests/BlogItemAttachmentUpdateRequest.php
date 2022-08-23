<?php

namespace App\Http\Requests;

use App\Models\BlogItemAttachment;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\Rule;

/**
 * Class BlogItemAttachmentUpdateRequest
 * @package App\Http\Requests
 */
class BlogItemAttachmentUpdateRequest extends FormRequest
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
            'blog_item_id' => 'required|exists:App\Models\BlogItem,id',
            'source' => ['required', Rule::in(BlogItemAttachment::SOURCES),],
            'file_path' => 'nullable',
        ];
    }

    /**
     * @return array
     */
    public function messages()
    {
        return [

            'blog_item_id.required' => ':attribute не може бути пустим',
            'blog_item_id.exists' => ':attribute не знайдено',
            'source.required' => ':attribute не може бути пустим',
            'source.in' => ':attribute недопустимий',
            'file_path.required' => ':attribute не може бути пустим',
        ];

    }

    /**
     * @return array
     */
    public function attributes()
    {
        return [
            'blog_item_id' => 'blog_item_id',
            'type' => 'Тип вкладення',
            'source' => 'Джерело вкладення',
            'file_path' => 'Вкладення',
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
