<?php

namespace App\Http\Controllers;

use App\Promocode;
use App\Service\ExternalPromoApiService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class PromoCodeController extends Controller
{
    public function registerPromoCode(Request $request)
    {
        $count = Promocode::where(['email' => $request->get('email'), 'code' => $request->get('code')])->count();

        /**
         * тут можно по фантазировать с тем будет ли кешироваться результат ответа внешней системы или нет
         * можно просто проверить и сказать что код невалидный и все, а можно еще добавить поле в таблицу с результатом.
         * и в идефле вообще вынести кещ в сервис, кроме того можно использовать redis, это будет гораздо быстрее
         */

        if ($count) {
            return JsonResponse::create('This Code Already Used', 403);
        }

        $promoService = new ExternalPromoApiService();

        $promoResponse = $promoService->registerPromocodeAtExternalSystem($request->get('email'), $request->get('code'));

        Promocode::create(['email' => $request->get('email'), 'code' => $request->get('code')]);

        if($promoResponse){
            return JsonResponse::create('Your Code Successfully registered');
        }

        return JsonResponse::create('This Code Not found', 403);
    }
}
