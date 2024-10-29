@extends('layouts.dashboard')

@section('content')
<div>
    <div class="d-flex my-2 align-items-center">
        <h4 class="m-0 flex-grow-1" style="font-family: NunitoSans-ExtraBold; color: var(--title-color);">
            Daftar Assessment</h4>
        <a href="{{ route('student_assessment.create') }}" class="btn btn-primary">
            <i class="uil uil-plus me-2"></i>Tambah Assessment
        </a>
    </div>

    <div class="card border-0 shadowNavbar" id="panel">
        <div class="card-body">
            @if (session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif

            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nama Assessment</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    {{-- @foreach ($assessments as $assessment) --}}
                        <tr>
                            {{-- <td>{{ $assessment->id }}</td>
                            <td>{{ $assessment->name }}</td>
                            <td>
                                <a href="{{ route('assessment.edit', $assessment->id) }}" class="btn btn-warning btn-sm">
                                    Edit
                                </a>
                                <form action="{{ route('assessment.destroy', $assessment->id) }}" method="POST" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Apakah Anda yakin ingin menghapus?')">Hapus</button>
                                </form>
                            </td> --}}
                        </tr>
                    {{-- @endforeach --}}
                </tbody>
            </table>

            {{-- Pagination links --}}
            {{-- {{ $assessments->links() }} --}}
        </div>
    </div>
</div>
@endsection
