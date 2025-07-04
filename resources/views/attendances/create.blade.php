<form action="{{ route('admin.attendances.store') }}" method="POST">
  @csrf
  <div class="form-group">
    <label for="user_id">Karyawan</label>
    <select name="user_id" class="form-control">
      @foreach($users as $user)
      <option value="{{ $user->id }}">{{ $user->name }}</option>
    @endforeach
    </select>
  </div>

  <div class="form-group mt-3">
    <label for="date">Tanggal</label>
    <input type="date" name="date" class="form-control">
  </div>

  <div class="form-group mt-3">
    <label for="status">Status</label>
    <select name="status" class="form-control">
      <option value="hadir">Hadir</option>
      <option value="sakit">Sakit</option>
      <option value="izin">Izin</option>
      <option value="cuti">Cuti</option>
      <option value="alpa">Alpa</option>
    </select>
  </div>

  <button type="submit" class="btn btn-primary mt-4">Simpan</button>
</form>