<?php

namespace App\Controller\MyTracklist;

use App\Interfaces\MyTracklist\MyTracklistInterface;
use App\Controller\SerializeController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use App\DTO\Transformer\TracklistTransformerDTO;
use App\Entity\Track;

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
    private $tracklistTransformerDTO;

    public function __construct(MyTracklistInterface $myTracklistInterface, TracklistTransformerDTO $tracklistTransformerDTO)
    {
        $this->myTrackListService = $myTracklistInterface;
        $this->tracklistTransformerDTO = $tracklistTransformerDTO;
    }

    /**
     * @api {GET} /backend/api/mytracklist Index Mytracklist
     * 
     * @apiGroup MYTRACKLIST
     * @apiName index_mytracklist
     * 
     * @apiSuccess {Int}  id Track unique ID
     * @apiSuccess {String} author    Name of track author
     * @apiSuccess {String} title     Name of track
     * @apiSuccess {String} album     Name of Album
     * @apiSuccess {String} type      Type of track
     * @apiSuccess {String} genre     Genre of track
     * @apiSuccess {String} cover     Path to image of track
     * @apiSuccess {String} trackPath Path to track
     * @apiSuccess {Json}   createdAt Time of create
     * @apiSuccess {Json}   updateAt  Time of update
     * @apiSuccess {Int}    playlistId Can be Null 
     * 
     * @apiSuccessExample Success-Response:
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

    public function index() : JsonResponse
    {
        return JsonResponse::fromJsonString($this->serializeJson($this->myTrackListService->indexService()));
    }
    
    /**
     * @api {GET} /backend/api/mytracklist/create Create MyTracklist
     * 
     * @apiGroup MYTRACKLIST
     * @apiName create_mytracklist
     * 
     * @apiSuccess (200) {Boolean} success Should be true
     * @apiSuccess (200) {JSON} body Response body
     * 
     * @apiSuccess {Array} trackType Array of track type
     * @apiSuccess {Array} genreType Array of genre type
     * 
     * @apiSuccessExample Success-Response:
     *     HTTP/1.1 200 OK
     * [
     *{
     *   "trackType": [
     *       "Book",
     *       "Podcast",
     *       "Music"
     *   ],
     *   "genreType": [
     *       "Rock",
     *       "Pop",
     *       "Classical",
     *       "Jazz",
     *       "Blues",
     *       "Hip-Hop",
     *       "Hardcore",
     *       "Metal",
     *       "Trance",
     *       "House",
     *       "Punk",
     *       "Grunge",
     *       "Folk",
     *       "Drum'n'bass",
     *       "Russian Chanson",
     *       "Retro",
     *       "Funk",
     *       "Ethnic",
     *       "Reggae",
     *       "Lounge"
     *   ]
     *}
     * ]
     *      
     * */

    public function create(): JsonResponse
    {
        return JsonResponse::fromJsonString($this->serializeJson($this->myTrackListService->createService()));
    }

    /**
     * @api {POST} /backend/api/mytracklist Store Mytracklist
     * 
     * @apiName store_mytracklist
     * @apiGroup MYTRACKLIST
     * 
     * @apiSuccess {Int}  id Track unique ID
     * @apiSuccess {String} author    Name of track author
     * @apiSuccess {String} title     Name of track
     * @apiSuccess {String} album     Name of Album
     * @apiSuccess {String} type      Type of track
     * @apiSuccess {String} genre     Genre of track
     * @apiSuccess {String} cover     Path to image of track
     * @apiSuccess {String} trackPath Path to track
     * @apiSuccess {Json}   createdAt Time of create
     * @apiSuccess {Json}   updateAt  Time of update
     * @apiSuccess {Int}    playlistId Can be Null 
     * 
     * 
     * @apiSuccessExample Success-Response:
     *     HTTP/1.1 200 OK
     * {
     *"id": 10,
     *"author": "deskot",
     *"title": "my live",
     *"album": null,
     *"type": "Music",
     *"genre": "Rock",
     *"cover": "/var/www/backend/public/uploads/image/8ecccced945ef3ee60fba17307ac4a46-619be96855036.png",
     *"trackPath": "/var/www/backend/public/uploads/audio/c0a116860981bb05e9164ee572133fcf-619be96857dc9.mp3",
     *"createdAt": {
     *   "timezone": {
     *       "name": "UTC",
     *       "transitions": [
     *           {
     *               "ts": -9223372036854775808,
     *               "time": "-292277022657-01-27T08:29:52+0000",
     *               "offset": 0,
     *               "isdst": false,
     *               "abbr": "UTC"
     *           }
     *       ],
     *       "location": {
     *           "country_code": "??",
     *           "latitude": 0,
     *           "longitude": 0,
     *           "comments": ""
     *       }
     *   },
     *   "offset": 0,
     *   "timestamp": 1637607784
     *},
     *"updatedAt": {
     *   "timezone": {
     *       "name": "UTC",
     *       "transitions": [
     *           {
     *               "ts": -9223372036854775808,
     *               "time": "-292277022657-01-27T08:29:52+0000",
     *               "offset": 0,
     *               "isdst": false,
     *               "abbr": "UTC"
     *           }
     *       ],
     *       "location": {
     *           "country_code": "??",
     *           "latitude": 0,
     *           "longitude": 0,
     *           "comments": ""
     *       }
     *   },
     *   "offset": 0,
     *   "timestamp": 1637607784
     *},
     *"playlistId": null
     *}
     * 
     */

    public function store(Request $request): JsonResponse
    {
        $dto = $this->tracklistTransformerDTO->transformerDTO($request);
        return JsonResponse::fromJsonString($this->serializeJson($this->myTrackListService->storeService($dto)));
    }

    /**
     * @api {GET} /backend/api/mytracklist/{id} Show Mytracklist
     * 
     * @apiName show_mytracklist
     * @apiGroup MYTRACKLIST
     * 
     * @apiSuccess {Int}  id Track unique ID
     * @apiSuccess {String} author    Name of track author
     * @apiSuccess {String} title     Name of track
     * @apiSuccess {String} album     Name of Album
     * @apiSuccess {String} type      Type of track
     * @apiSuccess {String} genre     Genre of track
     * @apiSuccess {String} cover     Path to image of track
     * @apiSuccess {String} trackPath Path to track
     * @apiSuccess {Json}   createdAt Time of create
     * @apiSuccess {Json}   updateAt  Time of update
     * @apiSuccess {Int}    playlistId Can be Null 
     * 
     * @apiSuccessExample Success-Response:
     *     HTTP/1.1 200 OK
     * {
     *"id": 7,
     *"author": "deskot",
     *"title": "my live",
     *"album": null,
     *"type": "Music",
     *"genre": "Rock",
     *"cover": null,
     *"trackPath": "publick",
     *"createdAt": {
     *   "timezone": {
     *       "name": "UTC",
     *       "transitions": [
     *           {
     *               "ts": -9223372036854775808,
     *               "time": "-292277022657-01-27T08:29:52+0000",
     *               "offset": 0,
     *               "isdst": false,
     *               "abbr": "UTC"
     *           }
     *       ],
     *       "location": {
     *           "country_code": "??",
     *           "latitude": 0,
     *           "longitude": 0,
     *           "comments": ""
     *       }
     *   },
     *   "offset": 0,
     *   "timestamp": 1637604470
     *},
     *"updatedAt": {
     *   "timezone": {
     *       "name": "UTC",
     *       "transitions": [
     *           {
     *               "ts": -9223372036854775808,
     *               "time": "-292277022657-01-27T08:29:52+0000",
     *               "offset": 0,
     *               "isdst": false,
     *               "abbr": "UTC"
     *           }
     *       ],
     *       "location": {
     *           "country_code": "??",
     *           "latitude": 0,
     *           "longitude": 0,
     *           "comments": ""
     *       }
     *   },
     *   "offset": 0,
     *   "timestamp": 1637604470
     *},
     *"playlistId": null
     *}
     *
     * @apiError CanNotFindTrack Can not find track
     * 
     * @apiErrorExample Error-Response
     *     HTTP/1.1 Not Found
     *     [
     * {
     *   "success": false,
     *   "body": "Can not find track"
     * }
     *]
     */
    public function show($id): JsonResponse
    {
        return JsonResponse::fromJsonString($this->serializeJson($this->myTrackListService->showService($id)));
    }

    /**
     * @api {GET} /api/mytracklist/{id}/edit
     * @apiName edit_mytracklist
     * @apiGroup MYTRACKLIST
     * 
     * @apiParam {id} id Track unique ID
     * 
     * @apiSuccess {Int}  id Track unique ID
     * @apiSuccess {String} author    Name of track author
     * @apiSuccess {String} title     Name of track
     * @apiSuccess {String} album     Name of Album
     * @apiSuccess {String} type      Type of track
     * @apiSuccess {String} genre     Genre of track
     * @apiSuccess {String} cover     Path to image of track
     * @apiSuccess {String} trackPath Path to track
     * @apiSuccess {Json}   createdAt Time of create
     * @apiSuccess {Json}   updateAt  Time of update
     * @apiSuccess {Int}    playlistId Can be Null 
     * 
     * @apiSuccessExample Success-Response:
     *     HTTP/1.1 200 OK
     * {
     *"id": 1,
     *"author": "deskot",
     *"title": "my live",
     *"album": null,
     *"type": "Music",
     *"genre": "Rock",
     *"cover": "image/8ecccced945ef3ee60fba17307ac4a46-619f76784b608.png",
     *"trackPath": "audio/c0a116860981bb05e9164ee572133fcf-619f767853c72.mp3",
     *"createdAt": {
     *   "timezone": {
     *       "name": "UTC",
     *       "transitions": [
     *           {
     *               "ts": -9223372036854775808,
     *               "time": "-292277022657-01-27T08:29:52+0000",
     *               "offset": 0,
     *               "isdst": false,
     *               "abbr": "UTC"
     *           }
     *      ],
     *       "location": {
     *           "country_code": "??",
     *          "latitude": 0,
     *           "longitude": 0,
     *           "comments": ""
     *       }
     *   },
     *   "offset": 0,
     *   "timestamp": 1637840504
     *},
     *"updatedAt": {
     *   "timezone": {
     *       "name": "UTC",
     *       "transitions": [
     *           {
     *               "ts": -9223372036854775808,
     *               "time": "-292277022657-01-27T08:29:52+0000",
     *               "offset": 0,
     *               "isdst": false,
     *               "abbr": "UTC"
     *           }
     *       ],
     *       "location": {
     *           "country_code": "??",
     *           "latitude": 0,
     *           "longitude": 0,
     *           "comments": ""
     *       }
     *   },
     *   "offset": 0,
     *   "timestamp": 1637840504
     *},
     *"playlistId": null
     *}
     */
    public function edit($id): JsonResponse
    {
        return JsonResponse::fromJsonString($this->serializeJson($this->myTrackListService->editService($id)));
    }
    /**
     * @api {POST} /api/mytracklist/{id}
     * @apiName edit_mytracklist
     * @apiGroup MYTRACKLIST
     * 
     * @apiParam {id} id Track unique ID
     * 
     * @apiSuccess {Int}  id Track unique ID
     * @apiSuccess {String} author    Name of track author
     * @apiSuccess {String} title     Name of track
     * @apiSuccess {String} album     Name of Album
     * @apiSuccess {String} type      Type of track
     * @apiSuccess {String} genre     Genre of track
     * @apiSuccess {String} cover     Path to image of track
     * @apiSuccess {String} trackPath Path to track
     * @apiSuccess {Json}   createdAt Time of create
     * @apiSuccess {Json}   updateAt  Time of update
     * @apiSuccess {Int}    playlistId Can be Null 
     * 
     * @apiSuccessExample Success-Response:
     *     HTTP/1.1 200 OK
     * {
     *"id": 1,
     *"author": "deskot",
     *"title": "my live",
     *"album": null,
     *"type": "Music",
     *"genre": "Rock",
     *"cover": "image/8ecccced945ef3ee60fba17307ac4a46-619f76784b608.png",
     *"trackPath": "audio/c0a116860981bb05e9164ee572133fcf-619f767853c72.mp3",
     *"createdAt": {
     *   "timezone": {
     *       "name": "UTC",
     *       "transitions": [
     *           {
     *               "ts": -9223372036854775808,
     *               "time": "-292277022657-01-27T08:29:52+0000",
     *               "offset": 0,
     *               "isdst": false,
     *               "abbr": "UTC"
     *           }
     *      ],
     *       "location": {
     *           "country_code": "??",
     *          "latitude": 0,
     *           "longitude": 0,
     *           "comments": ""
     *       }
     *   },
     *   "offset": 0,
     *   "timestamp": 1637840504
     *},
     *"updatedAt": {
     *   "timezone": {
     *       "name": "UTC",
     *       "transitions": [
     *           {
     *               "ts": -9223372036854775808,
     *               "time": "-292277022657-01-27T08:29:52+0000",
     *               "offset": 0,
     *               "isdst": false,
     *               "abbr": "UTC"
     *           }
     *       ],
     *       "location": {
     *           "country_code": "??",
     *           "latitude": 0,
     *           "longitude": 0,
     *           "comments": ""
     *       }
     *   },
     *   "offset": 0,
     *   "timestamp": 1637840504
     *},
     *"playlistId": null
     *}
     */
    public function update(Track $track, Request $request): JsonResponse
    {
        $dto = $this->tracklistTransformerDTO->transformerDTO($request);
        return JsonResponse::fromJsonString($this->serializeJson($this->myTrackListService->updateService($dto, $track)));
    }

    /**
     * @api {DELETE} /backend/api/mytracklist/{id} Delete mytracklist
     * 
     * @apiName delete_mytracklist
     * @apiGroup MYTRACKLIST
     * 
     * @apiParam {id} Track unique ID
     * 
     * @apiSuccess {Boolean} true 
     * @apiSuccess {String} body session answer
     * 
     * @apiSuccessExample Success-Response:
     *     HTTP/1.1 200 OK
     * [
     *{
     *   "success": true,
     *   "body": "Track successfully deleted"
     *}
     *]
     *
     * @apiError CanNotFindTrack Can not find track
     * 
     * @apiErrorExample Error-Response
     *     HTTP/1.1 Not Found
     *     [
     * {
     *   "success": false,
     *   "body": "Can not find track"
     * {
     * ]
     */
    public function delete($id): JsonResponse
    {
        return JsonResponse::fromJsonString($this->serializeJson($this->myTrackListService->deleteService($id)));
    }
}
