<?php

namespace App\Http\Controllers;

use App\Http\Requests\StudentFormRequest;
use App\Http\Requests\UpdateStudentFormRequest;
use App\Models\Student;
use App\Models\Subject;
use Illuminate\Http\Request;
use DataTables;

class StudentController extends Controller
{
    /**
     * @param Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Student::select('*');
            return Datatables::of($data)
                ->addIndexColumn()
                ->editColumn('status', function ($row) {
                    return ($row->status == 1 ? '<span class="badge alert-success">Active</span>' : '<span class="badge alert-danger">Inactive</span>') . ' <a href="javascript:;" data-id="' . $row->id . '" class="edit btn btn-primary btn-sm toggle_status">Toggle Status</a>';
                })
                ->addColumn('action', function ($row) {
                    $btn = '<a href="' . route('students.show', [$row->id]) . '" class="edit btn btn-primary btn-sm">View</a>';
                    $btn .= ' <a href="' . route('students.edit', [$row->id]) . '" class="edit btn btn-primary btn-sm">Edit</a>';
                    $btn .= ' <form method="post" action="' . route('students.destroy', ['student' => $row->id]) . '">' . csrf_field() . '<input type="hidden" name="_method" value="delete"><button class="edit btn btn-danger btn-sm">Delete</button></form>';
                    return $btn;
                })
                ->rawColumns(['action', 'status'])
                ->make(true);
        }

        return view('students.index');
    }

    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function create()
    {
        return view('students.create');
    }

    /**
     * @param Student $student
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function edit(Student $student)
    {
        return view('students.edit', compact('student'));
    }

    /**
     * @param Student $student
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function show(Student $student)
    {
        return view('students.show', compact('student'));
    }

    /**
     * @param StudentFormRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(StudentFormRequest $request)
    {
        $studentData = $request->except(['subjects']);
        $student = Student::create($studentData);

        $subjectData = $request->only(['subjects']);
        if (!empty($subjectData['subjects']['name']) && count($subjectData['subjects']['name']) > 0) {
            $this->insertSubjects($subjectData['subjects'], $student);
        }
        return back()->with('success', 'Student record successfully created.');
    }

    /**
     * @param Student $student
     * @param UpdateStudentFormRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Student $student, UpdateStudentFormRequest $request)
    {
        $studentData = $request->except(['subjects']);
        $student->update($studentData);
        $subjectData = $request->only(['subjects']);

        $student->subjects()->delete();
        if (!empty($subjectData['subjects']['name']) && count($subjectData['subjects']['name']) > 0) {
            $this->insertSubjects($subjectData['subjects'], $student);
        }

        return back()->with('success', 'Student record successfully created.');
    }

    /**
     * @param $subjectData
     * @param $student
     * @return bool
     */
    public function insertSubjects($subjectData = [], $student)
    {
        $aubjectArray = [];
        $subjectNames = $subjectData['name'];
        $subjectMarks = $subjectData['marks'];
        $subjectGrades = $subjectData['grade'];
        foreach ($subjectData['name'] as $key => $val) {
            $aubjectArray[] = [
                'student_id' => $student->id,
                'name' => $val,
                'marks' => $subjectMarks[$key],
                'grade' => $subjectGrades[$key],
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ];
        }
        Subject::insert($aubjectArray);
        return true;
    }

    /**
     * @param Student $student
     * @param UpdateStudentFormRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Student $student)
    {
        $student->subjects()->delete();
        $student->delete();
        return back()->with('success', 'Student record successfully deleted.');
    }

    /**
     * @param Student $student
     * @return \Illuminate\Http\JsonResponse
     */
    public function updateStatus(Request $request)
    {
        $student = Student::where('id', $request->id)->first();
        if (empty($student)) {
            return response()->json(['status' => 402], 402);
        }
        $student->status = $student->status == 0 ? 1 : 0;
        $student->save();
        return response()->json(['status' => 200, 'updated_status' => $student->status == 1 ? 'Active' : 'Inactive', 'class' => $student->status == 1 ? 'alert-success' : 'alert-danger'], 200);
    }
}
