<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use DB;
use Carbon\Carbon;

use GuzzleHttp\Client;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function userHome()
    {
        $barangAvaibles = DB::table('crudBarang')->orderBy('id_produk', 'asc')->simplePaginate(10);


        return view('home',compact('barangAvaibles'));
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function stafHome()
    {
        $barangAvaibles = DB::table('crudBarang')->orderBy('id_produk', 'asc')->simplePaginate(10);


        return view('home',compact('barangAvaibles'));
    }
    public function searchBarang(Request $request)
    {   $query = $request->querySearch;
        $barangAvaibles = DB::table('crudBarang')->where('nama_produk', 'LIKE',"%$query%")->get();
        //dd(count($barangAvaibles));
       
       
        $data = [
            'date' => Carbon::now()->format('Y-m-d H:i:s'),
            'barangsearch' => $query,
            // Add other data fields as needed
        ];

        // Make the POST request
        $client = new Client();
        $response = $client->post('http://localhost:9200/search/_doc/', [
            'json' => $data,
        ]);

        // Handle the response as needed
        $statusCode = $response->getStatusCode();
        $responseData = json_decode($response->getBody(), true);

       

        return view('searchBarang',compact('barangAvaibles'));
    }
    public function createElasticSearch(Request $request)
    {   

        // Make the POST request
        $client = new Client();
        $response = $client->put('http://localhost:9200/search', [
            
        ]);

        // Handle the response as needed
        $statusCode = $response->getStatusCode();
        $responseData = json_decode($response->getBody(), true);

        return $responseData;

        //return view('home',compact('barangAvaibles'));
    }


    public function getLog(Request $request)
    {
        if(Auth::user()->role != 'admin')
        {return redirect("/")->with('message', 'you are not authorized');}
        // nembak api 
        $client = new Client();
        $response = $client->post('http://localhost:9200/search/_search', [
            
        ]);

        $statusCode = $response->getStatusCode();
        $responseData = json_decode($response->getBody(), true);
        $logAktivitass = $responseData['hits']['hits'];
      
        
        
        return view('logaktivitas',compact('logAktivitass'));

    }


    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    // public function adminHome()
    // {
    //     if(Auth::user()->role != 'admin')
    //     {return redirect("/")->with('message', 'you are not authorized');}
    //     $barangAvaibles = DB::table('crudBarang')->orderBy('id_produk', 'asc')->simplePaginate(10);


    //     return view('/',compact('barangAvaibles'));
    // }


    public function create(Request $request)
    {
        if(Auth::user()->role != 'admin' && Auth::user()->role != 'staf')
        {return redirect("/")->with('message', 'you are not authorized');}
        $validatedData = $request->validate([
            'nameProduk' => 'required|string',
            'harga' => 'required|numeric',
            'kategori' => 'required|string',
        ]);

        $inserDatabase =[
            'nama_produk' => $validatedData['nameProduk'],
            'harga' => $validatedData['harga'],
            'kategori' => $validatedData['kategori'],
        ];

        DB::table('crudBarang')->insert($inserDatabase);
        return redirect("/")->with('message', 'data added');;
    }


    public function delete($idBarang)
    {
        if(Auth::user()->role != "admin")
        {return redirect("/")->with('message', 'you are not authorized');}
        DB::table('crudBarang')->where('id_produk',$idBarang)->delete();
        return redirect("/")->with('message', 'barang terhapus');;;
    }


    public function update(Request $request)
    {
        if(Auth::user()->role != "admin" && Auth::user()->role != 'staf')
        {return redirect("/")->with('message', 'you are not authorized');}

        $validatedData = $request->validate([
            'nameProduk' => 'required|string',
            'harga' => 'required|numeric',
            'kategori' => 'required|string',
            'id' => 'required|numeric',
        ]);

        $insertDatabase =[
            'nama_produk' => $validatedData['nameProduk'],
            'harga' => $validatedData['harga'],
            'kategori' => $validatedData['kategori'],
        ];

        DB::table('crudBarang')->where('id_produk', $request->id)->update($insertDatabase);
        return redirect("/")->with('message', 'data updated');;
    }
}