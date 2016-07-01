<?php


namespace App\Traits\Http\Controller\Validation;


use Illuminate\Contracts\Validation\ValidationException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

trait isValidatable
{
    /**
     * Validation Rules
     * 
     * @var array
     */
    protected $rules = [];
    
    /**
     * Validation Messages
     * 
     * @var array
     */
    protected $messages = [];
    
    /**
     * Validates the given array
     *
     * @param array $data
     * @throws ValidationException
     */
    protected function validateInput(array $data)
    {
        $messages = property_exists($this, 'validationMessages') ? $this->messages : [];

        $validation = Validator::make($data, $this->rules, $messages);
        if($validation->fails())
        {
            throw new ValidationException($validation->errors());
        }
    }

    /**
     * @param Request $request
     * @throws ValidationException
     */
    public function validateRequest(Request $request)
    {
        $this->validateInput($request->all());
    }
}