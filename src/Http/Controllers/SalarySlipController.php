<?php

namespace Kumarrahul\salaryslipuploader\Http\Controllers;

use App\Http\Controllers\Member\MemberBaseController;
use App\EmployeeDetails;
use App\User;
use App\Role;
use Auth;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Notification;
use Yajra\DataTables\Facades\DataTables;
use Kumarrahul\salaryslipuploader\Models\SalarySlip;

class SalarySlipController extends MemberBaseController
{
    public function __construct() {
        parent::__construct();
        $this->pageTitle = __('Salary Slip');
        $this->pageIcon = 'ti-layout-list-thumb';
        
        $this->middleware(function ($request, $next) {
            $this->user = auth()->user();
            $this->modules = $this->user->modules;

            $userRole = $this->user->role; // Getting users all roles

            if(count($userRole) > 1){ $roleId = $userRole[1]->role_id; } // if single role assign getting role ID
            else{ $roleId = $userRole[0]->role_id; } // if multiple role assign getting role ID

            // Getting role detail by ID that got above according single or multiple roles assigned.
            $this->userRole = Role::where('id', $roleId)->first();

            
            return $next($request);
        });
        

    }
    
    public function index()
    {
        $emp_id = EmployeeDetails::where('user_id', $this->user->id)->pluck('employee_id');
        $dir_path = public_path('salary-slip');
        $all_slips = array_slice(scandir($dir_path), 2);
        foreach($all_slips as $key => $value){
            $existing_file = SalarySlip::where('file_name', $value)->get()->count();
            if($existing_file <= 0) {
                if (strpos($value, $emp_id[0]) !== false) {
                    $ss = SalarySlip::create([
                        'emp_id' => $emp_id[0],
                        'file_name' => $value
                        ]);
                }
            }
        }
        return view('salaryslipuploader::index',  $this->data);
    }
    
    public function data(Request $request) {
        
        $emp_id = EmployeeDetails::where('user_id', $this->user->id)->pluck('employee_id');
        $slips = SalarySlip::select('id','file_name')->where('emp_id', $emp_id)->get();

        return DataTables::of($slips)
            ->addColumn('action', function ($row) {
                $action = '';
                $action.= ' <a href="' . route('member.salary.download', [$row->id]) . '" class="btn btn-info btn-circle"
                  data-toggle="tooltip" data-original-title="Download">↓</a>';
                return $action;
            })
            ->make(true);
    }
    
    public function download(Request $request, $slip_id) {
        
        $emp_id = EmployeeDetails::where('user_id', $this->user->id)->pluck('employee_id');
        $slips = SalarySlip::where('id', $slip_id)->pluck('file_name');
        
        if (strpos($slips[0], $emp_id[0]) !== false) {
            $file_link = url('/').'/salary-slip/'.$slips[0];
            return response()->file(public_path('salary-slip/'.$slips[0]));
        } else {
           abort(403);
        }
        
    }

}