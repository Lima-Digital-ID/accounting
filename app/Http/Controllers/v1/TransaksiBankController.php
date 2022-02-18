<?php

namespace App\Http\Controllers\v1;

use App\Http\Controllers\Controller;
use App\Models\Jurnal;
use App\Models\JurnalDetail;
use App\Models\KodeAkun;
use App\Models\TransaksiBank;
use App\Models\TransaksiBankDetail;
use Exception;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TransaksiBankController extends Controller
{
    private $param;

    public function __construct()
    {
        $this->param['pageTitle'] = 'Transaksi Bank / List Transaksi Bank';
        $this->param['pageIcon'] = 'ti-wallet';
        $this->param['parentMenu'] = 'Transaksi Bank';
        $this->param['current'] = 'Transaksi Bank';
    }

    public function index(Request $request)
    {
        $this->param['btnText'] = 'Tambah Data';
        $this->param['btnLink'] = route('bank-transaksi.create');
        try {
            $keyword = $request->get('keyword');
            $getTransaksiBank = TransaksiBank::orderBy('kode_transaksi_bank', 'ASC');

            if ($keyword) {
                $getTransaksiBank->where('kode_transaksi_bank', 'LIKE', "%{$keyword}%")->orWhere('tipe', 'LIKE', "%{$keyword}%")->orWhere('akun_kode', 'LIKE', "%{$keyword}%");
            }

            $this->param['transaksi_bank'] = $getTransaksiBank->paginate(10);
        } catch (\Illuminate\Database\QueryException $e) {
            return back()->withError('Terjadi Kesalahan : ' . $e->getMessage());
        }
        catch (Exception $e) {
            return back()->withError('Terjadi Kesalahan : ' . $e->getMessage());
        }

        return view('pages.transaksi-bank.index', $this->param);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->param['btnText'] = 'Lihat Data';
        $this->param['btnLink'] = route('bank-transaksi.index');
        $this->param['kodeAkun'] = KodeAkun::select('kode_akun.kode_akun','kode_akun.nama')
                                            ->join('kode_induk','kode_akun.induk_kode','kode_induk.kode_induk')
                                            ->where('kode_akun.nama','LIKE','Bank%')
                                            ->get();
        $this->param['kode_lawan'] = KodeAkun::select('kode_akun.kode_akun','kode_akun.nama')
                                            ->join('kode_induk','kode_akun.induk_kode','kode_induk.kode_induk')
                                            ->where('kode_akun.nama','!=','Kas')
                                            ->where('kode_akun.nama', '!=', 'Bank')
                                            ->get();
        return view('pages.transaksi-bank.create',$this->param);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'tanggal' => 'required',
            'tipe' => 'required',
            'kode_akun' => 'required',
        ]);
        // return $request;
        DB::beginTransaction();
        try {
            $total = 0;
            $loopTotal = $_POST['subtotal'];
            foreach ($loopTotal as $key => $value) {
                $total += $value;
            }
            $addTransaksi = new TransaksiBank;
            $addTransaksi->kode_transaksi_bank = $request->kode_transaksi_bank;
            $addTransaksi->tanggal = $request->tanggal;
            $addTransaksi->akun_kode = $request->kode_akun;
            $addTransaksi->tipe = $request->tipe;
            $addTransaksi->total = $total;
            $addTransaksi->keterangan = $request->ket_transaksi;

            $addTransaksi->save();

            // return $addDetailKas;
            $addJurnal = new Jurnal;
            $addJurnal->tanggal = $request->tanggal;
            $addJurnal->keterangan = $request->ket_transaksi;
            $addJurnal->kode_transaksi_bank = $request->kode_transaksi_bank;
            // $addJurnal->
            $addJurnal->save();

            // return $addJurnal;
            $addDetailJurnal = new JurnalDetail;
            $addDetailJurnal->jurnal_id = $addJurnal->id;
            $addDetailJurnal->kode_akun = $request->kode_akun;
            if ($request->tipe == 'Masuk') {
                // return 'kredit';
                $addDetailJurnal->debit = $_POST['subtotal'][$key];
            }else{
                // return 'debit';
                $addDetailJurnal->kredit = $_POST['subtotal'][$key];
            }
            $addDetailJurnal->tipe = $request->tipe == 'Masuk' ? 'Debit' : 'Kredit';
            // $addDetailJurnal->id_detail_transaksi = $addDetailBank->id;
            $addDetailJurnal->save();

            foreach ($_POST['subtotal'] as $key => $value) {
                $addDetailBank =  new TransaksiBankDetail;
                $addDetailBank->kode_transaksi_bank = $request->kode_transaksi_bank;
                // $addDetailBank->kode_transaksi_kas = null;
                $addDetailBank->kode_lawan = $_POST['kode_lawan'][$key];
                $addDetailBank->subtotal = $_POST['subtotal'][$key];
                $addDetailBank->keterangan = $_POST['keterangan'][$key];

                $addDetailBank->save();

                // // return $addDetailKas;
                // $addJurnal = new Jurnal;
                // $addJurnal->tanggal = $request->tanggal;
                // $addJurnal->keterangan = $request->ket_transaksi;
                // $addJurnal->kode_transaksi_bank = $request->kode_transaksi_bank;
                // // $addJurnal->
                // $addJurnal->save();

                // return $addJurnal;
                $addDetailJurnal = new JurnalDetail;
                $addDetailJurnal->jurnal_id = $addJurnal->id;
                $addDetailJurnal->kode_akun = $_POST['kode_lawan'][$key];
                if ($request->tipe == 'Masuk') {
                    // return 'kredit';
                    $addDetailJurnal->kredit = $_POST['subtotal'][$key];
                }else{
                    // return 'debit';
                    $addDetailJurnal->debit = $_POST['subtotal'][$key];
                }
                $addDetailJurnal->tipe = $request->tipe == 'Masuk' ? 'Kredit' : 'Debit';
                $addDetailJurnal->id_detail_transaksi = $addDetailBank->id;
                $addDetailJurnal->save();
            }
            DB::commit();
            return redirect()->route('bank-transaksi.index')->withStatus('Berhasil Menambahkan data');
         } catch (QueryException $e) {
             DB::rollBack();
            //  return $e;
             return redirect()->back()->withError('Terjadi kesalahan.');
        } catch (Exception $e){
            DB::rollBack();
            // return $e;
            return redirect()->back()->withError('Terjadi kesalahan.');
        }
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
    // detail transaksi bank
    public function DetailbankTransaksi()
    {
        $next = $_GET['biggestNo'] + 1;
        $kode_lawan = KodeAkun::select('kode_akun.kode_akun','kode_akun.nama')
                        ->join('kode_induk','kode_akun.induk_kode','kode_induk.kode_induk')
                        ->where('kode_akun.nama','!=','Kas')
                        ->where('kode_akun.nama', '!=', 'Bank')
                        ->get();
        return view('pages.transaksi-bank.form-detail-transaksi-bank', ['hapus' => true, 'no' => $next, 'kode_lawan' => $kode_lawan]);
    }
}
