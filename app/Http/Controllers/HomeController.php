<?php

namespace App\Http\Controllers;

use App\Services\RavenDBManager;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\View\View;

class HomeController extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    private RavenDBManager $manager;

    public function __construct(RavenDBManager $manager)
    {
        $this->manager = $manager;
    }

    /**
     * Show the profile for a given user.
     *
     * @param Request $request
     *
     * @return View|RedirectResponse
     */
    public function index(Request $request): View|RedirectResponse
    {
        if ($this->shouldRedirect()) {
            return redirect('/tasks');
        }

        return view('home');
    }

    private function shouldRedirect(): bool
    {
        return $this->manager->databaseExists();
    }
}
