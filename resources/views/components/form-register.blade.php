<form action="{{ url('register') }}" method="POST">
    @csrf
    <div class="form-group">
      <label>NIK</label>
      <div class="input-with-icon">
        <input type="number" name="nik" id="NIK" class="form-control" placeholder="Masukkan NIK" maxlength="16" required>
        <i class="theme-cl ti-user"></i>
      </div>
    </div>
    <div class="form-group">
      <label>Nama Lengkap</label>
      <div class="input-with-icon">
        <input type="text" name="name" id="name" class="form-control" placeholder="Masukkan Nama Lengkap" required>
        <i class="theme-cl ti-user"></i>
      </div>
    </div>
    <div class="form-group">
      <label>Email</label>
      <div class="input-with-icon">
        <input type="email" name="email" id="email" class="form-control" placeholder="Masukkan Email" required>
        <i class="theme-cl ti-user"></i>
      </div>
    </div>
    <div class="form-group">
      <label>Username</label>
      <div class="input-with-icon">
        <input type="text" name="username" id="username" class="form-control" placeholder="Masukkan Username" required>
        <i class="theme-cl ti-user"></i>
      </div>
    </div>
    <div class="form-group">
      <label>Password</label>
      <div class="input-with-icon">
        <input type="password" name="password" id="password" class="form-control" placeholder="Masukkan Password" required>
        <i class="theme-cl ti-user"></i>
      </div>
    </div>
    <div class="form-group">
      <label>Re Password</label>
      <div class="input-with-icon">
        <input type="password" name="password_confirmation" id="password_confirmation" class="form-control" placeholder="Masukkan Password" required>
        <i class="theme-cl ti-user"></i>
      </div>
    </div>
    <div class="form-groups">
      <button type="submit" class="btn btn-primary theme-bg full-width">Daftar</button>
    </div>
  </form>