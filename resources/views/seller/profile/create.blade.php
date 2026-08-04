<x-app-layout>
    <x-slot name="header">
        <h2 class="fs-5 fw-semibold">Lengkapi Profil UMKM</h2>
    </x-slot>

    <div class="container py-4">
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('seller.profile.store') }}" enctype="multipart/form-data">
            @csrf

            <div class="mb-3">
                <label class="form-label">Nama Usaha</label>
                <input type="text" name="business_name" class="form-control" value="{{ old('business_name') }}" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Nama Pemilik</label>
                <input type="text" name="owner_name" class="form-control" value="{{ old('owner_name') }}" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Deskripsi Usaha</label>
                <textarea name="description" class="form-control" rows="4">{{ old('description') }}</textarea>
            </div>

            <div class="mb-3">
                <label class="form-label">Alamat</label>
                <textarea name="address" class="form-control" rows="2" required>{{ old('address') }}</textarea>
            </div>

            <div class="mb-3">
                <label class="form-label">Nomor WhatsApp</label>
                <input type="text" name="whatsapp" class="form-control" placeholder="628123456789" value="{{ old('whatsapp') }}" required>
                <div class="form-text">Format: 62xxxxxxxxxx (tanpa spasi/strip, dipakai buat link wa.me)</div>
            </div>

            <div class="mb-3">
                <label class="form-label">Logo UMKM (opsional)</label>
                <input type="file" name="logo" class="form-control" accept="image/*">
            </div>

            <button type="submit" class="btn btn-primary">Simpan Profil</button>
        </form>
    </div>
</x-app-layout>
