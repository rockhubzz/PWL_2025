<?php

namespace App\Http\Controllers;

use App\Models\StokModel;
use App\Models\BarangModel;
use App\Models\UserModel;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator;
use App\Models\SupplierModel;

class StokController extends Controller
{
    public function index()
    {
        $breadcrumb = (object) [
            'title' => 'Data Stok',
            'list' => ['Home', 'Stok']
        ];

        $page = (object) [
            'title' => 'Daftar data stok barang'
        ];

        $activeMenu = 'stok';

        $barang = BarangModel::all();
        $supplier = SupplierModel::all();

        return view('stok.index', compact('breadcrumb', 'page', 'activeMenu', 'barang', 'supplier'));
    }

    public function list(Request $request)
    {
        $stok = StokModel::with(['barang', 'user', 'supplier']);

        if ($request->barang_id) {
            $stok->where('barang_id', $request->barang_id);
        }

        if ($request->supplier_id) {
            $stok->where('supplier_id', $request->supplier_id);
        }

        return DataTables::of($stok)
            ->addIndexColumn()
            ->addColumn('aksi', function ($s) {
            $btn = '<button onclick="modalAction(\'' . url('/stok/' . $s->stok_id . '/show_ajax') . '\')" class="btn btn-info btn-sm">Detail</button> ';
            $btn .= '<button onclick="modalAction(\'' . url('/stok/' . $s->stok_id . '/edit_ajax') . '\')" class="btn btn-warning btn-sm">Edit</button> ';
            $btn .= '<button onclick="modalAction(\'' . url('/stok/' . $s->stok_id . '/delete_ajax') . '\')" class="btn btn-danger btn-sm">Hapus</button> ';
            return $btn;
        })
        ->rawColumns(['aksi'])
        ->make(true);
    }

    public function create()
    {
        $breadcrumb = (object) [
            'title' => 'Tambah Stok',
            'list' => ['Home', 'Stok', 'Tambah']
        ];

        $page = (object) [
            'title' => 'Tambah data stok baru'
        ];

        $barang = BarangModel::all();
        $user = UserModel::all();
        $supplier = SupplierModel::all();
        $activeMenu = 'stok';

        return view('stok.create', compact('breadcrumb', 'page', 'barang', 'user', 'supplier', 'activeMenu'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'barang_id' => 'required|integer',
            'user_id' => 'required|integer',
            'supplier_id' => 'required|integer',
            'stok_tanggal' => 'required|date',
            'stok_jumlah' => 'required|integer|min:1',
        ]);

        StokModel::create($request->all());

        return redirect('/stok')->with('success', 'Data stok berhasil disimpan');
    }

    public function show($id)
    {
        $stok = StokModel::with(['barang', 'user', 'supplier'])->find($id);

        $breadcrumb = (object) [
            'title' => 'Detail Stok',
            'list' => ['Home', 'Stok', 'Detail']
        ];

        $page = (object) [
            'title' => 'Detail data stok'
        ];

        $activeMenu = 'stok';

        return view('stok.show', compact('breadcrumb', 'page', 'stok', 'activeMenu'));
    }

    public function show_ajax(string $id)
    {
        $stok = StokModel::find($id);

        return view('stok.show_ajax', ['stok' => $stok]);
    }

    public function edit($id)
    {
        $stok = StokModel::find($id);
        $barang = BarangModel::all();
        $user = UserModel::all();
        $supplier = SupplierModel::all();

        $breadcrumb = (object) [
            'title' => 'Edit Stok',
            'list' => ['Home', 'Stok', 'Edit']
        ];

        $page = (object) [
            'title' => 'Edit data stok'
        ];

        $activeMenu = 'stok';

        return view('stok.edit', compact('breadcrumb', 'page', 'stok', 'barang', 'user', 'supplier', 'activeMenu'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'barang_id' => 'required|integer',
            'user_id' => 'required|integer',
            'supplier_id' => 'required|integer',
            'stok_tanggal' => 'required|date',
            'stok_jumlah' => 'required|integer|min:1',
        ]);

        StokModel::find($id)->update($request->all());

        return redirect('/stok')->with('success', 'Data stok berhasil diubah');
    }

    // Hapus data stok
    public function destroy($id)
    {
        $check = StokModel::find($id);

        if (!$check) {
            return redirect('/stok')->with('error', 'Data stok tidak ditemukan');
        }

        try {
            StokModel::destroy($id);
            return redirect('/stok')->with('success', 'Data stok berhasil dihapus');
        } catch (\Illuminate\Database\QueryException $e) {
            return redirect('/stok')->with('error', 'Gagal menghapus data stok karena data masih terhubung dengan tabel lain');
        }
    }

public function create_ajax()
{
    $barang = BarangModel::select('barang_id', 'barang_nama')->get();
    $user = UserModel::select('user_id', 'nama')->get();
    $supplier = SupplierModel::select('supplier_id', 'supplier_nama')->get();
    return view('stok.create_ajax', [
        'barang' => $barang,
        'user' => $user,
        'supplier' => $supplier
    ]);
}

public function store_ajax(Request $request)
{
    if ($request->ajax() || $request->wantsJson()) {
        $rules = [
            'barang_id'    => 'required|integer|exists:m_barang,barang_id',
            'user_id'      => 'required|integer|exists:m_user,user_id',
            'supplier_id'  => 'required|integer|exists:m_supplier,supplier_id',
            'stok_tanggal' => 'required|date',
            'stok_jumlah'  => 'required|integer|min:1',
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response()->json([
                'status'   => false,
                'message'  => 'Validasi gagal.',
                'msgField' => $validator->errors(),
            ]);
        }

        StokModel::create($request->all());

        return response()->json([
            'status'  => true,
            'message' => 'Data stok berhasil disimpan.',
        ]);
    }

    return redirect('/');
}

public function edit_ajax(string $id)
{
    $stok = StokModel::find($id);
    $barang = BarangModel::select('barang_id', 'barang_nama')->get();
    $user = UserModel::select('user_id', 'nama')->get();
    $supplier = SupplierModel::select('supplier_id', 'supplier_nama')->get();

    return view('stok.edit_ajax', [
        'stok' => $stok,
        'barang' => $barang,
        'user' => $user,
        'supplier' => $supplier,
    ]);
}

public function update_ajax(Request $request, $id)
{
    if ($request->ajax() || $request->wantsJson()) {
        $rules = [
            'barang_id'    => 'required|integer|exists:m_barang,barang_id',
            'user_id'      => 'required|integer|exists:m_user,user_id',
            'supplier_id'  => 'required|integer|exists:m_supplier,supplier_id', // Tambahkan validasi supplier
            'stok_tanggal' => 'required|date',
            'stok_jumlah'  => 'required|integer|min:1',
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response()->json([
                'status'   => false,
                'message'  => 'Validasi gagal.',
                'msgField' => $validator->errors(),
            ]);
        }

        $stok = StokModel::find($id);
        if ($stok) {
            $stok->update($request->all());

            return response()->json([
                'status'  => true,
                'message' => 'Data stok berhasil diupdate.',
            ]);
        }

        return response()->json([
            'status'  => false,
            'message' => 'Data tidak ditemukan.',
        ]);
    }

    return redirect('/');
}
public function confirm_ajax(string $id)
{
    $stok = StokModel::find($id);

    return view('stok.confirm_ajax', ['stok' => $stok]);
}
public function delete_ajax(Request $request, $id)
    {
        if ($request->ajax() || $request->wantsJson()) {
            $stok = StokModel::find($id);

            if ($stok) {
                $stok->delete();

                return response()->json([
                    'status' => true,
                    'message' => 'Data stok berhasil dihapus.',
                ]);
            } else {
                return response()->json([
                    'status' => false,
                    'message' => 'Data tidak ditemukan.',
                ]);
            }
        }

        return redirect('/');
    }

}
