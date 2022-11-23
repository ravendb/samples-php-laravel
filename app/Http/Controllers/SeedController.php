<?php

namespace App\Http\Controllers;

use App\Domain\Database\DatabaseSeeder;
use App\Services\RavenDBManager;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;

class SeedController extends BaseController
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
     * @return RedirectResponse
     */
    public function seed(Request $request): RedirectResponse
    {
        $this->manager->removeDatabaseIfExists();
        $this->manager->createDatabase();

        $seeder = new DatabaseSeeder($this->manager);
        $seeder->seed();

        return redirect('/tasks');
    }
}
