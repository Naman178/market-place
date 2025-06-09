<?php

namespace App\Http\Resources;
   
use Illuminate\Http\Resources\Json\JsonResource;
use Carbon\Carbon;
use App\Models\User;
use App\Models\Order;
use App\Models\Items;
use App\Models\Wallet;

class Key extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $status = '';
        if($this->expire_at > Carbon::now()){
            $status = 'Active';
        }
        else{
            $status = 'Expired';
        }

        $user = [];
        $user = User::where('id',$this->user_id)->get();
        $wallet = Wallet::where('user_id',$this->user_id)->first();
        $order = Order::where('id',$this->order_id)->get()->first();
        $product_id = $wallet->product_id;
        $plan = Items::where('id',$product_id)->get()->first();
        
        $order_id = $order->id;
        $order_count = $wallet->total_order;
        $order_limit = $wallet->remaining_order;
        $per_order_price = $plan->monthly_price;
        $remaining_wallet_amount = $wallet->wallet_amount;         
        $features = explode(',',$plan->key_features);        
        if(in_array('All Payment Integration',$features)){
            $features[] = 'Razorpay Payment Integration';
            $features[] = 'Cashfree Payment Integration';
            $features[] = 'Stripe Payment Integration';
            $features[] = 'Shiprockt Integration';
        }

        $product_name = $plan->name;
        if(count($user) == 0){
            return [];
        }
        else{
            return [
                'id' => $this->id,
                'status' => $status,
                'expired_at' => $this->expire_at,
                'user' => $user,
                'plan_features' => $features,
                'order_id' => $order_id,
                'order_count'=>$order_count,
                'order_limit'=>$order_limit,           
            ];
        }        
    }
}
