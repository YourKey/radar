<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\SnapshotRequest;
use App\Jobs\parseGuzzleJob;
use App\Models\Page;
use Illuminate\Http\Request;
use \Illuminate\Http\JsonResponse;

class SnapshotController extends Controller
{
    public function store(SnapshotRequest $request): JsonResponse
    {
        $page = Page::find($request->id);

        parseGuzzleJob::dispatch($page);

        return response()
            ->json([
                'status' => '200',
                'message' => 'Страница отправлена на проверку'
            ]);
    }
}
