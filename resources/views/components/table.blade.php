<div class="col-lg-12 grid-margin stretch-card">
  <div class="card">
    <div class="card-body">
      @isset($title)
      <h4 class="card-title">{{ $title }}</h4>
    @endisset

      @isset($description)
      <p class="card-description">{{ $description }}</p>
    @endisset

      <div class="table-responsive">
        <table class="table">
          {{ $slot }} {{-- Konten dari pemanggil komponen --}}
        </table>
      </div>
    </div>
  </div>
</div>