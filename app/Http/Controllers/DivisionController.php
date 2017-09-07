<?php

namespace App\Http\Controllers;

use App\Division;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class DivisionController extends Controller
{
    public function getDivisionsView()
    {
        $divisions = Division::orderBy('divisionid', 'desc')->get();

        return view('admin.divisions.divisions', compact('divisions'));
    }

    public function getDivisionCreateView()
    {
        return view('admin.divisions.createdivision');
    }

    public function updateDivision(Request $request)
    {
        $division = Division::where('name', urldecode($request->name))->get();
        return view('admin.divisions.createdivision', compact('division'));
    }

    public function create(Request $request)
    {
        $division = new Division();

        $this->validate($request, [
            'name' => 'required|unique:divisions,name',
        ]);

        $visible = 0;
        if (!empty($request->input('visible'))) {
            $visible = 1;
        }

        $division->name = htmlentities($request->input('name'));
        $division->visible = $visible;
        $division->description = htmlentities($request->input('description'));
        $division->code = htmlentities($request->input('code'));
        $division->agerange = htmlentities($request->input('agerange'));

        $division->save();

        return Redirect::route('divisions');
    }

    public function update(Request $request)
    {
        $division = Division::where('divisionid', $request->divisionid)->first();

        if (is_null($division)) {
            return Redirect::route('divisions');
        }

        $this->validate($request, [
            'name' => 'required|unique:division,name,'. $request->divisionid. ',divisionid',
        ]);

        if ($request->divisionid == $division->divisionid) {

            $visible = 0;
            if (!empty($request->input('visible'))) {
                $visible = 1;
            }

            $division->name = htmlentities($request->input('name'));
            $division->visible = $visible;
            $division->description = htmlentities($request->input('description'));
            $division->code = htmlentities($request->input('code'));
            $division->agerange = htmlentities($request->input('agerange'));

            $division->save();

            return Redirect::route('divisions');
        }


    }



}
