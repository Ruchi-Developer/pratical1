<?php
namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EmployeeController extends Controller {
    
 
    public function index() {
        $employees = Employee::all();
        return view('admin.employee.index', compact('employees'));
    }


    public function create() {
        return view('admin.employee.index');
    }

    public function edit($id) {
        $employee = Employee::findOrFail($id);
        return response()->json($employee); 
    }


    public function store(Request $request) {
        $request->validate([
            'name' => 'required|string|max:255',
            'department' => 'required',
            'position' => 'required',
            'phone' => 'required|string',
            'salary' => 'required|numeric',
        ]);

        $employee = new Employee();
        $employee->name = $request->name;
        $employee->department = $request->department;
        $employee->position = $request->position;
        $employee->phone = $request->phone;
        $employee->salary = $request->salary;

        $employee->save();

         return redirect()->route('employees.index')->with('success', 'Employee Added Successfully');
    }

    public function update(Request $request, $id) {
        $request->validate([
            'name'=> 'required',
            'position' => 'required|string',
            'department' => 'required|string',
            'phone' => 'nullable|string',
            'salary' => 'required|numeric',
        ]);

        $employee = Employee::findOrFail($id);
        $employee->update([
            'name' => $request->name,
            'position' => $request->position,
            'department' => $request->department,
            'phone' => $request->phone,
            'salary' => $request->salary,
        ]);

        return redirect()->route('employees.index')->with('success', 'Employee Updated Successfully');
    }

    
    public function destroy($id)
    {
        $employee = Employee::findOrFail($id);
        $employee->delete();
         return redirect()->route('employees.index')->with('success', 'Employee Deleted');
    }
    
}
