<?php

namespace App\Http\Controllers;

use App\Helpers\Constants\BaseConstants;
use App\Http\Actions\StudentAction;
use App\Http\Actions\UserAction;
use App\Models\Student;
use App\Models\Teacher;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Silber\Bouncer\BouncerFacade;

class UserController extends Controller
{
    public function __construct(UserAction $userAction)
    {
        $this->userAction = $userAction;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('user.index');
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function getUsersJson(Request $request): JsonResponse
    {
        try {
            $data = $this->userAction->getUsers($request->search['value'], $request->order, $request->start, $request->length);
        } catch (\Exception $ex) {
            dd($ex);
            return response()->json(['message' => 'Something Went Wrong'], 500);
        }
        return $data;
    }

    public function approveUserAsTeacher(){
        try {
            Teacher::create([
                'user_id'   =>  auth()->id(),
                'status'    =>  BaseConstants::ACTIVE
            ]);
            auth()->user()->update(['role' => 'teacher']);
        } catch (ValidationException $exception) {
            return redirect()->back()->withErrors($exception->errors());
        } catch (Exception $exception) {
            return redirect()->back()->withErrors($exception->getMessage());
        }
        return redirect()->route('users.index')->with('success', 'User updated successfully');
    }

    public function approveUserAsStudent(){
        try {
            Student::create([
                'user_id'   =>  auth()->id(),
                'status'    =>  BaseConstants::ACTIVE
            ]);
            auth()->user()->update(['role' => 'student']);
        } catch (ValidationException $exception) {
            return redirect()->back()->withErrors($exception->errors());
        } catch (Exception $exception) {
            return redirect()->back()->withErrors($exception->getMessage());
        }
        return redirect()->route('users.index')->with('success', 'User updated successfully');
    }
}
