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
use SebastianBergmann\CodeCoverage\Report\Xml\Project;

class FinanceController
{
    public function index(){
        $data = ProjectM::orderBy('created_at','desc')->get();
        $nol = ProjectM::where('progres','>=',0)->where('progres','<',30)->orderBy('created_at', 'desc')->get();
        $tiga = ProjectM::where('progres','>=',30)->where('progres','<',60)->orderBy('created_at', 'desc')->get();
        $enam = ProjectM::where('progres','>=',60)->where('progres','<',90)->orderBy('created_at', 'desc')->get();
        $sembilan = ProjectM::where('progres','>=',90)->where('progres','<',100)->orderBy('created_at', 'desc')->get();
        $sepuluh = ProjectM::where('progres','>=',100,)->orderBy('created_at', 'desc')->get();

       
        return view('page.finance.k-invoice.index',compact('data','nol','tiga','enam','sembilan','sepuluh'));
    }

    public function print($id)
{
    // Ambil ID invoice terkait project
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

public function printInvoice($id){
    $data = HistoryM::find($id);
    return view('page.finance.k-invoice.printInvoice',compact('data'));
}



    public function update(Request $request, $id)
    {
        // dd($request->all());
        // Validasi input
        $request->validate([
            'no_invoice' => 'nullable|string|max:255',
            'kepada' => 'nullable|string|max:255',
            'npwp' => 'nullable|string|max:255',
            'alamat' => 'nullable|string',
            'harga' => 'nullable|numeric',
            'ppn' => 'nullable',
            'terbilang' => 'nullable|string|max:255',
            'pembuat' => 'nullable|string|max:255',
        ]);

        // Temukan data berdasarkan ID
        $ids = invoiceM::where('project_id',$id)->value('id');
        $invoice = invoiceM::findOrFail($ids);

        // dd($invoice);

        // Update data
            $invoice->no_invoice = $request->no_invoice;
            $invoice->kepada = $request->kepada;
            $invoice->npwp = $request->npwp;
            $invoice->alamat = $request->alamat;
            $invoice->pembuat = $request->pembuat;
            // $invoice->date = $request->date;
            // $invoice->due_date = $request->due_date;
            $invoice->ppn = $request->ppn;
            // dd($invoice->ppn);
            $invoice->save();
            // dd($invoice);

        // Redirect atau kembali dengan pesan sukses
        return redirect()->back()->with('success', 'Invoice berhasil diperbarui.');
    }

    public function project(){
        $data = ProjectM::all();
        return view('page.finance.k-project.index',compact('data'));
    }

    public function mail(Request $request, $id){
        // dd($request->all());
        $invoice = invoiceM::findOrFail($id);
        $project = ProjectM::find($invoice->project_id);
        // dd($project);
        $user= User::find($project->customer_id);
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
        if($request->type == 30){
            if ($project->progres < 30){
                return back()->with('error', 'Progres belum mencapai 30%.');
            }
            $totalCostNoPpn = $project->biaya * 0.30;
            $totalCost = $project->biaya *0.30 + ($project->biaya *0.30 * $invoice->ppn);
            $terbilang = ucfirst(terbilang($totalCost)) . ' Rupiah';
    
            $emailData = [
                'customerName' => $user->name,
                'invoiceId'    => $invoice->no_invoice,
                'amount'       => $project->biaya,
                'date'      => Carbon::parse($request->date)->format('d M Y'),
                'dueDate'      => Carbon::parse($request->dueDate)->format('d M Y'),
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
            $subTotal = $totalCostNoPpn;

            $history = [
                'project_id' => $project->id,
                'invoice' => $invoice->id,
                'no_invoice' => $invoice->no_invoice,
                'date'      => Carbon::parse($request->date)->format('Y-m-d'),
                'dueDate'      => Carbon::parse($request->dueDate)->format('Y-m-d'),
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
            // dd($emailData);
        }elseif($request->type == 60){
            if ($project->progres < 60){
                return back()->with('error', 'Progres belum mencapai 60%.');
            }
            $totalCostNoPpn = $project->biaya * 0.60 - ($project->biaya * 0.30);
            $totalCost = ($project->biaya *0.60 + ($project->biaya *0.60 * $invoice->ppn)) - ($project->biaya *0.30 + ($project->biaya *0.30 * $invoice->ppn));
            $terbilang = ucfirst(terbilang($totalCost)) . ' Rupiah';
            // dd($totalCostNoPpn);
            $emailData = [
                'customerName' => $user->name,
                'invoiceId'    => $invoice->no_invoice,
                'amount'       => $project->biaya,
                'date'      => Carbon::parse($request->date)->format('d M Y'),
                'dueDate'      => Carbon::parse($request->dueDate)->format('d M Y'),
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

            $subTotal = $totalCostNoPpn;
            
            $history = [
                'project_id' => $project->id,
                'invoice' => $invoice->id,
                'no_invoice' => $invoice->no_invoice,
                'date'      => Carbon::parse($request->date)->format('Y-m-d'),
                'dueDate'      => Carbon::parse($request->dueDate)->format('Y-m-d'),
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
        }elseif($request->type == 90){
            if ($project->progres < 90){
                return back()->with('error', 'Progres belum mencapai 90%.');
            }
            $totalCostNoPpn = $project->biaya * 0.90 - ($project->biaya * 0.60);
            $totalCost = ($project->biaya *0.90 + ($project->biaya *0.90 * $invoice->ppn)) - ($project->biaya *0.60 + ($project->biaya *0.60 * $invoice->ppn));
            $terbilang = ucfirst(terbilang($totalCost)) . ' Rupiah';
            // dd($totalCostNoPpn);
            $emailData = [
                'customerName' => $user->name,
                'invoiceId'    => $invoice->no_invoice,
                'amount'       => $project->biaya,
                'date'      => Carbon::parse($request->date)->format('d M Y'),
                'dueDate'      => Carbon::parse($request->dueDate)->format('d M Y'),
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

            $subTotal = $totalCostNoPpn;
            
        $history = [
            'project_id' => $project->id,
            'invoice' => $invoice->id,
            'no_invoice' => $invoice->no_invoice,
            'date'      => Carbon::parse($request->date)->format('Y-m-d'),
                'dueDate'      => Carbon::parse($request->dueDate)->format('Y-m-d'),
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
        }elseif($request->type == 100){
            if ($project->progres < 100){
                return back()->with('error', 'Progres belum mencapai 100%.');
            }
            $totalCostNoPpn = $project->biaya * 1 - ($project->biaya * 0.90);
            $totalCost = ($project->biaya * 1 + ($project->biaya * 1 * $invoice->ppn)) - ($project->biaya *0.90 + ($project->biaya *0.90 * $invoice->ppn));
            $terbilang = ucfirst(terbilang($totalCost)) . ' Rupiah';
            // dd($totalCostNoPpn);
            $emailData = [
                'customerName' => $user->name,
                'invoiceId'    => $invoice->no_invoice,
                'amount'       => $project->biaya,
                'date'      => Carbon::parse($request->date)->format('d M Y'),
                'dueDate'      => Carbon::parse($request->dueDate)->format('d M Y'),
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

            $subTotal = $totalCostNoPpn;
            
        $history = [
            'project_id' => $project->id,
            'invoice' => $invoice->id,
            'no_invoice' => $invoice->no_invoice,
            'date'      => Carbon::parse($request->date)->format('Y-m-d'),
                'dueDate'      => Carbon::parse($request->dueDate)->format('Y-m-d'),
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
        return redirect()->back()->with('success', 'Email telah berhasil dikirim');
    }

    public function tiga($id) {
        $inv = invoiceM::find($id);
        $inv['30'] = 'payed'; // Use array syntax for numeric or unusual column names
        $inv->save();
        return redirect()->back()->with('success', 'Pembayaran telah dikonfirmasi');
    }
    public function enam($id) {
        $inv = invoiceM::find($id);
        $inv['60'] = 'payed'; // Use array syntax for numeric or unusual column names
        $inv->save();
        return redirect()->back()->with('success', 'Pembayaran telah dikonfirmasi');
    }
    public function sembilan($id) {
        $inv = invoiceM::find($id);
        $inv['90'] = 'payed'; // Use array syntax for numeric or unusual column names
        $inv->save();
        return redirect()->back()->with('success', 'Pembayaran telah dikonfirmasi');
    }
    public function sepuluh($id) {
        $inv = invoiceM::find($id);
        $inv['100'] = 'payed'; // Use array syntax for numeric or unusual column names
        $inv->save();
        return redirect()->back()->with('success', 'Pembayaran telah dikonfirmasi');
    }
    
}
