<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;
//use Auth;

class CreateBeratRequest extends Request
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
        switch($this->method())
        {
            case 'GET':
            case 'DELETE':
            {
                return [];
            }
            case 'POST':
            {
                return [
                    'deskripsi'     => 'required',
                    'tipe'          => 'required',
                    'berat'         => 'required'
                ];
            }
            case 'PUT':
            case 'PATCH':
            {
                return [
                    'deskripsi'     => 'required',
                    'tipe'          => 'required',
                    'berat'         => 'required'
                ];
            }
            default:break;
        }
    }
    
    /**
    * Get the error messages for the defined validation rules.
    *
    * @return array
    */
   public function messages()
   {
       return [
            'deskripsi.required'          => 'Deskripsi harus diisi.',
            'tipe.required'         => 'Tipe Berat harus diisi.',
            'berat.required'      => 'Berat harus diisi.'
       ];
   }
}