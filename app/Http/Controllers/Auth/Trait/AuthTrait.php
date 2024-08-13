<?php

namespace App\Http\Controllers\Auth\Trait;

use App\Events\Auth\UserLoginSuccess;
use App\Events\Frontend\UserRegistered;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Modules\Service\Models\SystemService;
use Modules\Commission\Models\EmployeeCommission;
use Modules\Commission\Models\Commission;
use App\Events\Backend\UserCreated;
use Modules\Employee\Models\BranchEmployee;


trait AuthTrait
{
    protected function loginTrait($request)
    {
        $email = $request->email;
        $password = $request->password;
        $remember = $request->remember_me;

    
           if (Auth::attempt(['email' => $email, 'password' => $password, 'status' => 1], $remember)) {
                if(auth()->user()->roles()->count() == 1){
                    if(auth()->user()->hasRole('pet_store') && enableMultivendor() == "0")     {
                        Auth::logout();
                        return false;
                    }
                }

                if(auth()->user()->hasRole('user')){
                    Auth::logout();
                    return false;
                }

                event(new UserLoginSuccess($request, auth()->user()));

                return true;
            }

             return false;
    }

    protected function checkService($request){

        $email = $request->email;

        $user=User::where('email',$email)->first();

        $user_type=$user->user_type;

        $islogin=1;

        switch($user_type) {
            case 'vet':

             $service=SystemService::active()->where('type','veterinary')->get();
             $islogin = $service->isNotEmpty() ? 1 : 0;
                 
                break;
            case 'groomer':

                $service=SystemService::active()->where('type','grooming')->get();
                $islogin = $service->isNotEmpty() ? 1 : 0;
             
                break;
            case 'walker':

                $service=SystemService::active()->where('type','walking')->get();
                $islogin = $service->isNotEmpty() ? 1 : 0;
              
                break;
            case 'boarder':

                $service=SystemService::active()->where('type','boarding')->get();
                $islogin = $service->isNotEmpty() ? 1 : 0;
               
                break;
            case 'trainer':

                $service=SystemService::active()->where('type','training')->get();
                $islogin = $service->isNotEmpty() ? 1 : 0;
               
                break;
            case 'day_taker':

                $service=SystemService::active()->where('type','daycare')->get();
                $islogin = $service->isNotEmpty() ? 1 : 0;
               
            default:

              $islogin=1;
              
                break;
          }

        return  $islogin;

    }

   
    protected function registerTrait($request, $model = null)
    {
        $request->validate([
            'first_name' => ['required', 'string', 'max:191'],
            'last_name' => ['required', 'string', 'max:191'],
            'email' => ['required', 'string', 'email', 'max:191', 'unique:users'],
            'password' => ['required', Rules\Password::defaults()],
        ]);

        $arr = [
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'name' => $request->first_name . ' ' . $request->last_name,
            'email' => $request->email,
            'mobile' => $request->mobile,
            'address' => $request->address,
            'password' => Hash::make($request->password),
            'user_type' => $request->user_type
        ];

        if (isset($model)) {
            $user = $model::create($arr);
        } else {
            $user = User::create($arr);
        }
        $usertype = $user->user_type;

        $user->assignRole($usertype);

        \Illuminate\Support\Facades\Artisan::call('cache:clear');

        $user->save();

        if($usertype == "vet" || $usertype == "groomer" || $usertype == "walker" || $usertype == "boarder" || $usertype == "trainer" || $usertype == "day_taker"){
            $commissions = Commission::where('type','service')->get();
            foreach($commissions as $commission){
                EmployeeCommission::create([
                    'employee_id' => $user->id,
                    'commission_id' => $commission->id,
                ]);
            }

            $branch_data = [
                'employee_id' => $user->id,
                'branch_id' => 1,
            ];
            BranchEmployee::create($branch_data);
        }
        else if($usertype == "pet_store"){
            $commissions = Commission::where('type','product')->get();
            foreach($commissions as $commission){
                EmployeeCommission::create([
                    'employee_id' => $user->id,
                    'commission_id' => $commission->id,
                ]);
            }
            $branch_data = [
                'employee_id' => $user->id,
                'branch_id' => 1,
            ];
            BranchEmployee::create($branch_data);
        }

          
        \Illuminate\Support\Facades\Artisan::call('view:clear');
        \Illuminate\Support\Facades\Artisan::call('cache:clear');
        \Illuminate\Support\Facades\Artisan::call('route:clear');
        \Illuminate\Support\Facades\Artisan::call('config:clear');
        \Illuminate\Support\Facades\Artisan::call('config:cache');

        event(new Registered($user));
        event(new UserRegistered($user));

        return $user;
    }
}
