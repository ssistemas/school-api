<?php

namespace Emtudo\Domains\Tenants\Resources\Rules;

use Emtudo\Support\Shield\Rules;

class TenantRules extends Rules
{
    public function defaultRules()
    {
        return [
            'name' => 'required|string|max:255',
            'email' => 'required|string|max:255|email|unique:tenants,email',
            'country_register' => 'required|cnpj|unique:tenants,country_register',
            'phones' => 'required|array',
            'phones.work' => 'required|nullable|phone_br',
            'phones.mobile' => 'required|cellphone_br',
            'phones.other' => 'sometimes|nullable|phone_br',
            'address' => 'required|array',
            'address.street' => 'required|string|max:60',
            'address.number' => 'required|string|max:10',
            'address.city' => 'required|string|max:60',
            'address.district' => 'required|string|max:60',
            'address.zip' => 'required|string|max:8',
            'address.state' => 'required|in:AC,AL,AP,AM,BA,CE,DF,ES,GO,MA,MT,MS,MG,PA,PB,PR,PE,PI,RJ,RN,RS,RO,RR,SC,SP,SE,TO',
        ];
    }

    public function creating($callback = null)
    {
        return $this->returnRules([
        ], $callback);
    }

    public function updating($callback = null)
    {
        return $this->returnRules([
        ], $callback);
    }
}
