<?php

namespace App\Http\Controllers;

use App\Models\Branch;
use Illuminate\Http\Request;

class StoreController extends Controller
{
    //
    public function Stores_list(Request $request){
        $customerLat = $request->input('customer_lat');
        $customerLng = $request->input('customer_lng');

        $branches = Branch::with(['store'])->get();
        // $points =


        $data = [];
        foreach ($branches as $branch) {
                $data = [
                    'store_name' => $branch->store->{"name_" . $request->header('lang')},
                    'category_name' => $branch->store->category->{"name_" . $request->header('lang')},
                    'logo' => asset('images/'.$branch->store->logo),
                    'branch_name' => $branch->{"name_" . $request->header('lang')},
                ];
        }

        return response()->json([
            'status' => 'success',
            'data' => $data,
        ]);
    }

}