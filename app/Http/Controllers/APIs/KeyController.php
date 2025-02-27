<?php

namespace App\Http\Controllers\APIs;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Resources\Key as KeyResource;
use Illuminate\Validation\Rule;
use App\Models\Order;
use App\Models\Items;
use App\Models\Wallet;
use App\Models\WoocommerceOrderHistory;
use App\Models\Key;
class KeyController extends Controller
{
    public function key(Request $request)
    {
        if($request->key){
            $key = Key::where('key',$request->key)->get();
            if ($key->isEmpty()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Key Not Found.'
                ], 404);
            }
            else{
                return $this->sendResponse(KeyResource::collection($key), 'Key Status Retrieved Successfully.');
            }               
        }
        else{
            return $this->sendResponse('','Please Enter the Key');
        }
    }
    
    public function keyVerify(Request $request)
    {
        print_r($request->all());
    }

    public function updateOrderCount(Request $request)
    {
        if($request->flag && $request->user_id && $request->woocommerce_order_id && $request->woocommerce_order_total && $request->woocommerce_order_url){         
            if($request->flag == 'Yes'){
                $wallet = Wallet::where('user_id',$request->user_id)->get()->first();                
                if (!$wallet) {
                    return response()->json([
                        'success' => false,
                        'message' => 'User / Wallet Not Found.'
                    ], 404);
                }
                else{
                    $plan_id = $wallet->product_id;
                    $ordercount = $wallet->remaining_order;
                    $wallet_amount = $wallet->wallet_amount;
                    $product_id = $wallet->product_id;
                    $plan = Items::where('id',$product_id)->first();
                    $per_order_price = $plan->monthly_price;

                    $update_order_count = $ordercount - 1;
                    $update_wallet_amount = $wallet_amount - $per_order_price;

                    $wallet->update([
                        'remaining_order' => $update_order_count,
                        'wallet_amount' => $update_wallet_amount
                    ]);
                    
                    $woo = WoocommerceOrderHistory::create([
                        'user_id' => $request->user_id,
                        'plan_id' => $plan_id,
                        'woocommerce_order_id' => $request->woocommerce_order_id,
                        'woocommerce_order_total' => $request->woocommerce_order_total,
                        'woocommerce_order_date' => $request->woocommerce_order_date,
                        'woocommerce_order_url' => $request->woocommerce_order_url,
                        'per_order_price' => $per_order_price,
                        'remaining_wallet_amount' => $update_wallet_amount,
                    ]);

                    return response()->json([
                        'total_order' => $wallet->total_order,
                        'remaining_order' => $wallet->remaining_order,
                        'message' => 'Order Count Value Updated Successfully'
                    ], 200);
                }
            }
        }
        else{
            return response()->json([
                'success' => false,
                'message' => 'Insufficient Data'
            ], 400);
        }
    }
    protected function sendResponse($result, $message, $status = 200)
    {
        return response()->json([
            'success' => true,
            'data'    => $result,
            'message' => $message,
        ], $status);
    }
}
