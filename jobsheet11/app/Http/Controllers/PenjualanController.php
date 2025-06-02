<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PenjualanModel;
use App\Models\PenjualanDetailModel;
use App\Models\BarangModel;
use App\Models\StokModel;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use PhpOffice\PhpSpreadsheet\IOFactory;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use PhpOffice\PhpSpreadsheet\Shared\Date as ExcelDate;

class PenjualanController extends Controller
{
    public function index()
    {
        $breadcrumb = (object) [
            'title' => 'Daftar Penjualan',
            'list' => ['Home', 'Penjualan']
        ];

        $page = (object) [
            'title' => 'Daftar Penjualan yang terdaftar di sistem'
        ];

        $activeMenu = 'penjualan';

        $penjualan = PenjualanModel::all();

        return view('penjualan.index', compact('breadcrumb', 'page', 'activeMenu', 'penjualan'));
    }

    public function list(Request $request)
    {
        $penjualan = PenjualanModel::with('user')->get();

        return DataTables::of($penjualan)
            ->addIndexColumn()
            ->addColumn('aksi', function ($penjualan) {
                $btn = '<button onclick="modalAction(\'' . url('/penjualan/' . $penjualan->penjualan_id ) . '\')" class="btn btn-info btn-sm">Detail</button> ';
                $btn .= '<button onclick="modalAction(\'' . url('/penjualan/' . $penjualan->penjualan_id . '/edit_ajax') . '\')" class="btn btn-warning btn-sm">Edit</button> ';
                $btn .= '<button onclick="modalAction(\'' . url('/penjualan/' . $penjualan->penjualan_id . '/delete_ajax') . '\')" class="btn btn-danger btn-sm">Hapus</button>';
                return $btn;
            })
            ->rawColumns(['aksi'])
            ->make(true);
    }

    public function create_ajax()
    {
        return view('penjualan.create_ajax', [
            'barang' => BarangModel::all()
        ]);
    }

    
    public function store_ajax(Request $request)
    {
        if ($request->ajax()) {
            // Step 1: Validate
            $validator = Validator::make($request->all(), [
                'pembeli' => 'required|string|max:100',
                'penjualan_tanggal' => 'required|date',
                'barang_id' => 'required|array',
                'barang_id.*' => 'required|exists:m_barang,barang_id',
                'jumlah' => 'required|array',
                'jumlah.*' => 'required|integer|min:1'
            ]);
    
            if ($validator->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => 'Validasi Gagal',
                    'msgField' => $validator->errors()
                ]);
            }
    
            // Step 2: Transaction
            DB::beginTransaction();
            try {
                $subtotal=0;
                foreach ($request->barang_id as $index => $barangId) {
                    $jumlah = $request->jumlah[$index];
    
                    $barang = BarangModel::findOrFail($barangId);
                    $hargaJual = $barang->harga_jual;
                    $subtotal += $hargaJual*$jumlah; 
                }
                $penjualan = PenjualanModel::create([
                    'user_id' => auth()->user()->user_id,
                    'pembeli' => $request->pembeli,
                    'penjualan_kode' => 'PJ-' . strtoupper(Str::random(8)),
                    'penjualan_tanggal' => $request->penjualan_tanggal,
                    'total_penjualan' => $subtotal
                ]);
    
                foreach ($request->barang_id as $index => $barangId) {
                    $jumlah = $request->jumlah[$index];
    
                    $barang = BarangModel::findOrFail($barangId);
                    $hargaJual = $barang->harga_jual;
    
                    PenjualanDetailModel::create([
                        'penjualan_id' => $penjualan->penjualan_id,
                        'barang_id' => $barangId,
                        'harga' => $hargaJual * $jumlah,
                        'jumlah' => $jumlah,
                    ]);
    
                    // Update stok
                    $stok = StokModel::where('barang_id', $barangId)->first();
                    if ($stok && $stok->stok_jumlah >= $jumlah) {
                        $stok->stok_jumlah -= $jumlah;
                        $stok->save();
                    } else {
                        DB::rollBack();
                        return response()->json([
                            'status' => false,
                            'message' => "Stok barang '{$barang->barang_nama}' tidak mencukupi"
                        ]);
                    }
                }
    
                DB::commit();
                return response()->json([
                    'status' => true,
                    'message' => 'Data penjualan berhasil disimpan'
                ]);
            } catch (\Exception $e) {
                DB::rollBack();
                return response()->json([
                    'status' => false,
                    'message' => 'Terjadi kesalahan: ' . $e->getMessage()
                ]);
            }
        }
    
        return redirect('penjualan/');
    }
    
        public function show_ajax($id)
    {
        $penjualan = PenjualanModel::with(['detail.barang', 'user'])->findOrFail($id);
        return view('penjualan.show_ajax', compact('penjualan'));
    }

    public function edit_ajax($id)
{
    $penjualan = PenjualanModel::with('detail')->find($id);
    $barang = BarangModel::all();
    return view('penjualan.edit_ajax', compact('penjualan', 'barang'));
}

public function update_ajax(Request $request, $id)
{
    $validator = Validator::make($request->all(), [
        'pembeli' => 'required|string|max:100',
        'penjualan_tanggal' => 'required|date',
        'barang_id' => 'required|array',
        'barang_id.*' => 'required|exists:m_barang,barang_id',
        'jumlah' => 'required|array',
        'jumlah.*' => 'required|integer|min:1'
    ]);

    if ($validator->fails()) {
        return response()->json([
            'status' => false,
            'message' => 'Validasi gagal',
            'msgField' => $validator->errors()
        ]);
    }

    try {
        $penjualan = PenjualanModel::with('detail')->find($id);
        if (!$penjualan) {
            return response()->json(['status' => false, 'message' => 'Data tidak ditemukan']);
        }

        // Save old quantities by barang_id
        $jumlah_lama = [];
        foreach ($penjualan->detail as $detail) {
            $jumlah_lama[$detail->barang_id] = $detail->jumlah;
        }

        // Update main data
        $penjualan->update([
            'pembeli' => $request->pembeli,
            'penjualan_tanggal' => $request->penjualan_tanggal
        ]);

        // Delete old detail
        DB::table('t_penjualan_detail')->where('penjualan_id', $id)->delete();

        // Insert new detail and update stok
        foreach ($request->barang_id as $index => $barangId) {
            $jumlah_baru = $request->jumlah[$index];
            $barang = BarangModel::findOrFail($barangId);
            $hargaJual = $barang->harga_jual;

            // Insert new detail
            DB::table('t_penjualan_detail')->insert([
                'penjualan_id' => $id,
                'barang_id' => $barangId,
                'harga' => $hargaJual * $jumlah_baru,
                'jumlah' => $jumlah_baru
            ]);

            // Hitung selisih stok (lama - baru)
            $lama = $jumlah_lama[$barangId] ?? 0;
            $selisih = $lama - $jumlah_baru;

            // Update stok (increase if selisih > 0, decrease if selisih < 0)
            DB::table('t_stok')->where('barang_id', $barangId)->update([
                'stok_jumlah' => DB::raw("stok_jumlah + $selisih")
            ]);
        }

        return response()->json(['status' => true, 'message' => 'Data berhasil diupdate']);

    } catch (\Throwable $e) {
        return response()->json([
            'status' => false,
            'message' => 'Terjadi kesalahan: ' . $e->getMessage()
        ]);
    }
}

public function confirm_ajax($id)
{
    $penjualan = PenjualanModel::find($id);
    return view('penjualan.confirm_ajax', compact('penjualan'));
}

public function delete_ajax($id)
{
    $penjualan = PenjualanModel::find($id);
    if (!$penjualan) {
        return response()->json(['status' => false, 'message' => 'Data tidak ditemukan']);
    }

    $penjualan->detail()->delete();
    $penjualan->delete();

    return response()->json(['status' => true, 'message' => 'Data berhasil dihapus']);
}

public function import() {
    return view('penjualan.import');
}

public function import_ajax(Request $request)
{
    if ($request->ajax() || $request->wantsJson()) {
        $rules = [
            'file_penjualan' => ['required', 'mimes:xlsx', 'max:1024']
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Validasi Gagal',
                'msgField' => $validator->errors()
            ]);
        }

        try {
            $file = $request->file('file_penjualan');
            $reader = IOFactory::createReader('Xlsx');
            $reader->setReadDataOnly(true);

            $spreadsheet = $reader->load($file->getRealPath());
            $sheet = $spreadsheet->getActiveSheet();
            $rows = $sheet->toArray(null, false, true, true); // Keys A, B, C...

            $penjualanMap = []; // map penjualan_kode to ID
            $penjualanTotal = []; // map penjualan_kode to total

            foreach ($rows as $index => $row) {
                if ($index <= 1) continue; // Skip header

                // Skip if required columns are empty (skip D)
                if (!isset($row['A'], $row['B'], $row['C'], $row['E'], $row['F']) || 
                    $row['A'] === null || $row['B'] === null || $row['C'] === null || $row['E'] === null || $row['F'] === null) {
                    continue;
                }
                
                $kode = trim($row['A']);
                $dateValue = $row['C'];
                if (is_numeric($dateValue)) {
                    $tanggal = Carbon::instance(ExcelDate::excelToDateTimeObject($dateValue))->format('Y-m-d');
                } else {
                    $tanggal = Carbon::parse($dateValue)->format('Y-m-d');
                }

                // Create penjualan if not created yet
                if (!isset($penjualanMap[$kode])) {
                    $penjualan = PenjualanModel::create([
                        'penjualan_kode' => $kode,
                        'pembeli' => trim($row['B']),
                        'penjualan_tanggal' => $tanggal,
                        'user_id' => Auth::user()->user_id,
                        'total_penjualan' => 0 // temp, will update later
                    ]);
                    $penjualanMap[$kode] = $penjualan->penjualan_id;
                    $penjualanTotal[$kode] = 0;
                }

                $barangKode = $row['E'];
                $jumlah = (int)$row['F'];

                // Get harga_jual from m_barang
                $barang = BarangModel::where('barang_kode', $barangKode)->first();
                if (!$barang) continue;

                $hargaJual = $barang->harga_jual;
                $subtotal = $hargaJual * $jumlah;

                // Insert detail
                DB::table('t_penjualan_detail')->insert([
                    'penjualan_id' => $penjualanMap[$kode],
                    'barang_id' => $barang->barang_id,
                    'jumlah' => $jumlah,
                    'harga' => $subtotal
                ]);

                $penjualanTotal[$kode] += $subtotal;
            }

            // Update total_penjualan per penjualan
            foreach ($penjualanTotal as $kode => $total) {
                PenjualanModel::where('penjualan_kode', $kode)->update([
                    'total_penjualan' => $total
                ]);
            }

            return response()->json([
                'status' => true,
                'message' => 'Data penjualan berhasil diimport'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ]);
        }
    }

    return redirect('/');
}

public function export_excel()
{
    $penjualan = PenjualanModel::select('user_id', 'pembeli', 'penjualan_kode', 'penjualan_tanggal', 'penjualan_id', 'total_penjualan')
        ->orderBy('penjualan_tanggal')
        ->with(['user', 'detail.barang']) // assuming you have relations
        ->get();

    $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
    $sheet = $spreadsheet->getActiveSheet();

    // Header for penjualan
    $sheet->setCellValue('A1', 'No');
    $sheet->setCellValue('B1', 'Kode Penjualan');
    $sheet->setCellValue('C1', 'Pembeli');
    $sheet->setCellValue('D1', 'Total Penjualan');
    $sheet->setCellValue('E1', 'Tanggal Penjualan');
    $sheet->setCellValue('F1', 'User');

    // Header for detail
    $sheet->setCellValue('H1', 'Barang');
    $sheet->setCellValue('I1', 'Jumlah');
    $sheet->setCellValue('J1', 'Harga');

    $sheet->getStyle('A1:J1')->getFont()->setBold(true);

    $no = 1;
    $baris = 2;

    foreach ($penjualan as $value) {
        // Set penjualan data
        $sheet->setCellValue('A' . $baris, $no);
        $sheet->setCellValue('B' . $baris, $value->penjualan_kode);
        $sheet->setCellValue('C' . $baris, $value->pembeli);
        $sheet->setCellValue('D' . $baris, $value->total_penjualan);
        $sheet->setCellValue('E' . $baris, $value->penjualan_tanggal);
        $sheet->setCellValue('F' . $baris, $value->user->nama ?? '-');

        // Set detail data next to it
        $startDetailRow = $baris;
        foreach ($value->detail as $detail) {
            $sheet->setCellValue('H' . $startDetailRow, $detail->barang->barang_nama ?? 'Barang tidak ditemukan');
            $sheet->setCellValue('I' . $startDetailRow, $detail->jumlah);
            $sheet->setCellValue('J' . $startDetailRow, $detail->harga);
            $startDetailRow++;
        }

        // Next row will be the larger of current penjualan row or last detail row
        $baris = max($baris + 1, $startDetailRow);
        $no++;
    }

    foreach (range('A', 'J') as $col) {
        $sheet->getColumnDimension($col)->setAutoSize(true);
    }

    $sheet->setTitle('Data Penjualan');

    $writer = IOFactory::createWriter($spreadsheet, 'Xlsx');
    $filename = 'Data Penjualan ' . date('Y-m-d H-i-s') . '.xlsx';

    header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    header("Content-Disposition: attachment; filename=\"$filename\"");
    header('Cache-Control: max-age=0');
    header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');
    header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT');
    header('Cache-Control: cache, must-revalidate');
    header('Pragma: public');

    $writer->save('php://output');
    exit;
}

    public function export_pdf()
    {
        $penjualan = PenjualanModel::with(['user', 'detail.barang'])
        ->orderBy('penjualan_tanggal')
        ->get();
        
        $pdf = Pdf::loadView('penjualan.export_pdf', ['penjualan' => $penjualan]);
        $pdf->setPaper('a4', 'portrait');
        $pdf->setOption("isRemoteEnabled", true);
        $pdf->render();

        return $pdf->stream('Data Penjualan '.date('Y-m-d H:i:s').'.pdf');
    }

}

?>