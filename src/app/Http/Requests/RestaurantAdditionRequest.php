<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RestaurantAdditionRequest extends FormRequest
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
            'reservation_id' => 'required',
            'name' => 'required',
            'area' => 'required',
            'genre' => 'required',
            'content' => 'required',
            'restaurant-image' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'reservation_id.required' => '※店舗代表者を入力してください。',
            'name.required' => '※店舗名を入力してください。',
            'area.required' => '※エリアを入力してください。',
            'genre.required' => '※ジャンルを入力してください。',
            'content.required' => '※説明を入力してください。',
            'restaurant-image.required' => '※アップロードする画像を選択してください。',
        ];
    }
}
