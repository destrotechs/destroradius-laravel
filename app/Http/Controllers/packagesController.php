<?php

namespace App\Http\Controllers;
use App\Package;
use Illuminate\Http\Request;
use DB;
USE App\Log;
use App\Zone;
use App\PackagePrice;
use Illuminate\Support\Facades\Auth;

class packagesController extends Controller
{
    public function __construct(){
        $this->logs_enabled=0;
        $enabled=DB::table('settings')->get();
        foreach ($enabled as $key => $en) {
            $this->logs_enabled=$en->logs_enabled;
        }
        return $this->middleware('auth');
    }

    public function newPackage(Request $request){
        $zones=Zone::all();
        return view('packages.newpackage',compact('zones'));
    }
    public function savePackage(Request $request){
      
        $request->validate([
            'packagename'=>'required|unique:packages',
            'uploadspeed'=>'required',
            'downloadspeed'=>'required',
            'packagezone'=>'required',
            'period'=>'required',
            'numberofdevices'=>'required',
            'validdays'=>'required',
            'users'=>'required',
            'description'=>'required',
        ]);
        $downloadspeed=0;
        $uploadspeed=0;
        $bandwidth=$request->get('bandwidth');
        if($bandwidth=='M'){
            $uploadspeed=$request->get('uploadspeed')*1024*1024;
            $downloadspeed=$request->get('downloadspeed')*1024*1024;
        }else{
            $uploadspeed=$request->get('uploadspeed')*1024;
            $downloadspeed=$request->get('downloadspeed')*1024;
        }
        $quota=($request->get('quota'))*1024*1024;
        $package = new Package;
        $package->packagename=$request->get('packagename');
        $package->uploadspeed=$uploadspeed;
        $package->downloadspeed=$downloadspeed;
        $package->users=$request->get('users');
        $package->packagezone=$request->get('packagezone');
        $package->quota=$quota;
        $package->durationmeasure=$request->get('period');
        $package->numberofdevices=$request->get('numberofdevices');
        $package->description=$request->get('description');
        $package->validdays=$request->get('validdays');

        $newpackage= $package->save();

        $period=$request->get('period');
        $validtime=$request->get('validdays');
        
        $expireafter=0;
        switch ($period) {
            case 'min':
                $expireafter=$validtime*60;
                break;
            case 'hour':
                $expireafter=$validtime*60*60;
                break;
            case 'day':
                $expireafter=$validtime*60*60*24;
                break;
            case 'week':
                $expireafter=$validtime*60*60*24*7;
                break;
            case 'month':
                $expireafter=$validtime*60*60*24*30;
                break;
            default:
                 $expireafter=0;
                break;
        }

        //create a group for hotspot users  with the defined attributes
        if($request->get('users')=='hotspot'){

            $newgroupreply=DB::table('radgroupreply')->insert([
            ['groupname'=>$request->get('packagename'),'attribute'=>'WISPr-Bandwidth-Max-Down','op'=>':=','value'=>$request->get('downbandwidth')],
            ['groupname'=>$request->get('packagename'),'attribute'=>'WISPr-Bandwidth-Max-Up','op'=>':=','value'=>$request->get('upbandwidth')],
            ['groupname'=>$request->get('packagename'),'attribute'=>'Simultaneous-Use','op'=>':=','value'=>$request->get('numberofdevices')],
           

            ]);
        if($expireafter>0 && $quota>0){
            $newcheckgroup=DB::table('radgroupcheck')->insert([
                ['groupname'=>$request->get('packagename'),'attribute'=>'Max-All-MB','op'=>':=','value'=>$quota],
                ['groupname'=>$request->get('packagename'),'attribute'=>'Max-All-Session','op'=>':=','value'=>$expireafter],
            ]);
            $newgroupreply=DB::table('radgroupreply')->insert([
                 ['groupname'=>$request->get('packagename'),'attribute'=>'Max-All-MB','op'=>':=','value'=>$quota],
                 ['groupname'=>$request->get('packagename'),'attribute'=>'Max-All-Session','op'=>':=','value'=>$expireafter],
            ]);
        }

        }else{
            //create a group for pppoe user with the defined attributes
            $ppoecheck=DB::table('radgroupcheck')->insert([
                ['groupname'=>$request->get('packagename'),'attribute'=>'Framed-Protocol','op'=>'==','value'=>'PPP'],
            ]);

            $ppoereply=DB::table('radgroupreply')->insert([
                ['groupname'=>$request->get('packagename'),'attribute'=>'Framed-Pool','op'=>'=','value'=>$request->get('poolname')],
                ['groupname'=>$request->get('packagename'),'attribute'=>'Mikrotik-Rate-Limit','op'=>'=','value'=>$request->get('uploadspeed').$request->get('bandwidth').'/'.$request->get('downloadspeed').$request->get('bandwidth').' '.($request->get('uploadspeed')+1).$request->get('bandwidth').'/'.($request->get('downloadspeed')+1).$request->get('bandwidth').' 40/40'],
            ]);
        }
        
        

        if($newpackage){
            return redirect()->back()->with("success","Package created successfully!");
        }
        
    }
    public function savePackageChanges(Request $request){

        $quota=($request->get('quota'))*1024*1024;
        $packagename=$request->get('packagename');
        $uploadspeed=$request->get('upbandwidth');
        $downloadspeed=$request->get('downbandwidth');
        $users=$request->get('users');
        $quota=$quota;
        $numberofdevices=$request->get('numberofdevices');

        $validdays=$request->get('validdays');
        $id=$request->get('id');

        $packageupdate=DB::table('packages')->where('id','=',$id)->update(['packagename'=>$packagename,'uploadspeed'=>$uploadspeed,'downloadspeed'=>$downloadspeed,'users'=>$users,'quota'=>$quota,'numberofdevices'=>$numberofdevices,'validdays'=>$validdays,'packagezone'=>$request->get('packagezone'),'durationmeasure'=>$request->get('period')]);
        //update attributes on radgroupcheck and radgroupreply
        DB::table('radgroupreply')->where('groupname','=',$packagename)->delete();

        DB::table('radgroupcheck')->where('groupname','=',$packagename)->delete();


        $period=$request->get('period');
        $validtime=$request->get('validdays');
        
        $expireafter=0;
        switch ($period) {
            case 'min':
                $expireafter=$validtime*60;
                break;
            case 'hour':
                $expireafter=$validtime*60*60;
                break;
            case 'day':
                $expireafter=$validtime*60*60*24;
                break;
            case 'week':
                $expireafter=$validtime*60*60*24*7;
                break;
            case 'month':
                $expireafter=$validtime*60*60*24*30;
                break;
            default:
                 $expireafter=0;
                break;
        }

        //create a group for hotspot users  with the defined attributes
        if($request->get('users')=='hotspot'){

            $newgroupreply=DB::table('radgroupreply')->insert([
            ['groupname'=>$request->get('packagename'),'attribute'=>'WISPr-Bandwidth-Max-Down','op'=>':=','value'=>$request->get('downbandwidth')],
            ['groupname'=>$request->get('packagename'),'attribute'=>'WISPr-Bandwidth-Max-Up','op'=>':=','value'=>$request->get('upbandwidth')],
            ['groupname'=>$request->get('packagename'),'attribute'=>'Simultaneous-Use','op'=>':=','value'=>$request->get('numberofdevices')],
           

            ]);
        if($expireafter>0 && $quota>0){
            $newcheckgroup=DB::table('radgroupcheck')->insert([
                ['groupname'=>$request->get('packagename'),'attribute'=>'Max-All-MB','op'=>':=','value'=>$quota],
                ['groupname'=>$request->get('packagename'),'attribute'=>'Max-All-Session','op'=>':=','value'=>$expireafter],
            ]);
            $newgroupreply=DB::table('radgroupreply')->insert([
                 ['groupname'=>$request->get('packagename'),'attribute'=>'Max-All-MB','op'=>':=','value'=>$quota],
                 ['groupname'=>$request->get('packagename'),'attribute'=>'Max-All-Session','op'=>':=','value'=>$expireafter],
            ]);
        }
        
        }

        return redirect()->route("packages.all")->with("success","Package details updated successfully");
    }
    public function allPackages(){
        $packages=Package::all();
        
        return view('packages.allpackages', compact('packages'));
    }
    public function editPackage(Request $request,$id){
        $package = Package::find($id);
        $zones=Zone::all();
        return view('packages.edit',compact('package','zones'));
    }
    public function deletePackage($id){
        //fetch package and store the name in a variable


        $package = Package::find($id);
        $packagename=$package->packagename;
        //LOG THE DELETED FILE

        $user=Auth::user()->email;
        $log=" Deleted a package called ".$packagename." on ".date("Y:m:d h:i:s");
        $logwrite=Log::createTxtLog($user,$log);
        try{

                //delete all associated attributes in radgroupcheck and radgroupreply
            $removeattributes=DB::table('radgroupcheck')->where('groupname','=',$packagename)->delete();

             $removeattributes=DB::table('radgroupreply')->where('groupname','=',$packagename)->delete();
            //remove the package users from usergroup
              $removeattributes=DB::table('radusergroup')->where('groupname','=',$packagename)->delete();
              //remove package price
              DB::table('package_prices')->where('packageid','=',$id)->delete();

              //remove all users associiated with the package

              $user_ids = DB::table('customerpackages')->where('packageid','=',$id)->get();
              if(count($user_ids)>0){
                  foreach($user_ids as $user_id){
                    $user_name = DB::table('customers')->where('id','=',$user_id->customerid)->first();

                      DB::table('customerpackages')->where('packageid','=',$id)->delete();
                      DB::table('customers')->where('id','=',$user_id->customerid)->delete();
                      DB::table('radcheck')->where('username','=',$user_name[0])->delete();
                  }
                }
              DB::table('package_prices')->where('packageid','=',$id)->delete();
              //finaly delete package from packages table
            DB::table('packages')->where('id','=',$id)->delete();

            return redirect()->back()->with("success","package removed successfully");

        }catch(Exception $e){
             return redirect()->back()->with("error","There was an error removing the selected package, try again!");
        }
        
    }
    public function packagePrices(Request $request){
        $packages=Package::all();
        $pricedpackages=DB::table('packages')->join('package_prices','package_prices.packageid','=','packages.id')->get();
        return view('packages.pricing',compact('packages','pricedpackages'));
    }
    public function savePackagePrice(Request $request){
        if($request->get('amount')<1){
           return redirect()->back()->with("error","price of a package should be 1 plus"); 
        }else{

            $packageprice=DB::table('package_prices')->updateOrInsert(
                ['packageid'=>$request->get('packageid')],
                ['currency'=>$request->get('currency'),'amount'=>$request->get('amount'),'rate'=>'null']
            );

            return redirect()->back()->with("success","Package price added successfully");
        }

        
    }
}
