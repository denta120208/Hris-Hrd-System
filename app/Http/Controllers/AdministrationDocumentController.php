<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Employee;
use App\Models\AdministrationDocument;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Redirect;

class AdministrationDocumentController extends Controller
{
    public function edit($id, $emp_number)
    {
        $employee = Employee::where('emp_number', $emp_number)->first();
        $document = AdministrationDocument::where('id', $id)
                    ->where('emp_number', $emp_number)
                    ->first();

        if (!$document) {
            Session::flash('error', 'Dokumen tidak ditemukan');
            return redirect()->back();
        }

        return view('pages.manage.administration_document.edit', compact('employee', 'document'));
    }

    public function update(Request $request, $id)
    {
        $document = AdministrationDocument::find($id);
        
        if (!$document) {
            Session::flash('error', 'Dokumen tidak ditemukan');
            return redirect()->back();
        }

        $document->update($request->all());
        
        Session::flash('success', 'Dokumen berhasil diperbarui');
        return redirect()->route('administration-document.index', $document->emp_number);
    }

    public function delete($id)
    {
        $document = AdministrationDocument::find($id);
        
        if (!$document) {
            Session::flash('error', 'Dokumen tidak ditemukan');
            return redirect()->back();
        }

        $document->delete();
        
        Session::flash('success', 'Dokumen berhasil dihapus');
        return redirect()->back();
    }
} 