<?php

namespace App\Http\Controllers\v1;

use App\Http\Controllers\Controller;
use App\Http\Traits\SequenceTrait;
use App\Models\Memorial;
use Exception;
use Illuminate\Http\Request;

class MemorialController extends Controller
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
    public function index($request)
    {
        $this->param['btnText'] = 'Tambah Data';
        $this->param['btnLink'] = route('memorial.index');
        try {
            $keyword = $request->get('keyword');
            $getMemorial = Memorial::orderBy('tanggal', 'DESC')->orderBy('created_at', 'DESC');

            if ($keyword) {
                $getMemorial->where('kode_memorial', 'LIKE', "%{$keyword}%")->orWhere('tipe', 'LIKE', "%{$keyword}%")->orWhere('akun_kode', 'LIKE', "%{$keyword}%");
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
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
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
}
