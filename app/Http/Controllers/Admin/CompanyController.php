<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\CompanyRequest;
use App\Models\Company as ModelsCompany;
use App\Models\Industry;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Str;

class CompanyController extends Controller
{
    public function index()
    {
        $companies = ModelsCompany::paginate(10);

        $data = [
            "title"         => __("admin/general.companies"),
            "companies"     => $companies,
            "industries"    => Industry::get(["id", "title"])
        ];

        return view("admin.company.index", $data);
    }

    public function store(CompanyRequest $request)
    {
        $companyLogo = null;

        if ($request->hasFile('logo')) {
            $companyLogo = Str::random(4) . "-" . Str::slug(Str::substr($request->title, 0, 40), '-') . "." . $request["logo"]->extension();

            $cover = Image::make($request->file('logo'))->encode('jpg', 100);
            Storage::disk('company')->put($companyLogo, $cover);
        }

        $createData = [
            "title"         => $request->title,
            "description"   => $request->description,
            "logo"          => $companyLogo
        ];
        $create = new ModelsCompany($createData);

        if ($create->save()) {
            $create->industry()->sync($request->industry, ['company_id' => $create->id]);
            return redirect()->back()->with("result", "Succesfully Added");
        }
    }

    public function edit(ModelsCompany $company)
    {
        $data = [
            "title"         => __("admin/general.companies"),
            "company"       => $company,
            "industries"    => Industry::get(["id", "title"])
        ];
        return view("admin.company.edit")->with($data);
    }

    public function update(ModelsCompany $company, CompanyRequest $request)
    {
        $company->industry()->sync($request->industry, ['company_id' => $company->id]); //Pivot tabloya id'leri senkronize etme

        if ($request->hasFile('logo')) {
            $companyLogo = Str::random(4) . "-" . Str::slug(Str::substr($request->title, 0, 40), '-') . "." . $request->logo->extension();

            $cover = Image::make($request->file('logo'))->encode('jpg', 100);
            Storage::disk('company')->put($companyLogo, $cover);

            $company->logo = $companyLogo;
        }

        $company->title = $request->title;
        $company->description = $request->description;
        $company->save();

        if ($company->save()) {
            return redirect()->back()->with("result", "Succesfully Updated");
        } else {
            return redirect()->back()->withErrors($validated);
        }
    }

    public function destroy(ModelsCompany $company)
    {
        $company->delete();
    }
}
