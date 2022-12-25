<?php

namespace Tests\Unit\Request\Admin;

use App\Http\Requests\AdminPassEditRequest;
use Illuminate\Support\Facades\Validator;
use Tests\TestCase;

class AdminPasswordEditRequestTest extends TestCase
{
    /**
     * @dataProvider providerOldPass
     */
    public function testOldPassValidation($value, $expect)
    {
        $request = new AdminPassEditRequest();
        $dataList = [
            'oldpassword' => $value,
            'password' => '[R;x6A.0FS',
            'password_confirmation' => '[R;x6A.0FS',
        ];
        $validator = Validator::make($dataList, $request->rules());
        $result = $validator->passes();
        $this->assertEquals($result, $expect);
    }

    /**
     * @dataProvider providerNewConfirmPass
     */
    public function testPassValidation($new, $confirm, $expect)
    {
        $request = new AdminPassEditRequest();
        $dataList = [
            'oldpassword' => 'password',
            'password' => $new,
            'password_confirmation' => $confirm,
        ];
        $validator = Validator::make($dataList, $request->rules());
        $result = $validator->passes();
        $this->assertEquals($result, $expect);
    }

    public function providerOldPass()
    {
        return [
            ['password', true],
            [true, false],
        ];
    }

    public function providerNewConfirmPass()
    {
        return [
            ['[R;x6A.0FS', '[R;x6A.0FS', true],
            ['[R;x6A.0FS', '[R;x6A.0', false],
            ['[R;x6A.0FS', '[R', false],
        ];
    }
}
