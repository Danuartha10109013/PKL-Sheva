<?php

namespace App\Http\Controllers;

use App\Models\ProjectM;
use App\Models\ProjectPlanM;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use PhpParser\Node\Expr\New_;

class KProjectController
{
    public function index(){
        $data =ProjectM::all();
        $customer = User::where('role',3)->get();
        return view('page.pm.k-project.index',compact('data','customer'));
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

        // Delete the project from the database
        $project->delete();

        // Redirect back with success message
        return redirect()->route('pm.k-project')->with('success', 'Project deleted successfully.');
    }

    public function plan($id){
        $data = ProjectPlanM::findOrFail($id);
        // dd($data);
        // $data = [];

        return view('page.pm.k-project.plan',compact('data','id'));
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
            'fase_1' => 'string|nullable',
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
        $projectPlan->fase_1 = $request->fase_1;
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

        // Save the changes to the database
        $projectPlan->save();

        // Redirect with a success message
        return redirect()->back()->with('success', 'Project plan updated successfully');
    }

    public function launch($id) {
        $projectPlans = ProjectPlanM::where('project_id', $id)->get();
        
        $allFilled = $projectPlans->every(function ($plan) {
            foreach ($plan->getAttributes() as $key => $value) {
                if (empty($value) && $key !== 'id' && $key !== 'project_id') { // Exclude non-essential fields
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
    
}
