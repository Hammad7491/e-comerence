@extends('layouts.app')

@push('styles')
<style>
  /* Header gradient */
  .bg-gradient-primary {
    background: linear-gradient(45deg, #0d6efd, #6610f2) !important;
  }

  /* “Light primary” button */
  .btn-light-primary {
    color: #0d6efd;
    background-color: #f0f5ff;
    border: 1px solid #0d6efd;
  }
  .btn-light-primary:hover {
    background-color: #e2ecff;
  }

  /* Striped rows */
  .table-striped > tbody > tr:nth-of-type(odd) {
    background-color: rgba(102,16,242,0.05);
  }

  /* Stronger table header line */
  .table thead th {
    border-bottom-width: 2px;
  }

  /* Custom badge color */
  .badge-role {
    background: #6610f2;
  }

  /* ---------- RESPONSIVE ENHANCEMENTS ---------- */

  /* Keep table scroll on smaller screens but also provide mobile “stacked” layout */
  .table-responsive {
    overflow-x: auto;
    -webkit-overflow-scrolling: touch;
  }

  /* Compact the header on narrow viewports */
  @media (max-width: 767.98px) {
    .card-header h4 {
      font-size: 1.05rem;
    }
    .card-header {
      gap: .5rem;
      row-gap: .75rem;
      flex-wrap: wrap;
    }
    .card-header .btn {
      padding: .375rem .6rem;
      font-size: .85rem;
    }
  }

  /* On very small phones, stack header title over button and make the button full width */
  @media (max-width: 575.98px) {
    .card-header {
      flex-direction: column;
      align-items: stretch;
    }
    .card-header h4 {
      text-align: center;
      margin-bottom: .25rem !important;
    }
    .card-header .btn {
      width: 100%;
      justify-content: center;
    }
  }

  /* ---------- Mobile-stacked table (labels + values) ---------- */
  /* Apply to .table.mobile-stacked only so desktops keep classic table */
  @media (max-width: 575.98px) {
    .table.mobile-stacked thead {
      display: none;
    }
    .table.mobile-stacked tbody tr {
      display: block;
      background: #fff;
      border: 1px solid rgba(0,0,0,.06);
      border-radius: .75rem;
      padding: .75rem .9rem;
      margin-bottom: .75rem;
      box-shadow: 0 6px 16px rgba(13, 110, 253, .06);
    }
    .table.mobile-stacked tbody td {
      display: flex;
      align-items: center;
      justify-content: space-between;
      gap: .75rem;
      padding: .35rem 0;
      border: 0 !important;
    }
    .table.mobile-stacked tbody td::before {
      content: attr(data-label);
      flex: 0 0 42%;
      max-width: 52%;
      color: #6c757d;
      font-weight: 700;
      font-size: .84rem;
      letter-spacing: .01em;
    }
    /* Make long text wrap nicely */
    .table.mobile-stacked tbody td > * {
      text-align: right;
      max-width: 58%;
      word-break: break-word;
      white-space: normal;
    }
    /* Badges smaller on mobile */
    .badge-role {
      font-size: .75rem;
      padding: .35em .55em;
    }
    /* Actions row becomes two buttons side-by-side, then wrap if needed */
    .stack-actions {
      display: flex;
      justify-content: flex-end;
      gap: .5rem;
      width: 100%;
    }
    .stack-actions .btn {
      flex: 1 1 48%;
      min-width: 0;
    }
  }
</style>
@endpush

@section('content')
<div class="container my-5">
  <div class="card shadow border-0 rounded-3">
    <div class="card-header bg-gradient-primary text-white d-flex justify-content-between align-items-center">
      <h4 class="mb-0">
        <i class="bi bi-people-fill me-2"></i>
        Users List
      </h4>
      <a href="{{ route('admin.users.create') }}" class="btn btn-light-primary btn-sm d-flex align-items-center">
        <i class="bi bi-person-plus-fill me-1"></i>
        Add New User
      </a>
    </div>

    <div class="card-body p-4">
      @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show d-flex align-items-center" role="alert">
          <i class="bi bi-check-circle-fill me-2 fs-4"></i>
          <div>{{ session('success') }}</div>
          <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert"></button>
        </div>
      @endif

      <div class="table-responsive">
        <!-- Add `mobile-stacked` class so the CSS can transform this table on phones -->
        <table class="table table-striped table-hover align-middle mb-0 mobile-stacked">
          <thead class="table-light">
            <tr>
              <th><i class="bi bi-person-fill me-1"></i>Name</th>
              <th><i class="bi bi-envelope-fill me-1"></i>Email</th>
              <th><i class="bi bi-shield-lock-fill me-1"></i>Role</th>
              <th class="text-center"><i class="bi bi-gear-fill me-1"></i>Actions</th>
            </tr>
          </thead>
          <tbody>
            @foreach($users as $user)
              <tr>
                <td data-label="Name" class="fw-semibold">{{ $user->name }}</td>
                <td data-label="Email">{{ $user->email }}</td>
                <td data-label="Role">
                  <span class="badge badge-role text-white rounded-pill">
                    {{ ucfirst($user->role) }}
                  </span>
                </td>
                <td data-label="Actions" class="text-center">
                  <!-- Normal desktop actions -->
                  <div class="d-none d-sm-inline-block">
                    <a
                      href="{{ route('admin.users.edit', $user) }}"
                      class="btn btn-sm btn-outline-primary me-1"
                      title="Edit"
                    >
                      <i class="bi bi-pencil-fill"></i>
                    </a>
                    <form
                      action="{{ route('admin.users.destroy', $user) }}"
                      method="POST"
                      class="d-inline"
                    >
                      @csrf
                      @method('DELETE')
                      <button
                        type="submit"
                        class="btn btn-sm btn-outline-danger"
                        onclick="return confirm('Are you sure you want to delete this user?')"
                        title="Delete"
                      >
                        <i class="bi bi-trash-fill"></i>
                      </button>
                    </form>
                  </div>

                  <!-- Mobile stacked actions -->
                  <div class="stack-actions d-sm-none">
                    <a
                      href="{{ route('admin.users.edit', $user) }}"
                      class="btn btn-outline-primary btn-sm"
                      title="Edit"
                    >
                      <i class="bi bi-pencil-fill me-1"></i>Edit
                    </a>
                    <form
                      action="{{ route('admin.users.destroy', $user) }}"
                      method="POST"
                    >
                      @csrf
                      @method('DELETE')
                      <button
                        type="submit"
                        class="btn btn-outline-danger btn-sm w-100"
                        onclick="return confirm('Are you sure you want to delete this user?')"
                        title="Delete"
                      >
                        <i class="bi bi-trash-fill me-1"></i>Delete
                      </button>
                    </form>
                  </div>
                </td>
              </tr>
            @endforeach
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>
@endsection
