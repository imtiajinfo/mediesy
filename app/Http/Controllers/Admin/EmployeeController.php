<?php

namespace App\Http\Controllers\Admin;

use Carbon\Carbon;
use App\Models\Role;
use App\Models\User;
use App\Models\Store;
use App\Models\Country;
use App\Models\Upazila;
use App\Models\District;
use App\Models\Employee;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Crypt;
use App\Http\Requests\StoreEmployeeRequest;
use App\Http\Requests\UpdateEmployeeRequest;
use Illuminate\Contracts\Encryption\DecryptException;

class EmployeeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        try {
            DB::beginTransaction();

            $perPage = $request->input('per_page', 10); // Default to 10 records per page, adjust as needed
            $search = $request->input('search');
            $status = $request->input('status'); // 'active', 'inactive', or null
            $query = Employee::leftJoin('countries', 'employees.country', '=', 'countries.id')
                ->leftJoin('districts', 'employees.country', '=', 'districts.id')
                ->leftJoin('upazilas', 'employees.country', '=', 'upazilas.id')
                // ->query()
                ->select(
                    'employees.id',
                    'employees.name',
                    'employees.image',
                    'employees.nid_font',
                    'employees.nid_back',
                    'employees.salary',
                    'email',
                    'store_id',
                    'role',
                    'phone',
                    'nid',
                    'email_verified_at',
                    'password',
                    'password_confirmation',
                    // 'countries.name as country_name',
                    // 'districts.name as district_name',
                    // 'upazilas.name as upazila_name',
                    'postcode',
                    'address',
                    'status'
                )
                // ->whereIn('status', [0, 1])
                ->latest('id');

            // Apply status filter
            if ($status) {
                $query->where('status' === $status);
            }
            // Apply search filter
            if ($search) {
                $query->where(function ($query) use ($search) {
                    // Dynamically search across all columns
                    $fillableColumns = (new Employee())->getFillable(); // Fetch all fillable columns
                    foreach ($fillableColumns as $column) {
                        $query->orWhere($column, 'like', '%' . $search . '%');
                    }
                });
            }

            $query = $query->paginate($perPage);
            // return ($query);
            DB::commit();
        } catch (\Exception $error) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'error' => 'An error occurred.',
                'message' => $error->getMessage(),
            ], 500);
        }
        return view('admin.employees.index', with(['employees' => $query,]));
    }


    public function create()
    {
        $countries = Country::with('districts', 'upazilas')->get();
        $districts = District::get();
        $stores = Store::get();
        $roles = Role::get();
        return view('admin.employees.create', with(['countries' => $countries, 'districts' => $districts, 'stores' => $stores, 'roles' => $roles]));
    }

    /**
     * Store a newly created resource in storage.
     */

    public function store(StoreEmployeeRequest $request)
    {
        DB::beginTransaction();
        try {
            $requestDataAll = $request->validated();

            $slug = Str::slug($request->name);

            // Extract relevant fields from request data
            $userData = $request->only(['name', 'email', 'password', 'role', 'store_id']);

            // Hash the password before saving the user
            $userData['password'] = Crypt::encrypt($userData['password']);

            // Create the user
            $user = User::create($userData);

            // Retrieve store_id from the user object
            $storeId = $user->store_id ?? null;




            if ($request->hasFile('image')) {
                $image = $request->file('image');
                $slug = str_slug($request->name);
                $currentDate = Carbon::now()->format('d-m-Y-h-i-s-');
                $image_name = $slug . '-' . $currentDate . rand(100, 999) . '.' . $image->getClientOriginalExtension();

                if (!File::exists(public_path('uploads/employee'))) {
                    File::makeDirectory(public_path('uploads/employee'), 0777, true, true);
                }
                $image->move('uploads/employee', $image_name);
            } else {
                $image_name = 'default.png';
            }


            if ($request->hasFile('nid_font')) {
                $nid_font = $request->file('nid_font');
                $slug = str_slug($request->name);
                $currentDate = Carbon::now()->format('d-m-Y-h-i-s-');
                $nid_font_name = $slug . '-' . $currentDate . rand(100, 999) . '.' . $nid_font->getClientOriginalExtension();

                if (!File::exists(public_path('uploads/employee'))) {
                    File::makeDirectory(public_path('uploads/employee'), 0777, true, true);
                }
                $nid_font->move('uploads/employee', $nid_font_name);
            } else {
                $nid_font_name = 'default.png';
            }

            if ($request->hasFile('nid_back')) {
                $nid_back = $request->file('nid_back');
                $slug = str_slug($request->name);
                $currentDate = Carbon::now()->format('d-m-Y-h-i-s-');
                $nid_back_name = $slug . '-' . $currentDate . rand(100, 999) . '.' . $nid_back->getClientOriginalExtension();

                if (!File::exists(public_path('uploads/employee'))) {
                    File::makeDirectory(public_path('uploads/employee'), 0777, true, true);
                }
                $nid_back->move('uploads/employee', $nid_back_name);
            } else {
                $nid_back_name = 'default.png';
            }








            // Ensure store_id is not null before creating the employee record
            if ($storeId !== null) {
                // Create the associated employee record
                $employeeData = array_merge($requestDataAll, [
                    'user_id' => $user->id,
                    'store_id' => $storeId,
                    'slug' => $slug,
                    'image' => $image_name,
                    'nid_font' => $nid_font_name,
                    'nid_back' => $nid_back_name,
                    'password' =>  Crypt::encrypt($userData['password']) // Store hashed password 
                ]);

                Employee::create($employeeData);

                DB::commit();

                session()->flash('success', 'employee added successfully.');
                return redirect()->route('admin.employees.index')->with('success', 'Inserted successfully.');
            } else {
                throw new \Exception('Store ID is null for the user');
            }
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['message' => 'Error creating employees', 'error' => $e->getMessage()], 500);
        }
    }
    /**
     * Display the specified resource.
     */
    public function show(Employee $employee)
    {
        $countries = Country::with('districts', 'upazilas')->get();
        $district = District::where('id', $employee->district)->first();
        $upazila = Upazila::where('id', $employee->upazila)->first();
        $role = Role::where('id', $employee->role)->first();
        $stores = Store::get();
        $roles = Role::get();
        $employee = $employee;
        return view('admin.employees.show', with(['employee' => $employee, 'countries' => $countries, 'district' => $district, 'upazila' => $upazila, 'stores' => $stores, 'roles' => $roles]));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Employee $employee)
    {
        $countries = Country::with('districts', 'upazilas')->get();
        $district = District::where('id', $employee->district)->first();
        $upazila = Upazila::where('id', $employee->upazila)->first();
        $role = Role::where('id', $employee->role)->first();
        $stores = Store::get();
        $roles = Role::get();
        $employee = $employee;
        try {
            $encryptedPassword = $employee->password;
            $decryptedPassword = Crypt::decrypt($encryptedPassword);
        } catch (DecryptException $e) {
            // Log the error for investigation
            Log::error('Failed to decrypt password: ' . $e->getMessage());
            // Set decrypted password to null or an empty string
            $decryptedPassword = null;
        }

        return view('admin.employees.edit', with(['decryptedPassword' => $decryptedPassword, 'employee' => $employee, 'countries' => $countries, 'district' => $district, 'upazila' => $upazila, 'stores' => $stores, 'roles' => $roles]));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateEmployeeRequest $request, Employee $employee)
    {

        DB::beginTransaction();

        try {
            $requestDataAll = $request->validated();

            if ($employee->user) {
                $employee->user->update($requestDataAll);
            }

            $encryptedPassword = Crypt::encrypt($requestDataAll['password']);

            $user = User::where('id', $employee->user_id)->update([
                'name' => $requestDataAll['name'],
                'email' => $requestDataAll['email'],
                'role' => $requestDataAll['role'],
                'password' => $encryptedPassword,
            ]);


            if ($request->hasFile('image')) {
                $image = $request->file('image');
                $slug = str_slug($request->name);
                $currentDate = Carbon::now()->format('d-m-Y-h-i-s-');
                $image_name = $slug . '-' . $currentDate . rand(100, 999) . '.' . $image->getClientOriginalExtension();

                if (!File::exists(public_path('uploads/employee'))) {
                    File::makeDirectory(public_path('uploads/employee'), 0777, true, true);
                }
                $image->move('uploads/employee', $image_name);
            } else {
                $image_name = $employee->image;
            }


            if ($request->hasFile('nid_font')) {
                $nid_font = $request->file('nid_font');
                $slug = str_slug($request->name);
                $currentDate = Carbon::now()->format('d-m-Y-h-i-s-');
                $nid_font_name = $slug . '-' . $currentDate . rand(100, 999) . '.' . $nid_font->getClientOriginalExtension();

                if (!File::exists(public_path('uploads/employee'))) {
                    File::makeDirectory(public_path('uploads/employee'), 0777, true, true);
                }
                $nid_font->move('uploads/employee', $nid_font_name);
            } else {
                $nid_font_name = $employee->nid_font;
            }

            if ($request->hasFile('nid_back')) {
                $nid_back = $request->file('nid_back');
                $slug = str_slug($request->name);
                $currentDate = Carbon::now()->format('d-m-Y-h-i-s-');
                $nid_back_name = $slug . '-' . $currentDate . rand(100, 999) . '.' . $nid_back->getClientOriginalExtension();

                if (!File::exists(public_path('uploads/employee'))) {
                    File::makeDirectory(public_path('uploads/employee'), 0777, true, true);
                }
                $nid_back->move('uploads/employee', $nid_back_name);
            } else {
                $nid_back_name = $employee->nid_back;
            }




            $employee->update([
                'store_id' => $requestDataAll['store_id'],
                'name' => $requestDataAll['name'],
                'email' => $requestDataAll['email'],
                'role' => $requestDataAll['role'],
                'password' => $encryptedPassword,
                'image' => $image_name,
                'nid_font' => $nid_font_name,
                'nid_back' => $nid_back_name,
            ]);

            $employee->update($requestDataAll);
            DB::commit();

            session()->flash('success', 'Employee updated successfully.');
            return redirect()->route('admin.employees.index')->with('success', 'Updated successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['message' => 'Error updating employee', 'error' => $e->getMessage()], 500);
        }





        $employee->update($request->validated());
        return redirect()->route('admin.employees.index')->with('success', 'Emloyee updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Employee $employee)
    {
        $employee->delete();
        return redirect()->route('admin.employees.index')->with('success', 'Emloyee deleted successfully.');
    }
}
