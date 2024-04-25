<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;


class ReservationStoreRequest extends FormRequest
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
            'date' => 'required|date|after_or_equal:today',
            'time' => 'required',
            'number' => 'required',
            // その他の必要なバリデーションルールを追加
        ];
        
    }

    public function messages()
    {
        return [
            'date.required' => '※日付を入力してください。',
            'time.required' => '※時間を入力してください。',
            'time.after' => '※只今の時間以降を入力してください。',
            'date.after_or_equal' => '※本日以降の日時を入力してください。',
            'number.required' => '※人数を入力してください。',
        ];
    }
}
// after_or_equal:now