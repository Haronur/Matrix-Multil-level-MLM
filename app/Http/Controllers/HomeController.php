<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Auth;
use App\User;
use App\Adminsetting;
class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('home');
    }

    public function register_new_member(Request $request)
    {

        $user =new User;
        $sponsor=User::where('username',$request['sponsor'])->firstOrFail();
        // dd($sponsor);
        $user->username=$request['username'];
        $user->fName=$request['fName'];
        $user->lName=$request['lName'];
        $user->gender=$request['gender'];
        $user->mobile_number=$request['phone'];
        $user->join_date=date('Y-m-d');
        if($this->check_under_user($sponsor->id)==false){
            session(['status'=>'fail_admin']);
            session(['message'=>'Can not register new member! You exceeded system depth']);
            return view('pages.admin.registration.register');
        }
        else{
                $value=$this->check_under_user($sponsor->id);
                $user->upline_id=$value["upline_id"];
                $user->sameline_no=$value["sameline_no"];
                $user->level_no=$value["level_no"];
                $user->path=User::where('id',$value["upline_id"])->first()->path.$value["sameline_no"];
                $user->email=$request['email'];
                $user->country=$request['country'];
                $user->state=$request['state'];
                $user->address=$request['address'];
                $user->zip_code=$request['zipcode'];
                $user->city=$request['city'];
                $user->password=bcrypt($request['password']);
        
                $user->save();
        
               return view('home');
            }
    }

    public function check_under_user($id){

        if(User::where('upline_id',$id)->count()<Adminsetting::all()->last()->width){

            $upline_id=$id;
            $sameline_no=User::where('upline_id',$id)->count()+1;
            $return_value=array();
            $return_value["upline_id"]=$upline_id;
            $return_value["sameline_no"]=$sameline_no;
            $return_value["level_no"]=User::where('id',$upline_id)->first()->level_no+1;

            return $return_value;
        }
        else {
            $new_user=User::where('upline_id',$id)->first();
            if($new_user->level_no >= Adminsetting::all()->last()->depth) 
                return false;
            return $this->check_under_user($new_user->id);
        }
    }
}
