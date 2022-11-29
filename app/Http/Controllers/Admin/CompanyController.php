<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\CompanyRequest;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Str;
use App\Models\Company;
use App\Models\Industry;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class CompanyController extends Controller
{
    public function index()
    {
        $data = [
            "title"         => __("admin/general.companies"),
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
        $create = new Company($createData);

        if ($create->save()) {
            $create->industry()->sync($request->industry, ['company_id' => $create->id]);
            return redirect()->back()->with("result", "Succesfully Added");
        }
    }

    public function edit(Company $company)
    {
        $data = [
            "title"         => __("admin/general.companies"),
            "company"       => $company,
            "industries"    => Industry::get(["id", "title"])
        ];
        return view("admin.company.edit")->with($data);
    }

    public function update(Company $company, CompanyRequest $request)
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

        if ($company->save()) {
            return redirect()->back()->with("result", "Succesfully Updated");
        }
    }

    public function destroy(Company $company)
    {
        $company->delete();
    }

    public function ajaxPaginate()
    {
        $company = Company::query(['id', 'title', 'description', 'logo']);

        return Datatables::of($company)
            ->addColumn('process', function ($company) {
                $btn = '
                <a href="' . route("admin.company.edit", $company->id) . '"
                class="btn rounded-pill btn-primary">' . __("admin/general.edit") . '</a>';

                $btn .= '<button type="button" class="btn rounded-pill btn-danger delete"
                id="' . $company->id . '">' . __("admin/general.del") . '</button>
                ';

                return $btn;
            })
            ->addColumn('logo', function ($company) {
                return '<img style="width:100%" src="' . Storage::url('company/' . $company->logo) . '">';
            })
            ->rawColumns(['process', 'logo'])
            ->make(true);
    }
}
