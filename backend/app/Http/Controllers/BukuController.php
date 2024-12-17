<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Buku;
use App\Http\Controllers\MyUtil;
use Validator;
use App\Http\Controllers\Controller;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\DB;

class BukuController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return MyUtil::sendresponse(Buku::all(), 'OK');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(),
        [
            'isbn' => 'required',
            'judul' => 'required',
            'tahun' => 'required',
        ]);

        if ($validator->fails())
        {
            return MyUtil::sendError('Validation Error.', $validator->errors());
        }
        else
        {
            if (Buku::where('isbn', '=', $request->isbn)->exists()) {
                return MyUtil::sendError('duplicate isbn', 'duplicate on book');
            } else
            {
                $bukus = new Buku();
                $bukus->isbn = $request->isbn;
                $bukus->judul = $request->judul;
                $bukus->pengarang = $request->pengarang;
                $bukus->tahun = $request->tahun;
                $bukus->save();
                return $this->index();
            }
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        try
        {
            $buku = Buku::where('isbn', $id)->firstOrFail();
            return MyUtil::sendResponse($buku, 'OK');
        }
        catch (ModelNotFoundException $ex)
        {
            return MyUtil::sendError("NOT FOUND", 'NOT FOUND');
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Buku $buku)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update (Request $request, $id)
    {
        $validator = Validator::make($request->all(),
        [
            'isbn' => 'required',
            'judul' => 'required',
            'pengarang' => 'required',
            'tahun' => 'required',
        ]);

        if ($validator->fails())
        {
            return MyUtil::sendError('Validation Error.', $validator->errors());
        }

        try
        {
            $buku = Buku::findOrFail($id);
            $buku->isbn = $request->isbn;
            $buku->judul = $request->judul;
            $buku->pengarang = $request->pengarang;
            $buku->tahun = $request->tahun;
            $buku->save();
            return MyUtil::sendResponse($buku, 'Book updated successfully.');
        }
        catch (ModelNotFoundException $ex)
        {
            return MyUtil::sendError("NOT FOUND", 'NOT FOUND');
        }
    }

    public function search(Request $request)
{
    $cari = $request->cari;
    $start = $request->start;
    $limit = $request->limit;

    $count = DB::table('bukus')
        ->where('judul', 'like', "%" . $cari . "%")
        ->orWhere('pengarang', 'like', "%" . $cari . "%")
        ->count();

    $buku = DB::table('bukus')
        ->where('judul', 'like', "%" . $cari . "%")
        ->orWhere('pengarang', 'like', "%" . $cari . "%")
        ->offset($start)
        ->limit($limit)
        ->orderBy('judul')
        ->get();

    $obj = new \stdClass();
    $obj->count = $count;
    $obj->buku = $buku;

    return MyUtil::sendResponse($obj, 'OK');
}


    /**
     * Remove the specified resource from storage.
     */
    public function destroy($isbn)
    {
        Buku::where('isbn', $isbn)->delete();
        return $this->index();
    }
}
