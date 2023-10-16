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
                    <h3>Transaction</h3>
                    <p class="text-subtitle text-muted">
                        A role that can access all menus.
                    </p>
                </div>
                <div class="col-12 col-md-6 order-md-2 order-first">
                    <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a href="/admin">Dashboard</a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">
                                Transaction
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
                            <h4 class="card-title">Order</h4>
                        </div>
                        <div class="card-content">
                            <div class="card-body">
                                <form class="form" id="form-keranjang" method="post">
                                    @csrf
                                    <div class="row">
                                        <div class="col-md-6 col-12">
                                            <div class="form-group">
                                                <label for="id_user">Cashier</label>
                                                <input type="text" class="form-control"
                                                    value="{{ auth()->user()->name }}" readonly>
                                                <input type="hidden" id="id_user" name="id_user"
                                                    value="{{ auth()->user()->id }}">
                                            </div>
                                        </div>
                                        <div class="col-md-6 col-12">
                                            <div class="form-group">
                                                <label for="id_produk">Product</label>
                                                <select class="choices form-select" id="id_produk" name="id_produk">
                                                    <option selected disabled>Choose</option>
                                                    @foreach ($data_produk as $produk)
                                                        <option value="{{ $produk->id }}"
                                                            data-harga="{{ $produk->harga }}">{{ $produk->nama_produk }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-6 col-12">
                                            <div class="form-group">
                                                <label for="kuantitas">Quantity</label>
                                                <input type="number" id="kuantitas" class="form-control" name="kuantitas"
                                                    value="1">
                                            </div>
                                        </div>
                                        <div class="col-md-6 col-12">
                                            <div class="form-group">
                                                <label for="harga_jual">Price</label>
                                                <input type="text" id="harga_jual" class="form-control" name="harga_jual"
                                                    readonly>
                                            </div>
                                        </div>
                                        <div class="col-12 d-flex justify-content-end">
                                            <button type="submit" class="btn btn-primary me-1 mb-1">Add</button>
                                            <button type="reset" class="btn btn-light-secondary me-1 mb-1">Reset</button>
                                        </div>
                                    </div>
                                </form>
                                <div id="error-message" class="alert alert-danger" style="display: none;"></div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <div class="row">
            <div class="col-md-7 col-12">
                <section>
                    <div class="row match-height">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-header pb-0">
                                    <h4 class="card-title">List Items</h4>
                                </div>
                                <div class="card-content">
                                    <div class="card-body">
                                        <div class="table-responsive">
                                            <table class="table" id="table">
                                                <thead>
                                                    <tr>
                                                        {{-- <th>Product code</th> --}}
                                                        <th>Product</th>
                                                        <th>Price</th>
                                                        <th>Qty</th>
                                                        <th>Subtotal</th>
                                                        <th>Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody id="list-keranjang">

                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                </section>
            </div>

            <div class="col-md-5 col-12">
                <section>
                    <div class="row match-height">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-header pb-0">
                                    <h4 class="card-title">Payment</h4>
                                </div>
                                <div class="card-content">
                                    <div class="card-body">
                                        <form method="post" action="{{ route('checkout') }}">
                                            @csrf
                                            <div class="row" id="form-checkout">
                                                <div class="col-md-12 col-12">
                                                    <div class="form-group">
                                                        <label for="tanggal_transaksi">Transaction date</label>
                                                        <input type="text" id="tanggal_transaksi" class="form-control"
                                                            value="{{ now() }}" name="tanggal_transaksi" readonly>
                                                    </div>
                                                </div>
                                                <div class="col-md-12 col-12">
                                                    <div class="form-group">
                                                        <label for="total_harga">Total price</label>
                                                        <input type="number" id="total-harga" class="form-control"
                                                            name="total_harga" readonly>
                                                    </div>
                                                </div>

                                                <div class="col-md-12 col-12">
                                                    <div class="form-group">
                                                        <label for="pay">Pay</label>
                                                        <input type="number" id="pay" class="form-control"
                                                            name="pay" required>
                                                    </div>
                                                </div>

                                                <div class="col-md-12 col-12">
                                                    <div class="form-group">
                                                        <label for="cashback">Cashback</label>
                                                        <input type="number" id="cashback" class="form-control"
                                                            name="cashback" readonly>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-12 d-flex justify-content-end">
                                                <button type="submit" id="checkout-button"
                                                    class="btn btn-primary me-1 mb-1">Pay</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                </section>
            </div>
        </div>


        <script src="https://code.jquery.com/jquery-3.7.1.min.js"
            integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>

        <script>
            $(document).ready(function() {
                $('#id_produk').on('change', function() {
                    const id_produk = $(this).val();
                    const produk = @json($data_produk);
                    const harga_produk = produk.find(item => item.id === parseInt(id_produk))?.harga_jual;

                    if (!isNaN(harga_produk)) {
                        $('#harga_jual').val(harga_produk);
                    } else {
                        $('#harga_jual').val('');
                    }
                });
            });

            $(document).ready(function() {
                $('#form-keranjang').on('submit', function(event) {
                    event.preventDefault();
                    const produk = @json($data_produk);
                    const id_produk = $('#id_produk').val();
                    const kuantitas = $('#kuantitas').val();
                    const harga_produk = parseFloat($('#harga_jual').val());
                    const nama_produk = $('#id_produk option:selected').text();
                    const id_user = $('#id_user').val();
                    const tanggal_transaksi = $('#tanggal_transaksi').val();
                    const kode_produk = produk.find(item => item.id === parseInt(id_produk))?.kode_produk;

                    const subtotal = harga_produk * kuantitas;

                    $.ajax({
                        type: 'POST',
                        url: '{{ route('tambahKeKeranjang') }}',
                        data: {
                            _token: '{{ csrf_token() }}',
                            id_produk: id_produk,
                            kuantitas: kuantitas,
                            total_harga: subtotal,
                            id_user: id_user,
                            tanggal_transaksi: tanggal_transaksi,
                        },
                        success: function(response) {
                            const itemKeranjang =
                                `<tr>
                                    <td>${nama_produk}</td>
                                    <td>${harga_produk}</td>
                                    <td>${kuantitas}</td>
                                    <td>${subtotal}</td>
                                    <td>
                                        <button type="button" class="btn btn-sm btn-primary col-12 mb-1" data-bs-toggle="modal" data-bs-target="#editModal{{ $produk->id }}">Edit</button>

                                        <button type="button" class="btn btn-sm btn-danger col-12 mb-1" data-bs-toggle="modal" data-bs-target="#deleteModal{{ $produk->id }}">Delete</button>
                                    </td>
                                </tr>`;
                            $('#list-keranjang').append(itemKeranjang);

                            const input_checkout =
                                `
                            <input type="text" name="id_produk[]" value="${id_produk}">
                            <input type="text" name="harga_jual[]" value="${harga_produk}">
                            <input type="text" name="kuantitas[]" value="${kuantitas}">
                            <input type="text" name="subtotal[]" value="${subtotal}">
                            <input type="text" name="id_user" value="{{ auth()->user()->id }}">
                            `;
                            $('#form-checkout').append(input_checkout);

                            const total_harga = parseFloat($('#total-harga').val());
                            if (!isNaN(total_harga)) {
                                const new_total_harga = total_harga + subtotal;
                                $('#total-harga').val(new_total_harga);
                                // $('#payment_total_harga').val(new_total_harga);
                            } else {
                                $('#total-harga').val(subtotal);
                                // $('#payment_total_harga').val(subtotal);
                            }

                            $('#payment_id_produk').val(id_produk);
                            $('#payment_id_user').val(id_user);
                            $('#payment_kuantitas').val(kuantitas);

                            $('#id_produk').val('');
                            $('#kuantitas').val('');
                            $('#harga').val('');
                        },
                        error: function(xhr, status, error) {
                            console.log("Error: " + error);
                        }
                    });
                });


                $(document).ready(function() {
                    const subtotalInput = $('#total-harga');
                    const payInput = $('#pay');
                    const changingMoneyInput = $('#cashback');

                    subtotalInput.on('input', calculateChange);
                    payInput.on('input', calculateChange);

                    function calculateChange() {
                        const subtotal = parseFloat(subtotalInput.val()) || 0;
                        const pay = parseFloat(payInput.val()) || 0;
                        const changingMoney = pay - subtotal;

                        changingMoneyInput.val(changingMoney);
                    }
                });

            });
        </script>
    @endsection
