<?php

namespace App\Http\Controllers\v1;

use App\Http\Controllers\Controller;
use App\Models\KodeAkun;
use App\Models\TransaksiKas;
use Exception;
use Illuminate\Http\Request;

class TransaksiKasController extends Controller
{
    private $param;

    public function __construct()
    {
        $this->param['pageTitle'] = 'Transaksi Kas / List Transaksi Kas';
        $this->param['pageIcon'] = 'ti-wallet';
        $this->param['parentMenu'] = 'Transaksi Kas';
        $this->param['current'] = 'Transaksi Kas';
    }
    public function index(Request $request)
    {
        $data =  TransaksiKas::orderBy('tanggal','DESC')->get();
        $this->param['btnText'] = 'Tambah Data';
        $this->param['btnLink'] = route('kas-transaksi.create');
        try {
            $keyword = $request->get('keyword');
            $getTransaksiKas = TransaksiKas::orderBy('kode_transaksi_kas', 'ASC');

            if ($keyword) {
                $getTransaksiKas->where('kode_transaksi_kas', 'LIKE', "%{$keyword}%")->orWhere('tipe', 'LIKE', "%{$keyword}%")->orWhere('akun_kode', 'LIKE', "%{$keyword}%");
            }

            $this->param['transaksi_kas'] = $getTransaksiKas->paginate(10);
        } catch (\Illuminate\Database\QueryException $e) {
            return back()->withError('Terjadi Kesalahan : ' . $e->getMessage());
        }
        catch (Exception $e) {
            return back()->withError('Terjadi Kesalahan : ' . $e->getMessage());
        }

        return view('pages.transaksi-kas.index', $this->param);
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->param['btnText'] = 'Lihat Data';
        $this->param['btnLink'] = route('kas-transaksi.index');
        $this->param['kodeAkun'] = KodeAkun::select('kode_akun.kode_akun','kode_akun.nama')
                                            ->join('kode_induk','kode_akun.induk_kode','kode_induk.kode_induk')
                                            ->where('kode_akun.nama','LIKE','Kas%')
                                            ->get();
        $this->param['kode_lawan'] = KodeAkun::select('kode_akun.kode_akun','kode_akun.nama')
                                            ->join('kode_induk','kode_akun.induk_kode','kode_induk.kode_induk')
                                            ->where('kode_akun.nama','!=','Kas')
                                            ->where('kode_akun.nama', '!=', 'Bank')
                                            ->get();
        return view('pages.transaksi-kas.create',$this->param);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        return $request;

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    // add detail transaksi kas
    public function DetailKasTransaksi()
    {
        $next = $_GET['biggestNo'] + 1;
        $kode_lawan = KodeAkun::select('kode_akun.kode_akun','kode_akun.nama')
                        ->join('kode_induk','kode_akun.induk_kode','kode_induk.kode_induk')
                        ->where('kode_akun.nama','!=','Kas')
                        ->where('kode_akun.nama', '!=', 'Bank')
                        ->get();
        return view('pages.transaksi-kas.form-detail-transaksi-kas', ['hapus' => true, 'no' => $next, 'kode_lawan' => $kode_lawan]);
    }
}
