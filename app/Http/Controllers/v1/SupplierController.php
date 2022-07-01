<?php

namespace App\Http\Controllers\v1;

use App\Http\Controllers\Controller;
use App\Models\Supplier;
use Exception;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;

class SupplierController extends Controller
{
    private $param;

    public function __construct()
    {
        $this->param['pageTitle'] = 'Supplier';
        $this->param['pageIcon'] = 'fa-solid fa-people-carry-box';
        $this->param['parentMenu'] = 'supplier';
        $this->param['current'] = 'Supplier';
    }

    public function index(Request $request)
    {
        $this->param['btnText'] = 'Tambah Supplier';
        $this->param['btnLink'] = route('supplier.create');
        $this->param['btnTrashText'] = 'Lihat Sampah';
        $this->param['btnTrashLink'] = route('supplier.trash');

        try {
            $keyword = $request->get('keyword');
            $getSupplier = Supplier::orderBy('nama', 'ASC');

            if ($keyword) {
                $getSupplier->where('nama', 'LIKE', "%{$keyword}%");
            }

            $this->param['supplier'] = $getSupplier->paginate(10);
        } catch (\Illuminate\Database\QueryException $e) {
            return back()->withError('Terjadi Kesalahan : ' . $e->getMessage());
        }
        catch (Exception $e) {
            return back()->withError('Terjadi Kesalahan : ' . $e->getMessage());
        }

        return view('pages.supplier.index', $this->param);
    }

    public function create()
    {
        $this->param['btnText'] = 'List Supplier';
        $this->param['btnLink'] = route('supplier.index');

        return view('pages.supplier.create',$this->param);
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required',
            'no_hp' => 'required|unique:supplier',
            'alamat' => 'required',
        ]);
        try {
            $addSupplier = new Supplier;
            $addSupplier->nama = $request->nama;
            $addSupplier->alamat = $request->alamat;
            $addSupplier->no_hp = $request->no_hp;
            $addSupplier->save();
            return redirect()->route('supplier.index')->withStatus('Berhasil menambahkan data');
        } catch (QueryException $e) {
            return redirect()->back()->withError('Terjadi kesalahan.');
        } catch (Exception $e){
            return redirect()->back()->withError('Terjadi kesalahan.');
        }
    }


    public function edit($id)
    {
        try {
            $this->param['btnText'] = 'Lihat Supplier';
            $this->param['btnLink'] = route('supplier.index');
            $this->param['data'] = Supplier::findOrFail($id);
            return view('pages.supplier.edit',$this->param);
        } catch (QueryException $e) {
            return redirect()->back()->withError('Terjadi kesalahan.');
        } catch (Exception $e){
            return redirect()->back()->withError('Terjadi kesalahan.');

        }
    }

    public function update(Request $request, $id)
    {
        $supplier = Supplier::findOrFail($id);
        $isUniquPhone = $supplier->no_hp == $request->no_hp ? '' : '|unique:supplier';

        $request->validate([
            'nama' => 'required',
            'alamat' => 'required',
            'no_hp' => 'required'.$isUniquPhone,
        ]);
        try {
            $supplier = Supplier::find($id);
            $supplier->nama = $request->nama;
            $supplier->alamat = $request->alamat;
            $supplier->no_hp = $request->no_hp;
            $supplier->save();
            return redirect()->route('supplier.index')->withStatus('Berhasil memperbarui data');
        } catch (QueryException $e) {
            return redirect()->back()->withError('Terjadi kesalahan.');
        } catch (Exception $e){
            return redirect()->back()->withError('Terjadi kesalahan.');

        }
    }

    public function destroy($id)
    {
        try {
            $trashSupplier = Supplier::findOrFail($id);
            // return $trashSupplier;
            if ($trashSupplier->deleted_by = auth()->user()->id) {
                $trashSupplier->update();
            }
            $trashSupplier->delete();
            return redirect()->route('supplier.index')->withStatus('Berhasil memindahkan ke tempat sampah');

        } catch (\Exception $e) {
            return redirect()->back()->withError('Terjadi kesalahan.');
        } catch (\Illuminate\Database\QueryException $e) {
            return redirect()->back()->withError('Terjadi kesalahan.');
        }
    }

    public function trashSupplier(Request $request)
    {
        $this->param['btnText'] = 'Tambah Supplier';
        $this->param['btnLink'] = route('supplier.create');
        $this->param['btnTrashText'] = 'Lihat Sampah';
        $this->param['btnTrashLink'] = route('supplier.trash');

        try {
            $keyword = $request->get('keyword');
            $getSupplier = Supplier::onlyTrashed();

            if ($keyword) {
                $getSupplier->where('nama', 'LIKE', "%{$keyword}%");
            }

            $this->param['supplier'] = $getSupplier->paginate(10);
            return view('pages.supplier.listTrash',$this->param);
        } catch (\Illuminate\Database\QueryException $e) {
            return back()->withError('Terjadi Kesalahan : ' . $e->getMessage());
        }
        catch (Exception $e) {
            return back()->withError('Terjadi Kesalahan : ' . $e->getMessage());
        }
    }
    public function restoreSupplier($id)
    {
        try {
            $supplier = Supplier::withTrashed()->findOrFail($id);
            if ($supplier->trashed()) {
                $supplier->deleted_by = null;
                $supplier->restore();
                return redirect()->route('supplier.trash')->withStatus('Data berhasil di restore.');
            }
            else
            {
                return redirect()->route('supplier.trash')->withError('Data tidak ada dalam tempat sampah.');
            }

        } catch (\Illuminate\Database\QueryException $e) {
            return back()->withError('Terjadi Kesalahan : ' . $e->getMessage());
        }
        catch (Exception $e) {
            return back()->withError('Terjadi Kesalahan : ' . $e->getMessage());
        }

    }
    public function hapusPermanen($id)
    {
        try {
            $deleteSupplier = Supplier::onlyTrashed()->where('id',$id);
            $deleteSupplier->forceDelete();
            return redirect()->route('supplier.trash')->withStatus('Data berhasil dihapus permanen.');

        } catch (\Illuminate\Database\QueryException $e) {
            return $e;
            return back()->withError('Terjadi Kesalahan : ' . $e->getMessage());
        }
        catch (Exception $e) {
            return $e;
            return back()->withError('Terjadi Kesalahan : ' . $e->getMessage());
        }
    }
}
