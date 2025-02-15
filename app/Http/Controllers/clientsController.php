<?php

namespace App\Http\Controllers;
use Validator;
use Illuminate\Http\Request;
use DB;
use Auth;
use App\Payment;
use Morris\Mpesa\Mpesa;
use App\Message;
use Alert;
use Redirect;
use App\Helpers\CustomerHelper;

class clientsController extends Controller
{
    public function getLogin(Request $request){
    	return view('auth.clientsauth.login');
    }
    public function getBundles(Request $request){
        if(Auth::guard('customer')->check()){
            $type =  Auth::guard('customer')->user()->type;           
            $packages = DB::table('package_prices')->join('packages','packages.id','=','package_prices.packageid')->where('packages.users',$type)->orderBy('priority', 'desc')->get();
        }else{
            $packages = DB::table('package_prices')->join('packages','packages.id','=','package_prices.packageid')->where('packages.users','hotspot')->orderBy('priority', 'desc')->get();

        }
    	return view('clients.bundles',compact('packages'));
    }



    public function bundlebalance(Request $request){
        $user_info = '';
        $user_type = '';
        $username='';
        $accounts = null;
        $valid_until = array();
        if(Auth::guard('customer')->check()){

            $username = Auth::guard('customer')->user()->username;
            $user_type = Auth::guard('customer')->user()->type;

            if(Auth::guard('customer')->user()->type=='pppoe' || Auth::guard('customer')->user()->type=='prepaid'){
                $accounts = DB::table('customer_accounts')->where('owner',$username)->get();
                foreach($accounts as $a){

                    $info = DB::table('radcheck')->where([['username','=',$a->account_no],['attribute','=','Expiration']])->first();
                    array_push($valid_until, $info->value??'Disconnected');
                }
                $user_info = DB::table('radcheck')->where([['username','=',$username],['attribute','=','Expiration']])->first();
                // array_push($user_info,$info);

            }

        }
        return view('clients.checkbalance',compact('user_info','user_type','username','accounts','valid_until'));
    }
    public function fetchBalance(Request $request){
        $username=$request->get('username');

        $user=DB::table('radcheck')->where('username','=',$username)->get();
        $userpackage=DB::table('radusergroup')->where('username','=',$username)->first();
        $mbsused=0;
        $totalbytesrecord=0;
        $remainder=0;
        $account_info = DB::table('customer_accounts')->where('account_name',$username)->first();
        $userispppoe=DB::table('radcheck')->where([['username','=',$account_info->account_no??$username],['attribute','=','Expiration']])->first();
        if($userispppoe){
            return '<tr><td colspan="2"> You Account is valid until '.$userispppoe->value.'</td></tr>';
        }
        if(count($user)>0){
            $userdata = DB::table('radgroupreply')->where([['attribute','=','Max-All-MB'],['groupname','=',$userpackage->groupname??'']])->first();
            if(!$userdata){
            $userdata=DB::table('radcheck')->where([['username','=',$username],['attribute','=','Max-All-MB']])->first();

            }
            if($userdata){
            $totalbytesrecord=$userdata->value??0;
            
            $totaldownbs=DB::table('radacct')->where('username','=',$username)->sum('AcctInputOctets');
            $totalupbs=DB::table('radacct')->where('username','=',$username)->sum('AcctOutputOctets');
            $mbsused=($totaldownbs+$totalupbs);

            $totalbytesrecord=($totalbytesrecord/(1024*1024));
            $mbsused=0;
            $remainder=$totalbytesrecord-$mbsused;

             echo '<tr><td>'.round($totalbytesrecord,2).' MBs</td><td>'.round($mbsused,2).' MBs</td><td>'.round($remainder,2).' MBs</td></tr>';
         }else{
            return "error";
         }
        }else{
            echo "error";
        }

    }

    public function buyBundlePlan(Request $request,$id){
        $package=DB::table('packages')->join('package_prices','packages.id','=','package_prices.packageid')->where('packages.id','=',$id)->get();
        $balance = 0;
        $usertype = '';
        if(Auth::guard('customer')->check()){
            $username = Auth::guard('customer')->user()->username;
            $usertype = Auth::guard('customer')->user()->type;
            $balance = self::getBBalance($username);
        }
        if($balance>0){
            $package = DB::table('customer_accounts')->where('owner',Auth::guard('customer')->user()->username)->first();
            alert()->warning("You have an active package (".$package->package_name."), you cannot purchase a new one");
            return redirect()->route('client.bundles');
        }else{
            if(Auth::guard('customer')->check()){
                $userid = Auth::guard('customer')->user()->id;
                // $customer_has_accounts = count(CustomerHelper::getUserAccounts($username));
                // if($customer_has_accounts>0){
                    return redirect()->route('customer.accounts.all',['username'=>$username,'packageid'=>$id]);                    

                // }else{
                    // alert()->error("Contact administrator for initial subscription");
                    // return redirect()->back();
                // }
            }else{
                $cost =0;
                $thispackage = $package=DB::table('packages')->join('package_prices','packages.id','=','package_prices.packageid')->where('packages.id','=',$id)->first();

                if ($thispackage->amount==0){
                    return view('clients.getfreepackage',compact('thispackage'));
                }else{
                    if(Auth::guard('customer')->check()){
                        $type = Auth::guard('customer')->user()->type;
                        $packages=DB::table('packages')->join('package_prices','packages.id','=','package_prices.packageid')->where([['packages.users','=',$type],['package_prices.amount','!=',0]])->get();

                    }else{
                        $packages=DB::table('packages')->join('package_prices','packages.id','=','package_prices.packageid')->where([['packages.users','=','hotspot'],['package_prices.amount','!=',0]])->get();

                    }

                    return view('clients.buybundle',compact('packages'));
                }

            }
            
        }
            
        // }else{
        //     return view('clients.buybundle',compact('package','balance'));
        // }

    }
    public static function getBBalance($username){
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

            return $remainder;
        } 
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
            toast('You must be logged in to view this page"','warning');
            return redirect()->back();
        // return response()->json(["message"=>"You must be logged in to view this page"]);
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
            toast('Phone number was updated successfully','success');
            return redirect()->back()->with("success_message","Phone number was updated successfully");
        }else{
            toast('No user was found with the current phone number','error');
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
            toast('You must be logged in to view this page"','warning');
            return redirect()->back();
            // return response()->json(["message"=>"You must be logged in to view this page"]);
        }

    }
    public function payToGetCredentials(Request $request){
        $package = $request->get('package');
        $amount = $request->get('amount');
        $phone = $request->get('phone');
        $account_name = $request->get('account_name');

        $package_info = DB::table('packages')->where('packagename',$package)->first();

        if($amount && $amount!=0){

            $payment = new Mpesa();

            $phone = '254'.substr($phone, 1);

            $payment->generateToken();

            $checkoutid = $payment->processRequest($phone,$amount);
        }else{
        //check phone if already saved
            $phone_activated = DB::table('free_account_details')->where([['phone','=',$phone]])->get();
            if(count($phone_activated)>0){
                alert()->error("You have already subscribed to the free package");
                return redirect()->back();
            }
            $checkoutid='success';
        }

        $username = '';
        $password = '';

        if ($checkoutid!='failed!'){
            if(isset($amount) && $amount!=0){
                sleep(30);//wait for user to enter MPESA pin and check if the transaction has completed
                $status = $payment->querySTKPush($checkoutid);
            }else{
                $status = "success";
            }

            if($status == 'success'){
                //read mpesa transaction details
                // $details = $payment->getTransactionDetails();

                

                $permitted_chars_username = '123456789';
    	        $permitted_chars_password = '23456789abcdefghjklmnopqrstuvwxyzABCDEFGHJKLMNOPQRSTUVWXYZ';
                if(Auth::guard('customer')->check()){                     
                    $username = $request->get('account');
                    $password = $package_info->users=='pppoe'?$request->get('account'):'';
                }else{
                    $username=rand(1000,100000);
		    		$password= $package_info->users=='pppoe'?$username:'';
                }

                $c_username = Auth::guard('customer')->user()->username??false;

                if(isset($amount) && $amount!=0){
                    $cust_trans = new Payment();

                    $cust_trans->phonenumber = $phone;
                    $cust_trans->transactionid= 'N/A';
                    $cust_trans->packagebought=$package;
                    $cust_trans->username=$username;
                    $cust_trans->amount = $amount;
                    $cust_trans->username = $username;
                    $cust_trans->transactiondate= date("Y/m/d");

                    $cust_trans->save();
                }else{
                    $freedetails = DB::table('free_account_details')->insert(
                        ['account_no'=>$username,'phone'=>$phone,'owner'=>$c_username??'']
                    );
                }
                
                $userexist = DB::table('customers')->where('username',$c_username)->first();
                if ($userexist){
                    $newuseraccount = DB::table('customer_accounts')->updateOrInsert(
                        ['owner'=>$c_username,'account_no'=>$username],
                        ['package_name'=>$package,'status'=>'active']
                    );
                    $package_info = DB::table('packages')->where('packagename',$package)->first();
                    if($package_info->users=='pppoe'){
                        // $userinpackage = DB::table('customerpackages')->where([['packageid','=',$package_info->id],['customerid','=',$username]])->count();
                        // if($userinpackage>0){
                        if(1==1){
                            $packageprice = DB::table('package_prices')->where('packageid',$package_info->id)->first();

                            //check if user connection is expired
                            $date_to_disconnect = DB::table('radcheck')->where([['username','=',$username],['attribute','=','Expiration']])->first();
                            $remove_maxallmb = DB::table('radcheck')->where([['username','=',$username],['attribute','=','Max-All-MB']])->delete();
                            if($date_to_disconnect){                                
                                if(!self::checkIfUserIsExpired($username)){
                                    $newdatetodisconnect=self::checkDaysToActivate($amount,$packageprice);
                                    if($newdatetodisconnect!=false){
                                          $updateexpiration = DB::table('radcheck')->updateOrInsert(['username'=>$username,'attribute'=>'Expiration'],['op'=>':=','value'=>$newdatetodisconnect]);
                                          $sent = self::newMessage($package,$account_name,$username,$phone);
                                          if($sent){
                                          return "success";
                                            
                                          } else{
                                            return "error";
                                          } 
                                    }else{
                                        return "error";
                                    }
                                  
                                }else{
                                    //hold funds
                                    $available_funds = DB::table('customer_funds')->where([['username','=',$username]])->first();

                                    $held_funds = DB::table('customer_funds')->updateOrInsert([
                                        'username'=>$username],['available_funds'=>(floatval($amount)+floatval($available_funds->available_funds??0)),'added_on'=>date("Y/m/d")
                                    ]);
                                    $activated_acc = DB::table('customer_accounts')->where('account_no',$username)->update(['status'=>'active']);
                                    alert()->success("You have an active account, the funds have been added to your wallet");
                                    if($request->ajax()){
                                        $sent = self::newMessage($package,$account_name,$username,$phone);
                                        if($sent){
                                        return "success";
                                          
                                        } else{
                                          return "error";
                                        } 
                                    }else{
                                        $sent = self::newMessage();
                                        if($sent){
                                            alert()->success("success");
                                            // return redirect()->route('client.bundles');
    
                                            return Redirect::to('http://familywifi.net/login');
                                            
                                          } else{
                                            return "error";
                                          } 
                                        
                                    }

                                }
                            }else{

                                // $newdatetodisconnect = self::calculateTime($package_info->durationmeasure,$package_info->validdays,'pppoe');
                                $newdatetodisconnect=self::checkDaysToActivate($amount,$packageprice);
                                $updateexpiration = DB::table('radcheck')->updateOrInsert(['username'=>$username,'attribute'=>'Expiration'],['op'=>':=','value'=>$newdatetodisconnect]);
                                $activated_acc = DB::table('customer_accounts')->where('account_no',$username)->update(['status'=>'active']);
                                if($request->ajax()){
                                    return "success";
                                }else{
                                    alert()->success("success");
                                    // return redirect()->route('client.bundles');
                                    return Redirect::to('http://familywifi.net/login');
                                }

                            }
                            
                            
                        }
                    }else{

                    }
                }
                if(isset(Auth::guard('customer')->user()->name)){
                    $c_name = Auth::guard('customer')->user()->name;
                }
                $status = self::purchasePackage($username,$password,$package,$amount,$phone);
                //send message on success
                if($status == 'success'){
                    //send message here...
                    if(Auth::guard('customer')->check()){
                        if(Auth::guard('customer')->user()->type=='pppoe'){
                            $message=str_replace("<br />","",nl2br("FROM ".ucwords(strtoupper(env('APP_NAME'))))." Dear Customer, You have successfully purchased ".$package." for account ".$account_name);

                        }else{
                            $message=str_replace("<br />","",nl2br("FROM ".ucwords(strtoupper(env('APP_NAME'))))." Dear Customer, You have successfully purchased ".$package.". Your Access Code is ".$username.".");

                        }
                    }else{
                        $message=str_replace("<br />","",nl2br("FROM ".ucwords(strtoupper(env('APP_NAME'))))." Dear  Customer You have successfully purchased ".$package.". Your Access Code is ".$username.".");
                    
                    }

                    $sms = new Message();
 
                    
                    $sent = $sms->sendSMS($phone,$message);

                    if ($sent){
                        if($request->ajax()){
                            return "success";
                        }else{
                            alert()->success("Activation successfull");
                            // return redirect()->route('client.bundles');
                            return Redirect::to('http://familywifi.net/login');
                        }
                    }else{
                        if($request->ajax()){
                            return "error";
                        }else{
                            alert()->error("Error sending message");
                            return redirect()->back();
                        }
                    }

                }else{
                    if($request->ajax()){
                        return "error";
                    }else{
                        alert()->error("Error");
                        return redirect()->back();
                    }
                }

            }else{
                if($request->ajax()){
                    return "error";
                }else{
                    alert()->error("Error");
                    return redirect()->back();
                }
            }
        }
        else{
            if($request->ajax()){
                return "error";
            }else{
                alert()->error("Error");
                return redirect()->back();
            }
        }


    }
    public static function newMessage($package,$account_name,$username,$phone){
        $message=str_replace("<br />","",nl2br("FROM ".ucwords(strtoupper(env('APP_NAME')))).". Dear Customer, You have successfully purchased ".$package." for account ".$account_name);  

        $sms = new Message();

        
        $sent = $sms->sendSMS($phone,$message);

        if ($sent){
           return true;
        }else{
           return false;
        }
    }
    public static function purchasePackage($username,$password,$package,$amount,$phone){

        if(isset($username)){
          $user_exist = DB::table('radcheck')->where('username','=',$username)->count();

            if($user_exist>0){
                $remove_pppoe_details = DB::table('radcheck')->where([['username','=',$username],['attribute','=','User-Profile']])->delete();
                $remove_pppoe_details = DB::table('radcheck')->where([['username','=',$username],['attribute','=','Expiration']])->delete();
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
    public static function calculateTime($timemeasure,$num,$usertype='hotspot'){
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
                $packageValidDate = mktime($hour,$min,$sec,$month,($day+(7*$num)),$year);

            break;
            default:
                $packageValidDate = mktime($hour,$min,$sec,$month,$day+$num,$year);

        }

        if ($usertype=='hotspot'){

            $dateToDisconnect = date("Y-m-dTH:i:s",$packageValidDate);
            $dateToDisconnect=str_replace('CET', 'T', $dateToDisconnect);

            $dateToDisconnect=str_replace('am', '', $dateToDisconnect);

            $dateToDisconnect=str_replace('UTC', 'T', $dateToDisconnect);

            $dateToDisconnect=str_replace('CES', 'T', $dateToDisconnect);

            $dateToDisconnect=str_replace('pm', '', $dateToDisconnect);

            return $dateToDisconnect;
        }else if ($usertype=='pppoe'){

            $dateToDisconnect = date("Y-m-dTH:i:s",$packageValidDate);
            $dateToDisconnect=str_replace('CET', 'T', $dateToDisconnect);

            $dateToDisconnect=str_replace('am', '', $dateToDisconnect);

            $dateToDisconnect=str_replace('UTC', 'T', $dateToDisconnect);

            $dateToDisconnect=str_replace('CES', 'T', $dateToDisconnect);

            $dateToDisconnect=str_replace('pm', '', $dateToDisconnect);

            
            $mnth = date('M',$packageValidDate);
            $d = date('j',$packageValidDate);
            $y = date('Y',$packageValidDate);

            return $d." ".$mnth." ".$y. " 12:00";
            // return $d." ".$mnth." ".$y. " 12:00"."H".$dateToDisconnect;
        }

    }
    public function suspendAccount(Request $request,$username=null){

        if($request->get('username')){
            $username = $request->get('username');
        }
        // dd($username);
        $userisactive = DB::table('radcheck')->where('username',$username)->get();
        if(count($userisactive)>0){            
            $expiration = DB::table('radcheck')->where([['username','=',$username],['attribute','=','Expiration']])->first();
            $cltpass = '';
            $other_attrs = array();
            foreach ($userisactive as $key => $a) {
                $attrs=array($a->attribute,$a->op,$a->value);

                $atrs = implode("|",$attrs);
                array_push($other_attrs,$atrs);

                if($a->attribute=='Cleartext-Password'){
                    $cltpass = $a->value;
                }
            }


            $activation_code = rand(1,10000);
            if($expiration){                
            $expval = $expiration->value;
            }else{
                $expiration = DB::table('radreply')->where([['username','=',$username],['attribute','=','WISPr-Session-Terminate-Time']])->first();
                $expval = $expiration->value;
            }
            $ot = implode("N", $other_attrs);
            $sus = DB::table('user_access_suspensions')->insert(
                ['username'=>$username,'activation_code'=>$activation_code,'expiration'=>$expval,'cleartextpassword'=>$cltpass,'otherattributes'=>$ot,'suspended_on'=>date("Y/m/d")]
            );

            if($sus){
                //clear radcheck to disable connection
                $userout = DB::table('radcheck')->where('username',$username)->delete();
                if ($userout){

                $activated = DB::table('customer_accounts')->where('account_no',$username)->update(['status'=>'inactive']);
                    echo "Account suspended successfully, Please use code ".$activation_code." to reactivate again";
                }
            }else{
                echo "There was an error suspending your account, try again!";
            }
        }else{
            echo "You are not an active internet user!";
        }
    }

    public function activateSuspendedAccount(Request $request){
        $activation_code= $request->get('activation_code');
        $username= $request->get('username');
        $accountissuspended = DB::table('user_access_suspensions')->where([['username','=',$username],['activation_code','=',$activation_code],['activation_used','=',false]])->first();
        if($accountissuspended){
            $records = explode("N", $accountissuspended->otherattributes);
            $attrs = $accountissuspended->otherattributes;

            // dd($attrs);
            foreach($records as $r){
                $at=explode("|",$r);

                DB::table('radcheck')->insert(
                    ['username'=>$username,'attribute'=>$at[0],'op'=>$at[1],'value'=>$at[2]]
                );
            }
            $accountissuspended = DB::table('user_access_suspensions')->where([['username','=',$username],['activation_code','=',$activation_code],['activation_used','=',false]])->update(['activation_used'=>true]);
            
            $activated = DB::table('customer_accounts')->where('account_no',$username)->update(['status'=>'active']);

            alert()->success("Account has been reactivated successfully!");
            return redirect()->back();

        }else{
            alert()->error("Your activation code may be wrong!");
            return redirect()->back();
        }
    }
    public function gettestingPPoe(Request $request){
        return view('clients.test');
    }

    public function testingPPoe(Request $request){
        self::checkIfUserIsExpired('test1');
    }

    public static function checkIfUserIsExpired($username){
        $expiration = DB::table('radreply')->where([['username','=',$username],['attribute','=','WISPr-Session-Terminate-Time']])->first();

        if($expiration){
            $date_to_expire = explode("T",$expiration->value)[0];
            $date_string = strtotime($date_to_expire);
            $date = date("Y/m/d",$date_string);
            $today_date = date("Y/m/d");
            return ($date>$today_date);
        }else{
            return false;
        }
    }
    public static function checkDaysToActivate($amount,$packageprice){
        $packageM = DB::table('packages')->where('id',$packageprice->packageid)->first();
        if ($amount==$packageprice->amount){
            $newdatetodisconnect = self::calculateTime($packageM->durationmeasure,$packageM->validdays,'pppoe');
            return $newdatetodisconnect;
        }else if($packageprice->amount>$amount){
            $risk_fee = DB::table('package_risk_fees')->where('packageid',$packageM->id)->first();
            $base_daily_fee = $packageprice->amount/30;
            $upfee = $base_daily_fee+$risk_fee->amount;
            $customer_days = ceil($amount/$upfee);
            $newdatetodisconnect = self::calculateTime('day',$customer_days,'pppoe');
            return $newdatetodisconnect;
        }else{
            return false;
        }


    }
    public function getAllUserAccounts(Request $request,$username,$packageid){
        if($username){
            $pid=$packageid;
            if(Auth::guard('customer')->check()){
                $accounts = DB::table('customer_accounts')->where('owner',$username)->get();
                toast("You have been redirected to your subscribed accounts","warning");
                return view('clients.client_accounts',compact('accounts','pid'));
            }else{
                alert()->error("You should be logged in to a access the requested page");
                return redirect()->route('client.bundles');
            }
            
        }
    }
    public function AccountsPayFor(Request $request){
        $account= $request->get('account');
        $account_name = DB::table('customer_accounts')->where('account_no',$account)->first();
        $packageid = $request->get('packageid');
        if($packageid){
            $thispackage=DB::table('packages')->join('package_prices','packages.id','=','package_prices.packageid')->where([['packages.id','=',$packageid]])->select('packages.*','package_prices.amount')->first();

            if($thispackage->amount==0){
                return redirect()->route('clients.freepackage',['id'=>$thispackage->id,'acc'=>$account]);
                // return view('clients.getfreepackage',compact('thispackage','account'));
            }

        }
        if($account){
            $today = date("Y-m-d");
            if(Auth::guard('customer')->check()){
                $type = Auth::guard('customer')->user()->type;
                $packages=DB::table('packages')->join('package_prices','packages.id','=','package_prices.packageid')->where([['packages.users','=',$type],['package_prices.amount','!=',0]])->get();  
            }else{
                $packages=DB::table('packages')->join('package_prices','packages.id','=','package_prices.packageid')->where([['packages.users','=','hotspot'],['package_prices.amount','!=',0]])->get();  
            }

            return view('clients.buybundle',compact('packages','account','account_name','packageid'));
        }else{
            alert()->error("Please select an account");
            return redirect()->back();
        }
    }
    public function getFreeAccess(Request $request,$id,$acc=null){
        $account = $acc;
        $thispackage = DB::table('packages')->where('id',$id)->first();

        //check if user has freeaccess
        $userexist = DB::table('radusergroup')->where([['username','=',$account],['groupname','=',$thispackage->packagename]])->count();
        if($userexist>0){
            alert()->error("You are already subscribed to this free package");
            return redirect()->route('client.bundles');
        }
        return view('clients.getfreepackage',compact('thispackage','account'));
    }

    public function getSuspendAccount(){
        $user = Auth::guard('customer')->user()->username;
        $accounts = DB::table('customer_accounts')->where('owner',$user)->get();
        return view('clients.suspend_account',compact('accounts'));
    }

    public function getLogout(Request $request){
        Auth::guard('customer')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/customer/login');
    }
}
