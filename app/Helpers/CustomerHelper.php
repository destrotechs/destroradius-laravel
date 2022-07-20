<?php
namespace App\Helpers;

use Auth;
use DB;
class CustomerHelper
{
    public static function isSuspended($username)
    {
        $accountissuspended = DB::table('user_access_suspensions')->where([['username','=',$username],['activation_used','=',false]])->get();
        if(count($accountissuspended)>0){
            return true;
        }else{
            return false;
        }
    }
    public static function availableFunds($username){
        $funds = DB::table('customer_funds')->where('username',$username)->first();
        return $funds->available_funds??0;
    }
    public static function usedFunds($username){
        $funds = DB::table('customer_funds')->where('username',$username)->first();
        return $funds->used_funds??0;
    }
    public static function userAllocatedPackage($username){
        $customer = DB::table('customers')->where('username',$username)->first();
        $userpackages = DB::table('customerpackages')->where('customerid',$customer->id)->count();
        if($userpackages>0){
            return true;
        }else{
            return false;
        }
    }
    public static function getUserAccounts($username,$account_id=null){
        $accounts = DB::table('customer_accounts')->where([['owner','=',$username]])->get();
        return $accounts;
    }
}
?>