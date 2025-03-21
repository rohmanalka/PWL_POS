<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SupplierModel;
use Yajra\DataTables\Facades\DataTables;

class SupplierController extends Controller
{
    public function index()
    {
        $breadcrumb = (object) [
            'title' => 'Daftar Supplier Barang',
            'list' => ['Home', 'Supplier'],
        ];

        $page = (object) [
            'title' => 'Daftar Supplier Barang yang terdaftar dalam sistem',
        ];

        $activeMenu = 'supplier';
        $supplier = SupplierModel::all();

        return view('supplier.index', ['breadcrumb' => $breadcrumb,  'page' => $page, 'activeMenu' => $activeMenu, 'supplier' => $supplier]);
    }
    // Ambil data supplier dalam bentuk json untuk datatables
    public function list(Request $request)
    {
        $suppliers = SupplierModel::select('supplier_id', 'supplier_kode', 'supplier_nama', 'supplier_alamat');

        //Filter data berdasarkan supplier_id
        if ($request->supplier_id) {
            $suppliers->where('supplier_id', $request->supplier_id);
        }

        return DataTables::of($suppliers)
            // menambahkan kolom index / no urut (default nama kolom: DT_RowIndex)
            ->addIndexColumn()
            ->addColumn('aksi', function ($supplier) { // menambahkan kolom aksi
                $btn = '<a href="' . url('/supplier/' . $supplier->supplier_id) . '" class="btn btn-info btn-sm">Detail</a> ';
                $btn .= '<a href="' . url('/supplier/' . $supplier->supplier_id . '/edit') . '" class="btn btn-warning btn-sm">Edit</a> ';
                $btn .= '<form class="d-inline-block" method="POST" action="' . url('/supplier/' . $supplier->supplier_id) . '">'
                    . csrf_field() . method_field('DELETE') . '<button type="submit" class="btn btn-danger btn-sm" onclick="return 
                        confirm(\'Apakah Anda yakit menghapus data ini?\');">Hapus</button></form>';
                return $btn;
            })
            ->rawColumns(['aksi']) // memberitahu bahwa kolom aksi adalah html
            ->make(true);
    }

    //Menampilkan halaman form tambah supplier
    public function create()
    {
        $breadcrumb = (object) [
            'title' => 'Tambah supplier',
            'list' => ['Home', 'supplier', 'Tambah'],
        ];

        $page = (object) [
            'title' => 'Tambah supplier Baru',
        ];

        $activeMenu = 'supplier';

        return view('supplier.create', ['breadcrumb' => $breadcrumb, 'activeMenu' => $activeMenu, 'page' => $page]);
    }
    //Menyimpan data supplier baru
    public function store(Request $request)
    {
        $request->validate([
            'supplier_kode'     => 'required|string|max:10|unique:m_supplier,supplier_kode',
            'supplier_nama'     => 'required|string|max:100',
            'supplier_alamat'   => 'required|string|max:255',
        ]);

        supplierModel::create([
            'supplier_kode'   => $request->supplier_kode,
            'supplier_nama'   => $request->supplier_nama,
            'supplier_alamat' => $request->supplier_alamat,
        ]);

        return redirect('/supplier')->with('success', 'Data supplier berhasil disimpan');
    }

    public function show(string $id)
    {
        $supplier = supplierModel::find($id);

        $breadcrumb = (object) [
            'title' => 'Detail supplier',
            'list' => ['Home', 'supplier', 'Detail'],
        ];

        $page = (object) [
            'title' => 'Detail supplier',
        ];

        $activeMenu = 'supplier';

        return view('supplier.show', ['breadcrumb' => $breadcrumb, 'activeMenu' => $activeMenu, 'page' => $page, 'supplier' => $supplier]);
    }

    public function edit(string $id)
    {
        $supplier = supplierModel::find($id);

        $breadcrumb = (object) [
            'title' => 'Edit supplier',
            'list' => ['Home', 'supplier', 'Edit'],
        ];

        $page = (object) [
            'title' => 'Edit supplier',
        ];

        $activeMenu = 'supplier';

        return view('supplier.edit', ['breadcrumb' => $breadcrumb, 'activeMenu' => $activeMenu, 'page' => $page, 'supplier' => $supplier]);
    }

    public function update(Request $request, string $id)
    {
        $request->validate([
            'supplier_kode'   => 'required|string|max:10',
            'supplier_nama'   => 'required|string|max:100',
            'supplier_alamat' => 'required|string|max:255',
        ]);

        supplierModel::find($id)->update([
            'supplier_kode'   => $request->supplier_kode,
            'supplier_nama'   => $request->supplier_nama,
            'supplier_alamat' => $request->supplier_alamat,
        ]);

        return redirect('/supplier')->with('success', 'Data supplier berhasil diubah');
    }

    public function destroy(string $id)
    {
        $check = supplierModel::find($id);
        if (!$check) {
            return redirect('/supplier')->with('error', 'Data supplier tidak ditemukan');
        }

        try {
            supplierModel::destroy($id);

            return redirect('/supplier')->with('success', 'Data supplier berhasil dihapus');
        } catch (\Illuminate\Database\QueryException $e) {
            return redirect('/supplier')->with('error', 'Data supplier gagal dihapus karena masih terdapat tabel lain yang terkait dengan data ini');
        }
    }
}
