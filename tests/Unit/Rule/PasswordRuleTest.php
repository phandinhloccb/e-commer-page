<?php

namespace Tests\Unit\Rule;

use App\Rules\PasswordRule;
use Illuminate\Support\Facades\Validator;
use Tests\TestCase;

class PasswordRuleTest extends TestCase
{
    /**
     * @dataProvider providerPassword
     */
    public function testPassword($password, $expect)
    {
        $rule = ['rule' => new PasswordRule()];
        $dataList = [];
        $dataList['rule'] = $password;
        $validator = Validator::make($dataList, $rule);
        $result = $validator->passes();
        $this->assertEquals($expect, $result);
    }

    public function providerPassword()
    {
        return [
            ['[R;x6A.0', true],
            ['[R;A.6788@teTe.;', true],
            ['[R;x', false],
            ['11111111111111', false],
            ['aaaaaaaaaaaaaa', false],
            ['11111111aaaaaa', false],
            ['@@@@@@@@@@@@@@@', false],
        ];
    }
}
