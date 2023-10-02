<?php

namespace App\Core\Helper;

use App\Core\Common\CoreConst;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Lang;

class CommonHelper
{
    /**
     * @return bool
     */
    public static function isJpLang(): bool
    {
        return Lang::getLocale() == CoreConst::JA_LOCALE;
    }

    /**
     * @param $statusCode
     * @param $msg
     * @return JsonResponse
     */
    public static function AbortError($statusCode, $msg=null): JsonResponse
    {
        return response()->json([
            'message' => $msg,
        ], $statusCode);
    }

    /**
     * @param $msg
     * @return JsonResponse
     */
    public static function ResponseSuccess($msg=null):JsonResponse
    {
        return response()->json(['message'=>$msg], 200);
    }

    /**
     * @param string $url
     * @return string
     */
    public static function url_encode(string $url): string {
        $result = urlencode($url);
        $result = str_replace('.','%2E',$result);
        $result = str_replace('-','%2D',$result);
        $result = str_replace('_','%5F',$result);
        $result = str_replace('~','%7E',$result);
        return $result;
    }

    /**
     * @param string $url
     * @return string
     */
    public static function url_decode(string $url): string {
        return urldecode($url);
    }

    /**
     * @param string $url
     * @return string
     */
    public static function url_base64_encode(string $url): string {
        return preg_replace(array('/\+/', '/\//'), array('-', '_'), base64_encode($url));
    }

    public static function url_base64_decode(string $url_base64_encode): string {
        return base64_decode(preg_replace(array('/-/', '/_/'), array('+', '/'), $url_base64_encode));
    }
    /**
     * @param   User $user
     * @param $actorId
     * @return bool
     */
    public static function isActionAllow(User $user, $actorId): bool
    {
        if($user->isViewer()){
            return !empty($actorId) && $actorId == $user->id;
        }

        return $user->isAdmin();
    }
    public static function isActionAllowMeta(User $user): bool
    {
        return $user->isAdmin();
    }

    public static function isJalang(): bool
    {
        return Lang::locale() == CoreConst::JA_LOCALE;
    }
}