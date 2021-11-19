<?php

namespace App\Controller\MyTracklist;

use App\Interfaces\MyTraclist\MyTraclistInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Interfaces\MyTracklist\MyTracklistInterface;
use App\Controller\SerializeController;
use Symfony\Component\HttpFoundation\JsonResponse;

/**
 * @IgnoreAnnotation("apiName")
 * @IgnoreAnnotation("apiGroup")
 * @IgnoreAnnotation("apiParam")
 * @IgnoreAnnotation("apiBody")
 * @IgnoreAnnotation("apiSuccess")
 * @IgnoreAnnotation("apiSuccessExample")
 * @IgnoreAnnotation("apiError")
 * @IgnoreAnnotation("apiErrorExample")
 * @IgnoreAnnotation("apiHeader")
 * @IgnoreAnnotation("apiHeaderExample")
 */

class MyTracklistController extends SerializeController
{
    private $myTrackListService;

    public function __construct(MyTracklistInterface $myTracklistInterface)
    {
        $this->myTrackListService = $myTracklistInterface;
    }

    /**
     * @api {GET} /backend/api/mytracklist Index Mytracklist
     * 
     * @apiGroup MYTRACKLIST
     * @apiName index_mytracklist
     * 
     * @apiSuccess (200) {Boolean} succes Should be true
     * @apiSuccess (200) {JSON} body Response body
     * 
     *  * @apiSuccessExample Success-Response:
     *     HTTP/1.1 200 OK
     *[
    *{
    *    "id": 1,
    *   "name": "deskot",
    *    "author": "Deskot",
    *    "title": "my Live",
    *    "album": "This is my live",
    *    "type": "Music",
    *    "genre": "Rock",
    *    "cover": null,
    *   "trackPath": "public/music/myLive.mp3",
    *    "createdAt": {
    *        "timezone": {
    *            "name": "UTC",
    *            "transitions": [
    *                {
    *                    "ts": -9223372036854775808,
    *                    "time": "-292277022657-01-27T08:29:52+0000",
    *                    "offset": 0,
    *                    "isdst": false,
    *                    "abbr": "UTC"
    *                }
    *            ],
    *            "location": {
    *                "country_code": "??",
    *                "latitude": 0,
    *                "longitude": 0,
    *                "comments": ""
    *            }
    *        },
    *        "offset": 0,
    *        "timestamp": -62169984000
    *    },
    *    "updatedAt": {
    *        "timezone": {
    *            "name": "UTC",
    *            "transitions": [
    *                 {
    *                    "ts": -9223372036854775808,
    *                    "time": "-292277022657-01-27T08:29:52+0000",
    *                   "offset": 0,
    *                    "isdst": false,
    *                    "abbr": "UTC"
    *                }
    *            ],
    *            "location": {
    *                "country_code": "??",
    *                "latitude": 0,
    *                "longitude": 0,
    *                "comments": ""
    *            }
    *        },
    *        "offset": 0,
    *        "timestamp": -62169984000
    *    },
    *    "playlistId": null
    *}
    * ]
     */
    public function index()
    {
        return JsonResponse::fromJsonString($this->serializeJson($this->myTrackListService->indexService()));
    }
    
    public function create()
    {
        return JsonResponse::fromJsonString($this->serializeJson($this->myTrackListService->createService()));
    }
}
