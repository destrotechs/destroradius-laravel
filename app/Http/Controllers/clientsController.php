<?php

namespace App\Http\Controllers;
use Validator;
use Illuminate\Http\Request;
use DB;
use Auth;
use App\Payment;
use Morris\Mpesa\Mpesa;
use App\Message;
class clientsController extends Controller
{
    public function getLogin(Request $request){
    	return view('auth.clientsauth.login');
    }
    public function getBundles(Request $request){
        $packages = DB::table('package_prices')->join('packages','packages.id','=','package_prices.packageid')->get();
    	return view('clients.bundles',compact('packages'));
    }



    public function bundlebalance(Request $request){
        return view('clients.checkbalance');
    }
    public function fetchBalance(Request $request){
        $username=$request->get('username');

        $user=DB::table('radcheck')->where('username','=',$username)->get();
        $mbsused=0;
        $totalbytesrecord=0;
        $remainder=0;
        if(count($user)>0){
            $userdata=DB::table('radcheck')->where([['username','=',$username],['attribute','=','Max-All-MB']])->get();
            foreach ($userdata as $key => $data) {
                $totalbytesrecord=$data->value;
            }
            $totaldownbs=DB::table('radacct')->where('username','=',$username)->sum('AcctInputOctets');
            $totalupbs=DB::table('radacct')->where('username','=',$username)->sum('AcctOutputOctets');
            $mbsused=($totaldownbs+$totalupbs);

            $totalbytesrecord=($totalbytesrecord/(1024*1024));
            $mbsused=0;
            $remainder=$totalbytesrecord-$mbsused;

             echo '<tr><td>'.round($totalbytesrecord,2).' MBs</td><td>'.round($mbsused,2).' MBs</td><td>'.round($remainder,2).' MBs</td></tr>';
        }else{
            echo "error";
        }

    }

    public function buyBundlePlan(Request $request,$id){
        $package=DB::table('packages')->join('package_prices','packages.id','=','package_prices.packageid')->where('packages.id','=',$id)->get();
        return view('clients.buybundle',compact('package'));
    }
    public function getCleanStale(){
        return view('clients.cleanstale');
    }
    public function cleanStaleConn(Request $request){
        $username=$request->get('username');
        $staleconn=DB::table('radacct')->where([['username','=',$username],['acctstoptime','=',NULL]])->delete();
        if ($staleconn) {
            echo "success";
        }else{
            echo "failed";
        }
    }


     public function getChangePhone(Request $request){
        if(isset(Auth::guard('customer')->user()->username)){
           return view('clients.changephone');
       }else{
        return response()->json(["message"=>"You must be logged in to view this page"]);
       }

    }
    public function postChangePhone(Request $request){
        $validator=Validator::make($request->all(),[
            'phone'=>['required','min:10','max:10','unique:customers'],
        ]);

        if ($validator->fails()) {
            return redirect()->back()->with('error',$validator->messages()->all()[0]);
        }
        $username=Auth::guard('customer')->user()->username;
        $phone=Auth::guard('customer')->user()->phone;
        $phoneupdate=$request->get('phone');
        $user= DB::table('customers')->where('phone','=',$phone)->get();
        if (count($user)>0) {
            $userupdate=DB::table('customers')->where('username','=',$username)->update(['phone'=>$phoneupdate]);
            return redirect()->back()->with("success_message","Phone number was updated successfully");
        }else{
            return redirect()->back()->with('error','No user was found with the current phone number');
        }
    }
    public function getTransactions(Request $request){

        $username="";
        if(isset(Auth::guard('customer')->user()->username)){
            $username = Auth::guard('customer')->user()->username;
        }

        if($username!=""){
            $transactions=DB::table('payments')->where('username','=',$username)->get();
        return view('clients.transactions',compact('transactions'));
        }
        else{
            return response()->json(["message"=>"You must be logged in to view this page"]);
        }

    }
    public function payToGetCredentials(Request $request){
        $package = $request->get('package');
        $amount = $request->get('amount');
        $phone = $request->get('phone');
        $payment = new Mpesa();

        $phone = '254'.substr($phone, 1);

        $payment->generateToken();

        $checkoutid = $payment->processRequest($phone,$amount);

        $username = '';
        $password = '';

        if ($checkoutid!='failed!'){
            sleep(30);

            $status = $payment->querySTKPush($checkoutid);

            if($status == 'success'){
                //read mpesa transaction details
                // $details = $payment->getTransactionDetails();

                // $cust_trans = new Payment();

                // $cust_trans->phonenumber = $phone;
                // $cust_trans->transactionid= $details[1];
                // $cust_trans->packagebought=$package;
                // $cust_trans->amount = $amount;
                // $cust_trans->username = $username;
                // $cust_trans->transactiondate= $details[2];

                // $cust_trans->save();

                $permitted_chars_username = 'ABCDEFGHJKLMNPQRSTUVWXYZ23456789';
    	        $permitted_chars_password = '23456789abcdefghjklmnopqrstuvwxyzABCDEFGHJKLMNOPQRSTUVWXYZ';
                if(isset(Auth::guard('customer')->user()->username)){
                    $username = Auth::guard('customer')->user()->username;
                    $password = Auth::guard('customer')->user()->cleartextpassword;
                }else{
                    $username=substr(str_shuffle($permitted_chars_username), 0, 6);
		    		$password= substr(str_shuffle($permitted_chars_password), 0, 5);
                }

                $status = self::purchasePackage($username,$password,$package,$amount,$phone);
                //send message on success
                if($status == 'success'){
                    $message = "You have succesfully bought HEWANET ".$package.". Username : ".$username." Password : ".$password;
                    $mess = new Message();
                    $sent = $mess->sendSMS($phone,$message);

                    if ($sent){
                        return "success";
                    }else{
                        return 'error';
                    }

                }else{
                    return "error";
                }

            }else{
                return "error";
            }
        }
        else{
            return "error";
        }


    }
    public static function purchasePackage($username,$password,$package,$amount,$phone){

        if(isset($username)){
          $user_exist = DB::table('radcheck')->where('username','=',$username)->count();

            if($user_exist>0){
                //check if user is registered to use bundle mbs
                $bundle_user = DB::table('radgroupreply')->where([['groupname','=',$package],['attribute','=','Max-All-MB']])->count();

                if($bundle_user>0){
                    //if user uses bundles, update the balance
                $status = self::updateBundlesForExistingCustomer($username,$package);

                    if($status==true){
                        return "success";
                    }else{
                        return "error";
                    }


                }else{
                    //delete records from radcheck and radreply
                    DB::table('radcheck')->where('username','=',$username)->whereNotIn('attribute',['Cleartext-Password'])->delete();
                    DB::table('radreply')->where('username','=',$username)->delete();


                    //change package only
                    $user_pack = DB::table('radusergroup')->updateOrInsert(
                        ['username'=>$username],
                        ['groupname'=>$package,'priority'=>10]
                    );

                   $packageinfo = DB::table('packages')->where('packagename','=',$package)->get();
                    $durmeasure = '';
                    $num = 0;

                    foreach($packageinfo as $p){
                        $durmeasure = $p->durationmeasure;
                        $num = $p->validdays;
                    }

                    $disconnecttime = self::calculateTime($durmeasure,$num);

                    $user_rep = DB::table('radreply')->updateOrInsert(
                        ['username'=>$username,'attribute'=>'WISPr-Session-Terminate-Time'],
                        ['op'=>':=','value'=>$disconnecttime],
                    );

                    if($user_rep){
                        return "success";
                    }else{
                        return "error";
                    }
                }
            }else{

                $status = self::addNewCheckCustomer($username,$password,$package);
                if($status==true){
                    return "success";
                }else{
                    return "error";
                }
            }
        }else{
            return "success";
        }

    }
    public static function addNewCheckCustomer($username,$password,$package){
        $update = false;
        $package_has_mbs = DB::table('radgroupcheck')->where([['groupname','=',$package],['attribute','=','Max-All-MB']])->count();


        if($package_has_mbs>0){
            $package_quota = DB::table('packages')->where('packagename','=',$package)->get();
            $quota=0;
            foreach($package_quota as $p){
                $quota = $p->quota;
            }
            $add_cus = DB::table('radcheck')->insert([
            ['username'=>$username,'attribute'=>'Cleartext-Password','op'=>':=','value'=>$password],['username'=>$username,'attribute'=>'Max-All-MB','op'=>':=','value'=>$quota]
            ]);
            $add_cus = DB::table('radreply')->insert(
           ['username'=>$username,'attribute'=>'Max-All-MB','op'=>':=','value'=>$quota]
            );

            $add_cus_group = DB::table('radusergroup')->insert(['username'=>$username,'groupname'=>$package,'priority'=>10]);

            if($add_cus && $add_cus_group){
                $update = true;
            }else{
                $update = false;
            }

        }else{
            $add_cus = DB::table('radcheck')->insert(
            ['username'=>$username,'attribute'=>'Cleartext-Password','op'=>':=','value'=>$password]
            );

            $add_cus_group = DB::table('radusergroup')->insert(['username'=>$username,'groupname'=>$package,'priority'=>10]);

             //add date to disconnect

            $packageinfo = DB::table('packages')->where('packagename','=',$package)->get();
            $durmeasure = '';
            $num = 0;

            foreach($packageinfo as $p){
                $durmeasure = $p->durationmeasure;
                $num = $p->validdays;
            }

            $disconnecttime = self::calculateTime($durmeasure,$num);

            $user_rep = DB::table('radreply')->updateOrInsert(
                ['username'=>$username,'attribute'=>'WISPr-Session-Terminate-Time'],
                ['op'=>':=','value'=>$disconnecttime],
            );

            if($add_cus && $add_cus_group){
                $update = true;
            }else{
                $update = false;
            }
        }

        return $update;


    }
    public static function updateBundlesForExistingCustomer($username,$package){
        $total_mbs_bought =0;
        $mbsbought = DB::table('radgroupcheck')->where([['groupname','=',$package],['attribute','=','Max-All-MB']])->get();

        foreach($mbsbought as $mb){
            $total_mbs_bought = $mb->value;
        }

        $mbs_balance = self::calculateBundleRemaining($username,$package);


        if($mbs_balance==0){
            //delete accnts recs
            DB::table('radacct')->where('username','=',$username)->delete();

            //remove user from current groups and add him to new one
            DB::table('radusergroup')->where('username','=',$username)->delete();

            //add user to new group

            DB::table('radusergroup')->insert(['username'=>$username,'groupname'=>$package,'priority'=>10]);
            //record for max mbs to help check bundle balance
            $package_quota = DB::table('packages')->where('packagename','=',$package)->get();
                    $quota=0;
                    foreach($package_quota as $p){
                        $quota = $p->quota;
                    }
                    if($quota>0){
                        $add_cus = DB::table('radcheck')->insert(['username'=>$username,'attribute'=>'Max-All-MB','op'=>':=','value'=>$quota]
                        );
                    }
            return true;

        }else{
            $package_quota =0;
            $quota = DB::table('packages')->where('packagename','=',$package)->get();

            foreach($quota as $q){
                $package_quota = $q->quota;
            }
            $user_new_mbs_balance = $package_quota+$mbs_balance;

            $package_reply_attrs= DB::table('radgroupreply')->where('groupname','=',$package)->get();

            foreach($package_reply_attrs as $pr){
                if($pr->attribute == 'Max-All-MB'){
                    DB::table('radreply')->updateOrInsert(
                    ['username'=>$username,'attribute'=>$pr->attribute],['op'=>':=','value'=>$user_new_mbs_balance]
                    );
                }else{
                DB::table('radreply')->updateOrInsert(
                    ['username'=>$username,'attribute'=>$pr->attribute],
                    ['op'=>':=','value'=>$pr->value]
                    );
                }

            }

            $package_check_attrs= DB::table('radgroupcheck')->where('groupname','=',$package)->get();

            foreach($package_check_attrs as $pc){
                if($pc->attribute == 'Max-All-MB'){
                    DB::table('radcheck')->updateOrInsert(
                    ['username'=>$username,'attribute'=>$pc->attribute],['op'=>':=','value'=>$user_new_mbs_balance]
                    );
                }else{
                    DB::table('radcheck')->updateOrInsert(
                        ['username'=>$username,'attribute'=>$pc->attribute],['op'=>':=','value'=>$pc->value]
                    );
                }
            }

            //remove user from group

            $remove_user = DB::table('radusergroup')->where('username','=',$username)->delete();
            return true;
            if($remove_user){
                return true;
            }else{
                return false;
            }
        }
    }
    public static function calculateBundleRemaining($username,$package){
        $user_total_mbs = 0;
        $usermbs=DB::table('radcheck')->where([['username','=',$username],['attribute','=','Max-All-MB']])->get();
        foreach($usermbs as $um){
            $user_total_mbs=$um->value;
        }

        //check if user is in a package

        $user_packaged = DB::table('radusergroup')->where('username','=',$username)->get();

        $packaged_user = "";
        foreach($user_packaged as $up){
            $packaged_user = $up->groupname;
        }

        //check the package totalquota
        $packagembs = DB::table('packages')->where('packagename','=',$packaged_user)->get();

        if($user_total_mbs==0){
            foreach ($packagembs as $pm) {
                $user_total_mbs = $pm->quota;
            }
        }
        // dd($user_total_mbs);
        $useruploadspent=DB::table('radacct')->where('username','=',$username)->sum('AcctInputOctets');
        $userdownloadspent=DB::table('radacct')->where('username','=',$username)->sum('AcctOutputOctets');
        $user_used_mbs = $useruploadspent+$userdownloadspent;

        $remaining = $user_total_mbs - $user_used_mbs;



        if ($remaining<0){
            return 0;
        }else{
            return $remaining;
        }
    }
    public static function calculateTime($timemeasure,$num){
        $year=date("Y");
        $month=date("n");
        $day=date("j");
        $hour=date("H");
        $min=date("i");
        $sec=date("s");

        $duration = 0;

        $packageValidDate = '';

        switch($timemeasure){
            case 'month':
                $packageValidDate = mktime($hour,$min,$sec,($month+$num),$day,$year);

            break;
            case 'day':
                $packageValidDate = mktime($hour,$min,$sec,$month,($day+$num),$year);

            break;
            case 'week':
                $packageValidDate = mktime($hour,$min,$sec,$month,($day+$num),$year);

            break;
            default:
                $packageValidDate = mktime($hour,$min,$sec,$month,$day+$num,$year);

        }

        $dateToDisconnect = date("Y-m-dTH:i:s",$packageValidDate);
        $dateToDisconnect=str_replace('CET', 'T', $dateToDisconnect);

        $dateToDisconnect=str_replace('am', '', $dateToDisconnect);

        $dateToDisconnect=str_replace('UTC', 'T', $dateToDisconnect);

        $dateToDisconnect=str_replace('CES', 'T', $dateToDisconnect);

        $dateToDisconnect=str_replace('pm', '', $dateToDisconnect);

        return $dateToDisconnect;

    }
    public function getLogout(Request $request){
        Auth::guard('customer')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/customer/login');
    }
}
