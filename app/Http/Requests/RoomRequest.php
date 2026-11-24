<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RoomRequest extends FormRequest
{
    public function rules(): array
    {
        $rules = [
            'name' => 'required',
            'description' => 'required',
        ];

        if ($this->isMethod('post') && $this->route('room')) {
            $rules['image'] = 'nullable|image';
        } else {
            $rules['image'] = 'required|image';
        }

        return $rules;
    }
}
