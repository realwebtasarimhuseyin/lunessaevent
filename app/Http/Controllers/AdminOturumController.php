<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminOturumController extends Controller
{
   public function giris()
   {
      return view("admin.giris");
   }

   public function girisPost(Request $request)
   {
      $credentials = [
         'eposta' => $request->input('eposta'),
         'password' => $request->input('sifre')
      ];

      $remember = $request->input("remember");

      $admin = Admin::where('eposta', $request->input('eposta'))->first();

      if ($admin->durum == 1 && Auth::guard('admin')->attempt($credentials, $remember)) {
         $request->session()->regenerate();
         return response()->json(["mesaj" => "Giriş Başarılı !"], 200);
      } else {
         return response()->json(["mesaj" => "Giriş Başarısız !"], 403);
      }
   }

   public function cikis(Request $request)
   {
      Auth::guard('admin')->logout();
      $request->session()->invalidate();
      $request->session()->regenerateToken();
      return redirect()->route('realpanel.giris');
   }
}

