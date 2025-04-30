<?php

namespace App\Models;

use App\Models\UserModel;
use App\Models\BarangModel;
use App\Models\SupplierModel;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\DB;


class StokModel extends Model
{
    use HasFactory;

    protected $table = 't_stok';
    protected $primaryKey = 'stok_id';

    protected $fillable = [
        'barang_id',
        'user_id',
        'supplier_id',
        'stok_tanggal',
        'stok_jumlah',
    ];

    public function barang()
    {
        return $this->belongsTo(BarangModel::class, 'barang_id', 'barang_id');
    }

    public function user()
    {
        return $this->belongsTo(UserModel::class, 'user_id', 'user_id');
    }

    public function supplier()
    {
        return $this->belongsTo(SupplierModel::class, 'supplier_id', 'supplier_id');
    }

    public static function getLowestStockItems($limit = 5)
    {
        return self::select(
            't_stok.barang_id',
            'm_barang.barang_nama',
            'm_barang.barang_kode',
            DB::raw('SUM(t_stok.stok_jumlah) as total_stok')
        )
        ->join('m_barang', 't_stok.barang_id', '=', 'm_barang.barang_id')
        ->groupBy('t_stok.barang_id', 'm_barang.barang_nama', 'm_barang.barang_kode')
        ->havingRaw('SUM(t_stok.stok_jumlah) < 20')
        ->orderBy('total_stok', 'asc')
        ->limit(5)
        ->get();
        }
}
