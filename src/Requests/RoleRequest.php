<?php
/**
 * Created by PhpStorm.
 * User: Hong
 * Date: 2018/3/30
 * Time: 22:19
 * Function:
 */

namespace Tanmo\Admin\Requests;


use Illuminate\Foundation\Http\FormRequest;

class RoleRequest extends FormRequest
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

    public function rules()
    {
        return [
            'slug' => 'required',
            'name' => 'required'
        ];
    }

    public function messages()
    {
        return [
            'slug.required' => '标识必填',
            'name.required' => '名称必填'
        ];
    }
}