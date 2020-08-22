<?php

namespace App\Http\Requests;

use App\Wagon;
use Illuminate\Foundation\Http\FormRequest;

class StoreWagonRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return $this->user()->can('create', Wagon::class);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'number' => 'required|digits:12|unique:wagons,number',
            'letter_index' => '',
            'v_max' => 'sometimes|nullable|integer',
            'seats' => 'sometimes|nullable|integer',
            'depot_id' => 'sometimes|nullable|integer|exists:depots,id',
            'revisory_point_id' => 'sometimes|nullable|integer|exists:revisory_points,id',
            'revision_date' => 'sometimes|nullable|date',
            'status_id' => 'sometimes|nullable|integer|exists:statuses,id'
        ];
    }
}
