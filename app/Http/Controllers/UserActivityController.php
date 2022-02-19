<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\UserActivity;
use Exception;
use Illuminate\Http\Request;

class UserActivityController extends Controller
{
    private $param;

    public function __construct()
    {
        $this->param['pageTitle'] = 'User Activity';
        $this->param['pageIcon'] = 'fa fa-history';
        $this->param['parentMenu'] = 'User Activity';
        $this->param['current'] = 'User Activity';
    }
    public function index(Request $request)
    {
        try {
            $start = $request->start;
            $end = $request->end;
            $idUser = $request->id_user;
            $getUserActivity = UserActivity::select('user_activity.id','user_activity.id_user','user_activity.jenis_transaksi','user_activity.tipe','user_activity.keterangan','user_activity.created_at','user_activity.updated_at','users.id','users.name')
                                            ->join('users','users.id','user_activity.id_user')
                                            ->orderBy('user_activity.id', 'DESC');
            if ($idUser) {
                $getUserActivity->where('id_user', $idUser);
            }
            if ($start && $end) {
                $getUserActivity->whereBetween('user_activity.created_at', ["$start 00:00:00", "$end 23:59:59"]);
            }

            $this->param['users'] = User::get();

            $this->param['logActivity'] = $getUserActivity->paginate(10);
        } catch (\Illuminate\Database\QueryException $e) {
            return back()->withError('Terjadi Kesalahan : ' . $e->getMessage());
        }
        catch (Exception $e) {
            return back()->withError('Terjadi Kesalahan : ' . $e->getMessage());
        }

        return view('pages.user-activity.index', $this->param);
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
