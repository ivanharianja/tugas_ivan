<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use App\Models\Klien;
use App\Models\User;
use App\Models\FormTes;
use App\Models\Test;
use App\Models\TesKecerdasan;
use App\Models\TesKecermatan;
use App\Models\JawabanTesKecerdasan;
use App\Models\JawabanTesKecermatan;
use App\Models\SubSoalTesKecermatan;

class KlienController extends Controller
{
    public function index()
    {
        return view('klien.index');
    }

    public function klienlistday()
    {
        $klienList = Klien::where('updated_at', '>', Carbon::now()->subDay())->get();
        return view('klien.index', compact('klienList'));
    }

    public function dashboard()
    {
        $idUser = Auth::id();
        $user = User::find($idUser);
        $klien = Klien::where('nama', $user->nama)->first();
        $formtes = FormTes::where('idklien', $klien->id)
            ->where('status', 'Belum Dikerjakan')
            ->get();
        if (empty ($klien->jeniskelamin) || empty ($klien->tanggallahir)) {
            $completeProfilePrompt = empty ($klien->jeniskelamin) || empty ($klien->tanggallahir);
            return view('klien.dashboard', compact('klien', 'completeProfilePrompt'));
        }
        return view('klien.dashboard', compact('klien', 'formtes'));
    }

    public function isidatadiri(Request $request)
    {
        $request->validate([
            'jeniskelamin' => 'required|in:L,P',
            'tanggallahir' => 'required|date',
            'email' => 'required|email',
            'nomortelepon' => 'required|integer',
            'alamat' => 'required|string',
            'kota' => 'required|string',
            'instansi' => 'required|string',
            'pendidikanterakhir' => 'required|string',
            'keperluan' => 'required|string',
        ]);
        $idUser = Auth::id();
        $user = User::find($idUser);
        $klien = $klien = Klien::where('nama', $user->nama)->first();
        $klien->jeniskelamin = $request->input('jeniskelamin');
        $klien->tanggallahir = $request->input('tanggallahir');
        $klien->email = $request->input('email');
        $klien->nomortelepon = $request->input('nomortelepon');
        $klien->alamat = $request->input('alamat');
        $klien->kota = $request->input('kota');
        $klien->instansi = $request->input('instansi');
        $klien->pendidikanterakhir = $request->input('pendidikanterakhir');
        $klien->keperluan = $request->input('keperluan');
        $klien->save();
        return redirect()->route('klien.dashboard');
    }

    public function pengerjaanteskecerdasan($id)
    {
        $formtes = FormTes::find($id);
        $test = Test::find($formtes->idtest);
        $sessionKey = 'random_soal_order_' . $formtes->id;
        if (!session()->has($sessionKey)) {
            $randomSoalOrder = $this->generateRandomSoalOrder($test->id);
            session([$sessionKey => $randomSoalOrder]);
        }
        $randomSoalOrder = session($sessionKey);
        $soal = $randomSoalOrder;
        return view('klien.pengerjaanteskecerdasan', compact('formtes', 'soal'));
    }

    private function generateRandomSoalOrder($testId)
    {
        $soalAritmatikaLevel1 = TesKecerdasan::where('idtest', $testId)
            ->where('kategori', 'Aritmatika')
            ->where('level', 1)
            ->inRandomOrder()
            ->limit(12)
            ->get();
        $soalAritmatikaLevel2 = TesKecerdasan::where('idtest', $testId)
            ->where('kategori', 'Aritmatika')
            ->where('level', 2)
            ->inRandomOrder()
            ->limit(7)
            ->get();
        $soalAritmatikaLevel3 = TesKecerdasan::where('idtest', $testId)
            ->where('kategori', 'Aritmatika')
            ->where('level', 3)
            ->inRandomOrder()
            ->limit(6)
            ->get();
        $soalLogisLevel1 = TesKecerdasan::where('idtest', $testId)
            ->where('kategori', 'Logis')
            ->where('level', 1)
            ->inRandomOrder()
            ->limit(12)
            ->get();
        $soalLogisLevel2 = TesKecerdasan::where('idtest', $testId)
            ->where('kategori', 'Logis')
            ->where('level', 2)
            ->inRandomOrder()
            ->limit(7)
            ->get();
        $soalLogisLevel3 = TesKecerdasan::where('idtest', $testId)
            ->where('kategori', 'Logis')
            ->where('level', 3)
            ->inRandomOrder()
            ->limit(6)
            ->get();
        $soalVerbalLevel1 = TesKecerdasan::where('idtest', $testId)
            ->where('kategori', 'Verbal')
            ->where('level', 1)
            ->inRandomOrder()
            ->limit(12)
            ->get();
        $soalVerbalLevel2 = TesKecerdasan::where('idtest', $testId)
            ->where('kategori', 'Verbal')
            ->where('level', 2)
            ->inRandomOrder()
            ->limit(7)
            ->get();
        $soalVerbalLevel3 = TesKecerdasan::where('idtest', $testId)
            ->where('kategori', 'Verbal')
            ->where('level', 3)
            ->inRandomOrder()
            ->limit(6)
            ->get();
        $soalNonVerbalLevel1 = TesKecerdasan::where('idtest', $testId)
            ->where('kategori', 'Non Verbal')
            ->where('level', 1)
            ->inRandomOrder()
            ->limit(12)
            ->get();
        $soalNonVerbalLevel2 = TesKecerdasan::where('idtest', $testId)
            ->where('kategori', 'Non Verbal')
            ->where('level', 2)
            ->inRandomOrder()
            ->limit(7)
            ->get();
        $soalNonVerbalLevel3 = TesKecerdasan::where('idtest', $testId)
            ->where('kategori', 'Non Verbal')
            ->where('level', 3)
            ->inRandomOrder()
            ->limit(6)
            ->get();
        $soalAritmatika = $soalAritmatikaLevel1->merge($soalAritmatikaLevel2)->merge($soalAritmatikaLevel3);
        $soalLogis = $soalLogisLevel1->merge($soalLogisLevel2)->merge($soalLogisLevel3);
        $soalVerbal = $soalVerbalLevel1->merge($soalVerbalLevel2)->merge($soalVerbalLevel3);
        $soalNonVerbal = $soalNonVerbalLevel1->merge($soalNonVerbalLevel2)->merge($soalNonVerbalLevel3);
        $soal = $soalAritmatika->merge($soalLogis)->merge($soalVerbal)->merge($soalNonVerbal);
        $randomSoalOrder = $soal->shuffle();
        return $randomSoalOrder;
    }

    public function submitjawabanteskecerdasan(Request $request)
    {
        $idFormTes = $request->input('idformtes');
        $idKlien = $request->input('idklien');
        $klien = Klien::find($idKlien);
        $formtes = FormTes::find($idFormTes);
        for ($i = 1; $i <= 100; $i++) {
            $idSoal = $request->input("idsoal-$i");
            $tesKecerdasan = TesKecerdasan::find($idSoal);
            $kategoriSoal = $tesKecerdasan->kategori;
            $levelSoal = $tesKecerdasan->level;
            $jawabanKlien = $request->input("jawaban-$i");
            $jawabanKlien = ($jawabanKlien === "null") ? '' : $jawabanKlien;
            $jawabanBenar = TesKecerdasan::where('id', $idSoal)->value('jawabanbenar');
            $benarSalah = ($jawabanKlien === $jawabanBenar) ? 'Benar' : ($jawabanKlien ? 'Salah' : 'Tak Terjawab');
            $jawaban = new JawabanTesKecerdasan([
                'idformtes' => $idFormTes,
                'idklien' => $idKlien,
                'idsoal' => $idSoal,
                'kategorisoal' => $kategoriSoal,
                'levelsoal' => $levelSoal,
                'jawabanklien' => $jawabanKlien,
                'benarsalah' => $benarSalah,
            ]);
            $jawaban->save();
        }
        $formtes->status = 'Sudah Dikerjakan';
        $formtes->save();
        $klien->kedatanganterakhir = now();
        $klien->save();
        return redirect()->route('klien.dashboard');
    }

    public function pengerjaanteskecermatan($id, $sesi)
    {
        $formtes = FormTes::find($id);
        $test = Test::find($formtes->idtest);
        $subsoal = [];
        $existingRecords = JawabanTesKecermatan::where('idformtes', $formtes->id)->get();
        if ($existingRecords->isEmpty()) {
            if (!session()->has('shuffledSubSoalOrder')) {
                $randomSoalTesKecermatan = TesKecermatan::where('idtest', $test->id)
                    ->inRandomOrder()
                    ->limit(10)
                    ->get();
                $shuffledOrder = $randomSoalTesKecermatan->pluck('id')->toArray();
                session(['shuffledSubSoalOrder' => $shuffledOrder]);
            } else {
                $shuffledOrder = session('shuffledSubSoalOrder');
            }
            $soal = TesKecermatan::whereIn('id', $shuffledOrder)->get();
            for ($i = 1; $i <= 10; $i++) {
                $jawabanteskecermatan = new JawabanTesKecermatan([
                    'idformtes' => $formtes->id,
                    'idklien' => $formtes->idklien,
                    'idsoal' => $soal[$i - 1]['id'],
                    'sesi' => $i,
                ]);
                $jawabanteskecermatan->save();
                $subsoal[$i - 1] = SubSoalTesKecermatan::where('idsoal', $soal[$i - 1]['id'])->get();
            }
            $jawabanteskecermatan = JawabanTesKecermatan::where('idformtes', $formtes->id)->get();
        } else {
            $jawabanteskecermatan = $existingRecords;
            foreach ($existingRecords as $soalItem) {
                $subsoal[] = SubSoalTesKecermatan::where('idsoal', $soalItem->idsoal)->get();
            }
            $idsoalArray = $existingRecords->pluck('idsoal')->toArray();
            $soal = TesKecermatan::whereIn('id', $idsoalArray)->orderByRaw("FIELD(id, " . implode(',', $idsoalArray) . ")")->get();
        }
        $jawabanteskecermatan = $jawabanteskecermatan->where('sesi', $sesi)->first();
        $soal = $soal->where('id', $jawabanteskecermatan->idsoal)->first();
        $subsoal = $subsoal[$sesi - 1];
        return view('klien.pengerjaanteskecermatan', compact('formtes', 'soal', 'jawabanteskecermatan', 'subsoal', 'sesi'));
    }

    public function submitjawabanteskecermatan(Request $request)
    {
        $sesi = $request->input('sesi');
        $idformtes = $request->input('idformtes');
        $idsoal = $request->input('idsoal');
        $correctAnswers = $request->input('correctAnswers');
        $wrongAnswers = $request->input('wrongAnswers');
        $formtes = FormTes::find($idformtes);
        $klien = Klien::find($formtes->idklien);
        $jawaban = JawabanTesKecermatan::where('idformtes', $idformtes)->where('idsoal', $idsoal)->first();
        $jawaban->benar = $correctAnswers;
        $jawaban->salah = $wrongAnswers;
        $jawaban->save();
        if ($sesi == 10) {
            $formtes->status = 'Sudah Dikerjakan';
            $formtes->save();
            $klien->kedatanganterakhir = now();
            $klien->save();
            session()->forget('shuffledSubSoalOrder');
            return redirect()->route('klien.dashboard')->header('Cache-Control', 'no-store, no-cache, must-revalidate, post-check=0, pre-check=0');
        } else {
            return redirect()->route('pengerjaanteskecermatan', ['id' => $idformtes, 'sesi' => $sesi + 1]);
        }
    }
}
