<?php

namespace App\Http\Controllers\log;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\TransactionLog;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class TransactionLogController extends Controller
{
    public function store ($user_id, $transaction_id, $activity, $note) {
       try{
            DB::beginTransaction();
            $log = TransactionLog::create([
                'user_id' => $user_id,
                'transaction_id' => $transaction_id,
                'activity' => $activity,
                'note' => $note
            ]);
            DB::commit();
            return $log;
       }catch(\Exception $e){
            DB::rollBack();
            throw $e;
       }

    }
}
