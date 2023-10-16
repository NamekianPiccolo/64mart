@extends('layout/main');

@section('container')
    <header class="mb-3">
        <a href="#" class="burger-btn d-block d-xl-none">
            <i class="bi bi-justify fs-3"></i>
        </a>
    </header>

    <div class="page-heading">
        <div class="page-title">
            <div class="row">
                <div class="col-12 col-md-6 order-md-1 order-last">
                    <h3>Owners</h3>
                    <p class="text-subtitle text-muted">
                        A role that can access the list of goods, transaction details and reports.
                    </p>
                </div>
                <div class="col-12 col-md-6 order-md-2 order-first">
                    <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a href="/owner">Dashboard</a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">
                                Owners
                            </li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>

        @if (session('success'))
            <div class="alert alert-success alert-dismissible show fade">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @if (session('error'))
            <div class="alert alert-danger alert-dismissible show fade">
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <section id="multiple-column-form">
            <div class="row match-height">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header pb-0">
                            <h4 class="card-title">Add Owner</h4>
                        </div>
                        <div class="card-content">
                            <div class="card-body">
                                <form class="form" action="{{ route('users.store', 'owner') }}" method="post">
                                    @csrf
                                    <div class="row">
                                        <div class="col-md-6 col-12">
                                            <div class="form-group">
                                                <label for="name">Name</label>
                                                <input type="text" id="name" class="form-control" placeholder="Name"
                                                    name="name">
                                            </div>
                                        </div>
                                        <div class="col-md-6 col-12">
                                            <div class="form-group">
                                                <label for="username">Username</label>
                                                <input type="text" id="username" class="form-control"
                                                    placeholder="Username" name="username">
                                            </div>
                                        </div>
                                        <div class="col-md-6 col-12">
                                            <div class="form-group">
                                                <label for="email">Email</label>
                                                <input type="email" id="email" class="form-control"
                                                    placeholder="Email" name="email">
                                            </div>
                                        </div>

                                        <div class="col-md-6 col-12">
                                            <div class="form-group">
                                                <label for="role">Role</label>
                                                <input type="text" id="role" class="form-control" name="role"
                                                    value="owner" readonly>
                                            </div>
                                        </div>
                                        <div class="col-md-6 col-12">
                                            <div class="form-group">
                                                <label for="password">Password</label>
                                                <input type="password" id="password" class="form-control"
                                                    placeholder="Password" name="password">
                                            </div>
                                        </div>
                                        <div class="col-12 d-flex justify-content-end">
                                            <button type="submit" class="btn btn-primary me-1 mb-1">Submit</button>
                                            <button type="reset" class="btn btn-light-secondary me-1 mb-1">Reset</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Basic Tables start -->
        <section class="section">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title">Owner Table</h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table" id="table1">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Name</th>
                                    <th>Username</th>
                                    <th>Email</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($data_owner as $i => $owner)
                                    <tr>
                                        <td class="col-1">{{ $i + 1 }}</td>
                                        <td>{{ $owner->name }}</td>
                                        <td>{{ $owner->username }}</td>
                                        <td>{{ $owner->email }}</td>
                                        <td class="col-2">
                                            <button type="button" class="btn btn-sm btn-primary col-12 mb-1"
                                                data-bs-toggle="modal"
                                                data-bs-target="#editModal{{ $owner->id }}">Edit</button>
                                            <button type="button" class="btn btn-sm btn-danger col-12 mb-1"
                                                data-bs-toggle="modal"
                                                data-bs-target="#deleteModal{{ $owner->id }}">Delete</button>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </section>

        <!-- Modal untuk Edit -->
        @foreach ($data_owner as $owner)
            <div class="modal fade" id="editModal{{ $owner->id }}" tabindex="-1" role="dialog"
                aria-labelledby="editModalLabel{{ $owner->id }}" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title" id="editModalLabel{{ $owner->id }}">Edit Owner</h4>
                            <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                                <i data-feather="x"></i>
                            </button>
                        </div>
                        <form action="{{ route('users.update', $owner->id) }}" method="post">
                            @csrf
                            @method('PUT')
                            <div class="modal-body">
                                <label for="name">Name</label>
                                <div class="form-group">
                                    <input id="name" name="name" type="text" placeholder="Name"
                                        class="form-control" value="{{ $owner->name }}">
                                </div>

                                <label for="username">Username</label>
                                <div class="form-group">
                                    <input type="text" id="username" class="form-control" placeholder="username"
                                        name="username" value="{{ $owner->username }}">
                                </div>

                                <label for="email">Email</label>
                                <div class="form-group">
                                    <input type="email" id="email" class="form-control" placeholder="Email"
                                        name="email" value="{{ $owner->email }}">
                                </div>

                                <label for="role">Role</label>
                                <div class="form-group">
                                    <input type="text" id="role" class="form-control" name="role"
                                        value="owner" readonly>
                                </div>

                                <label for="password">Password</label>
                                <div class="form-group">
                                    <input type="password" id="password" class="form-control" placeholder="password"
                                        name="opsional">
                                </div>

                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-light-secondary" data-bs-dismiss="modal">
                                    <i class="bx bx-x d-block d-sm-none"></i>
                                    <span class="d-none d-sm-block">Close</span>
                                </button>
                                <button type="submit" class="btn btn-primary ms-1">
                                    <i class="bx bx-check d-block d-sm-none"></i>
                                    <span class="d-none d-sm-block">Save</span>
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <div class="modal fade" id="deleteModal{{ $owner->id }}" tabindex="-1" role="dialog"
                aria-labelledby="deleteModalLabel{{ $owner->id }}" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalCenterTitle">Delete owner
                            </h5>
                            <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                                <i data-feather="x"></i>
                            </button>
                        </div>
                        <div class="modal-body">
                            <p>
                                Are you sure you want to delete this owner?
                            </p>
                            <p>
                                Name : {{ $owner->name }}
                            </p>
                            <p>
                                Username : {{ $owner->username }}
                            </p>
                            <p>
                                Email : {{ $owner->email }}
                            </p>
                            <p>
                                Role : {{ $owner->role }}
                            </p>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-light-secondary" data-bs-dismiss="modal">
                                <i class="bx bx-x d-block d-sm-none"></i>
                                <span class="d-none d-sm-block">Close</span>
                            </button>

                            <form action="{{ route('users.destroy', $owner->id) }}" method="POST">
                                @csrf
                                <input type="text" value="owner" name="role" hidden>
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger ms-1">
                                    Delete
                                </button>
                            </form>


                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    @endsection
