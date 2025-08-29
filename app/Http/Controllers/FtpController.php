<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class FtpController extends Controller
{
    public function index()
    {

        $localFolders = collect(File::directories(base_path()))
            ->map(fn($dir) => basename($dir))
            ->values();

        $ftpFolders = $this->getFtpDirectories();

        return view('ftp.index', compact('localFolders', 'ftpFolders'));
    }

    private function getFtpDirectories(): array
    {
        try {
            $ftpDisk = Storage::disk('ftp');

            return $ftpDisk->directories('/');
        } catch (\Exception $e) {
            return ['FTP bağlantısı başarısız: ' . $e->getMessage()];
        }
    }


    public function upload(Request $request)
    {
        $items = json_decode($request->input('selected_items', '[]'), true);
    
        if (!$items || !is_array($items)) {
            return back()->with('error', 'Gönderilecek dosya veya klasör seçilmedi.');
        }
    
        $ftpDisk = Storage::disk('ftp');
        $ftpPath = $request->ftp_path ? rtrim($request->ftp_path, '/') : '/';
    
        foreach ($items as $item) {
            $fullPath = base_path($item);
    
            if (File::isFile($fullPath)) {
                $target = $ftpPath . '/' . basename($item);
                $ftpDisk->put($target, File::get($fullPath));
            }
    
            if (File::isDirectory($fullPath)) {
                $files = File::allFiles($fullPath);
                foreach ($files as $file) {
                    $relative = ltrim(str_replace(base_path(), '', $file->getPathname()), '/');
                    $target = $ftpPath . '/' . $relative;
    
                    // FTP'de klasörleri oluştur
                    $dirParts = explode('/', dirname($target));
                    $accum = '';
                    foreach ($dirParts as $part) {
                        $accum .= $part . '/';
                        if (!$ftpDisk->exists($accum)) {
                            $ftpDisk->makeDirectory($accum);
                        }
                    }
    
                    $ftpDisk->put($target, File::get($file));
                }
            }
        }
    
        return back()->with('success', 'Seçilen dosya ve klasörler FTP\'ye gönderildi.');
    }
    


    public function klasorAgaci()
    {
        $base = base_path();
        $tree = $this->klasorleriGetir($base);

        return response()->json($tree);
    }

    private function klasorleriGetir($path)
    {
        $items = [];

        foreach (File::directories($path) as $dir) {
            $items[] = [
                'text' => basename($dir),
                'id' => str_replace(base_path() . '/', '', $dir),
                'children' => $this->klasorleriGetir($dir),
            ];
        }

        return $items;
    }

    public function klasorAgaciDetayli(Request $request)
{
    $id = $request->get('id', '');
    $root = $id === '#' ? base_path() : base_path($id);

    $items = [];

    foreach (File::directories($root) as $dir) {
        $items[] = [
            'text' => basename($dir),
            'id'   => str_replace(base_path() . '/', '', $dir),
            'children' => true,
            'type' => 'folder'
        ];
    }

    foreach (File::files($root) as $file) {
        $items[] = [
            'text' => basename($file),
            'id'   => str_replace(base_path() . '/', '', $file),
            'icon' => 'jstree-file',
            'type' => 'file'
        ];
    }

    return response()->json($items);
}

    

}
