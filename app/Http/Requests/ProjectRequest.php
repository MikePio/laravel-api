<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProjectRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
      // di deafult è false
      // return false;
      // ma //* per il controllo degli errori bisogna passare a true
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
//* necessari per la soluzione 1 MIGLIORE -> public function store(ProjectRequest $request){
    public function rules()
    {
        return [
          'name' => 'required|min:2|max:50',
          // 'description' => ''
          'category' => 'required|min:2|max:255',
          'start_date' => 'date',
          'end_date' => 'date|after:start_date',
          'url' => 'required|min:4|max:255',
          'produced_for' => 'max:255',
          'collaborators' => 'max:255'
        ];
    }
//* necessari per la soluzione 1 MIGLIORE -> public function store(ProjectRequest $request){
    public function messages(){
      return [
          'name.required' => 'The name field is required',
          'name.min' => 'The name must be at least :min characters',
          'name.max' => 'The name must not exceed :max characters',

          // 'image.required' => 'The image field is required',

          'category.required' => 'The category field is required',
          'category.min' => 'The category field must be at least :min characters',
          'category.max' => 'The category field must not exceed :max characters',

          'start_date.date' => 'The start date was written incorrectly',

          'end_date.date' => 'The start date was written incorrectly',

          'url.required' => 'The url field is required',
          'url.min' => 'The url field must be at least :min characters',
          'url.max' => 'The url field must not exceed :max characters',

          'produced_for.max' => 'The produced for field must not exceed :max characters',

          'collaborators.max' => 'The collaborators field must not exceed :max characters',

      ];

    }
}
