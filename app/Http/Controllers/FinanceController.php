<?php

namespace App\Http\Controllers;

use App\Models\invoiceM;
use App\Models\ProjectM;
use Illuminate\Http\Request;
use SebastianBergmann\CodeCoverage\Report\Xml\Project;

class FinanceController
{
    public function index(){
        $data = ProjectM::all();
        $tiga = ProjectM::where('progres','>=',30)->where('progres','<',60)->get();
        $enam = ProjectM::where('progres','>=',60)->where('progres','<',100)->get();
        $sepuluh = ProjectM::where('progres','>=',100)->get();

       
        return view('page.finance.k-invoice.index',compact('data','tiga','enam','sepuluh'));
    }

    public function print($id)
{
    // Ambil ID invoice terkait project
    $ids = InvoiceM::where('project_id', $id)->value('id');
    $data = InvoiceM::find($ids);

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
                empty($invoice->harga) || 
                empty($invoice->terbilang) || 
                empty($invoice->pembuat) || 
                empty($invoice->date)
            ) {
                return redirect()->back()->with('error', 'Lengkapi data invoice terlebih dahulu untuk project: ' . $project->judul);
            }
        }
    }

    // Perbarui tanggal invoice
    $data->date = now();
    $data->save();

    // Hitung rincian berdasarkan progres
    $invoiceDetails = [];
    if ($project->progres >= 30 && $project->progres < 60) {
        $subTotal = $project->biaya * 0.3;
        $invoiceDetails[] = [
            'no' => 1,
            'deskripsi' => "Termin I 30%, {$project->judul}",
            'unit' => '1 Pckg',
            'harga' => $subTotal,
            'jumlah' => $subTotal,
        ];
    } elseif ($project->progres >= 60 && $project->progres < 100) {
        $subTotal = ($project->biaya * 0.6) - ($project->biaya * 0.3);
        $invoiceDetails[] = [
            'no' => 1,
            'deskripsi' => "Termin II 60%, {$project->judul}",
            'unit' => '1 Pckg',
            'harga' => $subTotal,
            'jumlah' => $subTotal,
        ];
    } elseif ($project->progres >= 100) {
        $subTotal = ($project->biaya * 1) - ($project->biaya * 0.6);
        $invoiceDetails[] = [
            'no' => 1,
            'deskripsi' => "Termin III 100%, {$project->judul}",
            'unit' => '1 Pckg',
            'harga' => $subTotal,
            'jumlah' => $subTotal,
        ];
    }

    $ppn = $subTotal * 0.11;
    $total = $subTotal + $ppn;

    return view('page.finance.k-invoice.print', compact('data', 'project', 'invoiceDetails', 'subTotal', 'ppn', 'total'));
}


    public function update(Request $request, $id)
    {
        // Validasi input
        $request->validate([
            'no_invoice' => 'nullable|string|max:255',
            'kepada' => 'nullable|string|max:255',
            'npwp' => 'nullable|string|max:255',
            'alamat' => 'nullable|string',
            'harga' => 'nullable|numeric',
            'terbilang' => 'nullable|string|max:255',
            'pembuat' => 'nullable|string|max:255',
            'date' => 'nullable|date',
        ]);

        // Temukan data berdasarkan ID
        $ids = invoiceM::where('project_id',$id)->value('id');
        $invoice = invoiceM::findOrFail($ids);

        // Update data
        $invoice->update([
            'no_invoice' => $request->no_invoice,
            'kepada' => $request->kepada,
            'npwp' => $request->npwp,
            'alamat' => $request->alamat,
            'harga' => $request->harga,
            'terbilang' => $request->terbilang,
            'pembuat' => $request->pembuat,
            'date' => $request->date,
        ]);

        // Redirect atau kembali dengan pesan sukses
        return redirect()->back()->with('success', 'Invoice berhasil diperbarui.');
    }

    public function project(){
        $data = ProjectM::all();
        return view('page.finance.k-project.index',compact('data'));
    }
}
