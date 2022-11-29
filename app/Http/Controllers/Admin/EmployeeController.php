<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\EmployeeRequest;
use App\Models\Company;
use App\Models\Employee;

class EmployeeController extends Controller
{
    public function index()
    {
        $employees = Employee::with('company:id,title')->paginate(10);
        $companies = Company::get(["title", "id"]);

        $data = [
            "title" => __("admin/general.employees"),
            "employees" => $employees,
            "companies" => $companies
        ];

        return view("admin.employee.index", $data);
    }

    public function store(EmployeeRequest $request)
    {
        $createData = [
            "name"          => $request->name,
            "phone"         => $request->phone,
            "address"       => $request->address,
            "company_id"    => $request->company_id,
        ];

        $create = new Employee($createData);
        $create->save();

        return redirect()->back()->with("result", "Succesfully Added");
    }

    public function edit(Employee $employee)
    {
        $data = [
            "title"     => __("admin/general.employees"),
            "employee"  => $employee,
            "companies" => Company::get(["title", "id"])
        ];
        return view("admin.employee.edit")->with($data);
    }

    public function update(Employee $employee, EmployeeRequest $request)
    {
        $employee->name         = $request->name;
        $employee->phone        = $request->phone;
        $employee->address      = $request->address;
        $employee->company_id   = $request->company_id;
        $employee->save();

        return redirect()->back()->with("result", "Succesfully Updated");
    }

    public function destroy(Employee $employee)
    {
        $employee->delete();
    }
}
