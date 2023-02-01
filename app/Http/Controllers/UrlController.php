<?php

namespace App\Http\Controllers;

use App\Http\Requests\UrlRequest;
use App\Models\Url;
use Illuminate\Http\JsonResponse;
use Nette\Utils\Random;

class UrlController extends Controller
{
    public function store(UrlRequest $request): JsonResponse
    {
        $originalUrl = $request->validated()['original_url'];
        $identifier = Random::generate();

        if ($url = Url::where('original_url', $originalUrl)->first()) {
            $identifier = $url->identifier;
        } else {
            Url::create([
                'original_url' => $originalUrl,
                'identifier' => $identifier
            ]);
        }

        return response()->json(['url' => \url('') . '/'. $identifier]);
    }


    public function show(string $identifier): JsonResponse
    {
        return response()->json(['url' => Url::whereIdentifier($identifier)->first()->original_url]);
    }
}
