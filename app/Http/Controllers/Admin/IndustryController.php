<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\IndustryRequest;
use App\Models\Industry;

class IndustryController extends Controller
{
    public function index()
    {
        $industries = Industry::get(["title", "id"]);

        $data = [
            "title" => __("admin/general.industries"),
            "industries" => $industries
        ];

        return view("admin.industry.index", $data);
    }

    public function store(IndustryRequest $request)
    {
        $createData = [
            "title" => $request->title,
        ];

        $create = new Industry($createData);
        $create->save();

        return redirect()->back()->with("result", "Succesfully Added");
    }

    public function edit(Industry $industry)
    {
        $data = [
            "title"     => __("admin/general.industries"),
            "industry"  => $industry,
        ];

        return view("admin.industry.edit")->with($data);
    }

    public function update(Industry $industry, IndustryRequest $request)
    {
        $industry->title = $request->title;

        $industry->save();
        return redirect()->back()->with("result", "Succesfully Updated");
    }


    public function destroy(Industry $industry)
    {
        $industry->delete();
    }
}
