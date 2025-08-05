<?php

namespace App\Http\Controllers\HRD;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Master\Employee;
use DB;
use Illuminate\Support\Facades\File;

class AdministrationDocumentController extends Controller
{
    public function edit($id, $type)
    {
        $employee = Employee::where('emp_number', $id)->firstOrFail();
        
        // Mengambil template dokumen berdasarkan type
        $content = $this->getTemplateContent($type, $employee);

        return view('pages.manage.administration_document.edit', compact('employee', 'type', 'content'));
    }

    public function update(Request $request, $id)
    {
        try {
            // Di sini Anda bisa menyimpan konten yang diedit ke file template
            $this->saveTemplateContent($request->type, $request->content);
            
            return redirect()->route('administration.document.index', $id)
                           ->with('success', 'Dokumen berhasil diperbarui');
        } catch (\Exception $e) {
            return redirect()->back()
                           ->with('error', 'Terjadi kesalahan saat memperbarui dokumen');
        }
    }

    public function delete($id, $type)
    {
        try {
            // Di sini Anda bisa menghapus atau mereset template ke default
            $this->resetTemplateToDefault($type);
            
            return redirect()->back()->with('success', 'Dokumen berhasil direset ke default');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Terjadi kesalahan saat mereset dokumen');
        }
    }

    private function getTemplateContent($type, $employee)
    {
        // Implementasi untuk mengambil template berdasarkan type
        switch($type) {
            case 'berakhir_hubungan_kerja':
                return view('prints.pdfSuratPernyataanBerakhirHubunganKerja', compact('employee'))->render();
            case 'menjaga_rahasia':
                return view('prints.pdfSuratPernyataanMenjagaRahasiaPerusahaan', compact('employee'))->render();
            case 'perintah_kerja':
                return view('prints.pdfSuratPerintahKerja', compact('employee'))->render();
            case 'kontrak_kerja':
                return view('prints.pdfSuratPernyataanKontrakKerja', compact('employee'))->render();
            default:
                return '';
        }
    }

    private function saveTemplateContent($type, $content)
    {
        // Implementasi untuk menyimpan perubahan template
        $templatePath = $this->getTemplatePath($type);
        if ($templatePath) {
            File::put($templatePath, $content);
        }
    }

    private function resetTemplateToDefault($type)
    {
        // Implementasi untuk mereset template ke default
        $defaultPath = $this->getDefaultTemplatePath($type);
        $templatePath = $this->getTemplatePath($type);
        
        if ($defaultPath && $templatePath && File::exists($defaultPath)) {
            File::copy($defaultPath, $templatePath);
        }
    }

    private function getTemplatePath($type)
    {
        // Implementasi untuk mendapatkan path template yang akan diedit
        switch($type) {
            case 'berakhir_hubungan_kerja':
                return base_path('resources/views/prints/pdfSuratPernyataanBerakhirHubunganKerja.blade.php');
            case 'menjaga_rahasia':
                return base_path('resources/views/prints/pdfSuratPernyataanMenjagaRahasiaPerusahaan.blade.php');
            case 'perintah_kerja':
                return base_path('resources/views/prints/pdfSuratPerintahKerja.blade.php');
            case 'kontrak_kerja':
                return base_path('resources/views/prints/pdfSuratPernyataanKontrakKerja.blade.php');
            default:
                return null;
        }
    }

    private function getDefaultTemplatePath($type)
    {
        // Implementasi untuk mendapatkan path template default
        switch($type) {
            case 'berakhir_hubungan_kerja':
                return base_path('resources/views/prints/defaults/pdfSuratPernyataanBerakhirHubunganKerja.blade.php');
            case 'menjaga_rahasia':
                return base_path('resources/views/prints/defaults/pdfSuratPernyataanMenjagaRahasiaPerusahaan.blade.php');
            case 'perintah_kerja':
                return base_path('resources/views/prints/defaults/pdfSuratPerintahKerja.blade.php');
            case 'kontrak_kerja':
                return base_path('resources/views/prints/defaults/pdfSuratPernyataanKontrakKerja.blade.php');
            default:
                return null;
        }
    }
} 