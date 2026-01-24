<?php
namespace App\Exports;

use App\Models\Transaction;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class AdminTransactionExport implements FromCollection, WithHeadings, WithMapping, WithStyles, ShouldAutoSize
{
    protected $startDate;
    protected $endDate;
    protected $status;
    private $rank = 0; // Tambahkan rank

    public function __construct($sellerId, $startDate, $endDate, $status)
    {
        $this->sellerId = $sellerId;
        $this->startDate = $startDate;
        $this->endDate = $endDate;
        $this->status = $status;
    }

    public function collection()
    {
        $query = Transaction::orderBy('id', 'asc');

        if(!empty($this->sellerId)){
            $query->where('seller_id', $this->sellerId);
        }

        if (!empty($this->startDate) && !empty($this->endDate)) {
            $query->whereBetween('created_at', [$this->startDate . ' 00:00:00', $this->endDate . ' 23:59:59']);
        }

        if (!empty($this->status)) {
            $query->where('status', $this->status);
        }

        return $query->get();
    }

    public function headings(): array
    {
        return [
            'No', 'Seller', 'Order ID', 'Tanggal', 'Customer', 'Total (Rp)', 'Status', 'Produk',
        ];
    }

    public function map($transaction): array
    {
        return [
            ++$this->rank, 
            $transaction->seller->name,
            $transaction->code,
            $transaction->created_at->format('d-m-Y H:i'), // Format tanggal lebih rapi
            $transaction->customer->name,
            number_format($transaction->total + $transaction->shipping_cost + $transaction->other_costs()->sum('amount'), 0, ',', '.'), // Format uang
            $this->getStatusText($transaction->status),
            implode("\n", $transaction->transactionProducts->map(function ($product) {
                return '• ' . $product->product->name . ' (Qty: ' . $product->qty . ')';
            })->toArray()), // Bullet list produk
        ];
    }

    private function getStatusText($status)
    {
        $statusMap = [
            1 => 'Waiting Seller',
            2 => 'Waiting Admin',
            3 => 'Waiting Payment',
            4 => 'Paid',
            5 => 'On Packing',
            6 => 'On Delivery',
            7 => 'Received',
            8 => 'Cancelled',
            9 => 'Expired',
        ];
        return $statusMap[$status] ?? 'Unknown';
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => ['font' => ['bold' => true, 'color' => ['rgb' => 'FFFFFF']], 'fill' => ['fillType' => 'solid', 'startColor' => ['rgb' => '0073e6']]], // Header warna biru
            'A' => ['alignment' => ['horizontal' => 'center']], 
            'C' => ['alignment' => ['horizontal' => 'center']], // Tanggal tengah
            'E' => ['alignment' => ['horizontal' => 'right']], // Total rata kanan
            'F' => ['alignment' => ['horizontal' => 'center']], // Status tengah
            'G' => ['alignment' => ['wrapText' => true]], // Produk wrap text
        ];
    }
}

