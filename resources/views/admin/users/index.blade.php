@extends('layout.app')

@section('content')

@auth
@if(auth()->user()->role == 'admin') {{-- 🔒 HANYA ADMIN --}}

<div class="d-flex justify-content-between align-items-center mb-3">
    <h2>Kelola Anggota</h2>
    <a href="{{ route('admin.users.create') }}" class="btn btn-primary">Tambah Anggota</a>
</div>

<div class="card shadow-sm">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered table-striped">
                <thead class="table-dark text-center">
                    <tr>
                        <th width="50">No</th>
                        <th>Nama Lengkap</th>
                        <th>Username</th>
                        <th>Alamat</th>
                        <th>Role</th>
                        <th width="200">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($users as $user)
                        <tr>
                            <td class="text-center">{{ $loop->iteration }}</td>
                            <td>{{ $user->nama_lengkap }}</td>
                            <td>
                                <span class="badge bg-light text-dark border">
                                    {{ $user->username }}
                                </span>
                            </td>
                            <td>{{ $user->alamat ?? '-' }}</td>

                            <td class="text-center">
                                @if($user->role == 'admin')
                                    <span class="badge bg-danger">Admin</span>
                                @else
                                    <span class="badge bg-success">Siswa</span>
                                @endif
                            </td>

                            <td class="text-center">
                                <a href="{{ route('admin.users.edit', $user->id) }}" class="btn btn-warning btn-sm">
                                    Edit
                                </a>
                                
                                <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin ingin menghapus anggota ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm">
                                        Hapus
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center text-muted">
                                Belum ada data anggota.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

@else
    {{-- ❌ KALAU SISWA MASUK SINI --}}
    <div class="alert alert-danger">
        Kamu tidak punya akses ke halaman ini.
    </div>
@endif
@endauth

@endsection