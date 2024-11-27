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

    public function print($id){
        $ids = invoiceM::where('project_id',$id)->value('id');
        $data = invoiceM::find($ids);
        $project = ProjectM::find($id);
        $datain = ProjectM::where('id',$id)->get();
        foreach ($datain as $project) {
            $invoice = InvoiceM::where('project_id', $project->id)->first();
            if ($invoice) {
                if (empty($invoice->no_invoice) || empty($invoice->kepada) || empty($invoice->npwp) || empty($invoice->alamat) || empty($invoice->harga) || empty($invoice->terbilang) || empty($invoice->pembuat) || empty($invoice->date)) {
                    return redirect()->back()->with('error' , 'Lengkapi data invoice terlebih dahulu untuk project: ' . $project->judul);
                }
            }
        }
        $data->date= now();
        $data->save();
        return view('page.finance.k-invoice.print',compact('data','project'));
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
}
