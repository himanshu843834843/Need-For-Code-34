<?php

namespace App\Http\Actions;

use App\Models\Teacher;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Collection;
use Yajra\DataTables\Facades\DataTables;

class TeacherAction{
    public function getTeachers(?string $searchValue, array $order, int $start, int $length): JsonResponse
    {
        $teachers = Teacher::search($searchValue)
            ->order($order)
            ->limitBy($start, $length)
            ->get();
        $numberOfTotalRows = Teacher::count('*');

        if (empty($searchValue)) {
            $numberOfFilteredRows = $numberOfTotalRows;
        } else {
            $numberOfFilteredRows = Teacher::search($searchValue)
                ->count('*');
        }
        return $this->yajraData($teachers, $numberOfFilteredRows, $numberOfTotalRows);
    }

    private function yajraData(Collection $teachers, int $numberOfFilteredRows, int $numberOfTotalRows): JsonResponse
    {
        return DataTables::of($teachers)
            ->skipPaging()
            ->addColumn('name', function ($teacher){
                return $teacher->company->name;
            })
            ->addColumn('status', function ($teacher) {
                return '<span style="width: 120px;">
                                <span class="label font-weight-bold label-lg label-light-'
                    . (($teacher->isActive()) ? 'success' : 'danger') . ' label-inline">'
                    . $teacher->status .
                    '</span>
                            </span>';
            })
            ->addColumn('actions', function ($teacher) {
                $html = '<a href="' . route('teachers.edit', [$teacher->id]) . '"
                                class="btn btn-sm btn-clean btn-icon"
                                title="Edit details" >
                                <i class="la la-edit"></i>
                            </a>';
                $html .= '<a href="' . route('teachers.show', [$teacher->id]) . '"
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
