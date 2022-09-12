<?php

namespace App\Http\Controllers;

use App\Models\kinerja;
use Illuminate\Http\Request;

class kinerjaController extends Controller
{
    public function index(Request $request)
    {
        $keyword = $request->keyword;
        $kinerja = Kinerja::where('hasil','LIKE', '%'.$keyword.'%')
        ->orWhere('hasil','LIKE', '%'.$keyword.'%')
        ->paginate(2);
        return view('pegawai.p_kinerja',compact('kinerja'));
    }

    public function tambah()
    {
        return view('pegawai.p_tambah_kinerja');
    }

    public function store(Request $request)
    {
        $foto = $request->file('foto');
        $newFoto = 'foto_kinerja' . '_' . time() . '.' . $foto->extension();

        $doc = $request->file('doc');
        $newDoc = 'doc_kinerja' . '_' . time() . '.' . $doc->extension();

        $path = 'template/dist/img/kinerja/';
        $request->foto->move(public_path($path), $newFoto);
        $request->doc->move(public_path($path), $newDoc);
        Kinerja::create([
            // $( "#tgl" ).datepicker({  minDate: new Date() })
            'tgl' => $request->tgl,
            'hasil' => $request->hasil,
            'foto' => $newFoto,
            'doc' => $newDoc,
        ]);
        // $message="Berhasil Simpan Data";
        return redirect('/pegawai/kinerja-pegawai');
    }

    public function destroy($id)
    {
        $kinerja = Kinerja::where('id', $id)->delete();
        return redirect('/pegawai/kinerja-pegawai')->with('status','Data berhasil di hapus!');
    }

    public function edit($id)
    {
        $kinerja = Kinerja::find($id);
        return view('pegawai.p_edit_kinerja',compact(['kinerja']));
    }

    public function update($id, Request $request)
    {
        $kinerja = Kinerja::find($id);
        $kinerja->update();
        return redirect('/pegawai/kinerja-pegawai');
    }
}
