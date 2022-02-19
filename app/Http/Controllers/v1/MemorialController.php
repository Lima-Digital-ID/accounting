<?php

namespace App\Http\Controllers\v1;

use App\Http\Controllers\Controller;
use App\Http\Traits\SequenceTrait;
use App\Models\Jurnal;
use App\Models\KodeAkun;
use App\Models\Memorial;
use App\Models\MemorialDetail;
use Exception;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MemorialController extends Controller
{
    private $param;

    use SequenceTrait;

    public function __construct()
    {
        $this->param['pageTitle'] = 'Memorial / List Memorial';
        $this->param['pageIcon'] = 'ti-wallet';
        $this->param['parentMenu'] = 'Memorial';
        $this->param['current'] = 'Memorial';
    }
    public function index(Request $request)
    {
        $this->param['btnText'] = 'Tambah Data';
        $this->param['btnLink'] = route('memorial.create');
        try {
            $keyword = $request->get('keyword');
            $getMemorial = Memorial::orderBy('tanggal', 'DESC')->orderBy('created_at', 'DESC');

            if ($keyword) {
                $getMemorial->where('kode_memorial', 'LIKE', "%{$keyword}%")->orWhere('tipe', 'LIKE', "%{$keyword}%");
            }

            $this->param['memorial'] = $getMemorial->paginate(10);
        } catch (\Illuminate\Database\QueryException $e) {
            return back()->withError('Terjadi Kesalahan : ' . $e->getMessage());
        } catch (Exception $e) {
            return back()->withError('Terjadi Kesalahan : ' . $e->getMessage());
        }

        return view('pages.memorial.index', $this->param);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->param['btnText'] = 'Lihat Data';
        $this->param['btnLink'] = route('memorial.index');

        $this->param['kode_lawan'] = KodeAkun::select('kode_akun.kode_akun','kode_akun.nama')->get();
        return view('pages.memorial.create',$this->param);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // return $request;
        $request->validate([
            'tanggal' => 'required',
            'tipe' => 'required|not_in:0',
            'kode_akun.*' => 'required|not_in:0',
            'kode_lawan.*' => 'required|not_in:0',
            'subtotal.*' => 'required',
            'keterangan.*' => 'required',
        ],[
            'required' => ':attribute harus terisi.',
            'not_in' => ':attribute harus terisi',
        ],[
            'kode_akun.*' => 'kode akun',
            'kode_lawan.*' => 'kode lawan',
            'subtotal.*' => 'subtotal',
            'keterangan.*' => 'keterangan'

        ]);
        DB::beginTransaction();
        try {
            $total = 0;
            $loopTotal = $_POST['subtotal'];
            foreach ($loopTotal as $key => $value) {
                $total += $value;
            }

            $kode = $request->tipe == 'Masuk' ? 'BMM' : 'BMK';
            $tahun = date('Y', strtotime($request->tanggal));
            $bulan = date('m', strtotime($request->tanggal));
            $kodeMemorial = $this->generateNomorTransaksi($kode, $tahun, $bulan, null);

            $addMemorial = new Memorial;
            $addMemorial->kode_memorial = $kodeMemorial;
            $addMemorial->tanggal = $request->tanggal;
            // $addMemorial->akun_kode = $request->kode_akun;
            $addMemorial->tipe = $request->tipe;
            $addMemorial->total = $total;


            $addMemorial->save();


            foreach ($_POST['subtotal'] as $key => $value) {

                $addDetailMemorial =  new MemorialDetail;
                $addDetailMemorial->kode_memorial = $kodeMemorial;
                $addDetailMemorial->keterangan = $_POST['keterangan'][$key];
                $addDetailMemorial->kode = $_POST['kode_akun'][$key];
                $addDetailMemorial->lawan = $_POST['kode_lawan'][$key];
                $addDetailMemorial->subtotal = $_POST['subtotal'][$key];

                $addDetailMemorial->save();

                // tambah jurnal
                $addJurnal = new Jurnal;
                $addJurnal->tanggal = $request->tanggal;
                $addJurnal->jenis_transaksi = 'Memorial';
                $addJurnal->kode_transaksi = $kodeMemorial;
                $addJurnal->keterangan = $_POST['keterangan'][$key];
                $addJurnal->kode = $_POST['kode_akun'][$key];
                $addJurnal->lawan = $_POST['kode_lawan'][$key];
                $addJurnal->tipe = $request->tipe == 'Masuk' ? 'Debit' : 'Kredit';
                $addJurnal->nominal = $_POST['subtotal'][$key];
                $addJurnal->id_detail = $addDetailMemorial->id;
                $addJurnal->save();
            //     // tambah jurnal
            //     $addJurnal = new Jurnal;
            //     $addJurnal->tanggal = $request->tanggal;
            //     $addJurnal->jenis_transaksi = 'Bank';
            //     $addJurnal->kode_transaksi = $kodeBank;
            //     $addJurnal->keterangan = $_POST['keterangan'][$key];
            //     $addJurnal->kode = $request->kode_akun;
            //     $addJurnal->lawan = $_POST['kode_lawan'][$key];
            //     $addJurnal->tipe = $request->tipe == 'Masuk' ? 'Debit' : 'Kredit';
            //     $addJurnal->nominal = $_POST['subtotal'][$key];
            //     $addJurnal->id_detail = $addDetailBank->id;
            //     $addJurnal->save();
            }
            DB::commit();
            return redirect()->route('memorial.index')->withStatus('Berhasil Menambahkan data');
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

    public function DetailMemorial()
    {
        $next = $_GET['biggestNo'] + 1;
        $kode_lawan = KodeAkun::select('kode_akun.kode_akun','kode_akun.nama')
                                ->get();
        return view('pages.memorial.form-detail-memorial-kas', ['hapus' => true, 'no' => $next, 'kode_lawan' => $kode_lawan,'kode_akun' => $kode_lawan]);
    }

    // report memorial
    public function reportMemorial()
    {
        try {

            $this->param['report_memorial'] = null;
            return view('pages.memorial.laporan-memorial',$this->param);
        }catch(\Exception $e){
            return redirect()->back()->withStatus('Terjadi kesalahan. : ' . $e->getMessage());
        }catch(\Illuminate\Database\QueryException $e){
            return redirect()->back()->withStatus('Terjadi kesalahan pada database : ' . $e->getMessage());
        }
    }
    public function getReport(Request $request)
    {
        $request->validate([
            'start' => 'required',
            'end' => 'required'
        ],[
            'required', ':atrribute harus terisi',
            'no_in' => ':attribute harus terisi'
        ]);
        // return $request;
        try {
            $this->param['report_memorial'] = Memorial::select(
                                                    'memorial.kode_memorial',
                                                    'memorial.tanggal',
                                                    'memorial.tipe',
                                                    'memorial.total',
                                                    'memorial_detail.kode_memorial',
                                                    'memorial_detail.kode',
                                                    'memorial_detail.lawan',
                                                    'memorial_detail.subtotal',
                                                    'memorial_detail.keterangan')
                                                    ->join('memorial_detail','memorial_detail.kode_memorial','memorial.kode_memorial')
                                                    // ->whereBetween('memorial.tanggal', [$request->get('start'), $request->get('end')])
                                                    ->whereBetween('memorial.tanggal',[$request->start,$request->end])
                                                    ->get();
            return view('pages.memorial.laporan-memorial',$this->param);
        }catch(\Exception $e){
            return redirect()->back()->withStatus('Terjadi kesalahan. : ' . $e->getMessage());
        }catch(\Illuminate\Database\QueryException $e){
            return redirect()->back()->withStatus('Terjadi kesalahan pada database : ' . $e->getMessage());
        }
    }
    public function printReport(Request $request)
    {
        $request->validate([
            'start' => 'required',
            'end' => 'required'
        ],[
            'required', ':atrribute harus terisi',
            'no_in' => ':attribute harus terisi'
        ]);
        // return $request;
        try {
            $this->param['report_memorial'] = Memorial::select(
                                                    'memorial.kode_memorial',
                                                    'memorial.tanggal',
                                                    'memorial.tipe',
                                                    'memorial.total',
                                                    'memorial_detail.kode_memorial',
                                                    'memorial_detail.kode',
                                                    'memorial_detail.lawan',
                                                    'memorial_detail.subtotal',
                                                    'memorial_detail.keterangan')
                                                    ->join('memorial_detail','memorial_detail.kode_memorial','memorial.kode_memorial')
                                                    // ->whereBetween('memorial.tanggal', [$request->get('start'), $request->get('end')])
                                                    ->whereBetween('memorial.tanggal',[$request->start,$request->end])
                                                    ->get();
            return view('pages.memorial.print-laporan-memorial',$this->param);
        }catch(\Exception $e){
            return redirect()->back()->withStatus('Terjadi kesalahan. : ' . $e->getMessage());
        }catch(\Illuminate\Database\QueryException $e){
            return redirect()->back()->withStatus('Terjadi kesalahan pada database : ' . $e->getMessage());
        }
    }
}
