<?php

namespace App\Http\Requests\Backend;

use App\Http\Requests\Request;

class UserRequest extends Request
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
        $rules = [
            'name' => 'required|max:100',
            'category_id' => 'required',            
            // 'description_bg' => 'required',
            // 'description_en' => 'required',
            'period_bg' => 'required|max:255',
            'period_en' => 'required|max:255',
            'material_bg' => 'required|max:255',
            'material_en' => 'required|max:255',
            'price' => 'required|numeric',
            'dimensions' => 'required|max:255',

        ];

        switch ($this->method()) {
            case 'POST':
                $rules['email'] = "required|max:255|unique:user,email,NULL,id,deleted_at,NULL";
                break;
            case 'PUT':
                $rules['email'] = "required|max:255|unique:user,email,{$this->user->id},id,deleted_at,NULL";
                break;
            default:
                throw new \Exception("Method not allowed", 1);
        }

        return $rules;
        
    }

    public function messages()
    {
        return array(
                'name.required' => 'Name is required!',
            );
    }
}
