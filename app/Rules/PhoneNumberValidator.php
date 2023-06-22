<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use libphonenumber\NumberParseException;
use libphonenumber\PhoneNumberUtil;

class PhoneNumberValidator implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */

    protected $countryCode;

    public function __construct($countryCode)
    {
        $this->countryCode = $countryCode;
    }
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $phoneUtil = PhoneNumberUtil::getInstance();
        try {
            $phoneNumber = $phoneUtil->parse($value, $this->countryCode);
            if (!$phoneUtil->isValidNumber($phoneNumber) && !$phoneUtil->isValidNumberForRegion($phoneNumber, $this->countryCode)){
                $fail("The phone number is not valid");
            }
        } catch (NumberParseException $e){
            $fail($e->getMessage());
        }
    }
}
