<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class UpdateWagonRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        $wagon = $this->route('wagon');

        return $this->user()->can('update', $wagon);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'number' => ['required', 'digits:12', Rule::unique('wagons')->ignore($this->wagon)],
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
