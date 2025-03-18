<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\DataTables\KategoriDataTable;
use App\Models\KategoriModel;

class KategoriController extends Controller
{
    public function index(KategoriDataTable $dataTable){
        // $data = [
        //     'kategori_kode' => 'SNK',
        //     'kategori_nama' => 'Snack/Makanan Ringan'
        // ];
        // DB::table('m_kategori')->insert($data);
        // return 'Insert data baru berhasil';

        // $row = DB::table('m_kategori')->where('kategori_kode', 'SNK')
        //             ->update(['kategori_nama' => 'Camilan']);
        // return 'Update data berhasil. Jumlah data yang diupdate: '.$row.' baris';

        // $row = DB::table('m_kategori')
        //         ->where('kategori_kode', 'SNK')->delete();
        // return 'Delete data berhasil. Jumlah data yang dihapus: '.$row.' baris';
    
        // $data = DB::table('m_kategori')->get();
        // return view('kategori', ['data'=>$data]);
        return $dataTable->render('kategori.index');
    }

    public function create(){
        return view('kategori.create');
    }

    public function store(Request $request){
        KategoriModel::create([
            'kategori_kode' => $request->kodeKategori,
            'kategori_nama' => $request->namaKategori
        ]);
        return redirect('/kategori');
    }

    public function edit($id_kategori)
    {
        $kategori = KategoriModel::findOrFail($id_kategori);
        return view('kategori.edit', compact('id_kategori', 'kategori'));
    }

    public function update(Request $request, $kategori_id){
        $kategori = KategoriModel::findOrFail($kategori_id);

        $request->validate([
            'kategori_kode' => 'required|unique:m_kategori,kategori_kode,' . $kategori->kategori_id . ',kategori_id',
            'kategori_nama' => 'required',
        ]);
        $kategori->update($request->all());

        return redirect("/kategori");
    }

    public function remove($id){
        $kategori = KategoriModel::findOrFail($id);
        $kategori->delete();

        return redirect("/kategori");
    }
}
