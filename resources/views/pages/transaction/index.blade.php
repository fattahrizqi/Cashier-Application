@extends('layouts.main')

@section('main-section')
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1>Transaksi</h1>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <a href="{{ route('transaction.create') }}" >+ Buat transaksi baru</a>
          </ol>
        </div>
      </div>
    </div><!-- /.container-fluid -->
  </section>

  <!-- Main content -->
  <section class="content">

    <!-- Default box -->
    <div class="card">
      <div class="card-header">
        <h3 class="card-title">Transaksi</h3>

        <div class="card-tools">
          <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
            <i class="fas fa-minus"></i>
          </button>
          <button type="button" class="btn btn-tool" data-card-widget="remove" title="Remove">
            <i class="fas fa-times"></i>
          </button>
        </div>
      </div>
      <div class="card-body p-0">
        <table class="table table-striped projects">
            <thead>
                <tr>
                    <th>
                        #
                    </th>
                    <th>
                        No transaksi
                    </th>
                    <th>
                        Nama produk
                    </th>
                    <th>
                        Total harga
                    </th>
                    <th>
                        Nominal bayar
                    </th>
                    <th>
                        Kembali
                    </th>
                    <th>
                        Aksi
                    </th>
                </tr>
            </thead>
            <tbody>
                @foreach ($transactions as $transaction)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>
                        {{ $transaction->num }}
                    </td>
                    <td>
                        @foreach ($transaction->item as $item)
                        <li>{{ $item->product->name . ' - Rp. ' . $item->product->price }}</li>
                    @endforeach
                    </td>
                    <td>
                        {{ $transaction->total }}
                    </td>
                    <td>
                        {{ $transaction->paid }}
                    </td>
                    <td>
                        {{ $transaction->return }}
                    </td>
                    <td>
                      <form action="/generateInvoice" method="post">
                        @csrf
                        <input type="hidden" name="num" value="{{ $transaction->num }}">
                        <button type="submit">Cetak struk</button>
                      </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
      </div>
      <!-- /.card-body -->
    </div>
    <!-- /.card -->

  </section>
  <!-- /.content -->
</div>
    
@endsection