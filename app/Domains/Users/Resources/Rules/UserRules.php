<?php

namespace Emtudo\Domains\Users\Resources\Rules;

use Emtudo\Support\Shield\Rules;

class UserRules extends Rules
{
    public function defaultRules()
    {
        return [
            'name' => 'required|string|max:50',
            'email' => 'required|string|max:255|email|unique:users',
            'password_confirmation' => 'required_with:password',
            'country_register' => 'bail|required|cpf|unique:users,country_register',
            'state_register' => [
                'sometimes',
                'regex:/[0-9]/',
            ],
            'state_register_entity' => 'required_with:state_register|in:SSP,PM,PC,CNT,DIC,CTPS,FGTS,IFP,IPF,IML,MTE,MMA,MAE,MEX,POF,POM,SES,SJS,SJTS,ZZZ',
            'state_register_state' => 'required_with:state_register|in:AC,AL,AP,AM,BA,CE,DF,ES,GO,MA,MT,MS,MG,PA,PB,PR,PE,PI,RJ,RN,RS,RO,RR,SC,SP,SE,TO',
            'birthdate' => 'required|date|date_format:Y-m-d',

            'phones' => 'required|array',
            'phones.home' => 'sometimes|nullable|phone_br',
            'phones.mobile' => 'required|cellphone_br',
            'phones.work' => 'sometimes|nullable|phone_br',

            'address' => 'required|array',
            'address.street' => 'required|string|max:60',
            'address.number' => 'required|string|max:10',
            'address.city' => 'required|string|max:60',
            'address.state' => 'required|in:AC,AL,AP,AM,BA,CE,DF,ES,GO,MA,MT,MS,MG,PA,PB,PR,PE,PI,RJ,RN,RS,RO,RR,SC,SP,SE,TO',
            'address.district' => 'required|string|max:60',
            'address.zip' => 'required|string|max:8',
            'have_profiles' => 'sometimes|array',
            // 'have_profiles.manager' => 'required|boolean',
            'have_profiles.student' => 'required|boolean',
            'have_profiles.responsible' => 'required|boolean',
            'have_profiles.teacher' => 'required|boolean',
        ];
    }

    public function creating($callback = null)
    {
        return $this->returnRules([
            'password' => 'required|min:6|confirmed',
        ], $callback);
    }

    public function updating($callback = null)
    {
        return $this->returnRules([
            'email' => 'required|email',
            //'password' => 'sometimes|min:6|confirmed',
        ], $callback);
    }

    public function document($callback = null)
    {
        return $this->rules([
            'document' => 'required|mimes:jpg,png,jpeg,pdf|between:1,1024',
            'kind' => 'required|in:country_register,state_register,address',
        ], $callback);
    }

    public function avatar($callback = null)
    {
        return $this->rules([
            'avatar' => 'required|mimes:jpg,png,jpeg|between:1,1024',
        ], $callback);
    }
}
