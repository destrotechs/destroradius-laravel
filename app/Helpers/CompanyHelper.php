<?php
namespace App\Helpers;

use Auth;
use DB;
class CompanyHelper
{

	public static function CompanyInfo(){
		$company = DB::table('company_details')->first();
		return $company;
	}

}