<?php

namespace App\Controller\MyTracklist;

use Symfony\Component\HttpFoundation\Response;
use App\Interfaces\MyTracklist\MyTracklistInterface;
use App\Controller\SerializeController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use App\Service\FileUploader;
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
    public function create()
    {
        return JsonResponse::fromJsonString($this->serializeJson($this->myTrackListService->createService()));
    }

    /**
     * @api {POST} /backend/api/mytracklist Store Mytracklist
     * 
     * @apiName store_mytracklist
     * @apiGroup MYTRACKLIST
     * 
     * @apiSuccess (200) {Boolean} success Should be true
     * @apiSuccess (200) {JSON} body Response body 
     * 
     * @apiSuccess {id}  id of tracklist.
     * @apiSuccess {String} author Author of track.
     * @apiSuccess {String} album Album of track.
     * @apiSuccess {String} type Type of track.
     * @apiSuccess {String} genre Genre of track.
     * @apiSuccess {String} cover URL of image track.
     * @apiSuccess {String} trackPath URL of track.
     * @apiSuccess {json}   createdAt time of create.
     * @apiSuccess {json}   updatedAt time of update.
     * @apiSuccess {int}    playlistId for PlaylistID
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
     */
    public function store(Request $request)
    {
        $dto = $this->tracklistTransformerDTO->transformerDTO($request);
        return JsonResponse::fromJsonString($this->serializeJson($this->myTrackListService->storeService($dto)));
    }

    /**
     * @api {DELETE} /backend/api/mytracklist/{id} Delete mytracklist
     * 
     * @apiName delete_mytracklist
     * @apiGroup MYTRACKLIST
     * 
     * @apiParam {id} Track unique ID
     * 
     * @apiSuccess (200) {Boolean} success Should be true
     * @apiSuccess (200) {JSON} body Response body 
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
     */
    public function delete($id)
    {
        return JsonResponse::fromJsonString($this->serializeJson($this->myTrackListService->deleteService($id)));
    }
}
