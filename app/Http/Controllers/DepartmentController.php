<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\Department;

use Illuminate\Http\Request;

class DepartmentController extends Controller
{
    /**
     * Display a listing of the resource. Get department wise employees data
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $query = Department::select('name', 'id')->with(['employees' => function ($query) {
            $query->select('id', 'name', 'salary', 'department_id');
        }])->withSum('employees', 'salary')->get();

        return response()->json($query);
    }
}
