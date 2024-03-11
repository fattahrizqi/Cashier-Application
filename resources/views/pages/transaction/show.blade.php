@extends('layouts.main')

@section('main-section')
<div class="wrapper">
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
      <!-- Content Header (Page header) -->
      <section class="content-header">
        <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
            <h1>Transaction</h1>
            </div>
            <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="#">Home</a></li>
                <li class="breadcrumb-item active">Transaction</li>
            </ol>
            </div>
        </div>
        </div><!-- /.container-fluid -->
        <form action="{{ route('transaction.destroy', $transaction->num) }}" method="post" class="ml-2">
            @csrf
            @method('delete')
    
            <button type="submit" style="background-color: red; color:white;"
                onclick="return confirm('Batalkan transaksi?')">Batal</button>
        </form>
    </section>
      <!-- /.content-header -->
  
      <!-- Main content -->
      <section class="content">
      <div class="container-fluid">
        <div class="card">
          <div class="card-header">
              <h6>Produk</h6>
            {{-- <div class="row"> --}}
              <form action="{{ route('transaction.update', $transaction->num) }}" method="post" class="row ">
                @csrf
                @method('PATCH')
                <input type="hidden" name="addProduct">
                <div class="col-7">
                    <div class="form-group">
                        <select class="form-control select2" name="product" id="product" style="width: 100%;">
                          <option disabled selected>Tambah produk</option>
                        @foreach ($products as $product)
                            <option value="{{ $product->id }}">{{ $product->name }}</option>
                        @endforeach
                        </select>
                      </div>
                </div>

                <div class="col-3"> 
                  <div class="form-group">
                    <input type="number" class="form-control" name="sum" id="sum" placeholder="Jumlah">
                  </div>
                </div>
                  
                <div class="col-2">
                  <div class="form-group">
                    <button type="submit" id="tambah" class="btn btn-success w-100" >Tambah</button>
                  </div>
                </div>
              </form>
            {{-- </div> --}}
          </div>

          <div class="card-body row">
            <div class="col-9 flex-grow">
                <table class="table w-100 table-bordered table-hover" id="transaksi">
                  <thead>
                    <tr>
                      <th>No</th>
                      <th>Kode Produk</th>
                      <th>Nama Produk</th>
                      <th>Harga</th>
                      <th>Aksi</th>
                    </tr>
                  </thead>
                  <tbody>
                    @foreach ($transaction->item as $item)
                    <tr>

                      <td>{{ $loop->iteration }}</td>
                      <td>{{ $item->product_code }}</td>
                      <td>{{ $item->product->name }}</td>
                      <td>{{ $item->product->price }}</td>
                      <td>
                        <form action="{{ route('transaction.update', $transaction->num) }}" method="post">
                          @csrf
                          @method('patch')
      
                          <input type="hidden" name="deleteProduct">
                          <input type="hidden" name="id" value="{{ $item->id }}">
      
                          <button type="submit" style="background-color: red; color:white;">Hapus</button>
                      </form>
                      </td>
                    </tr>
                    @endforeach
                  </tbody>
                </table>
            </div>

            <div class="col-3 d-flex flex-column align-items-end text-right">
              <div class="border rounded w-100 p-2">
                <div class="mb-0">
                  <b class="mr-2">Total</b> <span id="nota"></span>
                </div>
                <span id="total" class="text-xl text-danger">Rp. {{ $transaction->total != null ? $transaction->total : '0' }}</span>
              </div>
              <form action="{{ route('transaction.update', $transaction->num) }}" method="post" class="w-100">
                @csrf
                @method('PATCH')
                <input type="hidden" name="paidTransaction">
                <div class="form-group mt-4">
                    <input type="number" class="form-control" placeholder="Nominal bayar" name="paid" id="paid-input" min="{{ $transaction->total }}">
                  </div>
                  <div class="form-group mt-2">
                    {{-- shortcut --}}
                    <div class="paid-shortcuts" id="paid-shortcuts">
                      <p class="btn btn-warning" onclick="inputPaid(5000)">5</p>
                      <p class="btn btn-warning" onclick="inputPaid(10000)">10</p>
                      <p class="btn btn-warning" onclick="inputPaid(20000)">20</p>
                      <p class="btn btn-warning" onclick="inputPaid(50000)">50</p>
                      <p class="btn btn-warning" onclick="inputPaid(100000)">100</p>
                    </div>

                    <button type="submit" id="tambah" class="btn btn-success">Bayar</button>
                  </div>
              </form>

            </div>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->
  
  </div>
@endsection

@section('script')
  <script>
    const paidInput = document.getElementById('paid-input')
    const paidShortcuts = document.getElementById('paid-shortcuts')

    function inputPaid(value){
      paidInput.value = value;
    }
  </script>
    
@endsection