<?php

namespace App\Http\Controllers;

use App\Models\ProjectM;
use App\Models\ProjectPlanM;
use Illuminate\Http\Request;

class ClientController
{
    public function plan($id){
        $ids = ProjectM::where('customer_id',$id)->value('id');
        $project = ProjectM::find($ids);
        $plan = ProjectPlanM::where('project_id',$ids)->value('id');
        $data = ProjectPlanM::find($plan);
        $sections = [
            ['title' => 'Pengantar', 'content' => $data->pengantar, 'note' => $data->pengantar_catatan, 'name' => 'pengantar_catatan'],
            ['title' => 'Ringkasan Eksekutif', 'content' => $data->ringkasan, 'note' => $data->ringkasan_catatan, 'name' => 'ringkasan_catatan'],
            ['title' => 'Ruang Lingkup Proyek', 'content' => $data->ruang_lingkup, 'note' => $data->ruang_lingkup_catatan, 'name' => 'ruang_lingkup_catatan'],
            ['title' => 'Jadwal Proyek', 'content' => $data->jadwal_proyek, 'note' => $data->jadwal_proyek_catatan, 'name' => 'jadwal_proyek_catatan'],
            ['title' => 'Fase 1', 'content' => $data->fase_1, 'note' => $data->fase_1_catatan, 'name' => 'fase_1_catatan'],
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
        ];

        return view('page.Klien.plan',compact('data','project','sections'));
    }

    public function update(Request $request, $id)
    {
        // Validate the incoming request data
        $validatedData = $request->validate([
            'pengantar_catatan' => 'nullable|string',
            'ringkasan_catatan' => 'nullable|string',
            'ruang_lingkup_catatan' => 'nullable|string',
            'jadwal_proyek_catatan' => 'nullable|string',
            'fase_1_catatan' => 'nullable|string',
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

        // Update the fields with the validated data
        $projectPlan->update([
            'pengantar_catatan' => $validatedData['pengantar_catatan'] ?? $projectPlan->pengantar_catatan,
            'ringkasan_catatan' => $validatedData['ringkasan_catatan'] ?? $projectPlan->ringkasan_catatan,
            'ruang_lingkup_catatan' => $validatedData['ruang_lingkup_catatan'] ?? $projectPlan->ruang_lingkup_catatan,
            'jadwal_proyek_catatan' => $validatedData['jadwal_proyek_catatan'] ?? $projectPlan->jadwal_proyek_catatan,
            'fase_1_catatan' => $validatedData['fase_1_catatan'] ?? $projectPlan->fase_1_catatan,
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
}
