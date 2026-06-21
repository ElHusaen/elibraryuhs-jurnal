<?php

namespace App\Http\Controllers;

use App\Models\Jurnal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use App\Models\Mahasiswa;
use App\Models\Kategori;

class JurnalController extends Controller
{
       public function index(Request $request)
        {
            $kategori = Kategori::all();
            
            $perPage = $request->input('per_page', 10);
            $allowedPerPage = [10, 25, 50, 100];
            if (!in_array($perPage, $allowedPerPage)) {
                $perPage = 10;
            }
            
            $query = Jurnal::with('mahasiswa', 'kategori')
                ->orderBy('judul', 'asc');

            if ($request->filled('kategori')) {
                $query->where('id_kategori', $request->kategori);
            }

            if ($request->filled('prodi_filter')) {
                $query->whereHas('mahasiswa', function ($q) use ($request) {
                    $q->where('prodi', $request->prodi_filter);
                });
            }

            if ($request->filled('keyword')) {
                $keyword = $request->keyword;
                
                // Ambil semua data untuk binary search
                $allData = Jurnal::with('mahasiswa')->orderBy('judul', 'asc')->get();
                
                // Gunakan Binary Search Advanced untuk semua field
                $binaryResults = $this->binarySearchAdvanced($allData, $keyword, 'all');
                
                if ($binaryResults->count() > 0) {
                    // Ambil ID hasil binary search
                    $ids = $binaryResults->pluck('id_jurnal')->toArray();
                    
                    // Ambil data dengan pagination berdasarkan hasil binary search
                    $hasil = $query->whereIn('id_jurnal', $ids)
                        ->paginate($perPage);
                    
                    $searchMethod = 'Binary Search (Semua Field) - ' . $binaryResults->count() . ' ditemukan';
                } else {
                    // Fallback ke LIKE search jika binary search tidak menemukan
                    $hasil = $query->where(function ($q) use ($keyword) {
                        $q->where('judul', 'like', '%' . $keyword . '%')
                        ->orWhere('abstrak', 'like', '%' . $keyword . '%')
                        ->orWhereHas('mahasiswa', function ($subQ) use ($keyword) {
                            $subQ->where('nama_lengkap', 'like', '%' . $keyword . '%')
                                ->orWhere('prodi', 'like', '%' . $keyword . '%')
                                ->orWhere('fakultas', 'like', '%' . $keyword . '%');
                        });
                    })->paginate($perPage);
                    
                    $searchMethod = 'LIKE Search (Fleksibel)';
                }
            } else {
                $hasil = $query->paginate($perPage);
                $searchMethod = 'Semua Data';
            }

            $prodiList = Mahasiswa::distinct()->pluck('prodi')->filter()->values();

            return view('jurnal.index', [
                'title' => 'Data Jurnal',
                'jurnal' => $hasil,
                'hasil' => $hasil,
                'kategori' => $kategori,
                'prodiList' => $prodiList,
                'searchMethod' => $searchMethod ?? 'Semua Data',
                'keyword' => $request->keyword
            ]);
        }
    public function create()
    {
            $kategori = Kategori::all();
            $mahasiswa = Mahasiswa::all();

            return view('jurnal.create', compact(
                'kategori',
                'mahasiswa'
            ));
        $data = [
            'title' => 'Tambah Jurnal',
            'menuJurnal' => 'active',
     ];             

        return view('jurnal.create', $data);
    }

    public function store(Request $request)
    {
        try {
            $request->validate([
            'judul' => 'required',
            'abstrak' => 'required',
            'file_pdf' => 'required|mimes:pdf|max:10240',
            'nama_penulis_asli' => 'required|string|max:500', // Batasi maksimal 500 karakter
            'prodi' => 'required|string|max:255',
            'fakultas' => 'required|string|max:255',
        ]);

            $namaFile = null;
            if ($request->hasFile('file_pdf')) {
                $file = $request->file('file_pdf');
                $namaFile = time() . '_' . $file->getClientOriginalName();
                $file->move(public_path('uploads/jurnal'), $namaFile);
            }

            // Cari atau buat penulis berdasarkan nama asli yang diinput
           $penulis = Mahasiswa::firstOrCreate(
                ['nama_lengkap' => $request->nama_penulis_asli],
                [
                    'penulis' => $this->generateKodePenulis(),
                    'email' => $request->email_penulis ?? null, // isi default
                    'prodi' => $request->prodi,
                    'fakultas' => $request->fakultas,
                    'password' => bcrypt('default123'), // isi default password
                ]
            );
            // Simpan jurnal
            Jurnal::create([
                'id_jurnal'   => Str::uuid(),
                'penulis'     => $penulis->penulis,
                'id_kategori' => $request->id_kategori,
                'judul'       => $request->judul,
                'abstrak'     => $request->abstrak,
                'file_pdf'    => $namaFile,
                'tgl_upload'  => now(),
                'status'      => 'review'
            ]);

            return redirect()
                ->route('jurnal.index')
                ->with('success', 'Jurnal berhasil ditambahkan');

        } catch (\Exception $e) {
            return back()
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage())
                ->withInput();
        }
    }

    private function generateKodePenulis()
    {
        $last = Mahasiswa::orderBy('created_at', 'desc')->first();
        if (!$last) {
            return 'P001';
        }
        $lastNumber = (int) substr($last->penulis, 1);
        $newNumber = $lastNumber + 1;
        return 'P' . str_pad($newNumber, 3, '0', STR_PAD_LEFT);
    }
    public function show(string $id)
    {
        $jurnal = Jurnal::with([
            'mahasiswa',
            'kategori'
        ])->findOrFail($id);

        return view('jurnal.show', compact('jurnal'));
        
    }

    public function edit(string $id)
    {
        $jurnal = Jurnal::with('mahasiswa')->findOrFail($id);
        $kategori = Kategori::all(); // <-- TAMBAHKAN INI
        
        return view('jurnal.edit', compact('jurnal', 'kategori'));
    }

   public function update(Request $request, string $id)
    {
        $jurnal = Jurnal::findOrFail($id);

        $request->validate([
            'judul' => 'required',
            'abstrak' => 'required',
            'id_kategori' => 'required',
            'file_pdf' => 'nullable|mimes:pdf|max:10240',
        ]);

        $jurnal->judul = $request->judul;
        $jurnal->abstrak = $request->abstrak;
        $jurnal->id_kategori = $request->id_kategori;
        $jurnal->status = $request->status;

        if ($request->hasFile('file_pdf')) {
            // Hapus file lama jika ada
            if ($jurnal->file_pdf && file_exists(public_path('uploads/jurnal/' . $jurnal->file_pdf))) {
                unlink(public_path('uploads/jurnal/' . $jurnal->file_pdf));
            }

            $file = $request->file('file_pdf');
            $namaFile = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('uploads/jurnal'), $namaFile);
            $jurnal->file_pdf = $namaFile;
        }

        $jurnal->save();

        return redirect()
            ->route('jurnal.index')
            ->with('success', 'Jurnal berhasil diperbarui');
    }

    public function destroy(string $id)
    {
        $jurnal = Jurnal::findOrFail($id);

        $jurnal->delete();

        return redirect()->route('jurnal.index');
    }

    private function binarySearchAdvanced($data, $keyword, $field = 'all', $tolerance = 3)
    {
        $results = collect();
        $usedIds = collect();
        
        // Jika keyword kosong, return kosong
        if (empty(trim($keyword))) {
            return $results;
        }
        
        // Pecah keyword menjadi kata-kata (untuk pencarian kalimat)
        $keywordLower = strtolower(trim($keyword));
        $keywords = array_filter(explode(' ', $keywordLower));
        
        // Jika field = 'all', cari di semua field
        if ($field == 'all') {
            $fields = ['judul', 'abstrak', 'nama_lengkap', 'prodi', 'fakultas'];
        } else {
            $fields = [$field];
        }
        
        // Skor untuk setiap data
        $scores = [];
        
        foreach ($data as $index => $item) {
            $totalScore = 0;
            $matchDetails = [];
            
            foreach ($fields as $f) {
                $value = $this->getFieldValue($item, $f);
                if (empty($value)) continue;
                
                $valueLower = strtolower($value);
                
                // 1. CEK EXACT MATCH (Skor tertinggi)
                if (strpos($valueLower, $keywordLower) !== false) {
                    $score = 100;
                    $totalScore += $score;
                    $matchDetails[] = "Exact match di {$f}";
                    continue;
                }
                
                // 2. CEK KEMIRIPAN KALIMAT (Levenshtein untuk seluruh kalimat)
                $distance = levenshtein($valueLower, $keywordLower);
                $maxLength = max(strlen($valueLower), strlen($keywordLower));
                if ($maxLength > 0) {
                    $similarity = 1 - ($distance / $maxLength);
                    if ($similarity > 0.5) {
                        $score = $similarity * 80;
                        $totalScore += $score;
                        $matchDetails[] = "Similarity {$similarity} di {$f}";
                        continue;
                    }
                }
                
                // 3. CEK PER KATA (Keyword dipecah menjadi kata-kata)
                foreach ($keywords as $word) {
                    if (strlen($word) < 2) continue; // Abaikan kata pendek
                    
                    // 3a. Kata persis dalam kalimat
                    if (strpos($valueLower, $word) !== false) {
                        $score = 60 / count($keywords);
                        $totalScore += $score;
                        $matchDetails[] = "Kata '{$word}' ditemukan di {$f}";
                        continue;
                    }
                    
                    // 3b. Kemiripan kata (Levenshtein per kata)
                    $wordDistance = levenshtein($valueLower, $word);
                    $wordMaxLength = max(strlen($valueLower), strlen($word));
                    if ($wordMaxLength > 0) {
                        $wordSimilarity = 1 - ($wordDistance / $wordMaxLength);
                        if ($wordSimilarity > 0.6) {
                            $score = ($wordSimilarity * 40) / count($keywords);
                            $totalScore += $score;
                            $matchDetails[] = "Kata mirip '{$word}' di {$f}";
                        }
                    }
                }
            }
            
            // Simpan skor jika > 0
            if ($totalScore > 0) {
                $scores[] = [
                    'item' => $item,
                    'score' => $totalScore,
                    'details' => $matchDetails,
                    'index' => $index
                ];
            }
        }
        
        // Urutkan berdasarkan skor tertinggi
        usort($scores, function($a, $b) {
            return $b['score'] <=> $a['score'];
        });
        
        // Ambil hasil dengan skor > 10 (threshold minimum)
        foreach ($scores as $scoreData) {
            if ($scoreData['score'] > 10) {
                $results->push($scoreData['item']);
            }
        }
        
        // Jika hasil kosong dan data tidak terlalu besar, coba dengan tolerance lebih tinggi
        if ($results->count() == 0 && count($data) <= 200) {
            $results = $this->fallbackSearch($data, $keywords, $fields);
        }
        
        return $results;
    }


    private function fallbackSearch($data, $keywords, $fields)
    {
        $results = collect();
        $usedIds = collect();
        
        foreach ($data as $item) {
            $found = false;
            foreach ($fields as $f) {
                $value = $this->getFieldValue($item, $f);
                if (empty($value)) continue;
                
                $valueLower = strtolower($value);
                
                // Cek setiap kata dengan toleransi lebih tinggi
                foreach ($keywords as $word) {
                    if (strlen($word) < 2) continue;
                    
                    // Cek jika kata ada dalam value
                    if (strpos($valueLower, $word) !== false) {
                        $found = true;
                        break 2;
                    }
                    
                    // Cek kemiripan kata dengan tolerance lebih tinggi
                    $distance = levenshtein($valueLower, $word);
                    $maxLength = max(strlen($valueLower), strlen($word));
                    if ($maxLength > 0) {
                        $similarity = 1 - ($distance / $maxLength);
                        if ($similarity > 0.4) { // Tolerance lebih rendah (40%)
                            $found = true;
                            break 2;
                        }
                    }
                }
            }
            
            if ($found && !$usedIds->contains($item->id_jurnal)) {
                $results->push($item);
                $usedIds->push($item->id_jurnal);
            }
        }
        
        return $results;
    }


    private function binarySearchByJudul($data, $keyword)
    {
        $low = 0;
        $high = count($data) - 1;

        while ($low <= $high) {
            $mid = floor(($low + $high) / 2);
            
            $compare = strcasecmp($data[$mid]->judul, $keyword);
            
            if ($compare == 0) {
                return $data[$mid];
            }
            
            if ($compare < 0) {
                $low = $mid + 1;
            } else {
                $high = $mid - 1;
            }
        }
        
        return null;
    }

    private function binarySearchFlexible($data, $keyword, $field)
    {
        $low = 0;
        $high = count($data) - 1;
        
        while ($low <= $high) {
            $mid = floor(($low + $high) / 2);
            
            $value = $this->getFieldValue($data[$mid], $field);
            if ($value === null) {
                return null;
            }
            
            $compare = strcasecmp($value, $keyword);
            
            if ($compare == 0) {
                return $data[$mid];
            }
            
            if ($compare < 0) {
                $low = $mid + 1;
            } else {
                $high = $mid - 1;
            }
        }
        
        return null;
    }

    private function getFieldValue($jurnal, $field)
    {
        if ($field == 'judul') {
            return $jurnal->judul;
        } elseif ($field == 'abstrak') {
            return $jurnal->abstrak;
        } elseif ($field == 'nama_lengkap') {
            return $jurnal->mahasiswa->nama_lengkap ?? null;
        } elseif ($field == 'prodi') {
            return $jurnal->mahasiswa->prodi ?? null;
        } elseif ($field == 'fakultas') {
            return $jurnal->mahasiswa->fakultas ?? null;
        }
        return null;
    }


    private function binarySearchAllFields($data, $keyword)
    {
        return $this->binarySearchAdvanced($data, $keyword, 'all');
    }
}