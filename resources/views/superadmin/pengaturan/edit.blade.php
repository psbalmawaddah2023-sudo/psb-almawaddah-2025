@extends('superadmin.layouts.app')

@section('content')
<div class="container">
    <h1>Edit Pengaturan</h1>

    <form action="{{ route('pengaturan.update', $pengaturan->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="value" class="form-label">Value</label>

            @if(in_array($pengaturan->key, ['site_logo', 'brosur_file']))
                <input type="file" name="value" id="value" class="form-control">

                @if($pengaturan->value)
                    <div class="mt-2">
                        @if(Str::endsWith($pengaturan->value, ['.jpg','.jpeg','.png']))
                            <img src="{{ asset('storage/'.$pengaturan->value) }}" alt="Logo" width="150">
                        @elseif(Str::endsWith($pengaturan->value, '.pdf'))
                            <a href="{{ asset('storage/'.$pengaturan->value) }}" target="_blank">Lihat Brosur (PDF)</a>
                        @endif
                    </div>
                @endif
            @else
                <input type="text" name="value" id="value" class="form-control" 
                       value="{{ old('value', $pengaturan->value) }}">
            @endif

            @error('value')
                <div class="text-danger small">{{ $message }}</div>
            @enderror
        </div>

        <button type="submit" class="btn btn-success">Simpan</button>
        <a href="{{ route('pengaturan.index') }}" class="btn btn-secondary">Kembali</a>
    </form>
</div>
@endsection
