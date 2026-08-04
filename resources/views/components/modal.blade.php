@props(['id', 'title' => null, 'size' => 'md'])

<div id="{{ $id }}" class="admin-modal" data-modal>
    <div class="admin-modal__overlay" data-modal-close></div>
    <div class="admin-modal__dialog admin-modal__dialog--{{ $size }}">
        <div class="admin-modal__header">
            <h3 class="admin-modal__title">{{ $title }}</h3>
            <button type="button" class="admin-modal__close" data-modal-close aria-label="Tutup">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" /></svg>
            </button>
        </div>

        <div class="admin-modal__body">
            {{ $slot }}
        </div>

        @isset($footer)
            <div class="admin-modal__footer">
                {{ $footer }}
            </div>
        @endisset
    </div>
</div>
