<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rules\Password;

class UserController extends Controller
{
    //Request @request -> mengambil value data : bisa dari input atau url
    public function register(Request $request)
    {
        // Validate
        $validateData = $request->validate(
            [
                // nama_input => [Jenis validasi]
                'name' => ['required', 'min:3'],
                // unique : table, field : data email tidak boleh duplikat
                'email' => ['required', 'email:rfc,dns', 'unique:users,email'],
                //confrimed : di form ada inputan "konfirmasi password"
                //uncompromised :  mengecek pw yang dibuat apakah sudah pernah di bobol
                'password' => ['required', 'min:8', 'max:10', 'confirmed', Password::min(8)->max(10)->uncompromised()],
            ],
            [
                // teks error yang bakal muncul kalau validasi gagal
                // 'nama_input.jenis_validasi' => 'pesan'
                'name.required' => 'Nama lengkap harus diisi',
                'name.min' => 'Nama lengkap harus diisi minimal 3 karakter',
                'email.required' => 'Email harus disini',
                'email.unique' => 'Email harus diisi dengan data yang belum terdaftar',
                'password.required' => 'Password harus diisi',
                'password.min' => 'Password harus diisi minimal 8 karakter',
                'password.max' => 'Password harus diisi hanya sampai 10 karakter',
                'password.confirmed' => 'Konfirmasi password tidak sesuai dengan password yang diberikan',
            ],
        );

        //simpan data ke database melalui model
        $createAccount = User::create([
            //nama field => isi data
            'name' => $validateData['name'],
            'email' => $validateData['email'],
            //hash::make => mengubah pw plain text menjadi karakter acak yang tidak bisa dibaca/dikembalikan ke text aslinya
            'password' => Hash::make($validateData['password']),
        ]);
        //menentukan jika berhasil disimpan akan diarahkan ke halaman mana : return redirect()->resourcebundle_get_error_code
        //mengirimkan session untuk notifikasi/info berhasul : with('nama), 'pesan')
        return redirect()->route('login')->with('success', 'Berhasil membuat akun! Silahkan login.');
    }

    public function login(Request $request)
    {
        $validateData = $request->validate(
            [
                'email' => ['required'],
                'password' => ['required'],
            ],
            [
                'email.required' => 'Email wajid diisi!',
                'password.required' => 'password wajib diisi',
            ],
        );

        if (Auth::attempt($validateData)) {
            $request->session()->regenerate();
            if (Auth::user()->role == 'admin') {
                return redirect()->route('admin.dashboard')->with('success', 'Berhasil Login');
            } else {
                return redirect()->route('home')->with('success', 'Berhasil Login');
            }
        } else {
            return redirect()->route('login')->with('Error', 'Email dan password salah, coba lagi')->withInput();
        }

        // $auth = $request->except(['_token']);
        // $checkAuth = Auth::attempt($auth);
        // if ($checkAuth) {
        //     // bikin ulang id session
        //     $request->session()->regenerate();
        //     return redirect()->route('home')->with('succes', 'Berhasil Login!');
        // }else {
        //     //with input()->mengiri,kan old (data inputan sebelumnya) ke halaman login
        //     return redirect()->route('login')->with('error', 'email dan password salah. coa lagi!')->withInput();
        // }
    }

    public function logout(Request $request)
    {
        Auth::logout();
        //memastikan session yang ada dibuat invalid/ expired
        $request->session()->invalidate();
        //bikin ulang token session baru
        $request->session()->regenerateToken();
        return redirect()->route('home')->with('success', 'Berhasil logout!');
    }
}
//terdapat dua argumen
//argumen pertama berisi rules
//argumen kedua berisi pesan
