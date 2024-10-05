<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;
use App\Models\Barangay;
use Inertia\Inertia;
use Inertia\Response;
use DB;

class BarangayController extends Controller
{
    public function index() {   
        $filter = request()->all();
        $query = Barangay::query();
    
        if (!empty($filter['name'])) {
            $query->where(function($q) use ($filter) {
                $q->where('code', 'like', '%' . $filter['name'] . '%')
                  ->orWhere('name', 'like', '%' . $filter['name'] . '%');
            });
        }
    
        $barangays = $query->orderBy('code', 'ASC')->paginate(10)->withQueryString();
        
        return Inertia::render('Admin/Barangay/List', [
            'barangays' => $barangays
        ]);
    }

    public function save(Request $request)
    {
        Log::info('==========================');
        Log::info('barangay Data:', $request->all());
    
        if ($request->id) {
            $barangay = Barangay::find($request->id);
    
            if ($barangay) {
                $barangay->code = $request->code;
                $barangay->name = $request->name;
                // $barangay->status = $request->status;
                if($request->status != null){
                    $barangay->status = $request->status;
                } else {
                    $barangay->status = 0;
                }
                if($barangay->save()){
                    // $barangays = barangay::paginate(5)->withQueryString();
                    // return Inertia::render('barangays/Index', [
                    //     'scbarangays' => $barangays
                    // ]);
                    return to_route('barangays', ['message' => 'barangay updated successfully.']);
                }
    
                // return response()->json(['message' => 'barangay updated successfully.']);
                
            }
    
            return response()->json(['message' => 'barangay not found.'], 404);
        } else {
            $barangay = new Barangay();
            $barangay->code = $request->code;
            $barangay->name = $request->name;
            // $barangay->status = $request->status;
            if($request->status != null){
                $barangay->status = $request->status;
            } else {
                $barangay->status = 0;
            }
    
            // return response()->json(['message' => 'barangay created successfully.']);
            if($barangay->save()){
                // $barangays = barangay::paginate(5)->withQueryString();
                // return Inertia::render('barangays/Index', [
                //     'scbarangays' => $barangays
                // ]);
                return to_route('barangays');
            }
        }
    } 
    
    public function remove(Request $request)
    {
        
        Log::info('==========================');
        Log::info('Dlete barangay Data:', $request->all());

        $data = $request->all();

        $barangay = null;

        if (isset($data['id']) && strlen($data['id'])) {
            $barangay = Barangay::find($data['id']);
        }

        if ($barangay) {
            $barangay->delete();
        } else {

        }

        return to_route('barangays', ['message' => 'Barangay deleted successfully.']);
    }
}
