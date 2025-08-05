<?php

namespace App\Http\Requests\Voids;

use App\Http\Requests\Request;
use Session, Log;

class StoreVoidPointRequest extends Request
{
    public function authorize()
    {
        return false;
    }

    public function rules()
    {
        return [
            //
        ];
    }
}
