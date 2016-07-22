<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;

use App\Http\Requests;

use App\Crud;

class CrudController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $datas = Crud::orderBy('id', 'DESC')->paginate(3);
        return view('show')->with('datas', $datas);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('add');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        
      $this->validate($request, [
                'judul' => 'required',
                'isi' => 'required'
            ]);

            $tambah = new Crud();

             // Disini proses generate uuid
            $tambah->id_crud = Uuid::generate(4);


            $tambah->judul = $request['judul'];

            //Judul jadiin slug
            $tambah->slug_judul = Str::slug($request->get('judul'));

            $tambah->isi = $request['isi'];

            //Proses mendapatkan judul dan memindahkan gambar ke folder
            $file     = $request->file('gambar');
            $fileName = $file->getClientOriginalName();
            $request->file('gambar')->move("image/", $fileName);

            $tambah->gambar = $fileName;
            $tambah->save();

            return redirect()->to('/');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
     public function show($slug)
    {
        $tampilkan = Crud::where('slug_judul', $slug)->first();
        return view('tampil')->with('tampilkan', $tampilkan);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $tampiledit = Crud::where('id', $id)->first();
        return view('edit')->with('tampiledit', $tampiledit);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $update = Crud::where('id', $id)->first();
        $update->judul = $request['judul'];
        $update->isi = $request['isi'];
        $update->update();

        return redirect()->to('/');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $hapus = Crud::find($id);
        $hapus->delete();

        return redirect()->to('/');
    }
}
