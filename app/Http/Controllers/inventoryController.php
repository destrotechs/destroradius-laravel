<?php

namespace App\Http\Controllers;
use App\Item;
use DB;
use App\Log;
use Validator;
use App\Product;
use App\Supply;
use App\Vendor;
use Illuminate\Http\Request;

class inventoryController extends Controller
{
	public function __construct(){
        $this->logs_enabled=0;
        $enabled=DB::table('settings')->get();
        foreach ($enabled as $key => $en) {
            $this->logs_enabled=$en->logs_enabled;
        }
        $this->middleware('auth');
    }
    public function render_items(){
    	$items=Item::paginate(15);
    	return view('inventory.items',compact('items'));
    }
    public function render_products(){
    	$products=Product::paginate(15);
    	return view('inventory.products',compact('products'));
    }
    public function render_product_new(){
    	$products=DB::table('products')->orderBy('id','desc')->limit(5)->get();
    	return view('inventory.newproduct',compact('products'));
    }
    public function render_item_new(){
    	$items=DB::table('items')->orderBy('id','desc')->limit(5)->get();
    	return view('inventory.newitem',compact('items'));
    }
    /*creating new item*/
    public function post_new_item(Request $request){
    	 $validator = Validator::make($request->all(), [
            'itemname' => 'required',
            'itemmodel' => 'required',
            'itemserial'=>'required',
            'itemtype'=>'required',
            'itemquantity'=>'required',
        ]);

        if ($validator->fails()) {
            return redirect()
                        ->withErrors($validator)
                        ->withInput();
        }else{
        	$item=new Item;
        	$item->name=$request->get('itemname');
        	$item->model=$request->get('itemmodel');
        	$item->serial=$request->get('itemserial');
        	$item->type=$request->get('itemtype');
        	$item->quantity=$request->get('itemquantity');
        	$item->description=$request->get('description');
        	$item->cost=$request->get('cost');
        	$item->supplier_id=$request->get('supplierid')||'other';

        	$item->save();

        	if ($item) {
        		return redirect()->back()->with('success','Item added successfully');
        	}else{
        		return redirect()->back()->with('error','new item could not be added, try again ...
        			');
        	}
        }
    }
    public function post_new_product(Request $request){
    	$validator = Validator::make($request->all(), [
            'productname' => 'required',
            'vendor' => 'required',
            'price'=>'required',
            'producttype'=>'required',
        ]);

        if ($validator->fails()) {
            return redirect()
                        ->withErrors($validator)
                        ->withInput();
        }else{
        	$p=new Product;
        	$p->name=$request->get('productname');
        	$p->producttype=$request->get('producttype');
        	$p->vendor=$request->get('vendor');
        	$p->price=$request->get('price');

        	$p->save();

        	if ($p) {
        		return redirect()->back()->with('success','product added successfully');
        	}else{
        		return redirect()->back()->with('error','new product could not be added, try again ...
        			');
        	}
        }
    }
    public function edit_item(Request $request,$id){
    	$item=Item::find($id);
    	return view('inventory.edititem',compact('item'));
    }
    public function edit_product(Request $request,$id){
    	$product=Product::find($id);
    	return view('inventory.editproduct',compact('product'));
    }
    public function save_edit_item(Request $request){
    	$validator = Validator::make($request->all(), [
            'itemname' => 'required',
            'itemmodel' => 'required',
            'itemserial'=>'required',
            'itemtype'=>'required',
            'itemquantity'=>'required',
        ]);

        if ($validator->fails()) {
            return redirect()
                        ->withErrors($validator)
                        ->withInput();
        }else{

        	$id=$request->get('id');

        	$item = DB::table('items')->where('id','=',$id)->update([
        		'name'=>$request->get('itemname'),'model'=>$request->get('itemmodel'),'type'=>$request->get('itemtype'),'serial'=>$request->get('itemserial'),'description'=>$request->get('description'),'cost'=>$request->get('cost'),'supplier_id'=>$request->get('supplierid')||'other',
        	]);

        	if ($item) {
        		return redirect()->route('inventory.items')->with('success','item updated successfully');
        	}else{
        		return redirect()->back()->with('error','item could not be updated, try again');
        	}
        }
    }
     public function save_edit_product(Request $request){
    	$validator = Validator::make($request->all(), [
            'productname' => 'required',
            'vendor' => 'required',
            'price'=>'required',
            'producttype'=>'required',
        ]);

        if ($validator->fails()) {
            return redirect()
                        ->withErrors($validator)
                        ->withInput();
        }else{

        	$id=$request->get('id');

        	$item = DB::table('products')->where('id','=',$id)->update([
        		'name'=>$request->get('productname'),'producttype'=>$request->get('producttype'),'vendor'=>$request->get('vendor'),'price'=>$request->get('price'),
        	]);

        	if ($item) {
        		return redirect()->route('inventory.products')->with('success','product updated successfully');
        	}else{
        		return redirect()->back()->with('error','product could not be updated, try again');
        	}
        }
    }
    public function item_delete($id){
    	$item=Item::find($id);
    	$res=$item->delete();
    	if ($res) {
    		return redirect()->back()->with('success','Item deleted successfully');
    	}else{
    		return redirect()->back()->with('error','item could not be deleted, try again');
    	}
    }
    public function product_delete($id){
    	$item=Product::find($id);
    	$res=$item->delete();
    	if ($res) {
    		return redirect()->back()->with('success','product deleted successfully');
    	}else{
    		return redirect()->back()->with('error','product could not be deleted, try again');
    	}
    }
    public function render_suppliers(){
        $suppliers=Supply::paginate(15);
        return view('inventory.suppliers',compact('suppliers'));
    }
    public function render_supplier_new(){
        $suppliers=Supply::limit(5)->get();
        return view('inventory.newsupplier',compact('suppliers'));
    }
    public function supplier_new(Request $request){
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'address' => 'required',
            'zipcode'=>'required',
            'email'=>'required',
            'contact'=>'required',
            'phone'=>'required',
        ]);

        if ($validator->fails()) {
            return redirect()
                        ->withErrors($validator)
                        ->withInput();
        }else{
            $s = new Supply;
            $s->supplier_name=$request->get('name');
            $s->address=$request->get('address');
            $s->contact=$request->get('contact');
            $s->phone=$request->get('phone');
            $s->email=$request->get('email');
            $s->zipcode=$request->get('zipcode');
            $s->description=$request->get('description');

            $s->save();

            if($s){
                return redirect()->back()->with('success','supplier saved successfully');
            }else{
                return redirect()->back()->with('error','supplier could not be saved! try again');
            }
        }  
    }
    public function render_supplier_edit($id){
        $supplier=Supply::find($id);
        return view('inventory.editsupplier',compact('supplier'));
    }
    public function render_supplier_delete($id){
        $supplier=Supply::find($id);
        $res=$supplier->delete();
        if($res){
            return redirect()->back()->with('success','supplier removed successfully');
        }else{
            return redirect()->back()->with('error','supplier could not be removed, try again');
        }
        
    }
    public function save_edit_supplier(Request $request){
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'address' => 'required',
            'zipcode'=>'required',
            'email'=>'required',
            'contact'=>'required',
            'phone'=>'required',
        ]);

        if ($validator->fails()) {
            return redirect()
                        ->withErrors($validator)
                        ->withInput();
        }else{
            $id=$request->get('id');
            $supplier=DB::table('supplies')->where('id','=',$id)->update(['supplier_name'=>$request->get('name'),'address'=>$request->get('address'),'email'=>$request->get('email'),'contact'=>$request->get('contact'),'phone'=>$request->get('phone'),'zipcode'=>$request->get('zipcode')||null]);

            if ($supplier) {
                return redirect()->route('inventory.suppliers')->with('success','supplier details updated successfully');
            }else{
                return redirect()->back()->with('error','supplier details could not be updated, try again');
            }
        }
    }
    public function render_vendors(){
        $vendors=Vendor::paginate(15);
        return view('inventory.vendors',compact('vendors'));
    }
    public function render_vendors_new(Request $request){
        return view('inventory.newvendor');
    }
    public function save_new_vendor(Request $request){
      $request->validate([
            'vendor'=>['required','unique:vendors'],
        ]);
            $v = new Vendor;
            $v->vendor = $request->get('vendor');
            $v->description = $request->get('description');

            $v->save();

            if ($v) {
                return redirect()->route('inventory.vendors')->with('success','new vendor added successfully');
            }else{
                return redirect()->back()->with('error','vendor could not be added, please try again');
            }
    }
    public function delete_vendor($id){
        $vendor=Vendor::find($id);
        $res=$vendor->delete();
        if ($res) {
            return redirect()->back()->with('success','vendor removed successfully');
        }
    }
    public function edit_vendor($id){
        $vendor=Vendor::find($id);
        return view('inventory.editvendor',compact('vendor'));
    }
    public function save_edit_vendor(Request $request){
        $id=$request->get('id');
        $vendor = Vendor::find($id);

        $vendor->vendor=$request->get('vendor');
        $vendor->description=$request->get('description');

        $vendor->save();

        if ($vendor) {
            return redirect()->route('inventory.vendors')->with('success','vendor details updated successfully');
        }
        return redirect()->back()->with('error','vendor details could not be updated, please try again');
    }
}
