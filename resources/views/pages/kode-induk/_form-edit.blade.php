<form action="{{ route('kode-induk.update',$data->kode_induk) }}" method="POST">
    @csrf
    @method('PUT')
    <div class="form-group row">
        <label class="col-sm-2 col-form-label">Kode Induk</label>
        <div class="col-sm-10">
            <input type="text" name="kode_induk" class="form-control @error('kode_induk') is-invalid @enderror"
                placeholder="Nama User" value="{{ old('kode_induk',$data->kode_induk) }}">
            @error('kode_induk')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>
    </div>

    <div class="form-group row">
        <label class="col-sm-2 col-form-label">nama</label>
        <div class="col-sm-10">
            <input type="text" name="nama" class="form-control @error('nama') is-invalid @enderror"
                placeholder="Nama Kode Induk" value="{{ old('nama',$data->nama) }}">
            @error('nama')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>
    </div>

    <div class="form-group row">
        <label class="col-sm-2 col-form-label">Tipe</label>
        <div class="col-sm-10">
            <select name="tipe" id="tipe" class="form-control @error('email') is-invalid @enderror">
                <option value="">Pilih Tipe</option>
                <option value="Debit" {{ old('tipe',$data->tipe) == 'Debit' ? ' selected' : '' }}>Debit</option>
                <option value="Kredit" {{ old('tipe',$data->tipe) == 'Kredit' ? ' selected' : '' }}>Kredit</option>
            </select>
            @error('tipe')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>
    </div>


    <button type="submit" class="btn btn-sm btn-primary"><i class="feather icon-save"></i>Simpan</button>
</form>

@push('custom-scripts')

@endpush
