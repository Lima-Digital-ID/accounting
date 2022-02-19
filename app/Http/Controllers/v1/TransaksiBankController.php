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
use App\Http\Traits\SequenceTrait;

class TransaksiBankController extends Controller
{
    private $param;

    use SequenceTrait;

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
            $getTransaksiBank = TransaksiBank::orderBy('tanggal', 'DESC')->orderBy('created_at', 'DESC');

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
            'kode_transaksi_bank' => 'required|unique:transaksi_bank',
            'tanggal' => 'required',
            'tipe' => 'required',
            'kode_akun' => 'required|not_in:0',
            'kode_akun' => 'required',
            'kode_lawan.*' => 'required',
            'subtotal.*' => 'required',
            'keterangan.*' => 'required',
        ]);
        // return $request;
        DB::beginTransaction();
        try {
            $total = 0;
            $loopTotal = $_POST['subtotal'];
            foreach ($loopTotal as $key => $value) {
                $total += $value;
            }

            $kode = $request->tipe == 'Masuk' ? 'BBM' : 'BBK';
            $tahun = date('Y', strtotime($request->tanggal));
            $bulan = date('m', strtotime($request->tanggal));
            $kodeBank = $this->generateNomorTransaksi($kode, $tahun, $bulan, $request->kode_akun);

            $addTransaksi = new TransaksiBank;
            $addTransaksi->kode_transaksi_bank = $kodeBank;
            $addTransaksi->tanggal = $request->tanggal;
            $addTransaksi->akun_kode = $request->kode_akun;
            $addTransaksi->tipe = $request->tipe;
            $addTransaksi->total = $total;


            $addTransaksi->save();


            foreach ($_POST['subtotal'] as $key => $value) {
                $addDetailBank =  new TransaksiBankDetail;
                $addDetailBank->kode_transaksi_bank = $kodeBank;
                $addDetailBank->kode_lawan = $_POST['kode_lawan'][$key];
                $addDetailBank->subtotal = $_POST['subtotal'][$key];
                $addDetailBank->keterangan = $_POST['keterangan'][$key];

                $addDetailBank->save();

                // tambah jurnal
                $addJurnal = new Jurnal;
                $addJurnal->tanggal = $request->tanggal;
                $addJurnal->jenis_transaksi = 'Bank';
                $addJurnal->kode_transaksi = $kodeBank;
                $addJurnal->keterangan = $_POST['keterangan'][$key];
                $addJurnal->kode = $request->kode_akun;
                $addJurnal->lawan = $_POST['kode_lawan'][$key];
                $addJurnal->tipe = $request->tipe == 'Masuk' ? 'Debit' : 'Kredit';
                $addJurnal->nominal = $_POST['subtotal'][$key];
                $addJurnal->id_detail = $addDetailBank->id;
                $addJurnal->save();
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
