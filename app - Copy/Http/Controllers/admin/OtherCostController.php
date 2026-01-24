<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Controllers\log\TransactionLogController;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

use App\Models\OtherCost;
use App\Models\Transaction;

class OtherCostController extends Controller
{
    public function store(Request $request)
    {
     try{
         DB::beginTransaction();
         foreach ($request->costs as $key => $value) {
             $rowSaved = OtherCost::create([
                 'transaction_id' => $request->transaction_id,
                 'name' => $value['name'],
                 'amount' => $value['amount']
             ]);   
 
             $transaction_log = (new TransactionLogController())->store(Auth::user()->id, $request->transaction_id, 'Add Other Cost', json_encode($rowSaved));
         }
 
         $transaction = Transaction::where('id', $request->transaction_id)->first();
         $otherCost = OtherCost::where('transaction_id', $request->transaction_id)->sum('amount');
         $transaction->update([
             'other_cost' => $otherCost,
             'total' => $transaction->subtotal + $transaction->shipping_cost + $otherCost
         ]);
 
         DB::commit();
         return response()->json([
             'success' => true,
             'text' => 'Success add other cost'
         ]);
     } catch (\Throwable $th) {
         DB::rollBack();
         return response()->json([
             'success' => false,
             'text' => $th->getMessage()
         ]);
     }
    }
 
    public function update(Request $request, $id)
    {
     try{
        
        DB::beginTransaction();
        $otherCostRow = OtherCost::where('id', $id)->update([
            'name' => $request->name,
            'amount' => $request->amount
        ]);

        $otherCostRow = OtherCost::find($id);
        $transaction = Transaction::where('id', $otherCostRow->transaction_id)->first();
        $otherCost = OtherCost::where('transaction_id', $otherCostRow->transaction_id)->sum('amount');
        $transaction->update([
            'other_cost' => $otherCost,
            'total' => $transaction->subtotal + $transaction->shipping_cost + $otherCost
        ]);

        $transaction_log = (new TransactionLogController())->store(Auth::user()->id, $transaction->id, 'Add Other Cost', json_encode($otherCostRow));

        DB::commit();
        return response()->json([
            'success' => true,
            'text' => 'Success update other cost'
        ]);
    } catch (\Throwable $th) {
        DB::rollBack();
        return response()->json([
            'success' => false,
            'text' => $th->getMessage()
        ]);
     }
    }
 
    public function destroy($id)
    {
     try{
         DB::beginTransaction();
         OtherCost::where('id', $id)->delete();
         DB::commit();
         return response()->json([
             'success' => true,
             'text' => 'Success delete other cost'
         ]);
     } catch (\Throwable $th) {
         DB::rollBack();
         return response()->json([
             'success' => false,
             'text' => $th->getMessage()
         ]);
     }
    }

    public function save_shipping(Request $request) {

        try{
            DB::beginTransaction();
            $transaction = Transaction::find($request->transaction_id);
            $transaction->shipping_name = $request->shipping_name;
            $transaction->shipping_cost = $request->shipping_cost;
            $transaction->save();

            DB::commit();
            return response()->json([
                'success' => true,
                'text' => 'Success Saved Shipping'
            ]);
        } catch (\Throwable $th) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'text' => $th->getMessage()
            ]);
        }
    }
}
