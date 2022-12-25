<?php

namespace Tests\Unit\Request\Admin;

use App\Http\Requests\AdminProfileEditRequest;
use Illuminate\Support\Facades\Validator;
use Tests\TestCase;

class AdminProfileEditRequestTest extends TestCase
{
    /**
     * @dataProvider providerName
     */
    public function testNameValidation($value, $expect)
    {
        $request = new AdminProfileEditRequest();
        $dataList = [
            'name' => $value,
        ];
        $validator = Validator::make($dataList, $request->rules());
        $result = $validator->passes();
        $this->assertEquals($result, $expect);
    }

    /**
     * @dataProvider providerEmail
     */
    public function testEmailValidation($value, $expect)
    {
        $request = new AdminProfileEditRequest();
        $dataList = [
            'email' => $value,
        ];
        $validator = Validator::make($dataList, $request->rules());
        $result = $validator->passes();
        $this->assertEquals($result, $expect);
    }

    public function providerName()
    {
        return [
            ['phanloctest', true],
            ['phanlocupdate', true],
            ['test2', false],
            ['test', false],
        ];
    }

    public function providerEmail()
    {
        return [
            ['phanloc@gmail.com', true],
            ['test', false],
        ];
    }
}
