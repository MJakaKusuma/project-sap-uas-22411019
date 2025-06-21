@props([
    'action',
    'method' => 'POST',
    'title' => 'Yakin ingin menghapus data?',
    'text' => 'Data yang dihapus tidak dapat dikembalikan!',
    'confirmButtonText' => 'Ya, Hapus!',
    'cancelButtonText' => 'Batal',
    'buttonClass' => 'btn btn-sm btn-danger',
    'icon' => 'fa fa-trash-o',
    'buttonText' => 'Hapus'
])
<form id="form-{{ md5($action) }}" action="{{ $action }}" method="POST" style="display: none;">
  @csrf
  @if (strtoupper($method) !== 'POST')
    @method($method)
  @endif
</form>

<button
  type="button"
  class="{{ $buttonClass }}"
  onclick="confirmDelete('{{ md5($action) }}', @js($title), @js($text), @js($confirmButtonText), @js($cancelButtonText))"
>
  <i class="{{ $icon }} me-2"></i> {{ $buttonText }}
</button>
