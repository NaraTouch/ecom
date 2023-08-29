<?php

namespace AppModule\Customer\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use AppModule\Core\Contracts\Validations\Address;
use AppModule\Core\Contracts\Validations\AlphaNumericSpace;
use AppModule\Core\Contracts\Validations\PhoneNumber;
use AppModule\Customer\Rules\VatIdRule;

class CustomerAddressRequest extends FormRequest
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
            'company_name' => [new AlphaNumericSpace],
            'first_name'   => ['required', new AlphaNumericSpace],
            'last_name'    => ['required', new AlphaNumericSpace],
            'address1'     => ['required', 'array'],
            'address1.*'   => ['required', new Address],
            'country'      => [new AlphaNumericSpace],
            'state'        => [new AlphaNumericSpace],
            'city'         => ['required', 'string'],
            'postcode'     => ['required', 'numeric'],
            'phone'        => ['required', new PhoneNumber],
            'vat_id'       => [new VatIdRule()],
        ];
    }

    /**
     * Attributes.
     *
     * @return array
     */
    public function attributes()
    {
        return [
            'address1.*' => 'address',
        ];
    }
}
