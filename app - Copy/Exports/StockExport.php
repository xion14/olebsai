<?php
namespace App\Exports;

use App\Models\Product;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;

class StockExport implements FromCollection, WithMapping, WithHeadings
{
    private $index = 1; // Inisialisasi counter untuk nomor

    public function collection()
    {
        return Product::where('seller_id', auth()->user()->seller->id)->with(['unit'])->where('status', 2)->orderBy('name', 'asc')->get();
    }

    public function map($product): array
    {
        return [
            $this->index++,  // Tambahkan nomor otomatis
            $product->name,
            $product->stock,
            $product->unit->name ?? '-',
        ];
    }

    public function headings(): array
    {
        return [
            'No',   // Tambahkan header nomor
            'Nama Produk',
            'Stok',
            'Satuan',
        ];
    }

}
