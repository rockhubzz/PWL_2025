<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PenjualanDetailModel extends Model
{
    protected $table = 't_penjualan_detail';
    protected $primaryKey = 'detail_id';

    protected $fillable = [
        'penjualan_id',
        'barang_id',
        'harga',
        'jumlah'
    ];

    public function penjualan(): BelongsTo
    {
        return $this->belongsTo(PenjualanModel::class, 'penjualan_id', 'penjualan_id');
    }

    public function barang(): BelongsTo
    {
        return $this->belongsTo(BarangModel::class, 'barang_id', 'barang_id');
    }

    public static function topMostSoldBarang($limit = 5)
    {
        return self::select(
                't_penjualan_detail.barang_id',
                'm_barang.barang_nama',
                'm_barang.barang_kode',
                DB::raw('SUM(t_penjualan_detail.jumlah) as total_terjual')
            )
            ->join('m_barang', 't_penjualan_detail.barang_id', '=', 'm_barang.barang_id')
            ->groupBy('t_penjualan_detail.barang_id', 'm_barang.barang_nama', 'm_barang.barang_kode')
            ->orderByDesc('total_terjual')
            ->limit($limit)
            ->get();
    }}
?>