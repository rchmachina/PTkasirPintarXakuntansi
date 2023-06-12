@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            
            <div class="card">
                <div class="card-header">dashboard</div>
                <br>

                <div class="card-body">


                        <a href="/"> <button type="button" class="btn btn-danger">back to home </button> </a>
                        <br>
                        <br>
                

                
                            
                        
                <div class="col-12">
                    <table class="table table-hover">
                        <thead class="table-primary">
                            <tr>
                            <td scope="col">NO</td>
                            <td scope="col">searching time</td>
                            <td scope="col">search </td>
                            
                        </thead>
                        <tbody>
                        @php
                            $row = 0;
                        @endphp
                            <!-- foreach setiap data yang ada di elasticsearch -->
                        @foreach ($logAktivitass as $logAktivitas)
                            <tr> 
                                <td >{{$row += 1}}</td>
                                <td >{{$logAktivitas['_source']['date']}}</td>
                                <td >{{$logAktivitas['_source']['barangsearch']}}</td>
                            

                            </tr>
                            {{-- @endforeach --}}
                        @endforeach
                                    
                        </tbody>
                    </table>
                </div>
                

                {{-- <div class="d-flex justify-content-center">
                            {{ $barangAvaibles->links() }}
                            <br>
                            <br>
                </div> --}}
            </div>
        </div>
    </div>
</div>
@endsection
