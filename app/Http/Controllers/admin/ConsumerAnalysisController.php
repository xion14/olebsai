<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ConsumerAnalysisController extends Controller
{
    public function index()
    {
        if (Auth::user()->role != 7) abort(403);

        // Subsektor paling banyak komplain
        $bySubsector = DB::table('transaction_products as tp')
            ->join('products as p', 'p.id', '=', 'tp.product_id')
            ->leftJoin('setting_sub_categories as sc', 'sc.id', '=', 'p.sub_category_id')
            ->whereNotNull('tp.complain')
            ->select(DB::raw('COALESCE(sc.name, "Tanpa Subsektor") as subsektor'), DB::raw('COUNT(*) as total'))
            ->groupBy('subsektor')
            ->orderByDesc('total')
            ->get();

        // Jenis masalah (dari complain_note patterns)
        $patterns = [
            'pengemasan' => 'Pengemasan buruk',
            'lambat|terlambat' => 'Keterlambatan',
            'kualitas|rusak|cacat' => 'Kualitas tidak sesuai',
        ];
        $byIssue = collect();
        foreach ($patterns as $regex => $label) {
            $count = DB::table('transaction_products')
                ->whereNotNull('complain')
                ->where('complain_note', 'regexp', $regex)
                ->count();
            $byIssue->push((object)['label' => $label, 'total' => $count]);
        }

        return view('admin.consumer.analysis', compact('bySubsector','byIssue'));
    }
}

