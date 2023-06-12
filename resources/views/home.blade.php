@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            
            <div class="card">
                <div class="card-header">dashboard</div>
                <br>

                @if(session()->has('message'))
                <div class="row justify-content-center d-flex">
                    <div class="col-8 ">

                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session()->get('message') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    </div>
                </div>
                @endif
                @if ($errors->any())
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        format data tidak sesuai
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                    @if (Auth::check() && Auth::user()->role == 'admin')
                        <a href="/logaktivitas"> <button type="button" class="btn btn-danger">log aktivitas pencarian barang </button> </a>
                        <br>
                        <br>
                    @endif
                    <div class="row">
                        <div class="col-4">
                            <form action="/searchBarang " method="GET" >
                                @csrf
                                    <div class="input-group">
                                        <input type="search" name ="querySearch" class="form-control rounded" placeholder="Search" aria-label="Search" aria-describedby="search-addon" />
                                        <button type="submit" submit class="btn btn-outline-primary">cari barang </button>
                                    </div>
                            </form>
                        </div>
                    </div>
                    <br>
                    <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="staticBackdropLabel">Modal title</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                            <div class="modal-body">
                                <form action="/postBarang" method="POST">
                                    @csrf
                                    <div class="form-group">
                                        <label for="name">Nama produk</label>
                                        <input type="text" name="nameProduk" id="namaProduk" class="form-control" placeholder="masukan nama produk">
                                    </div>
                                    <div class="form-group">
                                        <label for="harga">harga</label>
                                        <input type="number" name="harga" id="harga" class="form-control" placeholder="masukan harga">
                                    </div>
                                    <div class="form-group">
                                        <label for="kategori">kategori</label>
                                        <input type="text" name="kategori" id="kategori" class="form-control" placeholder="masukan kategori">
                                    </div>
                                    <br>
                                    </div>
                                <div class="modal-footer">
                                    <button type="submit" class="btn btn-primary">buat data barang baru</button>
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                </div>
                                </form>
                            </div>
                        </div>
                    </div>
                            @if(Auth::check() && (Auth::user()->role == 'admin' || Auth::user()->role == 'staf'))
                            <div class="d-flex justify-content-between">
                                <h2>list barang yang tersedia</h2>
                                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#staticBackdrop">
                                tambah barang
                                </button>
                            </div>
                            @endif
                            <br>
 
                            
                        
                    <div class="col-12">
                        <table class="table table-hover">
                            <thead class="table-primary">
                               <tr>
                                <td scope="col">NO</td>
                                <td scope="col">nama produk </td>
                                <td scope="col">kategori</td>
                                <td scope="col">harga </td>
                                @if(Auth::check() &&( Auth::user()->role == 'admin' || Auth::user()->role == 'staf'))
                                <td scope="col">action </th>
                                </tr>
                                @endif
                            </thead>
                            <tbody>
                                <!-- foreach setiap data yang ada di database -->
                            @foreach ($barangAvaibles as $barangAvaible)
                                <tr>
                                    <td >{{$barangAvaible->id_produk}}</td>
                                    <td >{{$barangAvaible->nama_produk}}</td>
                                    <td >{{$barangAvaible->kategori}}</td>
                                    <td >{{$barangAvaible->harga}}</td>
                                    @if(Auth::check() )
                                    <td >
                                        <div class="d-inline-flex p-2">
                                        @if(Auth::user()->role == 'admin')
                                           <!-- delete data  -->
                                        <button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#deleteModal{{ $barangAvaible->id_produk }}">Delete</button> &nbsp;
                                        @endif
                                        <button type="button" data-bs-toggle="modal" data-bs-target="#updateModal{{ $barangAvaible->id_produk }}" class="btn btn-warning">update</button>
                                        </div>
                                    </td>
                                    @endif
                                </tr>
                                @if(Auth::check() && Auth::user()->role == 'admin' )
                                <!-- modal untuk menghapus data -->
                                <div class="modal fade" id="deleteModal{{ $barangAvaible->id_produk }}" tabindex="-1" aria-labelledby="deleteModalLabel{{ $barangAvaible->id_produk }}" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="deleteModalLabel{{ $barangAvaible->id_produk }}">hapus barang</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                           <div class="modal-body">
                                                <p>apakah anda yakin ingin menghapus barang ini?</p>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                                <a class="btn btn-danger" href="/deleteBarang/{{$barangAvaible->id_produk}}" role="button">delete</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @endif
                                @if(Auth::check() && (Auth::user()->role == 'admin' || Auth::user()->role == 'staf'))
                                <!-- modal untuk mengedit data  -->
                                
                                <div class="modal fade" id="updateModal{{ $barangAvaible->id_produk }}" tabindex="-1" aria-labelledby="updateModal{{ $barangAvaible->id_produk }}" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="updateModal{{ $barangAvaible->id_produk }}">edit barang</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                           <div class="modal-body">
                                                <form action="updateBarang/" method="POST">
                                                    @csrf
                                                    <input type="hidden" name="id" value="{{ $barangAvaible->id_produk  }}">
                                                    <div class="form-group">
                                                        <label for="name">Nama produk</label>
                                                        <input type="text" name="nameProduk" id="namaProduk" class="form-control" placeholder="masukan nama produk">
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="harga">harga</label>
                                                        <input type="number" name="harga" id="harga" class="form-control" placeholder="masukan harga">
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="kategori">kategori</label>
                                                        <input type="text" name="kategori" id="kategori" class="form-control" placeholder="masukan kategori">
                                                    </div>
                                                    <br>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel
                                                </button>
                                                <button type="submit" class="btn btn-primary">update barang</button>
                                            </form>
                                            </div>
                                            
                                        </div>
                                    </div>
                                </div>
                                @endif
                            @endforeach
                          
                            
                                
                                
                                
                            
                            
                            
                            </tbody>
                            
                        </table>
                        
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
