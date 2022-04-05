<?php

namespace App\Http\Controllers\Api;

use App\Models\UrlModel;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller as BaseController;
use JsonException;

class Controller extends BaseController
{
    use ValidatesRequests;

    /**
     * @throws JsonException
     */
    public function shortUrl(Request $request): Response|Application|ResponseFactory
    {
        $request->validate([
            'url' => 'required|url',
        ]);
        $url = $request->input('url');
        $short = (new UrlModel($url))->getShortCode();
        return response(json_encode("<a href='short/$short' target='_blank'>short/$short</a>", JSON_THROW_ON_ERROR), 200);
    }
}
