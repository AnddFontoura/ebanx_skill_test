<?php

namespace App\Http\Controllers;

use App\Service\Cleaner\CleanerService;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CleanerController extends Controller
{
    public function __construct(
        protected CleanerService $cleanerService
    ) {

    }

    public function clean() {
        $this->cleanerService->clearData();

        return response()->setStatusCode(Response::HTTP_OK);
    }
}
