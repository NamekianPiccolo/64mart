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
                    <h3>Products</h3>
                    <p class="text-subtitle text-muted">
                        A list of products
                    </p>
                </div>
                <div class="col-12 col-md-6 order-md-2 order-first">
                    <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a href="/admin">Dashboard</a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">
                                Products
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
                            <h4 class="card-title">Add Product</h4>
                        </div>
                        <div class="card-content">
                            <div class="card-body">
                                <form class="form" action="{{ route($role . '.produk.store') }}" method="post">
                                    @csrf
                                    <div class="row">
                                        <div class="col-md-6 col-12">
                                            <div class="form-group">
                                                <label for="nama_produk">Product name</label>
                                                <input type="text" id="nama_produk" class="form-control"
                                                    placeholder="Product name" name="nama_produk">
                                            </div>
                                        </div>
                                        <div class="col-md-6 col-12">
                                            <div class="form-group">
                                                <label for="id_kategori">Category</label>
                                                <select class="choices form-select" name="id_kategori">
                                                    @foreach ($data_kategori as $kategori)
                                                        <option value="{{ $kategori->id }}">{{ $kategori->nama_kategori }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-md-6 col-12">
                                            <div class="form-group">
                                                <label for="harga_beli">Purchase Price</label>
                                                <input type="text" id="harga_beli" class="form-control"
                                                    placeholder="Price" name="harga_beli">
                                            </div>
                                        </div>
                                        <div class="col-md-6 col-12">
                                            <div class="form-group">
                                                <label for="harga_jual">Selling Price</label>
                                                <input type="text" id="harga_jual" class="form-control"
                                                    placeholder="Price" name="harga_jual">
                                            </div>
                                        </div>
                                        <div class="col-md-6 col-12">
                                            <div class="form-group">
                                                <label for="stok">Stock</label>
                                                <input type="number" id="stok" class="form-control"
                                                    placeholder="Stock" name="stok">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
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
                    <h5 class="card-title">Product Table</h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table" id="table1">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Product code</th>
                                    <th>Product name</th>
                                    <th>Purchace price</th>
                                    <th>Selling price</th>
                                    <th>Category</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($data_produk as $i => $produk)
                                    <tr>
                                        <td>{{ $i + 1 }}</td>
                                        <td>{{ $produk->kode_produk }}</td>
                                        <td>{{ $produk->nama_produk }}</td>
                                        <td><span class="harga" data-harga="{{ $produk->harga_beli }}"></span></td>
                                        <td><span class="harga" data-harga="{{ $produk->harga_jual }}"></span></td>
                                        <td>
                                            @foreach ($data_kategori as $kategori)
                                                @if ($produk->id_kategori == $kategori->id)
                                                    {{ $kategori->nama_kategori }}
                                                @endif
                                            @endforeach
                                        </td>
                                        <td>
                                            <button type="button" class="btn btn-sm btn-primary col-12 mb-1"
                                                data-bs-toggle="modal"
                                                data-bs-target="#editModal{{ $produk->id }}">Edit</button>

                                            <button type="button" class="btn btn-sm btn-danger col-12 mb-1"
                                                data-bs-toggle="modal"
                                                data-bs-target="#deleteModal{{ $produk->id }}">Delete</button>
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
        @foreach ($data_produk as $produk)
            <div class="modal fade" id="editModal{{ $produk->id }}" tabindex="-1" role="dialog"
                aria-labelledby="editModalLabel{{ $produk->id }}" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title" id="editModalLabel{{ $produk->id }}">Edit Category</h4>
                            <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                                <i data-feather="x"></i>
                            </button>
                        </div>
                        <form action="{{ route($role . '.produk.update', $produk->id) }}" method="post">
                            @csrf
                            @method('PUT')
                            <div class="modal-body">
                                <label for="nama_produk">Product name</label>
                                <div class="form-group">
                                    <input id="nama_produk" name="nama_produk" type="text" placeholder="Product name"
                                        class="form-control" value="{{ $produk->nama_produk }}">
                                </div>

                                <label for="id_kategori">Category</label>
                                <div class="form-group">
                                    <select class="choices form-select" name="id_kategori">
                                        @foreach ($data_kategori as $kategori)
                                            <option value="{{ $kategori->id }}"
                                                @if ($produk->id_kategori == $kategori->id) selected @endif>
                                                {{ $kategori->nama_kategori }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <label for="harga">Price</label>
                                <div class="form-group">
                                    <input type="text" id="harga" class="form-control" placeholder="Price"
                                        name="harga" value="{{ $produk->harga }}">
                                </div>

                                <label for="deskripsi" class="form-label">Description Product</label>
                                <div class="form-group mb-3">
                                    <textarea class="form-control" id="deskripsi" name="deskripsi" rows="3">{{ $produk->deskripsi }}</textarea>
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

            <div class="modal fade" id="deleteModal{{ $produk->id }}" tabindex="-1" role="dialog"
                aria-labelledby="deleteModalLabel{{ $produk->id }}" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalCenterTitle">Delete Product
                            </h5>
                            <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                                <i data-feather="x"></i>
                            </button>
                        </div>
                        <div class="modal-body">
                            <p>
                                Are you sure you want to delete this product?
                            </p>
                            <p>
                                Product name : {{ $produk->nama_produk }}
                            </p>
                            <p>
                                Category : @foreach ($data_kategori as $kategori)
                                    @if ($produk->id_kategori == $kategori->id)
                                        {{ $kategori->nama_kategori }}
                                    @endif
                                @endforeach
                            </p>
                            <p>
                                Price : {{ $produk->harga }}
                            </p>
                            <p>
                                Description : {{ $produk->deskripsi }}
                            </p>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-light-secondary" data-bs-dismiss="modal">
                                <i class="bx bx-x d-block d-sm-none"></i>
                                <span class="d-none d-sm-block">Close</span>
                            </button>

                            <form action="{{ route($role . '.produk.destroy', $produk->id) }}" method="POST">
                                @csrf
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
