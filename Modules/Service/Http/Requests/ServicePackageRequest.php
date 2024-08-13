<?php

namespace Modules\Service\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ServicePackageRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        switch (strtolower($this->getMethod())) {
            case 'post':
                return [
                    'name' => 'required|string|max:255',
                    'employee_id' => 'required',
                    'category_id' => 'required',
                    'price' => 'required',
                ];
                break;
            case 'put':
            case 'patch':
                return [
                    'name' => 'required|string|max:255',
                    'employee_id' => 'required',
                    'category_id' => 'required',
                    'price' => 'required',
                ];
                break;

            default:
                // code...
                break;
        }
    }

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }
}
