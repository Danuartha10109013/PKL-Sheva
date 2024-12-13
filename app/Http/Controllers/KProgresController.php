<?php

namespace App\Http\Controllers;

use App\Models\ProjectM;
use App\Models\ProjectPlanM;
use Illuminate\Http\Request;

class KProgresController
{
    public function index(){
        $data = ProjectM::all();

        return view('page.pm.k-progres.index',compact('data'));
    }

    public function progres($id){
        $ids = ProjectPlanM::where('project_id',$id)->value('id');
        $plan = ProjectPlanM::find($ids);
        $data = json_decode($plan->fase, true);
        // dd($plan); 
        return view('page.pm.k-progres.progres',compact('data','id'));
    }

    public function update(Request $request, $id)
{
    $projecplan = ProjectPlanM::where('project_id', $id)->value('id');
    $plan = ProjectPlanM::find($projecplan);
    
    // Decode the existing fase data
    $existingFaseData = json_decode($plan->fase, true) ?? [];

    $faseData = [];

    foreach ($request->scrum_name as $index => $scrumName) {
        $faseData[] = [
            'scrum_name' => $scrumName,
            'start' => $request->start[$index] ?? null,
            'end' => $request->end[$index] ?? null,
            'description' => $request->fase_1[$index] ?? null,
            'status' => isset($request->status[$index]) ? 1 : 0, // Handle checkbox
        ];
    }

    $plan->fase = json_encode($faseData);
    $plan->save();

    $fase = json_decode($plan->fase, true);
    
    $total_tasks = is_array($fase) ? count($fase) : 0; 
    $completed_phase_1 = is_array($fase) ? collect($fase)->where('status', 1)->count() : 0; // Status 1 (selesai tahap 1)
    $completion_percentage = $total_tasks > 0 ? ($completed_phase_1 / $total_tasks) * 100 : 0; // Persentase penyelesaian
    // dd($completion_percentage);
    $pjct= ProjectM::find($id);
    $pjct->progres = $completion_percentage;
    $pjct->save();

    return redirect()->route('pm.k-progres')->with('success', 'Data telah diperbarui');
}

}
