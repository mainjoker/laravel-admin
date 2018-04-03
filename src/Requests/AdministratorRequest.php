<?php

namespace Tanmo\Admin\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AdministratorRequest extends FormRequest
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
            //
            'username' => 'required',
            'name' => 'required',
            'password' => 'required|confirmed',
            'password_confirmation' => 'required'
        ];
    }

    public function messages()
    {
        return [
            'username.required' => '用户名必填',
            'name.required' => '名称必填',
            'password.required' => '密码必填',
            'password.confirmed' => '两次输入的密码不一致',
            'password_confirmation.required' => '确认密码必填'
        ];
    }
}
