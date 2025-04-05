<?php
 
 namespace App\Http\Controllers;
 
 use App\Models\SupplierModel;
 use Illuminate\Http\Request;
 use Yajra\DataTables\Facades\DataTables;
 use Illuminate\Support\Facades\Validator;

 
 class SupplierController extends Controller
 {
     public function index()
     {
         $breadcrumb = (object) [
             'title' => 'Daftar Supplier',
             'list' => ['Home', 'Supplier']
         ];
 
         $page = (object) [
             'title' => 'Daftar Supplier yang terdaftar di sistem'
         ];
 
         $activeMenu = 'supplier';
         $supplier = SupplierModel::all();
 
         return view('supplier.index', ['breadcrumb' => $breadcrumb, 'page' => $page, 'activeMenu' => $activeMenu, 'supplier' => $supplier]);
     }
 
     public function list(Request $request)
     {
         $supplier = SupplierModel::select('supplier_id', 'supplier_kode', 'supplier_nama', 'supplier_alamat');
 
         if ($request->supplier_nama) {
             $supplier->where('supplier_nama', 'like', '%' . $request->supplier_nama . '%');
         }
 
         return DataTables::of($supplier)
             ->addIndexColumn()
             ->addColumn('aksi', function ($supplier) {
                $btn = '<button onclick="modalAction(\'' . url('/supplier/' . $supplier->supplier_id ) . '\')" class="btn btn-info btn-sm">Detail</button> ';
                $btn .= '<button onclick="modalAction(\'' . url('/supplier/' . $supplier->supplier_id . '/edit_ajax') . '\')" class="btn btn-warning btn-sm">Edit</button> ';
                $btn .= '<button onclick="modalAction(\'' . url('/supplier/' . $supplier->supplier_id . '/delete_ajax') . '\')" class="btn btn-danger btn-sm">Hapus</button>';                 return $btn;
             })
             ->rawColumns(['aksi'])
             ->make(true);
     }
 
     public function create()
     {
         $breadcrumb = (object) [
             'title' => 'Tambah Supplier',
             'list' => ['Home', 'Supplier', 'Tambah']
         ];
 
         $page = (object) [
             'title' => 'Tambah Supplier Baru'
         ];
 
         $activeMenu = 'supplier';
 
         return view('supplier.create', ['breadcrumb' => $breadcrumb, 'page' => $page, 'activeMenu' => $activeMenu]);
     }
 
     public function store(Request $request)
     {
         $request->validate([
             'supplier_kode' => 'required',
             'supplier_nama' => 'required',
             'supplier_alamat' => 'required'
         ]);

         SupplierModel::create([
            'supplier_kode' => $request->supplier_kode,
            'supplier_nama' => $request->supplier_nama,
            'supplier_alamat' => $request->supplier_alamat
        ]);

 
         return redirect('/supplier')->with('success', 'Data supplier berhasil ditambahkan');
     }
 
     public function show($id)
     {
         $breadcrumb = (object) [
             'title' => 'Detail Supplier',
             'list' => ['Home', 'Supplier', 'Detail']
         ];
 
         $page = (object) [
             'title' => 'Detail Supplier'
         ];
 
         $activeMenu = 'supplier';
 
         $supplier = SupplierModel::find($id);
 
         return view('supplier.show', ['breadcrumb' => $breadcrumb, 'page' => $page, 'activeMenu' => $activeMenu, 'supplier' => $supplier]);
     }
 
     public function edit($id)
     {
         $breadcrumb = (object) [
             'title' => 'Edit Supplier',
             'list' => ['Home', 'Supplier', 'Edit']
         ];
 
         $page = (object) [
             'title' => 'Edit Supplier'
         ];
 
         $activeMenu = 'supplier';
 
         $supplier = SupplierModel::find($id);
 
         return view('supplier.edit', ['breadcrumb' => $breadcrumb, 'page' => $page, 'activeMenu' => $activeMenu, 'supplier' => $supplier]);
     }
 
     public function update(Request $request, $id)
     {
         $request->validate([
             'supplier_kode' => 'required',
             'supplier_nama' => 'required',
             'supplier_alamat' => 'required'
         ]);
 
         SupplierModel::find($id)->update($request->all());
 
         return redirect('/supplier')->with('success', 'Data supplier berhasil diubah');
     }
 
     public function destroy($id)
     {
         $check = SupplierModel::find($id);
         if (!$check) {
             return redirect('/supplier')->with('error', 'Data supplier tidak ditemukan');
         }
 
         try {
             SupplierModel::destroy($id);
 
             return redirect('/supplier')->with('success', 'Data supplier berhasil dihapus');
         } catch (\Exception $e) {
             return redirect('/supplier')->with('error', 'Data supplier gagal dihapus karena masih terdapat tabel lain yang terkait dengan data ini');
         }
     }

     public function create_ajax()
     {
         return view('supplier.create_ajax');
     }

     // Simpan data supplier baru
     public function store_ajax(Request $request)
     {
         if ($request->ajax() || $request->wantsJson()) {
             $rules = [
                 'supplier_kode'  => 'required|string|max:50|unique:m_supplier,supplier_kode',
                 'supplier_nama'  => 'required|string|max:100',
                 'supplier_alamat' => 'nullable|string|max:255',
             ];

             $validator = Validator::make($request->all(), $rules);

             if ($validator->fails()) {
                 return response()->json([
                     'status'   => false,
                     'message'  => 'Validasi gagal.',
                     'msgField' => $validator->errors(),
                 ]);
             }

             SupplierModel::create($request->all());

             return response()->json([
                 'status'  => true,
                 'message' => 'Data supplier berhasil disimpan.',
             ]);
         }

         return redirect('/');
     }

     // Form edit data supplier
     public function edit_ajax(string $id)
     {
         $supplier = SupplierModel::find($id);
         return view('supplier.edit_ajax', ['supplier' => $supplier]);
     }

     // Update data supplier
     public function update_ajax(Request $request, $id)
     {
         if ($request->ajax() || $request->wantsJson()) {
             $rules = [
                 'supplier_kode'  => 'required|string|max:50|unique:m_supplier,supplier_kode,' . $id . ',supplier_id',
                 'supplier_nama'  => 'required|string|max:100',
                 'supplier_alamat' => 'nullable|string|max:255',
             ];

             $validator = Validator::make($request->all(), $rules);

             if ($validator->fails()) {
                 return response()->json([
                     'status'   => false,
                     'message'  => 'Validasi gagal.',
                     'msgField' => $validator->errors(),
                 ]);
             }

             $supplier = SupplierModel::find($id);
             if ($supplier) {
                 $supplier->update($request->all());
                 return response()->json([
                     'status'  => true,
                     'message' => 'Data supplier berhasil diupdate.',
                 ]);
             }

             return response()->json([
                 'status'  => false,
                 'message' => 'Data tidak ditemukan.',
             ]);
         }

         return redirect('/');
     }

     // Konfirmasi hapus data supplier
     public function confirm_ajax(string $id)
     {
         $supplier = SupplierModel::find($id);
         return view('supplier.confirm_ajax', ['supplier' => $supplier]);
     }

     // Hapus data supplier
     public function delete_ajax(Request $request, $id)
     {
         if ($request->ajax() || $request->wantsJson()) {
             $supplier = SupplierModel::find($id);
             if ($supplier) {
                 $supplier->delete();
                 return response()->json([
                     'status' => true,
                     'message' => 'Data supplier berhasil dihapus.',
                 ]);
             }
             return response()->json([
                 'status' => false,
                 'message' => 'Data tidak ditemukan.',
             ]);
         }

         return redirect('/');
     }

     public function show_ajax($id){
        $supplier = SupplierModel::find($id);
        return view('supplier.show_ajax', ['supplier' => $supplier]);
     }

 }