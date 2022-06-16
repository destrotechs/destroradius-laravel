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
            'zoneid'=>'required',
            'phone'=>'required|numeric',
            // 'package'=>'required',
            'nasid'=>'required',
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


        $c->save();
        $customerid=$c->id;
        $user = Auth::user()->email;
        $log=" Created New user ".$request->get('username');
        $logwrite=Log::createTxtLog($user,$log);
        $packageusers = DB::table('packages')->where('packagename','=',$request->get('package'))->pluck('users');
        //calculate validdays for this customer
        if($request->get('package')!="none" && $packageusers=='hotspot'){
            $customerdays=DB::table('packages')->where('packagename','=',$request->get('package'))->pluck('validdays');
            $customermaxmbs=DB::table('packages')->where('packagename','=',$request->get('package'))->pluck('quota');

            $expireafter=$customerdays[0]*24*60*60;
            $maximumbytes=$customermaxmbs[0];
            //adduser to radcheck
            if($maximumbytes>0){
                DB::table('radcheck')->insert([
                    ['username'=>$request->get('username'),'attribute'=>'Cleartext-Password','op'=>':=','value'=>$request->get('password')],
                    ['username'=>$request->get('username'),'attribute'=>'Max-All-MB','op'=>':=','value'=>$maximumbytes],
                ]);
                //create user attributes to radreply
                DB::table('radreply')->insert([
                    ['username'=>$request->get('username'),'attribute'=>'Max-All-MB','op'=>':=','value'=>$maximumbytes],
                ]);
            }else{
                DB::table('radcheck')->insert([
                    ['username'=>$request->get('username'),'attribute'=>'Cleartext-Password','op'=>':=','value'=>$request->get('password')],
                ]);
            }




            //apply package to the user
            DB::table('radusergroup')->insert(['username'=>$request->get('username'),'groupname'=>$request->get('package'),'priority'=>'10']);
            //add customer to customerpackages
            $packageid=DB::table('packages')->where('packagename','=',$request->get('package'))->pluck('id');
            $pid=$packageid[0];

            DB::table('customerpackages')->insert([
                ['packageid'=>$pid,'customerid'=>$customerid],
            ]);

            //add user to nas disabled mode

            //return success
            return redirect()->back()->with("success","user added successfully");
        }else if ($packageusers=='pppoe') {
           
            DB::table('radcheck')->insert([
                ['username'=>$request->get('username'),'attribute'=>'Cleartext-Password','op'=>':=','value'=>$request->get('password')],
            ]);
            //add user to PPOE Profile
             DB::table('radcheck')->insert([
                ['username'=>$request->get('username'),'attribute'=>'User-Profile','op'=>':=','value'=>$request->get('package').'_Profile'],
            ]);
            return redirect()->back()->with("success","user added successfully");

        }else{
            DB::table('radcheck')->insert([
                ['username'=>$request->get('username'),'attribute'=>'Cleartext-Password','op'=>':=','value'=>$request->get('password')],
            ]);
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
        // $query="ip/hotspot/user/active";
        // $users=Mikrotik::performFetchQuery('10.50.120.2','admin','123456',$query);
        // $users=json_decode($users);
        return view('users.onlineusers');
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

                foreach ($onlneuser as $key => $o) {
                    $totaldownload=DB::table('radacct')->where('username','=',$o->username)->sum('AcctInputOctets');
                    $totalupload=DB::table('radacct')->where('username','=',$o->username)->sum('AcctOutputOctets');
                    $output.="<tr>";
                    $output.="<td>".$num."</td><td>".$o->username."</td><td>".$o->acctstarttime."</td><td>".$o->framedipaddress."</td><td>".$o->nasipaddress."</td><td>".$totaldownload."</td><td>".$totalupload."</td>";
                    $output.="</tr>";
                }
                return $output;

            }else{
                echo "none";
            }
        }else if($usertype=='nas'){
           $users = Mikrotik::connectToNas(1);
                
                if(count($users)>0){
                    foreach ($users as $key => $o) {
                        $totaldownload=$o[3];
                        $totalupload=$o[4];
                        $output.="<tr>";
                        $output.="<td>".$num."</td><td>".$o[0]."</td><td>".$o[1]."</td><td>".$totaldownload."</td><td>".$totalupload."</td>";
                        $output.="</tr>";
                    }
                }
            return $output;
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

            $userdetails=DB::table('customers')->where('username','=',$username)->leftJoin('zones','zones.id','=','customers.zone')->get();

            $user_pppoe = DB::table('radcheck')->where([['username','=',$username],['attribute','=','User-Profile']])->get();

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
            return view('users.changeuser',compact('packages','customlimits','userdetails','userpackage','replyattributes','checkattributes','preplyattributes','pcheckattributes','packagedetails','usertimespent','userquotaspent'));

        }else{
            return redirect()->route('geteditcustomer');
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
        $username = $request->get('username');
        $user = Auth::user()->email;
        $log="Changed ".$username." Package to ".$package;
        $logwrite=Log::createTxtLog($user,$log);

        $package_id = DB::table('packages')->where('packagename','=',$package)->pluck('id');

        $packageusers = DB::table('packages')->where('packagename','=',$package)->pluck('users');

        $user_id = DB::table('customers')->where('username','=',$username)->pluck('id');

        if($username){
                $pass = DB::table('customers')->where('username','=',$username)->pluck('cleartextpassword');

                $radcheckuser = DB::table('radcheck')->updateOrInsert(
                    ['username'=>$username,'attribute'=>'Cleartext-Password'],['op'=>':=','value'=>$pass[0]],
                );
        }

        
        if ($package == 'nopackage'){
            $remove_userpackage = DB::table('customerpackages')->where('customerid','=',$user_id)->delete();

            $remove_radusergroup = DB::table('radusergroup')->where('username','=',$username)->delete();
            $remove_radusergroup = DB::table('radreply')->where('username','=',$username)->delete();

            echo "user activated on non-regulated mode";

        }else if($packageusers[0] == 'hotspot'){

            $user_on_package = DB::table('customerpackages')->where([['customerid','=',$user_id[0]],['packageid','=',$package_id[0]]])->count();

            if ($user_on_package > 0) {
                echo "user is already on the selected package";

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

                $new_radusergrouprecord = DB::table('radusergroup')->insert([
                    'username'=>$username,'groupname'=>$package,'priority'=>10,
                ]);

                $new_userpackage = DB::table('customerpackages')->insert([
                    'customerid'=>$user_id[0],'packageid'=>$package_id[0],
                ]);

                if ($new_radusergrouprecord){
                    echo "user package has been changed successfully";
                }
                else{
                    echo "user package could not be  changed, Try again.";
                }

            }
        }else if ($packageusers[0] =='pppoe'){
            $user_on_package = DB::table('customerpackages')->where([['customerid','=',$user_id[0]],['packageid','=',$package_id[0]]])->count();

            if ($user_on_package > 0) {
                echo "user is already on the selected package";

            }
            DB::table('radusergroup')->where('username','=',$request->get('username'))->delete();

            // DB::table('radcheck')->updateOrInsert(
            //     ['username'=>$request->get('username'),'attribute'=>'Cleartext-Password'],['op'=>':=','value'=>$request->get('password')]
            // );
            //add user to PPOE Profile
             DB::table('radcheck')->updateOrInsert(
                ['username'=>$request->get('username'),'attribute'=>'User-Profile'],['op'=>':=','value'=>$request->get('package').'_Profile']
            );
                $packagemeasure = DB::table('packages')->where('packagename','=',$package)->pluck('durationmeasure');
                $packagenum= DB::table('packages')->where('packagename','=',$package)->pluck('validdays');
                $dateToDisconnect = self::calculateTime($packagemeasure[0],$packagenum[0]);

              $rad_reply = DB::table('radreply')->updateOrInsert(
                    ['username'=>$username,'attribute'=>'WISPr-Session-Terminate-Time'],['op'=>':=','value'=>$dateToDisconnect]
                );
             //remove user from package
              $remove_userpackage = DB::table('customerpackages')->where('customerid','=',$user_id[0])->delete();
              //add user to the news package
              $new_userpackage = DB::table('customerpackages')->insert([
                    'customerid'=>$user_id[0],'packageid'=>$package_id[0],
                ]);


             return "PPOE Package applied successfully!";

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
                $packageValidDate = mktime($hour,$min,$sec,$month,($day+(7*$num)),$year);

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
}
