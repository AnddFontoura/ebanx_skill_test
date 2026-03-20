<?php

namespace App\Http\Controllers;

use App\Service\Cleaner\CleanerService;
use Illuminate\Http\Request;

class CleanerController extends Controller
{
    public function __construct(
        protected CleanerService $cleanerService
    ) {

    }

    public function clean() {
        $this->cleanerService->clearData();
    }
}
