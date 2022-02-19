<?php

namespace App\Http\Controllers\v1;

use App\Http\Controllers\Controller;
use App\Models\Jurnal;
use App\Models\JurnalDetail;
use App\Models\KodeAkun;
use App\Models\TransaksiKas;
use App\Models\TransaksiKasDetail;
use Exception;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Traits\SequenceTrait;
class TransaksiKasController extends Controller
{
    private $param;

    use SequenceTrait;

    public function __construct()
    {
        $this->param['pageTitle'] = 'Transaksi Kas / List Transaksi Kas';
        $this->param['pageIcon'] = 'ti-wallet';
        $this->param['parentMenu'] = 'Transaksi Kas';
        $this->param['current'] = 'Transaksi Kas';
    }
    public function index(Request $request)
    {
        // $data =  TransaksiKas::orderBy('tanggal','DESC')->get();
        $this->param['btnText'] = 'Tambah Data';
        $this->param['btnLink'] = route('kas-transaksi.create');
        try {
            $keyword = $request->get('keyword');
            $getTransaksiKas = TransaksiKas::orderBy('tanggal', 'DESC')->orderBy('created_at', 'DESC');

            if ($keyword) {
                $getTransaksiKas->where('kode_transaksi_kas', 'LIKE', "%{$keyword}%")->orWhere('tipe', 'LIKE', "%{$keyword}%")->orWhere('akun_kode', 'LIKE', "%{$keyword}%");
            }

            $this->param['transaksi_kas'] = $getTransaksiKas->paginate(10);
        } catch (\Illuminate\Database\QueryException $e) {
            return back()->withError('Terjadi Kesalahan : ' . $e->getMessage());
        } catch (Exception $e) {
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
        $this->param['kodeAkun'] = KodeAkun::select('kode_akun.kode_akun', 'kode_akun.nama')
            ->join('kode_induk', 'kode_akun.induk_kode', 'kode_induk.kode_induk')
            ->where('kode_akun.nama', 'LIKE', 'Kas%')
            ->get();
        $this->param['kode_lawan'] = KodeAkun::select('kode_akun.kode_akun', 'kode_akun.nama')
            ->join('kode_induk', 'kode_akun.induk_kode', 'kode_induk.kode_induk')
            ->where('kode_akun.nama', '!=', 'Kas')
            ->where('kode_akun.nama', '!=', 'Bank')
            ->get();
        return view('pages.transaksi-kas.create', $this->param);
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
            'tipe' => 'required|not_in:0',
            'kode_akun' => 'required|not_in:0',
            'kode_lawan.*' => 'required',
            'subtotal.*' => 'required|numeric',
            'keterangan.*' => 'required',
        ],[
            'required' => ':attribute data harus terisi.',
            'not_in' => 'data harus terisi',
        ],[
            'kode_transaksi_kas' => 'kode transaksi kas',
            'kode_akun' => 'kode akun'
        ]);

        DB::beginTransaction();
        try {
            $total = 0;
            $loopTotal = $_POST['subtotal'];
            foreach ($loopTotal as $key => $value) {
                $total += $value;
            }
            $kode = $request->tipe == 'Masuk' ? 'BKM' : 'BKK';
            $tahun = date('Y', strtotime($request->tanggal));
            $bulan = date('m', strtotime($request->tanggal));
            $kodeKas = $this->generateNomorTransaksi($kode, $tahun, $bulan, $request->kode_akun);

            $addTransaksi = new TransaksiKas;
            $addTransaksi->kode_transaksi_kas = $kodeKas;
            $addTransaksi->tanggal = $request->tanggal;
            $addTransaksi->akun_kode = $request->kode_akun;
            $addTransaksi->tipe = $request->tipe;
            $addTransaksi->total = $total;


            $addTransaksi->save();

            // // return $addDetailKas;
            // $addJurnal = new Jurnal;
            // $addJurnal->tanggal = $request->tanggal;
            // $addJurnal->keterangan = $request->ket_transaksi;
            // $addJurnal->kode_transaksi_kas = $request->kode_transaksi_kas;

            // // $addJurnal->
            // $addJurnal->save();

            // $addDetailJurnal = new JurnalDetail;
            // $addDetailJurnal->jurnal_id = $addJurnal->id;
            // $addDetailJurnal->kode_akun = $request->kode_akun;
            // if ($request->tipe == 'Masuk') {
            //     // return 'kredit';
            //     $addDetailJurnal->debit = $total;
            // } else {
            //     // return 'debit';
            //     $addDetailJurnal->kredit = $total;
            // }
            // $addDetailJurnal->tipe = $request->tipe == 'Masuk' ? 'Debit' : 'Kredit';
            // // $addDetailJurnal->id_detail_transaksi = $addDetailKas->id;
            // $addDetailJurnal->save();

            foreach ($_POST['subtotal'] as $key => $value) {
                $addDetailKas =  new TransaksiKasDetail;
                $addDetailKas->kode_transaksi_kas = $kodeKas;
                $addDetailKas->kode_lawan = $_POST['kode_lawan'][$key];
                $addDetailKas->subtotal = $_POST['subtotal'][$key];
                $addDetailKas->keterangan = $_POST['keterangan'][$key];

                $addDetailKas->save();

                // tambah jurnal
                $addJurnal = new Jurnal;
                $addJurnal->tanggal = $request->tanggal;
                $addJurnal->jenis_transaksi = 'Kas';
                $addJurnal->kode_transaksi = $kodeKas;
                $addJurnal->keterangan = $_POST['keterangan'][$key];
                $addJurnal->kode = $request->kode_akun;
                $addJurnal->lawan = $_POST['kode_lawan'][$key];
                $addJurnal->tipe = $request->tipe == 'Masuk' ? 'Debit' : 'Kredit';
                $addJurnal->nominal = $_POST['subtotal'][$key];
                $addJurnal->id_detail = $addDetailKas->id;
                $addJurnal->save();
            }
            DB::commit();
            return redirect()->route('kas-transaksi.index')->withStatus('Berhasil Menambahkan data');
        } catch (QueryException $e) {
            DB::rollBack();
            return redirect()->back()->withError('Terjadi kesalahan.' . $e->getMessage());
        } catch (Exception $e) {
            DB::rollBack();
            return redirect()->back()->withError('Terjadi kesalahan.'. $e->getMessage());
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

    // add detail transaksi kas
    public function DetailKasTransaksi()
    {
        $next = $_GET['biggestNo'] + 1;
        $kode_lawan = KodeAkun::select('kode_akun.kode_akun', 'kode_akun.nama')
            ->join('kode_induk', 'kode_akun.induk_kode', 'kode_induk.kode_induk')
            ->where('kode_akun.nama', '!=', 'Kas')
            ->where('kode_akun.nama', '!=', 'Bank')
            ->get();
        return view('pages.transaksi-kas.form-detail-transaksi-kas', ['hapus' => true, 'no' => $next, 'kode_lawan' => $kode_lawan]);
    }
}
