<?php

namespace App\Http\Controllers;

use App\Mail\InvoiceMail;
use App\Models\HistoryM;
use App\Models\invoiceM;
use App\Models\ProjectM;
use App\Models\ProjectPlanM;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class KProgresController
{
    public function index(){
        $data = ProjectM::orderBy('created_at','desc')->get();

        return view('page.pm.k-progres.index',compact('data'));
    }

    public function progres($id){
        $ids = ProjectPlanM::where('project_id',$id)->value('id');
        $plan = ProjectPlanM::find($ids);
        $data = json_decode($plan->fase, true);
        $in = invoiceM::where('project_id',$id)->value('id');
        $invoice = InvoiceM::find($in);

        if (
            empty($invoice->no_invoice) ||
            empty($invoice->ppn) ||
            empty($invoice->kepada) ||
            empty($invoice->npwp) ||
            empty($invoice->alamat) ||
            empty($invoice->pembuat) 
        ) {
            return back()->with('error', 'Data Invoice belum dilengkapi oleh Finance.');
        }
// dd($plan); 
        return view('page.pm.k-progres.progres',compact('data','id'));
    }

    public function update(Request $request, $id)
{
    $projecplan = ProjectPlanM::where('project_id', $id)->value('id');
    $plan = ProjectPlanM::find($projecplan);
    
    // dd($inn);
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
            'note' =>  $fase[$index]->note ?? null,
            'notes' =>  $fase[$index]->notes ?? null,
        ];
    }

    $plan->fase = json_encode($faseData);

    $fase = json_decode($plan->fase, true);
    
    $total_tasks = is_array($fase) ? count($fase) : 0; 
    $completed_phase_1 = is_array($fase) ? collect($fase)->where('status', 1)->count() : 0; // Status 1 (selesai tahap 1)
    $completion_percentage = $total_tasks > 0 ? ($completed_phase_1 / $total_tasks) * 100 : 0; // Persentase penyelesaian
    // dd($completion_percentage);
    $pjct= ProjectM::find($id);
    $kliens = User::find($pjct->customer_id);
    $pjct->progres = $completion_percentage;
    $inn = invoiceM::where('project_id',$plan->project_id)->first();
    if($plan->status == 0 || $plan->status == 2){
        return redirect()->back()->with('error','Project Plan Belum Disetujui Oleh Klien : '.$kliens->name);
    }

    if($total_tasks > 3){
        if($completion_percentage >= 60 && $completion_percentage < 90){
            if($inn->{'30'} == null){
                return redirect()->back()->with('error','Progres 30% belum terkonfirmasi membayar');
            }
        }elseif($completion_percentage >= 90 && $completion_percentage < 100){
            if($inn->{'60'} == null){
                return redirect()->back()->with('error','Progres 60% belum terkonfirmasi membayar');
            }
        }elseif($completion_percentage >= 100 ){
            if($inn->{'90'} == null){
                return redirect()->back()->with('error','Progres 90% belum terkonfirmasi membayar');
            }
        }
    }
   
    $plan->save();

    $pjct->save();

    $inv = invoiceM::where('project_id',$id)->value('id');
    $invoice = invoiceM::find($inv);
    $project = ProjectM::find($id);
    $user= User::find($project->customer_id);
    $emailData = null;
    // dd($project);
    $user= User::find($project->customer_id);
    if ($completion_percentage >= 30 && $completion_percentage < 60) {
        $totalCostNoPpn = $project->biaya * 0.30;
            $totalCost = $project->biaya *0.30 + ($project->biaya *0.30 * $invoice->ppn);
            $terbilang = ucfirst(terbilang($totalCost)) . ' Rupiah';
    
            $emailData = [
                'customerName' => $user->name,
                'invoiceId'    => $invoice->no_invoice,
                'amount'       => $project->biaya,
                'date'     => Carbon::now()->format('Y-m-d'),
                'dueDate' => Carbon::now()->addDays(14)->format('Y-m-d'),

                'company'      => 'PT ZEN MULTIMEDIA INDONESIA',
                'term'         => 'Termin 1',
                'percentage'   => '30%',
                'projectName'  => $project->judul,
                'terbilang'  => $terbilang,
                'senderName'  => $invoice->pembuat,
                'npwp'  => $invoice->npwp,
                'alamat'  => $invoice->alamat,
                'ppn'  => $invoice->ppn,
                'totalCostNoPpn'  => $totalCostNoPpn,
                'totalCost'  => $totalCost,
            ];
            $invoice->date = $emailData['date'];
            $invoice->due_date = $emailData['dueDate'];
            $invoice->save();
            $subTotal = $totalCostNoPpn;

            $history = [
                'project_id' => $project->id,
                'invoice' => $invoice->id,
                'no_invoice' => $invoice->no_invoice,
                'date'     => Carbon::now()->format('Y-m-d'),
                'dueDate' => Carbon::now()->addDays(14)->format('Y-m-d'),
                'kepada' => $invoice->kepada,
                'npwp' => $invoice->npwp,
                'alamat' => $invoice->alamat,
                'subTotal' => $subTotal,
                'no' => 1,
                'deskripsi' => "Termin I 30%, {$project->judul}",
                'unit' => '1 Pckg',
                'harga' => $subTotal,
                'jumlah' => $subTotal,
                'ppn' => $invoice->ppn,
                'terbilang' => $terbilang,
                'pembuat' => $invoice->pembuat,
                'total' => $totalCost,
            ];

    }elseif($completion_percentage >= 60 && $completion_percentage < 90){
        
        $totalCostNoPpn = $project->biaya * 0.60 - ($project->biaya * 0.30);
            $totalCost = ($project->biaya *0.60 + ($project->biaya *0.60 * $invoice->ppn)) - ($project->biaya *0.30 + ($project->biaya *0.30 * $invoice->ppn));
            $terbilang = ucfirst(terbilang($totalCost)) . ' Rupiah';
            // dd($totalCostNoPpn);
            $emailData = [
                'customerName' => $user->name,
                'invoiceId'    => $invoice->no_invoice,
                'amount'       => $project->biaya,
                'date'     => Carbon::now()->format('Y-m-d'),
                'dueDate' => Carbon::now()->addDays(14)->format('Y-m-d'),

                'company'      => 'PT ZEN MULTIMEDIA INDONESIA',
                'term'         => 'Termin 2',
                'percentage'   => '60%',
                'projectName'  => $project->judul,
                'terbilang'  => $terbilang,
                'senderName'  => $invoice->pembuat,
                'npwp'  => $invoice->npwp,
                'alamat'  => $invoice->alamat,
                'ppn'  => $invoice->ppn,
                'totalCostNoPpn'  => $totalCostNoPpn,
                'totalCost'  => $totalCost,
            ];
            $invoice->date = $emailData['date'];
            $invoice->due_date = $emailData['dueDate'];
            $invoice->save();
            $subTotal = $totalCostNoPpn;
            
            $history = [
                'project_id' => $project->id,
                'invoice' => $invoice->id,
                'no_invoice' => $invoice->no_invoice,
                'date'     => Carbon::now()->format('Y-m-d'),
                'dueDate' => Carbon::now()->addDays(14)->format('Y-m-d'),
                'kepada' => $invoice->kepada,
                'npwp' => $invoice->npwp,
                'alamat' => $invoice->alamat,
                'subTotal' => $subTotal,
                'no' => 1,
                'deskripsi' => "Termin 2 60%, {$project->judul}",
                'unit' => '1 Pckg',
                'harga' => $subTotal,
                'jumlah' => $subTotal,
                'ppn' => $invoice->ppn,
                'terbilang' => $terbilang,
                'pembuat' => $invoice->pembuat,
                'total' => $totalCost,
            ];
    }elseif($completion_percentage >= 90 && $completion_percentage < 100){
        
        $totalCostNoPpn = $project->biaya * 0.90 - ($project->biaya * 0.60);
        $totalCost = ($project->biaya *0.90 + ($project->biaya *0.90 * $invoice->ppn)) - ($project->biaya *0.60 + ($project->biaya *0.60 * $invoice->ppn));
        $terbilang = ucfirst(terbilang($totalCost)) . ' Rupiah';
        // dd($totalCostNoPpn);
        $emailData = [
            'customerName' => $user->name,
            'invoiceId'    => $invoice->no_invoice,
            'amount'       => $project->biaya,
            'date'     => Carbon::now()->format('d M Y'),
            'dueDate'  => Carbon::now()->addDays(14)->format('d M Y'),
            'company'      => 'PT ZEN MULTIMEDIA INDONESIA',
            'term'         => 'Termin 3',
            'percentage'   => '90%',
            'projectName'  => $project->judul,
            'terbilang'  => $terbilang,
            'senderName'  => $invoice->pembuat,
            'npwp'  => $invoice->npwp,
            'alamat'  => $invoice->alamat,
            'ppn'  => $invoice->ppn,
            'totalCostNoPpn'  => $totalCostNoPpn,
            'totalCost'  => $totalCost,
        ];
        $invoice->date = $emailData['date'];
            $invoice->due_date = $emailData['dueDate'];
            $invoice->save();
        $subTotal = $totalCostNoPpn;
            
        $history = [
            'project_id' => $project->id,
            'invoice' => $invoice->id,
            'no_invoice' => $invoice->no_invoice,
            'date'     => Carbon::now()->format('Y-m-d'),
                'dueDate' => Carbon::now()->addDays(14)->format('Y-m-d'),
            'kepada' => $invoice->kepada,
            'npwp' => $invoice->npwp,
            'alamat' => $invoice->alamat,
            'subTotal' => $subTotal,
            'no' => 1,
            'deskripsi' => "Termin 3 90%, {$project->judul}",
            'unit' => '1 Pckg',
            'harga' => $subTotal,
            'jumlah' => $subTotal,
            'ppn' => $invoice->ppn,
            'terbilang' => $terbilang,
            'pembuat' => $invoice->pembuat,
            'total' => $totalCost,
        ];
    }elseif($completion_percentage >= 100 ){
        
        $totalCostNoPpn = $project->biaya * 1 - ($project->biaya * 0.90);
            $totalCost = ($project->biaya * 1 + ($project->biaya * 1 * $invoice->ppn)) - ($project->biaya *0.90 + ($project->biaya *0.90 * $invoice->ppn));
            $terbilang = ucfirst(terbilang($totalCost)) . ' Rupiah';
            // dd($totalCostNoPpn);
            $emailData = [
                'customerName' => $user->name,
                'invoiceId'    => $invoice->no_invoice,
                'amount'       => $project->biaya,
                'date'     => Carbon::now()->format('Y-m-d'),
                'dueDate' => Carbon::now()->addDays(14)->format('Y-m-d'),

                'company'      => 'PT ZEN MULTIMEDIA INDONESIA',
                'term'         => 'Termin 4',
                'percentage'   => '100%',
                'projectName'  => $project->judul,
                'terbilang'  => $terbilang,
                'senderName'  => $invoice->pembuat,
                'npwp'  => $invoice->npwp,
                'alamat'  => $invoice->alamat,
                'ppn'  => $invoice->ppn,
                'totalCostNoPpn'  => $totalCostNoPpn,
                'totalCost'  => $totalCost,
            ];
            $invoice->date = $emailData['date'];
            $invoice->due_date = $emailData['dueDate'];
            $invoice->save();
        $subTotal = $totalCostNoPpn;
            
        $history = [
            'project_id' => $project->id,
            'invoice' => $invoice->id,
            'no_invoice' => $invoice->no_invoice,
            'date'     => Carbon::now()->format('Y-m-d'),
                'dueDate' => Carbon::now()->addDays(14)->format('Y-m-d'),
            'kepada' => $invoice->kepada,
            'npwp' => $invoice->npwp,
            'alamat' => $invoice->alamat,
            'subTotal' => $subTotal,
            'no' => 1,
            'deskripsi' => "Termin 4 100%, {$project->judul}",
            'unit' => '1 Pckg',
            'harga' => $subTotal,
            'jumlah' => $subTotal,
            'ppn' => $invoice->ppn,
            'terbilang' => $terbilang,
            'pembuat' => $invoice->pembuat,
            'total' => $totalCost,
        ];
    }
    if ($emailData != null) {
        Mail::to($user->email)->send(new InvoiceMail($emailData));
        HistoryM::create($history);
    }
    


    return redirect()->route('pm.k-progres')->with('success', 'Progress data has been updated');
}

}
