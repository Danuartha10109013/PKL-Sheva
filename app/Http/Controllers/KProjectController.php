<?php

namespace App\Http\Controllers;

use App\Models\forumM;
use App\Models\ProjectM;
use App\Models\ProjectPlanM;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use PhpParser\Node\Expr\New_;
use SebastianBergmann\CodeCoverage\Report\Xml\Project;

class KProjectController
{
    public function index(){
        $data =ProjectM::all();
        $customer = User::where('role',3)->get();
        $team_leader = User::where('role',1)->get();
        return view('page.pm.k-project.index',compact('data','customer','team_leader'));
    }

    public function store(Request $request)
    {
        // Validate the form data
        $request->validate([
            'judul' => 'required|string|max:255',
            'customer' => 'required|string|max:255',
            'start' => 'nullable|date',
            'end' => 'nullable|date|after_or_equal:start',
            'biaya' => 'nullable|numeric|min:0',
        ]);

        // Create a new project with the provided data
        $project = New ProjectM();
        $project->judul = $request->judul;
        $project->customer_id = $request->customer;
        $project->start = $request->start;
        $project->team_leader_id = $request->team_leader;
        $project->end = $request->end;
        $project->biaya = $request->biaya;
        $project->pm_id =  Auth::user()->id;
        $project->save();

        $plan = New ProjectPlanM();
        $plan->project_id = $project->id;
        $plan->save();

        // Redirect back with a success message
        return redirect()->back()->with('success', 'Project created successfully!');
    }

    public function update(Request $request, $id)
    {
        // Validate the request data
        $request->validate([
            'judul' => 'required|string|max:255',
            'start' => 'required|date',
            'end' => 'required|date|after_or_equal:start',
            'biaya' => 'required|numeric',
        ]);

        // Find the project by ID
        $project = ProjectM::findOrFail($id);

        // Update project attributes
        $project->judul = $request->judul;
        $project->start = $request->start;
        $project->end = $request->end;
        $project->biaya = $request->biaya;

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
        // Delete the project from the database
        $project->delete();

        // Redirect back with success message
        return redirect()->route('pm.k-project')->with('success', 'Project deleted successfully.');
    }

    public function plan($id){
        $data = ProjectPlanM::findOrFail($id);
        $fase = json_decode($data->fase, true); // Decode JSON to array

        return view('page.pm.k-project.plan',compact('data','id','fase'));
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
        ]);

        // Find the project plan by ID
        $projectPlan = ProjectPlanM::findOrFail($id);

        // Update fields with input data
        $projectPlan->pengantar = $request->pengantar;
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
            ];
        }
        $projectPlan->fase = json_encode($faseData); // Simpan dalam kolom JSON
        $projectPlan->save();

        // Redirect with a success message
        return redirect()->back()->with('success', 'Project plan updated successfully');
    }
    public function update_plan_revision(Request $request,$id){
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
        ]);

        // Find the project plan by ID
        $projectPlan = ProjectPlanM::findOrFail($id);

        // Update fields with input data
        $projectPlan->pengantar = $request->pengantar;
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
            ];
        }
        $projectPlan->fase = json_encode($faseData); 

        // $projectPlan->pengantar_catatan = null;
        // $projectPlan->ringkasan_catatan = null;
        // $projectPlan->ruang_lingkup_catatan = null;
        // $projectPlan->jadwal_proyek_catatan = null;
        // $projectPlan->fase_1_catatan = null;
        // $projectPlan->team_proyek_catatan = null;
        // $projectPlan->manajemen_proyek_catatan = null;
        // $projectPlan->fitur_utama_catatan = null;
        // $projectPlan->rincian_teknis_catatan = null;
        // $projectPlan->topologi_catatan = null;
        // $projectPlan->diagram_catatan = null;
        // $projectPlan->anggaran_catatan = null;
        // $projectPlan->nilai_catatan = null;
        // $projectPlan->pernyataan_catatan = null;
        // $projectPlan->catatan_catatan = null;

        // $projectPlan->pengantar_catatantl = null;
        // $projectPlan->ringkasan_catatantl = null;
        // $projectPlan->ruang_lingkup_catatantl = null;
        // $projectPlan->jadwal_proyek_catatantl = null;
        // $projectPlan->fase_1_catatantl = null;
        // $projectPlan->team_proyek_catatantl = null;
        // $projectPlan->manajemen_proyek_catatantl = null;
        // $projectPlan->fitur_utama_catatantl = null;
        // $projectPlan->rincian_teknis_catatantl = null;
        // $projectPlan->topologi_catatantl = null;
        // $projectPlan->diagram_catatantl = null;
        // $projectPlan->anggaran_catatantl = null;
        // $projectPlan->nilai_catatantl = null;
        // $projectPlan->pernyataan_catatantl = null;
        // $projectPlan->catatan_catatantl = null;

        // Save the changes to the database
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
        return view('page.pm.k-project.print',compact('data','fase'));
    }
    
}
