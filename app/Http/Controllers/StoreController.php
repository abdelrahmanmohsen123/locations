<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class StoreController extends Controller
{
    //
    public function Stores_list(Request $request){
        try{
            //assign values in variable
            $customerLat = $request->customer_lat;
            $customerLng = $request->customer_lng;

            //quesry to find nearest branch to customer

            $branches_nearest = DB::table('store_branches')
                    ->join('stores','stores.id','=','store_branches.store_id')
                    ->join('stores_categories','stores_categories.id','=','stores.category_id')
                    ->select('stores_categories.name_' . $request->header('lang') . ' as category_name',
                                'stores.name_' . $request->header('lang') . ' as store_name',
                                'store_branches.name_' . $request->header('lang') . ' as branch_name',
                                'stores.logo',
                                DB::raw("6731 * acos(cos(radians(" . $customerLat . "))
                                    * cos(radians(store_branches.lat))
                                    * cos(radians(store_branches.lng)) - radians(". $customerLng .")
                                    + sin(radians(store_branches.lat))
                                    * sin(radians(store_branches.lat))) as distance"))
                    ->orderBy('distance')
                    ->get();

            return response()->json([
                'status' => 'success',
                'data' => $branches_nearest,
            ]);
        }catch(Exception $e){
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage(),
            ]);
        }
    }

}
