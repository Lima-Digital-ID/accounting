<div class="table-responsive">
    <table class="table table-styling table-de">
        <thead>
            <tr class="table-primary">
                <th class="text-center">#</th>
                <th>Nama</th>
                <th>Username</th>
                <th>Email</th>
                <th>Level</th>
                <th>Deleted By</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @php
                $page = Request::get('page');
                $no = !$page || $page == 1 ? 1 : ($page - 1) * 10 + 1;
            @endphp
            @foreach ($user as $item)
                @php
                    $nama = \App\Models\User::select('*')->where('id',$item->deleted_by)->first();

                @endphp
                <tr class="border-bottom-primary">
                    <td class="text-center text-muted">{{ $no }}</td>
                    <td>{{ $item->name }}</td>
                    <td>{{ $item->username }}</td>
                    <td>{{ $item->email }}</td>
                    <td>{{ $item->level }}</td>
                    <td>{{  $nama->name }}</td>
                    <td>
                        <div class="form-inline">
                            <a href="{{ route('user.restore', $item->id) }}" class="mr-2">
                                <button type="button" id="PopoverCustomT-1" class="btn btn-primary btn-sm"
                                    data-toggle="tooltip" title="Restore" data-placement="top"><i class="ti-reload"></i></button>
                            </a>
                            {{-- <a href="{{ route('user.hapusPermanen',$item->id) }}"> --}}
                            <form action="{{ route('user.hapusPermanen', [$item->id]) }}" method="post" onsubmit="return confirm('Delete this data permanently ?')">
                                @csrf
                                <input type="hidden" name="_method" value="DELETE">
                                <button type="submit" value="Delete" class="btn btn-danger btn-sm" data-toggle="tooltip" title="Hapus Permanen"
                                    data-placement="top">
                                    <span class="feather icon-trash"></span>
                                </button>
                                {{-- </a> --}}
                            </form>

                        </div>
                    </td>
                </tr>
                @php
                    $no++;
                @endphp
            @endforeach
        </tbody>
    </table>
    <div class="pull-right">
        {{ $user->appends(Request::all())->links('vendor.pagination.custom') }}
    </div>
</div>
