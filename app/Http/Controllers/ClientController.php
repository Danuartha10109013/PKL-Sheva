<?php

namespace App\Http\Controllers;

use App\Models\HistoryM;
use App\Models\invoiceM;
use App\Models\ProjectM;
use App\Models\ProjectPlanM;
use Illuminate\Http\Request;

class ClientController
{
    public function project($id){
        $project = ProjectM::where('customer_id',$id)->get();

        return view('page.Klien.before_plan',compact('project'));
    }
    public function bef_invoice($id){
        $project = ProjectM::where('customer_id',$id)->get();

        return view('page.Klien.before_invoice',compact('project'));
    }

    public function plan($id){
        $project = ProjectM::find($id);
        $plan = ProjectPlanM::where('project_id',$id)->value('id');
        $data = ProjectPlanM::find($plan);
        // dd($data);
        
        $fase = json_decode(ProjectPlanM::where('project_id', $id)->value('fase'));
        $sections = [
            ['title' => 'Pengantar', 'content' => $data->pengantar, 'note' => $data->pengantar_catatan, 'name' => 'pengantar_catatan'],
            ['title' => 'Ringkasan Eksekutif', 'content' => $data->ringkasan, 'note' => $data->ringkasan_catatan, 'name' => 'ringkasan_catatan'],
            ['title' => 'Ruang Lingkup Proyek', 'content' => $data->ruang_lingkup, 'note' => $data->ruang_lingkup_catatan, 'name' => 'ruang_lingkup_catatan'],
            ['title' => 'Jadwal Proyek', 'content' => $data->jadwal_proyek, 'note' => $data->jadwal_proyek_catatan, 'name' => 'jadwal_proyek_catatan'],
        ];

        // Process dynamic sections from $fase
        if (!empty($fase)) {
            foreach ($fase as $d) {
                $sections[] = [
                    'title' => "{$d->scrum_name}, {$d->start} - {$d->end}",
                    'content' => $d->description,
                    'note' => $d->note,
                    'name' => 'scrum_name[]',
                ];
            }
        }

        // Add remaining sections
        $sections = array_merge($sections, [
            ['title' => 'Tim Proyek', 'content' => $data->team_proyek, 'note' => $data->team_proyek_catatan, 'name' => 'team_proyek_catatan'],
            ['title' => 'Manajemen Risiko', 'content' => $data->manajemen_proyek, 'note' => $data->manajemen_proyek_catatan, 'name' => 'manajemen_proyek_catatan'],
            ['title' => 'Fitur Utama Aplikasi', 'content' => $data->fitur_utama, 'note' => $data->fitur_utama_catatan, 'name' => 'fitur_utama_catatan'],
            ['title' => 'Rincian Teknis & Tugas', 'content' => $data->rincian_teknis, 'note' => $data->rincian_teknis_catatan, 'name' => 'rincian_teknis_catatan'],
            ['title' => 'Topologi Microservices Cloud Server dengan AWS', 'content' => $data->topologi, 'note' => $data->topologi_catatan, 'name' => 'topologi_catatan'],
            ['title' => 'Diagram Arsitektur', 'content' => $data->diagram, 'note' => $data->diagram_catatan, 'name' => 'diagram_catatan'],
            ['title' => 'Anggaran Pengerjaan', 'content' => $data->anggaran, 'note' => $data->anggaran_catatan, 'name' => 'anggaran_catatan'],
            ['title' => 'Nilai Proyek', 'content' => $data->nilai, 'note' => $data->nilai_catatan, 'name' => 'nilai_catatan'],
            ['title' => 'Pernyataan Kesepakatan Dokumen Perencanaan Proyek', 'content' => $data->pernyataan, 'note' => $data->pernyataan_catatan, 'name' => 'pernyataan_catatan'],
            ['title' => 'Catatan Tambahan', 'content' => $data->catatan, 'note' => $data->catatan_catatan, 'name' => 'catatan_catatan'],
        ]);


        return view('page.Klien.plan',compact('data','project','sections'));
    }

    public function update(Request $request, $id)
    {
        // dd($request->scrum_name);
        // Validate the incoming request data
        $validatedData = $request->validate([
            'pengantar_catatan' => 'nullable|string',
            'ringkasan_catatan' => 'nullable|string',
            'ruang_lingkup_catatan' => 'nullable|string',
            'jadwal_proyek_catatan' => 'nullable|string',
            'team_proyek_catatan' => 'nullable|string',
            'manajemen_proyek_catatan' => 'nullable|string',
            'fitur_utama_catatan' => 'nullable|string',
            'rincian_teknis_catatan' => 'nullable|string',
            'topologi_catatan' => 'nullable|string',
            'diagram_catatan' => 'nullable|string',
            'anggaran_catatan' => 'nullable|string',
            'nilai_catatan' => 'nullable|string',
            'pernyataan_catatan' => 'nullable|string',
            'catatan_catatan' => 'nullable|string',
        ]);

        // Find the project plan by ID
        $projectPlan = ProjectPlanM::findOrFail($id);
        $fase = json_decode($projectPlan->fase);
        // dd($fase);
        foreach ($fase as $index => $f) {
            $faseData[] = [
                'scrum_name' => $f->scrum_name,
                'start' => $f->start,
                'end' => $f->end,
                'description' => $f->description,
                'status' =>  $f->status,
                'notes' =>  $f->notes ?? null,
                'note' =>  $request->scrum_name[$index] ?? null, 
                ];
            }
            // dd($faseData);
        // Update the fields with the validated data
        $projectPlan->update([
            'fase' => json_encode($faseData),
            'pengantar_catatan' => $validatedData['pengantar_catatan'] ?? $projectPlan->pengantar_catatan,
            'ringkasan_catatan' => $validatedData['ringkasan_catatan'] ?? $projectPlan->ringkasan_catatan,
            'ruang_lingkup_catatan' => $validatedData['ruang_lingkup_catatan'] ?? $projectPlan->ruang_lingkup_catatan,
            'jadwal_proyek_catatan' => $validatedData['jadwal_proyek_catatan'] ?? $projectPlan->jadwal_proyek_catatan,
            'team_proyek_catatan' => $validatedData['team_proyek_catatan'] ?? $projectPlan->team_proyek_catatan,
            'manajemen_proyek_catatan' => $validatedData['manajemen_proyek_catatan'] ?? $projectPlan->manajemen_proyek_catatan,
            'fitur_utama_catatan' => $validatedData['fitur_utama_catatan'] ?? $projectPlan->fitur_utama_catatan,
            'rincian_teknis_catatan' => $validatedData['rincian_teknis_catatan'] ?? $projectPlan->rincian_teknis_catatan,
            'topologi_catatan' => $validatedData['topologi_catatan'] ?? $projectPlan->topologi_catatan,
            'diagram_catatan' => $validatedData['diagram_catatan'] ?? $projectPlan->diagram_catatan,
            'anggaran_catatan' => $validatedData['anggaran_catatan'] ?? $projectPlan->anggaran_catatan,
            'nilai_catatan' => $validatedData['nilai_catatan'] ?? $projectPlan->nilai_catatan,
            'pernyataan_catatan' => $validatedData['pernyataan_catatan'] ?? $projectPlan->pernyataan_catatan,
            'catatan_catatan' => $validatedData['catatan_catatan'] ?? $projectPlan->catatan_catatan,
            'status' => 2,
        ]);

        // Redirect back to the project details page with a success message
        return redirect()->back()
                         ->with('success', 'Project Plan updated successfully!');
    }

    public function setuju ($id){
        $data = ProjectPlanM::find($id);
        // dd($data);
        $data->status = 1 ;
        $data->save();
        return redirect()->back()->with('success','Project Plan has Approved');
    }

    public function invoice($id){
        // $cc = ProjectM::where('customer_id',$id)->value('id');
        $ids = invoiceM::where('project_id',$id)->value('id');
        // dd($ids);
        $data = invoiceM::find($ids);
        $project = ProjectM::find($id);
        $datain = ProjectM::where('id',$id)->get();
        // foreach ($datain as $project) {
        //     $invoice = InvoiceM::where('project_id', $project->id)->first();
        //     if ($invoice) {
        //         if (empty($invoice->no_invoice) || empty($invoice->kepada) || empty($invoice->npwp) || empty($invoice->alamat) || empty($invoice->harga) || empty($invoice->terbilang) || empty($invoice->pembuat) || empty($invoice->date)) {
        //             return redirect()->back()->with('error' , 'Lengkapi data invoice terlebih dahulu untuk project: ' . $project->judul);
        //         }
        //     }
        // }
        // $data->date= now();
        // $data->save();
        return view('page.Klien.invoice',compact('data','project'));
    }

    public function p_invoice($id){
        $ids = InvoiceM::where('project_id', $id)->value('id');
    $data = InvoiceM::find($ids);

    $history = HistoryM::all();

    // Ambil data project
    $project = ProjectM::find($id);

    // Validasi data invoice untuk project terkait
    $datain = ProjectM::where('id', $id)->get();
    foreach ($datain as $project) {
        $invoice = InvoiceM::where('project_id', $project->id)->first();
        if ($invoice) {
            if (
                empty($invoice->no_invoice) || 
                empty($invoice->kepada) || 
                empty($invoice->npwp) || 
                empty($invoice->alamat) || 
                empty($invoice->pembuat) || 
                empty($invoice->ppn) 
            ) {
                return redirect()->back()->with('error', 'Lengkapi data invoice terlebih dahulu untuk project: ' . $project->judul);
            }
        }
    }


    // Hitung rincian berdasarkan progres
    $invoiceDetails = [];
    if ($project->progres >= 0 && $project->progres < 30) {
        $subTotal = $project->biaya * 0;
        $ppn = $subTotal * $data->ppn;
        $total = $subTotal + $ppn;
        $terbilang = ucfirst(terbilang($total)) . ' Rupiah';
        dd($terbilang);
        $invoiceDetails[] = [
            'no' => 1,
            'deskripsi' => "Termin 0 0%, {$project->judul}",
            'unit' => '0 Pckg',
            'harga' => $subTotal,
            'jumlah' => $subTotal,
            'ppn' => $data->ppn,
            'terbilang' => $terbilang,

        ];
    }elseif ($project->progres >= 30 && $project->progres < 60) {
        $subTotal = $project->biaya * 0.3;
        $ppn = $subTotal * $data->ppn;
        $total = $subTotal + $ppn;
        $terbilang = ucfirst(terbilang($total)) . ' Rupiah';
        $invoiceDetails[] = [
            'no' => 1,
            'deskripsi' => "Termin 1 30%, {$project->judul}",
            'unit' => '1 Pckg',
            'harga' => $subTotal,
            'jumlah' => $subTotal,
            'ppn' => $data->ppn,
            'terbilang' => $terbilang,
        ];
    } elseif ($project->progres >= 60 && $project->progres < 90) {
        $subTotal = ($project->biaya * 0.6) - ($project->biaya * 0.3);
        $ppn = $subTotal * $data->ppn;
        $total = $subTotal + $ppn;
        $terbilang = ucfirst(terbilang($total)) . ' Rupiah';
        $invoiceDetails[] = [
            'no' => 1,
            'deskripsi' => "Termin 2 60%, {$project->judul}",
            'unit' => '1 Pckg',
            'harga' => $subTotal,
            'jumlah' => $subTotal,
            'ppn' => $data->ppn,
            'terbilang' => $terbilang,
        ];
    } elseif ($project->progres >= 90 && $project->progres < 100) {
        $subTotal = ($project->biaya * 0.9) - ($project->biaya * 0.6);
        $ppn = $subTotal * $data->ppn;
        $total = $subTotal + $ppn;
        $terbilang = ucfirst(terbilang($total)) . ' Rupiah';
        $invoiceDetails[] = [
            'no' => 1,
            'deskripsi' => "Termin 3 90%, {$project->judul}",
            'unit' => '1 Pckg',
            'harga' => $subTotal,
            'jumlah' => $subTotal,
            'ppn' => $data->ppn,
            'terbilang' => $terbilang,
        ];
    }elseif ($project->progres >= 100) {
        $subTotal = ($project->biaya * 0.9) - ($project->biaya * 0.6);
        $ppn = $subTotal * $data->ppn;
        $total = $subTotal + $ppn;
        $terbilang = ucfirst(terbilang($total)) . ' Rupiah';
        $invoiceDetails[] = [
            'no' => 1,
            'deskripsi' => "Termin 4 100%, {$project->judul}",
            'unit' => '1 Pckg',
            'harga' => $subTotal,
            'jumlah' => $subTotal,
            'ppn' => $data->ppn,
            'terbilang' => $terbilang,
        ];
    }

    $ppn = $subTotal * $data->ppn;
    $total = $subTotal + $ppn;

    return view('page.finance.k-invoice.print', compact('data','history','project', 'invoiceDetails', 'subTotal', 'ppn', 'total'));
}
}
