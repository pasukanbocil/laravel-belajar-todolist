<?php

namespace App\Http\Controllers;

use App\Services\UserSevice;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class UserController extends Controller
{
    private UserSevice $userSevice;

    /**
     * __construct
     *
     * @param  mixed $userSevice
     * @return void
     */
    public function __construct(UserSevice $userSevice)
    {
        $this->userSevice = $userSevice;
    }
    public function login(): Response
    {
        return response()
            ->view("user.login", [
                "title" => "Login"
            ]);
    }

    public function doLogin(Request $request): Response|RedirectResponse
    {
        $user = $request->input("user");
        $password = $request->input("password");

        // validate input
        if (empty($user) || empty($password)) {
            return response()->view("user.login", [
                "title" => "Login",
                "error" => "User Atau Password Tidak Boleh Kosong!"
            ]);
        }
        if ($this->userSevice->login($user, $password)) {
            $request->session()->put("user", $user);
            return redirect("/");
        }
        return response()->view("user.login", [
            "title" => "Login",
            "error" => "User Atau Password Salah!"
        ]);
    }

    public function doLogout(Request $request): RedirectResponse
    {
        $request->session()->forget("user");
        return redirect("/");
    }
}
