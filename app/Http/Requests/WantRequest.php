<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class WantRequest extends FormRequest
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
            'can_keep_reson' => ['required', 'string', 'max:300'],
            'keep_after' => ['required', 'string', 'max:255'],
        ];
    }
}
