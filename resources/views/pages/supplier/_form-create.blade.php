<form action="{{ route('supplier.store') }}" method="POST">
    @csrf
    <div class="form-group row">
        <label class="col-sm-2 col-form-label">Nama</label>
        <div class="col-sm-10">
            <input type="text" name="nama" class="form-control @error('nama') is-invalid @enderror"
                placeholder="Nama Supplier" value="{{ old('nama') }}">
            @error('nama')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>
    </div>

    <div class="form-group row">
        <label class="col-sm-2 col-form-label">Alamat</label>
        <div class="col-sm-10">
            <textarea name="alamat" class="form-control @error('alamat') is-invalid @enderror" id="" value="{{ old('alamat') }}" placeholder="Alamat supplier"></textarea>
            @error('alamat')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>
    </div>

    <div class="form-group row">
        <label class="col-sm-2 col-form-label">No Handphone</label>
        <div class="col-sm-10">
            <input type="number" name="no_hp" class="form-control @error('no_hp') is-invalid @enderror"
                placeholder="Nomor handphone supplier" value="{{ old('no_hp') }}">
            @error('no_hp')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>
    </div>

    <button type="submit" class="btn btn-sm btn-primary"><i class="feather icon-save"></i>Simpan</button>
</form>
