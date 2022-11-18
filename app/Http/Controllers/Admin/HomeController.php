<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Company;
use App\Models\Employee;
use App\Models\Industry;

class HomeController extends Controller
{
    public function index()
    {

        $data = [
            "title" => __("admin/general.dashboard"),
            "company" => Company::count(),
            "employee" => Employee::count(),
            "industry" => Industry::count(),
        ];

        return view("admin.home", $data);
    }
}
