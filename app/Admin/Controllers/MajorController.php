<?php

namespace App\Admin\Controllers;

use App\Major;
use Carbon\Carbon;
use Illuminate\Http\Request;
use \App\School;
use Illuminate\Support\Facades\DB;
use JavaScript;

class MajorController extends Controller
{
    public function index(Request $request)
    {
        $schoolId = $request->input('school_id', 0);
        $majors = Major::whereNull('deleted_at')->with('school')->orderBy('updated_at', 'desc')->paginate();
        if (!empty($schoolId)) {
            $majors = Major::whereNull('deleted_at')->where('school_id',
                $schoolId)->with('school')->orderBy('updated_at', 'desc')->paginate();
        }
        return view('/admin/major/index', compact('majors', 'schoolId'));
    }

    public function create(Request $request, $id = 0)
    {
        if (!empty($id)) {
            $major = Major::with('school')->find($id);
        } else {
            $major = new Major();
        }

        $schoolId = $request->input('school_id', 0);
        if (!empty($schoolId)) {
            $school = School::where('id', $schoolId)->first();
        } else {
            $school = new School();
        }
        $schools = School::whereNull('deleted_at')->orderBy('updated_at', 'desc')->get();

        return view('admin/major/create', compact('major', 'schools', 'school'));
    }

    public function store(Request $request)
    {
        $id = request('id');
        $this->validate($request, [
            'name' => 'required|min:4|max:30|unique:schools,name',
            'school_id' => 'required|min:1'
        ]);


        $data = request(['school_id', 'department', 'name']);
        if (empty($id)) {
            Major::create($data);
        } else {
            Major::where('id', $id)->update($data);
        }
        return redirect('/admin/majors');
    }

    public function delete(Major $major)
    {
        $major->deleted_at = Carbon::now()->toDateTimeString();
        $major->save();
        return [
            'error' => 0,
            'msg' => ''
        ];
    }
}
