<?php

namespace App\Http\Controllers;

use App\Http\Controllers\BaseController;
use App\Http\Requests\ResetPasswordFormRequest;
use App\Models\Customer;
use App\Models\Expense;
use App\Models\Product;
use App\Models\Sale;
use App\Models\Stock;
use App\Models\User;
use App\Models\Vendor;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\App;
use stdClass;

class HomeController extends BaseController
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
        App::setLocale('en');
        session()->put('locale', 'en');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $this->setPageTitle('Dashboard', 'Dashboard');

        if( auth()->user()->is_password_changed == 'yes' ){
            return view('dashboard.index');
        }else{
            return view('dashboard.reset_password');
        }
    }

    /**
     * CHANGE PASSWORD FORM
     */
    public function changePassword()
    {
        $this->setPageTitle('ChangePassword', 'Change Password');

        return view('dashboard.change_password');
    }

    /**
     *RESET / CHANGE PASSWORD
     */
    public function resetPassword(ResetPasswordFormRequest $request)
    {
        $affected = User::where(
            ['id' => auth()->user()->id ]
        )->update(['password' => bcrypt($request->password), 'is_password_changed' => 'yes']);

        if ($affected > 0) {
            return $this->responseRedirect('home', trans('common.reset_success'), 'success', false, false);
        }

        return $this->responseRedirectBack( trans('common.reset_error'), 'error', true, true);
    }
}
