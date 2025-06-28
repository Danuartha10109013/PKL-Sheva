<?php

namespace App\Http\Controllers;

use App\Mail\AddNewProjectMail;
use App\Mail\LaunchMail;
use App\Models\ChatM;
use App\Models\forumM;
use App\Models\invoiceM;
use App\Models\NotifKlienM;
use App\Models\NotifM;
use App\Models\PostM;
use App\Models\ProjectM;
use App\Models\ProjectPlanM;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use PhpParser\Node\Expr\New_;
use SebastianBergmann\CodeCoverage\Report\Xml\Project;

class KProjectController
{
    public function index(){
        $data =ProjectM::orderBy('created_at','desc')->get();
        $customer = User::where('role',3)->get();
        $team_leader = User::where('role',1)->get();
        return view('page.pm.k-project.index',compact('data','customer','team_leader'));
    }

    public function store(Request $request)
    {
        // dd($request->all());
        // Validate the form data
        $request->validate([
            'judul' => 'required|string|max:255',
            'customer' => 'required|string|max:255',
            'start' => 'nullable|date',
            'end' => 'nullable|date|after_or_equal:start',
            'biaya' => 'nullable|numeric|min:0',
        ]);

        // Check if the customer already has a project
        // $customerExists = ProjectM::where('customer_id', $request->customer)->exists();
        // if ($customerExists) {
        //     return redirect()->back()->with('error', 'User Telah memiliki Project');
        // }

        // Create a new project with the provided data
        $project = new ProjectM();
        $project->judul = $request->judul;
        $project->customer_id = $request->customer;
        $project->start = $request->start;
        $project->team_leader_id = $request->team_leader;
        $project->end = $request->end;
        $project->biaya = $request->biaya;
        $project->pm_id = Auth::user()->id;
        $project->save();

        $plan = New ProjectPlanM();
        $plan->project_id = $project->id;
        function getRomanMonth($month) {
            $romans = [
                1 => 'I', 2 => 'II', 3 => 'III', 4 => 'IV', 5 => 'V',
                6 => 'VI', 7 => 'VII', 8 => 'VIII', 9 => 'IX', 10 => 'X',
                11 => 'XI', 12 => 'XII'
            ];
            return $romans[$month] ?? '';
        }

        // Ambil data terakhir dari database
        $lastPlan = ProjectPlanM::orderBy('id', 'desc')->first();
        $lastNoProjectPlan = $lastPlan ? $lastPlan->no_projec_plan : null;

        if ($lastNoProjectPlan) {
            // Ekstrak nomor urut dari format "001/DOK-PRP/ZMI/VII/2024"
            preg_match('/^(\d+)\//', $lastNoProjectPlan, $matches);
            $lastNoUrut = isset($matches[1]) ? (int)$matches[1] : 0;
        } else {
            $lastNoUrut = 0; // Jika belum ada data, mulai dari 0
        }

        // Nomor urut baru
        $newNoUrut = str_pad($lastNoUrut + 1, 3, '0', STR_PAD_LEFT);

        $dokumen = "DOK-PRP";
        $companyCode = "ZMI";
        $tahun = date('Y');
        $bulanRomawi = getRomanMonth(date('n'));
        $noProjectPlan = "{$newNoUrut}/{$dokumen}/{$companyCode}/{$bulanRomawi}/{$tahun}";
        $plan->no_projec_plan = $noProjectPlan;
        $plan->no_rev = 0;
        $plan->save();

        $forum = New forumM();
        $forum->project_id = $project->id;
        $forum->save();

        $bill = new invoiceM;
        $bill->project_id = $project->id;

        // Format dasar
        $today = date('Ymd');
        $baseInvoice = "INV-$today." . $project->id;
        $invoiceNumber = $baseInvoice;
        $counter = 1;

        // Cek apakah invoice nomor ini sudah ada
        while (invoiceM::where('no_invoice', $invoiceNumber)->exists()) {
            $invoiceNumber = $baseInvoice . '-' . $counter;
            $counter++;
        }

        $bill->no_invoice = $invoiceNumber;
        $bill->save();
        // $finance = User::find(3);
        $notif = new NotifM();
                $notif->user_id = $project->customer_id;
                $notif->status = 0;
                $notif->title = 'New Project '. $project->judul . ' Has Been Created';
                $notif->value = 'Silahkan lengkapi detail invoice untuk project ini';
                $notif->project_id = $project->id;
                $notif->invoice_id = $bill->id;
                $notif->save();
        // Mail::to($finance->email)->send(new AddNewProjectMail($project));

        // Redirect back with a success message
        return redirect()->back()->with('success', 'Project created successfully!');
    }

    public function update(Request $request, $id)
    {
        // dd($request->all());
        // Validate the request data
        $request->validate([
            'judul' => 'required|string|max:255',
            'start' => 'required|date',
            'end' => 'required|date|after_or_equal:start',
            'biaya' => 'required|numeric',
            'customer' => 'required',
            'team_leader' => 'required',
        ]);

        // Find the project by ID
        $project = ProjectM::findOrFail($id);

        // Update project attributes
        $project->judul = $request->judul;
        $project->start = $request->start;
        $project->end = $request->end;
        $project->biaya = $request->biaya;
        $project->customer_id = $request->customer;
        $project->team_leader_id = $request->team_leader;

        // Save the changes to the database
        $project->save();

        // Redirect back with success message
        return redirect()->route('pm.k-project')->with('success', 'Project updated successfully.');
    }

    /**
     * Remove the specified project from storage.
     */
    public function delete($id)
    {
        // Find the project by ID
        $project = ProjectM::findOrFail($id);
        $ids = ProjectPlanM::where('project_id',$id)->value('id');
        $projectplan = ProjectPlanM::find($ids);
        $projectplan->delete();
        $forum = forumM::where('project_id',$id)->first();
        $forum->delete();
        $post = PostM::where('forum_id',$forum->id)->get();
        foreach ($post as $p){
            $chat = ChatM::where('post_id',$p->id)->get();
            foreach ($chat as $c){
                $c->delete();
            }
            $p->delete();
        }
        // Delete the project from the database
        $project->delete();

        // Redirect back with success message
        return redirect()->route('pm.k-project')->with('success', 'Project deleted successfully.');
    }

    public function plan($id){
        $data = ProjectPlanM::findOrFail($id);
        $project = ProjectM::find($data->project_id);
        $fase = json_decode($data->fase, true); // Decode JSON to array

        return view('page.pm.k-project.plan',compact('data','id','fase','project'));
    }

    public function show($id){
        $ids = ProjectPlanM::where('project_id',$id)->value('id');
        $data = ProjectPlanM::find($ids);
        $project = ProjectM::find($id);
        // dd($ids);
        return view('page.pm.k-project.show',compact('data','project'));
    }

    public function update_plan(Request $request,$id){
        // Validate incoming request data

        $request->validate([
            'pengantar' => 'string|nullable',
            'ringkasan' => 'string|nullable',
            'ruang_lingkup' => 'string|nullable',
            'jadwal_proyek' => 'string|nullable',
            'team_proyek' => 'string|nullable',
            'manajemen_proyek' => 'string|nullable',
            'fitur_utama' => 'string|nullable',
            'rincian_teknis' => 'string|nullable',
            'topologi' => 'string|nullable',
            'diagram' => 'string|nullable',
            'anggaran' => 'string|nullable',
            'nilai' => 'string|nullable',
            'pernyataan' => 'string|nullable',
            'catatan' => 'string|nullable',
            'updated_by' => 'string|nullable',
        ]);

        // Find the project plan by ID
        $projectPlan = ProjectPlanM::findOrFail($id);

        // Update fields with input data
        $projectPlan->pengantar = $request->pengantar;
        $projectPlan->update_by = $request->updated_by;
        $projectPlan->ringkasan = $request->ringkasan;
        $projectPlan->ruang_lingkup = $request->ruang_lingkup;
        $projectPlan->jadwal_proyek = $request->jadwal_proyek;
        $projectPlan->team_proyek = $request->team_proyek;
        $projectPlan->manajemen_proyek = $request->manajemen_proyek;
        $projectPlan->fitur_utama = $request->fitur_utama;
        $projectPlan->rincian_teknis = $request->rincian_teknis;
        $projectPlan->topologi = $request->topologi;
        $projectPlan->diagram = $request->diagram;
        $projectPlan->anggaran = $request->anggaran;
        $projectPlan->nilai = $request->nilai;
        $projectPlan->pernyataan = $request->pernyataan;
        $projectPlan->catatan = $request->catatan;
        $faseData = [];

        foreach ($request->scrum_name as $index => $scrumName) {
        $faseData[] = [
            'scrum_name' => $scrumName,
            'start' => $request->start[$index] ?? null,
            'end' => $request->end[$index] ?? null,
            'description' => $request->fase_1[$index] ?? null,
            'status' =>  null,
            'note' =>  null,
            'notes' =>  null,
            ];
        }
        
        $projectPlan->fase = json_encode($faseData); // Simpan dalam kolom JSON
        $projectPlan->save();

        // Redirect with a success message
        return redirect()->back()->with('success', 'Project plan updated successfully');
    }
    public function update_plan_revision(Request $request,$id){
        // Validate incoming request data
        // dd($request->all());
        $request->validate([
            'pengantar' => 'string|nullable',
            'ringkasan' => 'string|nullable',
            'ruang_lingkup' => 'string|nullable',
            'jadwal_proyek' => 'string|nullable',
            'team_proyek' => 'string|nullable',
            'manajemen_proyek' => 'string|nullable',
            'fitur_utama' => 'string|nullable',
            'rincian_teknis' => 'string|nullable',
            'topologi' => 'string|nullable',
            'diagram' => 'string|nullable',
            'anggaran' => 'string|nullable',
            'nilai' => 'string|nullable',
            'pernyataan' => 'string|nullable',
            'catatan' => 'string|nullable',
            'updated_by' => 'string|nullable',
        ]);

        // Find the project plan by ID
        $projectPlan = ProjectPlanM::findOrFail($id);
        // dd($projectPlan);

        // Update fields with input data
        $projectPlan->pengantar = $request->pengantar;
        $projectPlan->update_by = $request->updated_by;
        $projectPlan->ringkasan = $request->ringkasan;
        $projectPlan->ruang_lingkup = $request->ruang_lingkup;
        $projectPlan->jadwal_proyek = $request->jadwal_proyek;
        $projectPlan->team_proyek = $request->team_proyek;
        $projectPlan->manajemen_proyek = $request->manajemen_proyek;
        $projectPlan->fitur_utama = $request->fitur_utama;
        $projectPlan->rincian_teknis = $request->rincian_teknis;
        $projectPlan->topologi = $request->topologi;
        $projectPlan->diagram = $request->diagram;
        $projectPlan->anggaran = $request->anggaran;
        $projectPlan->nilai = $request->nilai;
        $projectPlan->pernyataan = $request->pernyataan;
        $projectPlan->catatan = $request->catatan;
        $projectPlan->no_rev = $projectPlan->no_rev + 1;

        $faseData = [];

        $fase= json_decode($projectPlan->fase);
        // dd($fase);

        foreach ($request->scrum_name as $index => $scrumName) {
        $faseData[] = [
            'scrum_name' => $scrumName,
            'start' => $request->start[$index] ?? null,
            'end' => $request->end[$index] ?? null,
            'description' => $request->fase_1[$index] ?? null,
            'status' =>  $fase[$index]->status ?? null,
            'note' =>  $fase[$index]->note ?? null,
            'notes' =>  $fase[$index]->notes ?? null,
            ];
        }
        // dd($faseData);
        $projectPlan->fase = json_encode($faseData);

        $projectPlan->save();

        // Redirect with a success message
        return redirect()->back()->with('success', 'Project plan updated successfully');
    }

    public function launch($id) {
        $projectPlans = ProjectPlanM::where('project_id', $id)->get();

        $excludedKeys = [
            'pengantar_catatan',
            'ringkasan_catatan',
            'ruang_lingkup_catatan',
            'jadwal_proyek_catatan',
            'fase_1_catatan',
            'team_proyek_catatan',
            'manajemen_proyek_catatan',
            'fitur_utama_catatan',
            'rincian_teknis_catatan',
            'topologi_catatan',
            'diagram_catatan',
            'anggaran_catatan',
            'nilai_catatan',
            'pernyataan_catatan',
            'catatan_catatan',
            'pengantar_catatantl',
            'ringkasan_catatantl',
            'ruang_lingkup_catatantl',
            'jadwal_proyek_catatantl',
            'fase_1_catatantl',
            'team_proyek_catatantl',
            'manajemen_proyek_catatantl',
            'fitur_utama_catatantl',
            'rincian_teknis_catatantl',
            'topologi_catatantl',
            'diagram_catatantl',
            'anggaran_catatantl',
            'nilai_catatantl',
            'pernyataan_catatantl',
            'catatan_catatantl',
        ];

        $allFilled = $projectPlans->every(function ($plan) use ($excludedKeys) {
            foreach ($plan->getAttributes() as $key => $value) {
                if (!in_array($key, $excludedKeys) && ($value === null || $value === '')) {
                    return false;
                }
            }
            return true;
        });


        // dd($allFilled);

        if ($allFilled) {
            $data = ProjectM::find($id);
            if ($data) {
                $data->launch = 1;
                $data->save();
                $forum = new forumM();
                $forum->project_id = $data->id;
                // $forum->project_id = $data->id;
                $forum->save();
                $klien = User::find($data->customer_id);
                Mail::to($klien->email)->send(new LaunchMail($data));
                $invoice = invoiceM::where('project_id',$data->id)->value('id');
                $notif = new NotifM();
                $notif->user_id = $data->customer_id;
                $notif->status = 0;
                $notif->title = 'Project '. $data->judul . ' Has Been Launched';
                $notif->value = 'Silahkan periksa detail project plan dan lakukan komentar serta persetujuan project plan';
                $notif->project_id = $data->id;
                // $notif->invoice_id = $invoice;
                $notif->save();
                $notifs = new NotifKlienM();
                $notifs->user_id = $data->customer_id;
                $notifs->status = 2;
                $notifs->title = 'Project '. $data->judul . ' Has Been Launched';
                $notifs->value = 'Silahkan periksa detail project plan dan lakukan komentar serta persetujuan project plan';
                $notifs->project_id = $data->id;
                // $notifs->invoice_id = $invoice;
                $notifs->save();

                return redirect()->back()->with('success', 'Your project has been launched.');
            } else {
                return redirect()->back()->with('error', 'Project not found.');
            }
        } else {
            return redirect()->back()->with('error', 'Data for the project is incomplete. Please complete all fields.');
        }
    }

    public function communication($id){
        $ids = ProjectPlanM::where('project_id',$id)->value('id');
        $data = ProjectPlanM::find($ids);
        $project = ProjectM::find($id);
        // dd($ids);
        return view('page.pm.k-project.communication',compact('data','project'));
    }

    public function print($id){
        $project = ProjectM::find($id);
        $ids = ProjectPlanM::where('project_id',$project->id)->value('id');
        $data = ProjectPlanM::find($ids);
        $fase = json_decode($data->fase, true);
        return view('page.pm.k-project.print',compact('data','fase','project'));
    }

    public function upload(Request $request)
    {
        // Memastikan file diupload
        if ($request->hasFile('upload')) {
            $file = $request->file('upload');

            // Simpan file ke storage
            $path = $file->store('uploads', 'public');

            // Membuat URL untuk file yang baru diupload

            // Mengembalikan response yang diharapkan CKEditor
            return redirect()->back()->with('success','http://127.0.0.1:8000/storage/'.$path);
        }
    }




}
