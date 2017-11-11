<?php

namespace App\Admin\Controllers;

use App\Major;
use Carbon\Carbon;
use Illuminate\Http\Request;
use \App\School;

class SchoolController extends Controller
{
    public function index()
    {
        $schools = School::whereNull('deleted_at')->orderBy('updated_at', 'desc')->paginate();
//        dd($schools[0]->major_count);
        return view('/admin/school/index', compact('schools'));
    }

    public function create(Request $request, $id = 0)
    {
        if (!empty($id)) {
            $school = School::find($id);
        } else {
            $school = new School();
        }
        return view('admin/school/create', compact('school'));
    }

    public function store(Request $request)
    {
        $id = request('id');
        $this->validate($request, [
            'name' => 'required|min:4|max:30|unique:schools,name'
        ]);

        if (empty($id)) {
            School::create(request(['name']));
        } else {
            School::where('id', $id)->update(request(['name']));
        }
        return redirect('/admin/schools');
    }

    public function delete(School $school)
    {
        $majorCount = Major::where('school_id', $school->id)->count();
        if ($majorCount == 0) {

            $school->deleted_at = Carbon::now()->toDateTimeString();
            $school->save();
            return [
                'error' => 0,
                'msg' => ''
            ];
        } else {
            return [
                'error' => 403,
                'msg' => '学校下有专业信息，不能删除'
            ];
        }
    }
}
