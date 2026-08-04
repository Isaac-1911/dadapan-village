@props(['id', 'action', 'title' => 'Hapus Data', 'message' => 'Apakah Anda yakin ingin menghapus data ini? Tindakan ini tidak dapat dibatalkan.'])

<x-modal :id="$id" :title="$title" size="sm">
    <p class="admin-modal__text">{{ $message }}</p>

    <x-slot name="footer">
        <button type="button" class="admin-btn admin-btn--ghost" data-modal-close>Batal</button>
        <form method="POST" action="{{ $action }}">
            @csrf
            @method('DELETE')
            <button type="submit" class="admin-btn admin-btn--danger">Ya, Hapus</button>
        </form>
    </x-slot>
</x-modal>
