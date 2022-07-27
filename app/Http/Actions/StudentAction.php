<?php

namespace App\Http\Actions;

use App\Models\Student;
use App\Models\Teacher;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Collection;
use Yajra\DataTables\Facades\DataTables;

class StudentAction{
    public function getStudents(?string $searchValue, array $order, int $start, int $length): JsonResponse
    {
        $students = Student::search($searchValue)
            ->order($order)
            ->limitBy($start, $length)
            ->get();
        $numberOfTotalRows = Student::count('*');

        if (empty($searchValue)) {
            $numberOfFilteredRows = $numberOfTotalRows;
        } else {
            $numberOfFilteredRows = Student::search($searchValue)
                ->count('*');
        }
        return $this->yajraData($students, $numberOfFilteredRows, $numberOfTotalRows);
    }

    private function yajraData(Collection $students, int $numberOfFilteredRows, int $numberOfTotalRows): JsonResponse
    {
        return DataTables::of($students)
            ->skipPaging()
            ->addColumn('name', function ($student){
                return $student->company->name;
            })
            ->addColumn('status', function ($student) {
                return '<span style="width: 120px;">
                                <span class="label font-weight-bold label-lg label-light-'
                    . (($student->isActive()) ? 'success' : 'danger') . ' label-inline">'
                    . $student->status .
                    '</span>
                            </span>';
            })
            ->addColumn('actions', function ($student) {
                $html = '<a href="' . route('teachers.edit', [$student->id]) . '"
                                class="btn btn-sm btn-clean btn-icon"
                                title="Edit details" >
                                <i class="la la-edit"></i>
                            </a>';
                $html .= '<a href="' . route('teachers.show', [$student->id]) . '"
                        class="btn btn-sm btn-clean btn-icon "
                        title="Show details" >
                        <i class="la la-eye"></i>
                    </a>';
                return $html;
            })
            ->rawColumns(['actions', 'status'])
            ->setFilteredRecords($numberOfFilteredRows)
            ->setTotalRecords($numberOfTotalRows)
            ->make(true);
    }

}
