<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Package;
use App\Customer;
use App\Mikrotik;
use App\Log;
use App\Zone;
use DB;
use Auth;
use Hash;
use PDF;
use App\Helpers\CustomerHelper;
class userController extends Controller
{
    public function __construct(){
        $this->logs_enabled=0;
        $enabled=DB::table('settings')->get();
        foreach ($enabled as $key => $en) {
            $this->logs_enabled=$en->logs_enabled;
        }
        $this->middleware('auth');
    }
    public function newUser(){
        $packages=Package::all();
        $role_id=Auth::user()->role_id;
         $myzones=DB::table('zonemanagers')->where('managerid',$role_id)->pluck('zoneid');
        if($role_id==1){
            $zones=Zone::all();
        }else{
           $zones=DB::table('zonemanagers')->join('zones','zones.id','zonemanagers.zoneid')->where('zonemanagers.managerid',$role_id)->get();
        }
        return view('users.newuser',compact('packages','zones'));
    }
    public function getNas(Request $request){
        $id=$request->get('id');
        $nas=DB::table('nas')
            ->join('naszones','naszones.nasid','=','nas.id')->where('naszones.zoneid','=',$id)->select('nas.*')->get();
        $output="<option value=''>Select Nas ...</option>";
        foreach ($nas as $key => $n) {
            $output.='<option value="'.$n->id.'">'.$n->nasname.'</option>';
        }
        return $output;
    }
    public function allUsers(){
        $customers=array();
        $role_id=Auth::user()->role_id;
        $myzones=DB::table('zonemanagers')->where('managerid',$role_id)->pluck('zoneid');
        if ($role_id==1) {
            $customers=DB::table('customers')
                // ->leftJoin('customer_accounts','customer_accounts.owner','=','customer')
                ->leftJoin('customerpackages','customerpackages.customerid','=','customers.id')
                ->leftJoin('packages','packages.id','=','customerpackages.packageid')
                ->leftJoin("zones",'zones.id','=','customers.zone')
                ->select('customers.*','packages.packagename','zones.zonename')->paginate(10);
        }else{
            $customers=DB::table('customers')->join('zones','zones.id','=','customers.zone')
            ->whereIn('zones.id',$myzones)
            ->select('customers.*')->paginate(10);
        }

        $remainingdays=array();
        $remainingtime=0;
        $totaltimespent=0;
        $totalalocatedtime=0;
        $remaindays="";
        $totaltime=0;
        $package="";
        foreach ($customers as $c) {
            $p=DB::table('radusergroup')->where('username','=',$c->username)->get();
            foreach($p as $pack){
                $package=$pack->groupname;
            }

        $totalalocatedtime=DB::table('radgroupcheck')->where([['groupname','=',$package],['attribute','=','Max-All-Session']])->get();

        if(count($totalalocatedtime)>0){
            foreach($totalalocatedtime as $t){
                $totaltime=$t->value;
            }
        }else{
            $totaltime=0;
        }
      // dd((int)$totaltime);
        $totaltimespent=DB::table('radacct')->where('username','=',$c->username)->sum('AcctSessionTime');
      //  $l=$totalalocatedtime->value;

            $remainingtime=(int)$totaltime-(int)$totaltimespent;

        if($remainingtime<=0){
                $remaindays='Expired/unalocated time limit';
                array_push($remainingdays, $remaindays);
            }else{
               $convertedtime=$remainingtime;

                if($convertedtime<60){

                    $remaindays=$convertedtime. " Seconds";
                    array_push($remainingdays, $remaindays);
                } else if($convertedtime>=60 && $convertedtime<3600){
                    $convertedtime=intval($convertedtime/60);
                    $remaindays=$convertedtime." Minutes";
                    array_push($remainingdays, $remaindays);
                }else if($remainingtime>=3600 && $remainingtime<86400){
                    $convertedtime=intval($remainingtime/(3600));
                    $remaindays=$convertedtime. " Hours";
                    array_push($remainingdays, $remaindays);
            }else if($remainingtime>=86400){
              $convertedtime=intval($remainingtime/(3600*24));
                        $remaindays=$convertedtime. " Days";
                        array_push($remainingdays, $remaindays);
            }
    }


    }
        return view('users.allusers',compact('customers','remainingdays'));
    }
    public function saveNewCustomer(Request $request){
        //validate details
        $request->validate([
            'username'=>'required|unique:customers|unique:radcheck|allowed_username',
            'password'=>'required|min:6',
            // 'zoneid'=>'required',
            'phone'=>'required|numeric',
            // 'package'=>'required',
            // 'nasid'=>'required',
        ]);
        

        //add user to customers table
        $c = new Customer;
        $c->username=$request->get('username');
        $c->password=Hash::make($request->get('password'));
        $c->zone=$request->get('zoneid');
        $c->phone=$request->get('phone');
        $c->address=$request->get('address');
        $c->type=$request->get('type');
        $c->name=$request->get('name');
        $c->email=$request->get('email');
        $c->cleartextpassword=$request->get('password');
        $c->gender=$request->get('gender');
        $c->created_by=Auth::user()->email;

        $c_username=$request->get('username');

        $c->save();
        $customerid=$c->id;
        $user = Auth::user()->email;
        $log=" Created New user ".$request->get('username');
        $logwrite=Log::createTxtLog($user,$log);
        $packageusers = DB::table('packages')->where('packagename','=',$request->get('package'))->pluck('users');

        //calculate validdays for this customer
        if($request->get('type')!='hotspot'){
            alert()->success("User created successfully");
            return redirect()->back()->with("success","user added successfully");
        }else if($request->get('type')=='hotspot'){
            $useraccount = DB::table('customer_accounts')->updateOrInsert(
                ['owner'=>$c_username,'account_no'=>$c_username],
                ['package_name'=>$package??'','status'=>'inactive']
            );

            alert()->success("User created successfully");
            return redirect()->back()->with("success","user added successfully");

        }
    }
    public function suspendedUsers(){
        return view('users.suspended');
    }
    public function deletedUsers(){
        return view('users.deleted');
    }
    public function pendingUsers(){
        return view('users.pending');
    }
    public function changeUserPackage(){
        return view('users.changepackage');
    }
    public function onlineUsers(){
        $nas = DB::table('nas')->get();
        return view('users.onlineusers',compact('nas'));
    }
    public function offlineUsers(){
        return view('users.offlineusers');
    }
    public function paidUsers(){

         $role_id=Auth::user()->role_id;
         $myzones=DB::table('zonemanagers')->where('managerid',$role_id)->pluck('zoneid');
        if ($role_id==2) {
            $customers=DB::table('customers')
                ->rightJoin('customerpackages','customerpackages.customerid','=','customers.id')
                ->join('packages','packages.id','=','customerpackages.packageid')
                ->join("zones",'zones.id','=','customers.zone')
                ->select('customers.*','packages.packagename','zones.zonename')->get();
            }else{
            $customers=DB::table('customers')->join('zones','zones.id','=','customers.zone')
            ->rightJoin('customerpackages','customerpackages.customerid','=','customers.id')
             ->join('packages','packages.id','=','customerpackages.packageid')
            ->whereIn('zones.id',$myzones)
            ->select('customers.*')->get();
        }
        $user_ids=array();
        foreach ($customers as $c) {
                $user_id=$c->id;
                $p=DB::table('radusergroup')->where('username','=',$c->username)->get();
                foreach($p as $pack){
                    $package=$pack->groupname;
                }
                 $totaltimespent=DB::table('radacct')->where('username','=',$c->username)->sum('AcctSessionTime');
                $totalalocatedtime=DB::table('radgroupcheck')->where([['groupname','=',$package],['attribute','=','Max-All-Session']])->get();

                if(count($totalalocatedtime)>0){
                    foreach($totalalocatedtime as $t){
                        $totaltime=$t->value;
                    }
                }else{
                    $totaltime=0;
                }

                $remainingtime=(int)$totaltime-(int)$totaltimespent;

                if($remainingtime>0){
                    $userid=$user_id;
                    array_push($user_ids,$userid);
                }
            }

            $paidusers=DB::table('customers')->whereIn('id',$user_ids)->get();

        return view('users.paidusers',compact('paidusers'));
    }
    public function unpaidUsers(){
        return view('users.unpaidusers');
    }
    public function getOnlineUser(Request $request){
        $usertype=$request->get('usertype');
        $output="";
        $num=0;
        if ($usertype=='radius') {
            $onlineusers=DB::table('radacct')->where('acctstoptime','=',NULL)->orWhere('acctstoptime','=','0000-00-00 00:00:00')->paginate(15);
            if (count($onlineusers)>0) {
                $num++;

                foreach ($onlineusers as $key => $o) {
                    $totaldownload=DB::table('radacct')->where('username','=',$o->username)->sum('AcctInputOctets');
                    $totalupload=DB::table('radacct')->where('username','=',$o->username)->sum('AcctOutputOctets');
                    $output.="<tr>";
                    $output.="<td>".$num."</td><td>".$o->username."</td><td>".$o->acctstarttime."</td><td>".$o->framedipaddress."</td><td>".$o->nasipaddress."</td><td>".$totaldownload."</td><td>".$totalupload."</td>";
                    $output.="</tr>";
                }
                echo $output;

            }else{
                echo "none";
            }
        }else if($usertype=='nas'){
            $nasid = $request->get('nasid');
           $users = Mikrotik::connectToNas($nasid);
                
                if(count($users)>0){
                    foreach ($users as $key => $o) {
                        $num++;
                        $totaldownload=$o[3];
                        $totalupload=$o[4];
                        $output.="<tr>";
                        $output.="<td>".$num."</td><td>".$o[0]."</td><td></td><td>".$o[1]."</td><td>".$o[5]."</td><td>".round($totalupload/(1024*1024),2)." MBs</td><td>".round($totaldownload/(1024*1024),2)."MBs</td>";
                        $output.="</tr>";
                    }
                }else{
                    echo "none";
                }
            echo $output;
        }
    }
    public function getUserEdit(){
        return view('users.edituser');
    }
    public function getUserToEdit(Request $request){
        $username=$request->get('username');
        $userexist=DB::table('customers')->where('username','=',$username)->get();
        if(count($userexist)>0){
            return redirect()->route('getchangecustomer',['username'=>$username]);
        }else{
            return redirect()->back()->with("error","The searched user does not exist");
        }
    }
    public function getUserChange($username){

        if($username){

            $userdetails=DB::table('customers')->where('username','=',$username)->leftJoin('zones','zones.id','=','customers.zone')->select('customers.*','zones.id as zoneid')->get();

            $user_pppoe = DB::table('radcheck')->where([['username','=',$username],['attribute','=','User-Profile']])->get();
            $zones=DB::table('zones')->get();


            if (count($user_pppoe)>0){
                $profile = '';
                foreach($user_pppoe as $p){
                    $profile=$p->value;
                }
                $userpackage=DB::table('radusergroup')->where('username','=',$profile)->pluck('groupname');
            }else{

                $userpackage=DB::table('radusergroup')->where('username','=',$username)->pluck('groupname');
            }


            $replyattributes = array();
            $checkattributes = array();
            $packagedetails =  array();
            $preplyattributes = array();
            $pcheckattributes = array();

            if(count($userpackage)>0){
                $replyattributes=DB::table('radgroupreply')->where('groupname','=',$userpackage[0])->get();

                $packagedetails=DB::table('packages')->where('packagename','=',$userpackage[0])->get();

                $checkattributes=DB::table('radgroupcheck')->where('groupname','=',$userpackage[0])->get();

                $preplyattributes=DB::table('radreply')->where('username','=',$username)->get();
                $pcheckattributes=DB::table('radcheck')->where('username','=',$username)->get();

            }else{
                $preplyattributes=DB::table('radreply')->where('username','=',$username)->get();
                $pcheckattributes=DB::table('radcheck')->where('username','=',$username)->get();

            }

            $usertimespent=DB::table('radacct')->where('username','=',$username)->sum('AcctSessionTime');
            $useruploadspent=DB::table('radacct')->where('username','=',$username)->sum('AcctInputOctets');
            $userdownloadspent=DB::table('radacct')->where('username','=',$username)->sum('AcctOutputOctets');

            $userquotaspent=$userdownloadspent+$useruploadspent;
            $packages = DB::table('packages')->get();
            $customlimits = DB::table('custom_limits')->get();

            $useritems = DB::table('customers')->join('item_allocations','item_allocations.customer_id','=','customers.id')->join('items','items.id','=','item_allocations.item_id')->select('customers.id as cid,username','items.id as item_id','items.item_code','items.name','item_allocations.quantity','item_allocations.allocation_date','item_allocations.status','item_allocations.date_returned','item_allocations.id as alloc_id','item_allocations.quantity_returned','item_allocations.account_no')->where('customers.username','=',$username)->get();

            $items = DB::table('items')->get();
            $customer_accounts = DB::table('customer_accounts')->where('owner',$username)->get();

            return view('users.changeuser',compact('packages','customlimits','userdetails','userpackage','replyattributes','checkattributes','preplyattributes','pcheckattributes','packagedetails','usertimespent','userquotaspent','zones','useritems','items','customer_accounts'));

        }else{
            return redirect()->route('geteditcustomer',compact('zones'));
        }
    }
    public function postUserPersonalDetails(Request $request){
        $id = $request->get('id');
         $userupdated = DB::table('customers')
              ->where('id', $id)
              ->update(['name'=>$request->get('name'),'username'=>$request->get('username'),'email'=>$request->get('email'),'phone'=>$request->get('phone'),'zone'=>$request->get('zone')]);
        if($userupdated){
            toast('User details updated successfully','success');
            return redirect()->back();
        }else{
            toast('User details could not be updated','error');
            return redirect()->back();
        }
    }
    public static function updateBundlesForExistingCustomer($username,$package){
        $total_mbs_bought = DB::table('radgroupcheck')->where([['groupname','=',$package],['attribute','=','Max-All-MB']])->pluck('value');


        $mbs_balance = self::calculateBundleRemaining($username,$package);

        if($mbs_balance==0){
            //delete accnts recs
            DB::table('radacct')->where('username','=',$username)->delete();

            //remove user from current groups and add him to new one
            DB::table('radusergroup')->where('username','=',$username)->delete();

            //add user to new group

            DB::table('radusergroup')->insert(['username'=>$username,'groupname'=>$package,'priority'=>10]);

            return true;

        }else{
            $package_quota = DB::table('packages')->where('packagename','=',$package)->pluck('quota');

            $user_new_mbs_balance = $package_quota+$mbs_balance;

            $package_reply_attrs= DB::table('radgroupreply')->where('groupname','=',$package)->get();
            foreach($package_reply_attrs as $pr){
                if($pr->attribute == 'Max-All-MB'){
                    DB::table('radreply')->updateOrInsert([
                    ['username'=>$username,'attribute'=>$pr->attribute,'op'=>':=','value'=>$user_new_mbs_balance],
                    ]);
                }else{
                    DB::table('radreply')->updateOrInsert([
                    ['username'=>$username,'attribute'=>$pr->attribute,'op'=>':=','value'=>$pr->value],
                    ]);
                }

            }

            $package_check_attrs= DB::table('radgroupcheck')->where('groupname','=',$package)->get();
            foreach($package_reply_attrs as $pr){
                if($pr->attribute == 'Max-All-MB'){
                    DB::table('radreply')->updateOrInsert([
                    ['username'=>$username,'attribute'=>$pr->attribute,'op'=>':=','value'=>$user_new_mbs_balance],
                    ]);
                }else{
                    DB::table('radcheck')->updateOrInsert([
                        ['username'=>$username,'attribute'=>$pr->attribute,'op'=>':=','value'=>$pr->value],
                    ]);
                }
            }

            //remove user from group

            $remove_user = DB::table('radusergroup')->where('username','=',$username)->delete();

            if($remove_user){
                return true;
            }else{
                return false;
            }
        }
    }

    public static function calculateBundleRemaining($username,$package){
        $user_total_mbs = DB::table('radcheck')->where([['username','=',$username],['attribute','=','Max-All-MB']])->pluck('value');

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
    public function changeCustomerPackage(Request $request){
        $package = $request->get('package');
        $username = $request->get('account_no'); //username becomes the account no to be activated
        if(!$package){
            alert()->error("Assign the account to a package first");
            return redirect()->back();
        }
        $c_username = $request->get('username');
        $user = Auth::user()->email;
        $log="Changed ".$username." Package to ".$package;
        $logwrite=Log::createTxtLog($user,$log);

        $package_id = DB::table('packages')->where('packagename','=',$package)->pluck('id');

        $packageusers = DB::table('packages')->where('packagename','=',$package)->pluck('users');

        $user_id = DB::table('customers')->where('username','=',$c_username)->pluck('id');



        if($username){
                $pass = DB::table('customers')->where('username','=',$username)->pluck('cleartextpassword');                
        }

        
        if ($package == 'nopackage'){
            $remove_userpackage = DB::table('customerpackages')->where('customerid','=',$username)->delete();

            $remove_radusergroup = DB::table('radusergroup')->where('username','=',$username)->delete();
            $remove_radusergroup = DB::table('radreply')->where('username','=',$username)->delete();
            $remove_raduserprofiles = DB::table('radcheck')->where([['username','=',$username],['attribute','=','User-Profile']])->delete();
                $remove_raduserprofiles = DB::table('radcheck')->where([['username','=',$username],['attribute','=','Expiration']])->delete();
            $remove_suspended_acc = DB::table('user_access_suspensions')->where([['username','=',$username]])->delete();
            $radcheckuser = DB::table('radcheck')->updateOrInsert(
                    ['username'=>$username,'attribute'=>'Cleartext-Password'],['op'=>':=','value'=>$username]
                );
            echo "user activated on non-regulated mode";

        }else if($packageusers[0] == 'hotspot'){

            $user_on_package = DB::table('customerpackages')->where([['customerid','=',$username],['packageid','=',$package_id[0]]])->count();

                $userinradcheck = DB::table('radcheck')->where('username',$username)->count();
            if ($user_on_package > 0 && $userinradcheck>0) {
                echo "user is already on the selected package";

            }else{
                $delete_user_replies = DB::table('radreply')->where('username','=',$username)->delete();

                //get valid days for the said package and add disconnect time
                $packagemeasure = DB::table('packages')->where('packagename','=',$package)->pluck('durationmeasure');
                $packagenum= DB::table('packages')->where('packagename','=',$package)->pluck('validdays');
                $dateToDisconnect = self::calculateTime($packagemeasure[0],$packagenum[0]);

                $rad_reply = DB::table('radreply')->updateOrInsert(
                    ['username'=>$username,'attribute'=>'WISPr-Session-Terminate-Time'],['op'=>':=','value'=>$dateToDisconnect]
                );

                //remove from radusergroup
                $remove_userpackage = DB::table('customerpackages')->where('customerid','=',$user_id[0])->delete();


                $remove_radusergroup = DB::table('radusergroup')->where('username','=',$username)->delete();

                $remove_raduserprofiles = DB::table('radcheck')->where([['username','=',$username],['attribute','=','User-Profile']])->delete();
                $remove_raduserprofiles = DB::table('radcheck')->where([['username','=',$username],['attribute','=','Expiration']])->delete();

                $new_radusergrouprecord = DB::table('radusergroup')->insert([
                    'username'=>$username,'groupname'=>$package,'priority'=>10,
                ]);

                $new_userpackage = DB::table('customerpackages')->insert([
                    'customerid'=>$username,'packageid'=>$package_id[0],
                ]);
                $radcheckuser = DB::table('radcheck')->updateOrInsert(
                    ['username'=>$username,'attribute'=>'Cleartext-Password'],['op'=>':=','value'=>$username]
                );

                if ($new_radusergrouprecord){
                     $remove_suspended_acc = DB::table('user_access_suspensions')->where([['username','=',$username]])->delete();
                    $activated = DB::table('customer_accounts')->where('account_no',$username)->update(['status'=>'active']);
                    if($request->ajax()){
                        echo "user package has been changed successfully";

                    }else{
                        toast("Success","success");
                        return redirect()->back();
                    }
                    
                }
                else{
                    if($request->ajax()){
                        echo "user package could not be  changed, Try again.";

                    }else{
                        toast("Action Failed","error");
                        return redirect()->back();
                    }
                }

            }
        }else if ($packageusers[0] =='pppoe'){
            $radcheckuser = DB::table('radcheck')->updateOrInsert(
                    ['username'=>$username,'attribute'=>'Cleartext-Password'],['op'=>':=','value'=>$username]
                );
            $mpackage = DB::table('packages')->where('packagename','=',$package)->first();
            $user_on_package = DB::table('customerpackages')->where([['customerid','=',$username],['packageid','=',$package_id[0]]])->count();

            if ($user_on_package > 0) {
                echo "user is already on the selected package";

            }
            DB::table('radusergroup')->where('username','=',$username)->delete();

            // DB::table('radcheck')->updateOrInsert(
            //     ['username'=>$request->get('username'),'attribute'=>'Cleartext-Password'],['op'=>':=','value'=>$request->get('password')]
            // );
            //add user to PPOE Profile
             DB::table('radcheck')->updateOrInsert(
                ['username'=>$username,'attribute'=>'User-Profile'],['op'=>':=','value'=>$mpackage->profile??$package.'_Profile']
            );
                $packagemeasure = DB::table('packages')->where('packagename','=',$package)->pluck('durationmeasure');
                $packagenum= DB::table('packages')->where('packagename','=',$package)->pluck('validdays');
                $dateToDisconnect = self::calculateTime($packagemeasure[0],$packagenum[0],'pppoe');
                $expiration = explode("H",$dateToDisconnect)[0];
                $wispr = explode("H",$dateToDisconnect)[1];

              $rad_reply = DB::table('radreply')->updateOrInsert(
                    ['username'=>$username,'attribute'=>'WISPr-Session-Terminate-Time'],['op'=>':=','value'=>$wispr]
                );
              DB::table('radcheck')->insert(
                ['username'=>$username,'attribute'=>'Expiration','op'=>':=','value'=>$expiration]
              );
             //remove user from package
              $remove_userpackage = DB::table('customerpackages')->where('customerid','=',$username)->delete();
              //add user to the news package
              $new_userpackage = DB::table('customerpackages')->insert([
                    'customerid'=>$username,'packageid'=>$package_id[0],
                ]);

                $activated = DB::table('customer_accounts')->where('account_no',$username)->update(['status'=>'active']);
                 $remove_suspended_acc = DB::table('user_access_suspensions')->where([['username','=',$username]])->delete();
                if($request->ajax()){
                    return "PPOE Package applied successfully!";

                }else{
                    toast("Success","success");
                    return redirect()->back();
                }


        }

    }
    public static function changeAccountPackage($account,$package,$customer_username){
        $package = $package;
        $username = $account; //username becomes the account no to be activated
        $c_username = $customer_username;
        $user = Auth::user()->email;
        $log="Changed ".$username." Package to ".$package;
        $logwrite=Log::createTxtLog($user,$log);

        $package_id = DB::table('packages')->where('packagename','=',$package)->pluck('id');

        $packageusers = DB::table('packages')->where('packagename','=',$package)->pluck('users');

        $user_id = DB::table('customers')->where('username','=',$c_username)->pluck('id');



        if($username){
                $pass = DB::table('customers')->where('username','=',$username)->pluck('cleartextpassword');

                $radcheckuser = DB::table('radcheck')->updateOrInsert(
                    ['username'=>$username,'attribute'=>'Cleartext-Password'],['op'=>':=','value'=>$username]
                );
        }

        
        if ($package == 'nopackage'){
            $remove_userpackage = DB::table('customerpackages')->where('customerid','=',$username)->delete();

            $remove_radusergroup = DB::table('radusergroup')->where('username','=',$username)->delete();
            $remove_radusergroup = DB::table('radreply')->where('username','=',$username)->delete();
            $remove_raduserprofiles = DB::table('radcheck')->where([['username','=',$username],['attribute','=','User-Profile']])->delete();
                $remove_raduserprofiles = DB::table('radcheck')->where([['username','=',$username],['attribute','=','Expiration']])->delete();
            $remove_suspended_acc = DB::table('user_access_suspensions')->where([['username','=',$username]])->delete();
            return true;

        }else if($packageusers[0] == 'hotspot'){

            $user_on_package = DB::table('customerpackages')->where([['customerid','=',$username],['packageid','=',$package_id[0]]])->count();

            if ($user_on_package > 0) {
                // echo "user is already on the selected package";
                return true;

            }
            else{
                $delete_user_replies = DB::table('radreply')->where('username','=',$username)->delete();

                //get valid days for the said package and add disconnect time
                $packagemeasure = DB::table('packages')->where('packagename','=',$package)->pluck('durationmeasure');
                $packagenum= DB::table('packages')->where('packagename','=',$package)->pluck('validdays');
                $dateToDisconnect = self::calculateTime($packagemeasure[0],$packagenum[0]);

                $rad_reply = DB::table('radreply')->updateOrInsert(
                    ['username'=>$username,'attribute'=>'WISPr-Session-Terminate-Time'],['op'=>':=','value'=>$dateToDisconnect]
                );

                //remove from radusergroup
                $remove_userpackage = DB::table('customerpackages')->where('customerid','=',$user_id[0])->delete();


                $remove_radusergroup = DB::table('radusergroup')->where('username','=',$username)->delete();

                $remove_raduserprofiles = DB::table('radcheck')->where([['username','=',$username],['attribute','=','User-Profile']])->delete();
                $remove_raduserprofiles = DB::table('radcheck')->where([['username','=',$username],['attribute','=','Expiration']])->delete();

                $new_radusergrouprecord = DB::table('radusergroup')->insert([
                    'username'=>$username,'groupname'=>$package,'priority'=>10,
                ]);

                $new_userpackage = DB::table('customerpackages')->insert([
                    'customerid'=>$username,'packageid'=>$package_id[0],
                ]);

                if ($new_radusergrouprecord){
                     $remove_suspended_acc = DB::table('user_access_suspensions')->where([['username','=',$username]])->delete();
                    $activated = DB::table('customer_accounts')->where('account_no',$username)->update(['status'=>'active']);
                   return true;
                    
                }
                else{
                    return false;
                }

            }
        }else if ($packageusers[0] =='pppoe'){
            $mpackage = DB::table('packages')->where('packagename','=',$package)->first();
            $user_on_package = DB::table('customerpackages')->where([['customerid','=',$username],['packageid','=',$package_id[0]]])->count();

            if ($user_on_package > 0) {
                echo "user is already on the selected package";

            }
            DB::table('radusergroup')->where('username','=',$username)->delete();

            // DB::table('radcheck')->updateOrInsert(
            //     ['username'=>$request->get('username'),'attribute'=>'Cleartext-Password'],['op'=>':=','value'=>$request->get('password')]
            // );
            //add user to PPOE Profile
             DB::table('radcheck')->updateOrInsert(
                ['username'=>$username,'attribute'=>'User-Profile'],['op'=>':=','value'=>$mpackage->profile??$package.'_Profile']
            );
                $packagemeasure = DB::table('packages')->where('packagename','=',$package)->pluck('durationmeasure');
                $packagenum= DB::table('packages')->where('packagename','=',$package)->pluck('validdays');
                $dateToDisconnect = self::calculateTime($packagemeasure[0],$packagenum[0],'pppoe');
                $expiration = explode("H",$dateToDisconnect)[0];
                $wispr = explode("H",$dateToDisconnect)[1];

              $rad_reply = DB::table('radreply')->updateOrInsert(
                    ['username'=>$username,'attribute'=>'WISPr-Session-Terminate-Time'],['op'=>':=','value'=>$wispr]
                );
              DB::table('radcheck')->insert(
                ['username'=>$username,'attribute'=>'Expiration','op'=>':=','value'=>$expiration]
              );
             //remove user from package
              $remove_userpackage = DB::table('customerpackages')->where('customerid','=',$username)->delete();
              //add user to the news package
              $new_userpackage = DB::table('customerpackages')->insert([
                    'customerid'=>$username,'packageid'=>$package_id[0],
                ]);

                $activated = DB::table('customer_accounts')->where('account_no',$username)->update(['status'=>'active']);
                 $remove_suspended_acc = DB::table('user_access_suspensions')->where([['username','=',$username]])->delete();
                return true;


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

            return $d." ".$mnth." ".$y. " 12:00"."H".$dateToDisconnect;
        }

    }
    
    public function perUserLimit(Request $request){
        $limit = $request->get('limit');
        $limitvalue = $request->get('limitvalue');
        $username = $request->get('username');
        $user = Auth::user()->email;
        $log=" Edited user ".$username." on ".date("Y:m:d h:i:s");
        $logwrite=Log::createTxtLog($user,$log);
        foreach ($limit as $key=>$l){
            $limit_details = DB::table('custom_limits')->where('id','=',$l)->get();
            foreach($limit_details as $ld){
                $p_table = strtolower($ld->pref_table);
                if($p_table =="reply"){
                    $new_reply_rec = DB::table('radreply')->insert([
                        'username'=>$username,'attribute'=>$ld->limitname,'op'=>$ld->op,'value'=>$limitvalue[$key]==NULL?$ld->limitmeasure:$limitvalue[$key],
                    ]);
                }else if($p_table == 'check'){
                    $new_reply_rec = DB::table('radcheck')->insert([
                        'username'=>$username,'attribute'=>$ld->limitname,'op'=>$ld->op,'value'=>$limitvalue[$key],
                    ]);
                }
            }
            return redirect()->back()->with("success","Limits applied successfully");
        }

    }
    public function editAttribute(Request $request){
        if($request->get('table') == 'check'){
            DB::table('radcheck')->where('id','=',$request->get('attr_id'))->update(
                ['attribute'=>$request->get('limit'),'value'=>$request->get('limitvalue')]
            );
        }else{
            DB::table('radreply')->where('id','=',$request->get('attr_id'))->update(
                ['attribute'=>$request->get('limit'),'value'=>$request->get('limitvalue')]
            );
        }
        return redirect()->back()->with("success","limit updated successfully");
    }
    public function deleteAttrcheck(Request $request,$id){
        if($id){
            DB::table('radcheck')->where('id','=',$id)->delete();
            if($request->ajax()){
                return "Limit deleted successfully";
            }
            return redirect()->back()->with("success","limit removed successfully");
        }else{
            return redirect()->back()->with("error","unknown id");
        }
    }
    public function deleteAttrreply(Request $request,$id){
        if($id){
            DB::table('radreply')->where('id','=',$id)->delete();
            if($request->ajax()){
                return "Limit deleted successfully";
            }
            return redirect()->back()->with("success","limit removed successfully");
        }
        else{
            return redirect()->back()->with("error","unknown id");
        }
    }
    public function deleteuser(Request $request){
        $username = $request->get('username');
        $del_ac = $request->get('del_acc');
        $customerexist = DB::table('radcheck')->where('username','=',$username)->count();

        $customeroncustomers = DB::table('customers')->where('username','=',$username)->count();
        $id = DB::table('customers')->where('username','=',$username)->pluck('id');
        
        if($customerexist > 0 || $customeroncustomers > 0){
            DB::table('customers')->where('id','=',$id[0])->delete();
            DB::table('radcheck')->where('username','=',$username)->delete();
            DB::table('radreply')->where('username','=',$username)->delete();
            DB::table('radusergroup')->where('username','=',$username)->delete();
            DB::table('customerpackages')->where('customerid','=',$id[0])->delete();
            if($del_ac=='yes'){
                DB::table('radacct')->where('username','=',$username)->delete();
            }
            $user = Auth::user()->email;
            $log="Deleted user ".$request->get('username');
            $logwrite=Log::createTxtLog($user,$log);
            
            return redirect()->route('user.all')->with("success","customer removed successfully");
        }
        return redirect()->back()->with("error","customer could not be removed, try again!");
    }
    public function getUserLimit(){
        $limits = DB::table('custom_limits')->get();
        return view('users.userlimits',compact('limits'));
    }
    public function postUserLimit(Request $request){
        $limits = DB::table('custom_limits')->updateOrInsert(
            ['limitname'=>$request->get('limitname'),'pref_table'=>$request->get('pref_table')],
            ['limitmeasure'=>$request->get('limitmeasure'),'op'=>$request->get('op')]
        );
        return redirect()->back()->with("success","limit changes applied successfully");
    }
    public function deleteUserLimit($id){
        $limits = DB::table('custom_limits')->where('id','=',$id)->delete();

        return redirect()->back()->with("success","limit has been deleted successfully");
    }
    public function allocateEquipmet(Request $request){
        $added_by = Auth::user()->email;
        $today_date = date("Y-m-d");
        $item_in_stock=DB::table('items')->where('id',$request->get('item_id'))->first();
        $item_stock = DB::table('item_stock')->where('item_id',$request->get('item_id'))->get();
        $quantity_in_stock = intval($item_in_stock->quantity);
        $stock_total = 0;
        foreach($item_stock as $s){
            $stock_total+=$s->quantity_in; 
        }
        if(($quantity_in_stock+$stock_total)>0 && ($quantity_in_stock+$stock_total)>= $request->get('quantity')){
                $allocation = DB::table('item_allocations')->insertGetId(
                ['item_id'=>$request->get('item_id'),'customer_id'=>$request->get('userid'),'quantity'=>$request->get('quantity'),'status'=>$request->get('status'),'return_date'=>$request->get('return_date'),'added_by'=>$added_by,'allocation_date'=>$today_date,'account_no'=>$request->get('account_no')]
            );
            DB::table('item_stock')->insert(
                ['item_id'=>$request->get('item_id'),'allocation_id'=>$allocation,'narration'=>'CUSTOMER ALLOCATION','added_by'=>$added_by,'quantity_in'=>-($request->get('quantity'))]
            );
            if(is_int($allocation) && $request->ajax()){
                return "success";
            }else if(is_int($allocation) && !$request->ajax()){
                toast("Item allocated successfully","success");
                return redirect()->back();
            }else{
                toast("Item could not be allocated","error");
                return redirect()->back();
            }
        }else{
           alert()->error("Item could not be allocated, There is no enough stock to issue ".$request->get('quantity')." items. Your stock for this item stand at ".intval(intval($quantity_in_stock)+intval($stock_total)));
            return redirect()->back(); 
        }
        
    }
    public function deleteAllocation(Request $request,$id){
        $del = DB::table('item_allocations')->where('id',$id)->delete();
        if($del){
            //remove stock negative record
            DB::table('item_stock')->where('allocation_id',$id)->delete();

            return "Allocation removed successfully";
        }else{
            return "Allocation could not be removed";

        }
    }
    public function reactivatePPPoeAccount(Request $request){
        $user = DB::table('customers')->where([['username','=',$request->get('username')]])->first();
        $package = DB::table('customerpackages')->where([['customerid','=',$user->id]])->first();
        if($package){
            $userpackage = DB::table('packages')->where('id',$package->packageid)->first();
            if($userpackage){
                if(!self::checkIfUserIsExpired($request->get('username'))){
                    if($request->deduct){
                        $packageprice = DB::table('package_prices')->where('packageid',$package->packageid)->first();
                        $userbalance = CustomerHelper::availableFunds($request->username);
                        if($userbalance<$packageprice->amount){
                            alert()->error("User available funds is less than the package price");
                        }else{
                            $used_funds = CustomerHelper::usedFunds($request->username)+$packageprice->amount;
                            $available_funds = $userbalance-$packageprice->amount;
                            DB::table('customer_funds')->updateOrInsert(
                                ['username'=>$request->get('username')],
                                ['available_funds'=>$available_funds,'used_funds'=>$used_funds]
                            );
                        }
                    }
                    $dateToDisconnectWSP = self::calculateTime($userpackage->durationmeasure,$userpackage->validdays,'hotspot');
                    $dateToDisconnectPPPOE = self::calculateTime($userpackage->durationmeasure,$userpackage->validdays,'pppoe');
                    $update_radcheck = DB::table('radcheck')->updateOrInsert(
                        ['username'=>$request->get('username'),'attribute'=>'Expiration'],
                        ['value'=>$dateToDisconnectPPPOE],
                    );
                    $update_radreply = DB::table('radreply')->updateOrInsert(
                        ['username'=>$request->get('username'),'attribute'=>'WISPr-Session-Terminate-Time'],
                        ['value'=>$dateToDisconnectWSP],
                    );
                    alert()->success('User reactivated for '.$userpackage->validdays.' '.$userpackage->durationmeasure.' (s)');
                    return redirect()->back();
                }else{
                    alert()->warning('user is already active, no action could be taken');
                    return redirect()->back();
                }
                
            }else{
                alert()->error("User is not allocated to a package");
                return redirect()->back();
            }

        }else{
             alert()->error("User is not allocated to a package");
            return redirect()->back();
        }
        

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
    public function returnEquipment(Request $request){
        $received_by = Auth::user()->email;
        $today_date = date("Y-m-d");
        $id = $request->get('allocation_id');
        $qr = $request->get('quantity_returned');
        $alloc = DB::table('item_allocations')->where('id',$id)->first();
        if (intval($qr)>intval($alloc->quantity)){
            alert()->error("Quantity returned cannot be more than what was allocated");
            return redirect()->back();
        }else{
           $update_alloc = DB::table('item_allocations')->where('id',$id)->update(
                ['quantity_returned'=>$qr,'date_returned'=>$today_date,'received_by'=>$received_by,'status'=>'RETURNED']
            );
            if ($update_alloc){
                DB::table('item_stock')->insert(
                    ['item_id'=>$alloc->item_id,'allocation_id'=>$id,
                    'narration'=>'CUSTOMER RETURNED ITEMS','added_by'=>$received_by,'quantity_in'=>$qr]
                );
                toast("Allocation updated successfully","success");
                return redirect()->back();
            }else{
                toast("Allocation could not be updated, try again ","error");
                return redirect()->back();
            } 
        }        

    }
    public function getUserAccounts(Request $request){
        $customers = DB::table('customers')->get();
        $customer_accounts = array();
        $packages = DB::table('packages')->get();


        if($customers){
            foreach($customers as $c){
                $accounts = DB::table('customer_accounts')->where([['owner','=',$c->username]])->get();
                if($accounts){

                array_push($customer_accounts, $accounts);
                }
            }
        }

        
        return view('user_accounts.user_accounts', compact('customers','customer_accounts','packages'));
    }
    public function postUserAccount(Request $request){
        $account_exist = DB::table('customer_accounts')->where([['owner','=',$request->get('owner')],['package_name','=',$request->get('package')]])->get();
        if(count($account_exist)>0){
         alert()->error("User has an account linked to this package!");
         return redirect()->back();   
        }else{
            $customerishotspot = DB::table('customers')->where('username',$request->owner)->first();
            if($customerishotspot->type=='hotspot'){
                alert()->error("An hotspot user cannot have multiple accounts!");
                return redirect()->back(); 
            }else{
               $account = DB::table('customer_accounts')->insert(
                ['owner'=>$request->get('owner'),'account_name'=>$request->get('account_name'),'account_no'=>$request->get('account_no'),'status'=>'inactive','package_name'=>$request->get('package')]
                );
                if($account){
                    toast("Account added successfully!","success");
                    return redirect()->back();
                }else{
                     toast("Account could not be added successfully!","error");
                    return redirect()->back();
                } 
            }

            
        }
        
    }
    
    public function getAccountEdit(Request $request,$acc){
        $account = DB::table('customer_accounts')->where('account_no',$acc)->first();
        $usertype = DB::table('customers')->where('username',$account->owner)->first();
        // $packages = DB::table('packages')->where('users',$usertype->type)->get();
        $packages = DB::table('packages')->get();
        return view('user_accounts.edit_customer_accounts',compact('account','packages'));
    }
    public function postAccountUpdate(Request $request){
        $account_package = DB::table('customer_accounts')->where('account_no',$request->get('account_no'))->first();
        if($account_package->package_name!=$request->package_name){
            $status = self::changeAccountPackage($request->get('account_no'),$request->get('package_name'),$account_package->owner);
            
            if($status){
                $updated_account = DB::table('customer_accounts')->where('account_no',$request->get('account_no'))->update(['account_name'=>$request->get('account_name'),'town'=>$request->get('town'),'address'=>$request->get('address'),'building'=>$request->get('building'),'coordinates'=>$request->get('coordinates'),'package_name'=>$request->get('package_name')]);
                 alert()->success("Changes applied successfully");
                return redirect()->back();
            }else{
                alert()->error("There was an error saving your changes, try again");
                return redirect()->back();
            }
        }else{
            $updated_account = DB::table('customer_accounts')->where('account_no',$request->get('account_no'))->update(['account_name'=>$request->get('account_name'),'town'=>$request->get('town'),'address'=>$request->get('address'),'building'=>$request->get('building'),'coordinates'=>$request->get('coordinates'),'package_name'=>$request->get('package_name')]);

            alert()->success("Changes applied successfully");
            return redirect()->back();
        }
    }
    public function customerformpdf(Request $request,$account_no=100){
        // return PDF::loadFile(public_path().'/templates/invoice.html')->save(public_path().'/docs/my_stored_file.pdf')->stream('download.pdf');
        $account = $account_no;
        $account_info = DB::table('customer_accounts')->where('account_no',$account)->first();
        $owner_info = DB::table('customers')->where('username',$account_info->owner)->first();
        $service_info = DB::table('packages')->where('packagename',$account_info->package_name)->first();
        $account_items = DB::table('item_allocations')->join('items','items.id','=','item_allocations.item_id')->where('account_no',$account)->get();
        
        $pdf = PDF::loadView('services.customer_form',compact('account','owner_info','service_info','account_items','account_info'));
        return $pdf->stream('customer_form.pdf');
        return view('services.customer_form');
    }

}
