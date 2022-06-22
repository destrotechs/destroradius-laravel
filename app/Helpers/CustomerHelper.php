<?php
namespace App\Helpers;

use Auth;
use DB;
class CustomerHelper
{
    public static function isSuspended()
    {
        $username = Auth::guard('customer')->user()->username;
        $accountissuspended = DB::table('user_access_suspensions')->where([['username','=',$username],['activation_used','=',false]])->get();
        if(count($accountissuspended)>0){
            return true;
        }else{
            return false;
        }
    }
}
?>