<?php

namespace App\Http\Actions;

use App\Models\Student;
use App\Models\Teacher;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Collection;
use Yajra\DataTables\Facades\DataTables;

class UserAction{
    public function getUsers(?string $searchValue, array $order, int $start, int $length): JsonResponse
    {
        $users = User::where('role', null)
            ->search($searchValue)
            ->order($order)
            ->limitBy($start, $length)
            ->get();
        $numberOfTotalRows = User::count('*');

        if (empty($searchValue)) {
            $numberOfFilteredRows = $numberOfTotalRows;
        } else {
            $numberOfFilteredRows = User::search($searchValue)
                ->count('*');
        }
        return $this->yajraData($users, $numberOfFilteredRows, $numberOfTotalRows);
    }

    private function yajraData(Collection $users, int $numberOfFilteredRows, int $numberOfTotalRows): JsonResponse
    {
        return DataTables::of($users)
            ->skipPaging()
            ->addColumn('actions', function ($user) {
                $html = '<a href="' . route('user.approveTeacher', [$user->id]) . '"
                        class="btn btn-warning "
                        title="Show details" >
                        MAKE TEACHER
                    </a>';
                $html .= '<a href="' . route('user.approveStudent', [$user->id]) . '"
                        class="btn btn-dark "
                        title="Show details" >
                        MAKE STUDENT
                    </a>';
                return $html;
            })
            ->rawColumns(['actions'])
            ->setFilteredRecords($numberOfFilteredRows)
            ->setTotalRecords($numberOfTotalRows)
            ->make(true);
    }

}
