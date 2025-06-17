<?php

namespace App\Http\Controllers;

use App\Models\NotifKlienM;
use App\Models\ProjectM;
use App\Models\ProjectPlanM;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TeamLeadController
{
    public function project(){
        $id = Auth::user()->id;
        $data = ProjectM::where('team_leader_id',$id)->orderBy('created_at','desc')->get();
        return view('page.team_lead.project.index',compact('data'));
    }

    public function plan($id){
        // dd($id);
        // $ids = ProjectM::where('customer_id',$id)->value('id');
        $project = ProjectM::find($id);
        $plan = ProjectPlanM::where('project_id',$project->id)->value('id');
        // dd($id);
        $data = ProjectPlanM::find($plan);
        $fase = json_decode($data->fase);

        $sections = [
            ['title' => 'Pengantar', 'content' => $data->pengantar, 'note' => $data->pengantar_catatantl, 'name' => 'pengantar_catatan'],
            ['title' => 'Ringkasan Eksekutif', 'content' => $data->ringkasan, 'note' => $data->ringkasan_catatantl, 'name' => 'ringkasan_catatan'],
            ['title' => 'Ruang Lingkup Proyek', 'content' => $data->ruang_lingkup, 'note' => $data->ruang_lingkup_catatantl, 'name' => 'ruang_lingkup_catatan'],
            ['title' => 'Jadwal Proyek', 'content' => $data->jadwal_proyek, 'note' => $data->jadwal_proyek_catatantl, 'name' => 'jadwal_proyek_catatan'],
        ];
        // Process dynamic sections from $fase
        if (!empty($fase)) {
            foreach ($fase as $d) {
                $sections[] = [
                    'title' => "{$d->scrum_name}, {$d->start} - {$d->end}",
                    'content' => $d->description,
                    'note' => $d->notes,
                    'name' => 'scrum_names[]',
                ];
            }
        }
       $sections = array_merge($sections, [

            ['title' => 'Tim Proyek', 'content' => $data->team_proyek, 'note' => $data->team_proyek_catatantl, 'name' => 'team_proyek_catatan', 'note_klien' => $data->team_proyek_catatan],
            ['title' => 'Manajemen Risiko', 'content' => $data->manajemen_proyek, 'note' => $data->manajemen_proyek_catatantl, 'name' => 'manajemen_proyek_catatan', 'note_klien' => $data->manajemen_proyek_catatan],
            ['title' => 'Fitur Utama Aplikasi', 'content' => $data->fitur_utama, 'note' => $data->fitur_utama_catatantl, 'name' => 'fitur_utama_catatan', 'note_klien' => $data->fitur_utama_catatan],
            ['title' => 'Rincian Teknis & Tugas', 'content' => $data->rincian_teknis, 'note' => $data->rincian_teknis_catatantl, 'name' => 'rincian_teknis_catatan', 'note_klien' => $data->rincian_teknis_catatan],
            ['title' => 'Topologi Microservices Cloud Server dengan AWS', 'content' => $data->topologi, 'note' => $data->topologi_catatantl, 'name' => 'topologi_catatan', 'note_klien' => $data->topologi_catatan],
            ['title' => 'Diagram Arsitektur', 'content' => $data->diagram, 'note' => $data->diagram_catatantl, 'name' => 'diagram_catatan', 'note_klien' => $data->diagram_catatan],
            ['title' => 'Anggaran Pengerjaan', 'content' => $data->anggaran, 'note' => $data->anggaran_catatantl, 'name' => 'anggaran_catatan', 'note_klien' => $data->anggaran_catatan],
            ['title' => 'Nilai Proyek', 'content' => $data->nilai, 'note' => $data->nilai_catatantl, 'name' => 'nilai_catatan', 'note_klien' => $data->nilai_catatan],
            ['title' => 'Pernyataan Kesepakatan Dokumen Perencanaan Proyek', 'content' => $data->pernyataan, 'note' => $data->pernyataan_catatantl, 'name' => 'pernyataan_catatan', 'note_klien' => $data->pernyataan_catatan],
            ['title' => 'Catatan Tambahan', 'content' => $data->catatan, 'note' => $data->catatan_catatantl, 'name' => 'catatan_catatan', 'note_klien' => $data->catatan_catatan],
        ]);


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

        foreach ($fase as $index => $f) {
            $faseData[] = [
                'scrum_name' => $f->scrum_name,
                'start' => $f->start,
                'end' => $f->end,
                'description' => $f->description,
                'status' =>  $f->status,
                'note' =>  $f->note,
                'notes' =>  $request->scrum_names[$index] ?? null, 
                ];
            }
        // Update the fields with the validated data
        $projectPlan->update([
            'fase' => json_encode($faseData),
            'pengantar_catatantl' => $validatedData['pengantar_catatan'] ?? $projectPlan->pengantar_catatantl,
            'ringkasan_catatantl' => $validatedData['ringkasan_catatan'] ?? $projectPlan->ringkasan_catatantl,
            'ruang_lingkup_catatantl' => $validatedData['ruang_lingkup_catatan'] ?? $projectPlan->ruang_lingkup_catatantl,
            'jadwal_proyek_catatantl' => $validatedData['jadwal_proyek_catatan'] ?? $projectPlan->jadwal_proyek_catatantl,
            'team_proyek_catatantl' => $validatedData['team_proyek_catatan'] ?? $projectPlan->team_proyek_catatantl,
            'manajemen_proyek_catatantl' => $validatedData['manajemen_proyek_catatan'] ?? $projectPlan->manajemen_proyek_catatantl,
            'fitur_utama_catatantl' => $validatedData['fitur_utama_catatan'] ?? $projectPlan->fitur_utama_catatantl,
            'rincian_teknis_catatantl' => $validatedData['rincian_teknis_catatan'] ?? $projectPlan->rincian_teknis_catatantl,
            'topologi_catatantl' => $validatedData['topologi_catatan'] ?? $projectPlan->topologi_catatantl,
            'diagram_catatantl' => $validatedData['diagram_catatan'] ?? $projectPlan->diagram_catatantl,
            'anggaran_catatantl' => $validatedData['anggaran_catatan'] ?? $projectPlan->anggaran_catatantl,
            'nilai_catatantl' => $validatedData['nilai_catatan'] ?? $projectPlan->nilai_catatantl,
            'pernyataan_catatantl' => $validatedData['pernyataan_catatan'] ?? $projectPlan->pernyataan_catatantl,
            'catatan_catatantl' => $validatedData['catatan_catatan'] ?? $projectPlan->catatan_catatantl,
        ]);

         $notif = new NotifKlienM();
        $notif->user_id = Auth::user()->id;
        $notif->project_id = $projectPlan->project_id;
        $project = ProjectM::find($projectPlan->project_id);
        $notif->title = 'Team Lead telah memberikan komentar pada '. $project->judul;
        $notif->value = 'Silahkan segera periksa komentar dan lakukan tanggapan terhadap komentar';
        $notif->save();

        // Redirect back to the project details page with a success message
        return redirect()->back()
                         ->with('success', 'Project Plan updated successfully!');
    }
}
