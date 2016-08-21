<?php

namespace App\Http\Controllers\Backend;

use App\Models\User;
use Validator;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use Illuminate\Foundation\Auth\AuthenticatesAndRegistersUsers;

class FinancialController extends Controller
{

    public function b2cpaymentsIndex ()
    {
        return view('backend.admin.financial_management.b2cpayments.index');
    }

    public function b2cpaymentShow ()
    {
        return view('backend.admin.financial_management.b2cpayments.show');
    }

}