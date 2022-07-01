<?php

namespace App\Http\Controllers\v1;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use Exception;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    private $param;

    public function __construct()
    {
        $this->param['pageTitle'] = 'Customer';
        $this->param['pageIcon'] = 'fa-solid fa-user-tag';
        $this->param['parentMenu'] = 'customer';
        $this->param['current'] = 'Customer';
    }

    public function index(Request $request)
    {
        $this->param['btnText'] = 'Tambah Customer';
        $this->param['btnLink'] = route('customer.create');
        $this->param['btnTrashText'] = 'Lihat Sampah';
        $this->param['btnTrashLink'] = route('customer.trash');

        try {
            $keyword = $request->get('keyword');
            $getCustomer = Customer::orderBy('nama', 'ASC');

            if ($keyword) {
                $getCustomer->where('nama', 'LIKE', "%{$keyword}%");
            }

            $this->param['customer'] = $getCustomer->paginate(10);
        } catch (\Illuminate\Database\QueryException $e) {
            return back()->withError('Terjadi Kesalahan : ' . $e->getMessage());
        }
        catch (Exception $e) {
            return back()->withError('Terjadi Kesalahan : ' . $e->getMessage());
        }

        return view('pages.customer.index', $this->param);
    }

    public function create()
    {
        $this->param['btnText'] = 'List Customer';
        $this->param['btnLink'] = route('customer.index');

        return view('pages.customer.create',$this->param);
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required',
            'no_hp' => 'required|unique:customer',
            'alamat' => 'required',
        ]);
        try {
            $addCustomer = new Customer;
            $addCustomer->nama = $request->nama;
            $addCustomer->alamat = $request->alamat;
            $addCustomer->no_hp = $request->no_hp;
            $addCustomer->save();
            return redirect()->route('customer.index')->withStatus('Berhasil menambahkan data');
        } catch (QueryException $e) {
            return redirect()->back()->withError('Terjadi kesalahan.');
        } catch (Exception $e){
            return redirect()->back()->withError('Terjadi kesalahan.');
        }
    }


    public function edit($id)
    {
        try {
            $this->param['btnText'] = 'Lihat Customer';
            $this->param['btnLink'] = route('customer.index');
            $this->param['data'] = Customer::findOrFail($id);
            return view('pages.customer.edit',$this->param);
        } catch (QueryException $e) {
            return redirect()->back()->withError('Terjadi kesalahan.');
        } catch (Exception $e){
            return redirect()->back()->withError('Terjadi kesalahan.');

        }
    }

    public function update(Request $request, $id)
    {
        $customer = Customer::findOrFail($id);
        $isUniquPhone = $customer->no_hp == $request->no_hp ? '' : '|unique:customer';

        $request->validate([
            'nama' => 'required',
            'alamat' => 'required',
            'no_hp' => 'required'.$isUniquPhone,
        ]);
        try {
            $customer = Customer::find($id);
            $customer->nama = $request->nama;
            $customer->alamat = $request->alamat;
            $customer->no_hp = $request->no_hp;
            $customer->save();
            return redirect()->route('customer.index')->withStatus('Berhasil memperbarui data');
        } catch (QueryException $e) {
            return redirect()->back()->withError('Terjadi kesalahan.');
        } catch (Exception $e){
            return redirect()->back()->withError('Terjadi kesalahan.');

        }
    }

    public function destroy($id)
    {
        try {
            $trashCustomer = Customer::findOrFail($id);
            // return $trashCustomer;
            if ($trashCustomer->deleted_by = auth()->user()->id) {
                $trashCustomer->update();
            }
            $trashCustomer->delete();
            return redirect()->route('customer.index')->withStatus('Berhasil memindahkan ke tempat sampah');

        } catch (\Exception $e) {
            return redirect()->back()->withError('Terjadi kesalahan.');
        } catch (\Illuminate\Database\QueryException $e) {
            return redirect()->back()->withError('Terjadi kesalahan.');
        }
    }

    public function trashCustomer(Request $request)
    {
        $this->param['btnText'] = 'Tambah Customer';
        $this->param['btnLink'] = route('customer.create');
        $this->param['btnTrashText'] = 'Lihat Sampah';
        $this->param['btnTrashLink'] = route('customer.trash');

        try {
            $keyword = $request->get('keyword');
            $getCustomer = Customer::onlyTrashed();

            if ($keyword) {
                $getCustomer->where('nama', 'LIKE', "%{$keyword}%");
            }

            $this->param['customer'] = $getCustomer->paginate(10);
            return view('pages.customer.listTrash',$this->param);
        } catch (\Illuminate\Database\QueryException $e) {
            return back()->withError('Terjadi Kesalahan : ' . $e->getMessage());
        }
        catch (Exception $e) {
            return back()->withError('Terjadi Kesalahan : ' . $e->getMessage());
        }
    }
    public function restoreCustomer($id)
    {
        try {
            $customer = Customer::withTrashed()->findOrFail($id);
            if ($customer->trashed()) {
                $customer->deleted_by = null;
                $customer->restore();
                return redirect()->route('customer.trash')->withStatus('Data berhasil di restore.');
            }
            else
            {
                return redirect()->route('customer.trash')->withError('Data tidak ada dalam tempat sampah.');
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
            $deleteCustomer = Customer::onlyTrashed()->where('id',$id);
            $deleteCustomer->forceDelete();
            return redirect()->route('customer.trash')->withStatus('Data berhasil dihapus permanen.');

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
