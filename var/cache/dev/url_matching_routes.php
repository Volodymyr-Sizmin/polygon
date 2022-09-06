<?php

/**
 * This file has been auto-generated
 * by the Symfony Routing Component.
 */

return [
    false, // $matchHost
    [ // $staticRoutes
        '/api/auth/clientpassword' => [[['_route' => 'clientpassword', '_controller' => 'App\\Controller\\ClientPasswordController::passwordMatch'], null, ['POST' => 0], null, false, false, null]],
        '/api/auth/clientquest' => [[['_route' => 'clientquestion', '_controller' => 'App\\Controller\\ClientQuestionController::yourQuestion'], null, ['POST' => 0], null, false, false, null]],
        '/api/auth/createpin' => [[['_route' => 'createpin', '_controller' => 'App\\Controller\\CreatePinController::createPin'], null, ['POST' => 0], null, false, false, null]],
        '/api/auth/confpin' => [[['_route' => 'confirmpin', '_controller' => 'App\\Controller\\CreatePinController::confPin'], null, ['POST' => 0], null, false, false, null]],
        '/api/auth/decode' => [[['_route' => 'decode', '_controller' => 'App\\Controller\\DecodeController::decodeJwtToken'], null, ['POST' => 0], null, false, false, null]],
        '/api/auth/fetch' => [[['_route' => 'fetch', '_controller' => 'App\\Controller\\FetchController::matchCodes'], null, ['GET' => 0], null, false, false, null]],
        '/api/auth/loginid' => [[['_route' => 'loginid', '_controller' => 'App\\Controller\\LoginByIdController::idLogin'], null, ['POST' => 0], null, false, false, null]],
        '/api/auth/login' => [[['_route' => 'login', '_controller' => 'App\\Controller\\LoginController::emailLogin'], null, ['POST' => 0], null, false, false, null]],
        '/api/auth/code' => [[['_route' => 'code', '_controller' => 'App\\Controller\\MatchCodesController::matchCodes'], null, ['POST' => 0], null, false, false, null]],
        '/api/auth/nonclient' => [[['_route' => 'nonclient', '_controller' => 'App\\Controller\\NonClientRegisterController::nonClientRegister'], null, ['POST' => 0], null, false, false, null]],
        '/api/auth/quest' => [[['_route' => 'question', '_controller' => 'App\\Controller\\OwnQuestionController::yourQuestion'], null, ['POST' => 0], null, false, false, null]],
        '/api/auth/password' => [[['_route' => 'password', '_controller' => 'App\\Controller\\PasswordController::passwordMatch'], null, ['POST' => 0], null, false, false, null]],
        '/api/auth/resetcode' => [[['_route' => 'resetcode', '_controller' => 'App\\Controller\\ResetCodeController::matchResetCodes'], null, ['POST' => 0], null, false, false, null]],
        '/api/auth/reset' => [[['_route' => 'reset', '_controller' => 'App\\Controller\\ResetController::resetById'], null, ['POST' => 0], null, false, false, null]],
        '/api/auth/newpassword' => [[['_route' => 'newpassword', '_controller' => 'App\\Controller\\ResetPasswordController::passwordMatch'], null, ['POST' => 0], null, false, false, null]],
        '/api/auth/receiveId' => [[['_route' => 'receiveId', '_controller' => 'App\\Controller\\ResetPinController::recieveId'], null, ['POST' => 0], null, false, false, null]],
        '/api/auth/matchPin' => [[['_route' => 'matchPin', '_controller' => 'App\\Controller\\ResetPinController::matchPin'], null, ['POST' => 0], null, false, false, null]],
        '/api/auth/newPin' => [[['_route' => 'newPin', '_controller' => 'App\\Controller\\ResetPinController::newPin'], null, ['POST' => 0], null, false, false, null]],
        '/api/auth/finalPin' => [[['_route' => 'finalPin', '_controller' => 'App\\Controller\\ResetPinController::finalSavePin'], null, ['POST' => 0], null, false, false, null]],
        '/api/auth/savenondata' => [[['_route' => 'nondata', '_controller' => 'App\\Controller\\SaveNonBankClientDataController::savedata'], null, ['POST' => 0], null, false, false, null]],
        '/api/auth/savedata' => [[['_route' => 'savedata', '_controller' => 'App\\Controller\\SaveRegisterDataController::savedata'], null, ['POST' => 0], null, false, false, null]],
        '/api/auth/savereset' => [[['_route' => 'savereset', '_controller' => 'App\\Controller\\SaveResetPasswordController::savedata'], null, ['POST' => 0], null, false, false, null]],
        '/api/auth/sendemail' => [[['_route' => 'email', '_controller' => 'App\\Controller\\SendEmailController::sendEmail'], null, ['POST' => 0], null, false, false, null]],
        '/api/playlists' => [
            [['_route' => 'index_playlist', '_controller' => 'App\\Controller\\PlaylistController::index'], null, ['GET' => 0], null, false, false, null],
            [['_route' => 'create_playlist', '_controller' => 'App\\Controller\\PlaylistController::createPlaylist'], null, ['POST' => 0], null, false, false, null],
        ],
        '/api/file/upload' => [[['_route' => 'file_upload', '_controller' => 'App\\Controller\\FileController::upload'], null, ['POST' => 0], null, false, false, null]],
        '/api/accounts/logged-in-user' => [[['_route' => 'api_account', '_controller' => 'App\\Controller\\AccountController::accountApi'], null, ['GET' => 0], null, false, false, null]],
        '/api/accounts' => [[['_route' => 'list_account', '_controller' => 'App\\Controller\\AccountController::list'], null, ['GET' => 0], null, false, false, null]],
        '/api/login/email' => [[['_route' => 'email_login', '_controller' => 'App\\Controller\\LoginController::emailLogin'], null, ['POST' => 0], null, false, false, null]],
        '/api/login/phone' => [[['_route' => 'phone_login', '_controller' => 'App\\Controller\\LoginController::phoneLogin'], null, ['POST' => 0], null, false, false, null]],
        '/api/logout' => [[['_route' => 'logout', '_controller' => 'App\\Controller\\LoginController::logout'], null, ['GET' => 0], null, false, false, null]],
        '/api/registration/email' => [[['_route' => 'email_registration', '_controller' => 'App\\Controller\\RegistrationController::emailRegistration'], null, ['POST' => 0], null, false, false, null]],
        '/api/registration/phone' => [[['_route' => 'phone_registration', '_controller' => 'App\\Controller\\RegistrationController::phoneRegistration'], null, ['POST' => 0], null, false, false, null]],
        '/api/verify/email/send' => [[['_route' => 'send_email_verification', '_controller' => 'App\\Controller\\VerificationController::emailVerification'], null, ['POST' => 0], null, false, false, null]],
        '/api/reset/email/send' => [[['_route' => 'send_email_reset', '_controller' => 'App\\Controller\\ResetController::emailRequestCreation'], null, ['POST' => 0], null, false, false, null]],
        '/api/reset/email/update' => [[['_route' => 'reset_password_email', '_controller' => 'App\\Controller\\ResetController::resetPasswordEmail'], null, ['POST' => 0], null, false, false, null]],
        '/api/mytracklist' => [
            [['_route' => 'index_mytracklist', '_controller' => 'App\\Controller\\MyTracklist\\MyTracklistController::index'], null, ['GET' => 0], null, false, false, null],
            [['_route' => 'store_mytracklist', '_controller' => 'App\\Controller\\MyTracklist\\MyTracklistController::store'], null, ['POST' => 0], null, false, false, null],
        ],
        '/api/mytracklist/create' => [[['_route' => 'create_mytracklist', '_controller' => 'App\\Controller\\MyTracklist\\MyTracklistController::create'], null, ['GET' => 0], null, false, false, null]],
        '/api/profile/about/photo' => [
            [['_route' => 'upload_profile_photo', '_controller' => 'App\\Controller\\ProfileController::uploadProfilePhoto'], null, ['POST' => 0], null, false, false, null],
            [['_route' => 'get_profile_photo', '_controller' => 'App\\Controller\\ProfileController::getProfilePhoto'], null, ['GET' => 0], null, false, false, null],
            [['_route' => 'delete_profile_photo', '_controller' => 'App\\Controller\\ProfileController::deleteProfilePhoto'], null, ['DELETE' => 0], null, false, false, null],
        ],
        '/api/profile/about/info' => [[['_route' => 'show_user_info', '_controller' => 'App\\Controller\\ProfileController::showUserInfo'], null, ['GET' => 0], null, false, false, null]],
        '/api/burger/gotoartist' => [[['_route' => 'go_to_artist', '_controller' => 'App\\Controller\\BurgerController::getArtist'], null, ['POST' => 0], null, false, false, null]],
        '/api/burger/gotoalbum' => [[['_route' => 'go_to_album', '_controller' => 'App\\Controller\\BurgerController::getAlbum'], null, ['POST' => 0], null, false, false, null]],
        '/api/ping' => [[['_route' => 'ping', '_controller' => 'App\\Controller\\PingController::ping'], null, ['GET' => 0], null, false, false, null]],
    ],
    [ // $regexpList
        0 => '{^(?'
                .'|/_error/(\\d+)(?:\\.([^/]++))?(*:35)'
                .'|/api/(?'
                    .'|p(?'
                        .'|laylists/(?'
                            .'|([^/]++)(?'
                                .'|(*:77)'
                            .')'
                            .'|addtrack(*:93)'
                        .')'
                        .'|rofile/about/(?'
                            .'|info/([^/]++)(*:130)'
                            .'|password/([^/]++)(*:155)'
                            .'|email/([^/]++)(?'
                                .'|(*:180)'
                                .'|(*:188)'
                            .')'
                        .')'
                    .')'
                    .'|accounts/(?'
                        .'|([^/]++)(*:219)'
                        .'|change_pass/([^/]++)(*:247)'
                        .'|([^/]++)(*:263)'
                    .')'
                    .'|mytracklist/([^/]++)(?'
                        .'|(*:295)'
                        .'|/edit(*:308)'
                        .'|(*:316)'
                    .')'
                    .'|burger/(?'
                        .'|addnextup/([^/]++)(*:353)'
                        .'|sharesong/([^/]++)(*:379)'
                    .')'
                .')'
                .'|/verify/email/([^/]++)(*:411)'
                .'|/reset/email/([^/]++)(*:440)'
            .')/?$}sDu',
    ],
    [ // $dynamicRoutes
        35 => [[['_route' => '_preview_error', '_controller' => 'error_controller::preview', '_format' => 'html'], ['code', '_format'], null, null, false, true, null]],
        77 => [
            [['_route' => 'show_playlist', '_controller' => 'App\\Controller\\PlaylistController::showPlaylist'], ['id'], ['GET' => 0], null, false, true, null],
            [['_route' => 'modify_playlist', '_controller' => 'App\\Controller\\PlaylistController::modifyPlaylist'], ['id'], ['PUT' => 0], null, false, true, null],
            [['_route' => 'delete_playlist', '_controller' => 'App\\Controller\\PlaylistController::deletePlaylist'], ['id'], ['DELETE' => 0], null, false, true, null],
        ],
        93 => [[['_route' => 'add_track', '_controller' => 'App\\Controller\\PlaylistController::addTrack'], [], ['POST' => 0], null, false, false, null]],
        130 => [[['_route' => 'update_user_info', '_controller' => 'App\\Controller\\ProfileController::updateUserInfo'], ['id'], ['PUT' => 0], null, false, true, null]],
        155 => [[['_route' => 'check_password', '_controller' => 'App\\Controller\\ProfileController::checkPassword'], ['id'], ['POST' => 0], null, false, true, null]],
        180 => [[['_route' => 'send_email_verification_id', '_controller' => 'App\\Controller\\ProfileController::emailVerification'], ['id'], ['POST' => 0], null, false, true, null]],
        188 => [[['_route' => 'verify_email_to_change', '_controller' => 'App\\Controller\\ProfileController::verifyEmail'], ['url'], ['GET' => 0], null, false, true, null]],
        219 => [[['_route' => 'update_account', '_controller' => 'App\\Controller\\AccountController::update'], ['id'], ['PUT' => 0], null, false, true, null]],
        247 => [[['_route' => 'change_account_password', '_controller' => 'App\\Controller\\AccountController::changePassword'], ['id'], ['POST' => 0], null, false, true, null]],
        263 => [[['_route' => 'delete_account', '_controller' => 'App\\Controller\\AccountController::delete'], ['id'], ['DELETE' => 0], null, false, true, null]],
        295 => [[['_route' => 'show_mytracklist', '_controller' => 'App\\Controller\\MyTracklist\\MyTracklistController::show'], ['id'], ['GET' => 0], null, false, true, null]],
        308 => [[['_route' => 'edit_mytracklist', '_controller' => 'App\\Controller\\MyTracklist\\MyTracklistController::edit'], ['id'], ['GET' => 0], null, false, false, null]],
        316 => [
            [['_route' => 'update_mytracklist', '_controller' => 'App\\Controller\\MyTracklist\\MyTracklistController::update'], ['id'], ['POST' => 0], null, false, true, null],
            [['_route' => 'delete_mytracklist', '_controller' => 'App\\Controller\\MyTracklist\\MyTracklistController::delete'], ['id'], ['DELETE' => 0], null, false, true, null],
        ],
        353 => [[['_route' => 'add_to_nextup', '_controller' => 'App\\Controller\\BurgerController::addNextUp'], ['id'], ['GET' => 0], null, false, true, null]],
        379 => [[['_route' => 'share_song', '_controller' => 'App\\Controller\\BurgerController::shareSong'], ['id'], ['GET' => 0], null, false, true, null]],
        411 => [[['_route' => 'verify_email', '_controller' => 'App\\Controller\\VerificationController::verifyEmail'], ['url'], ['GET' => 0], null, false, true, null]],
        440 => [
            [['_route' => 'activate_reset_email', '_controller' => 'App\\Controller\\ResetController::activateResetEmail'], ['url'], ['GET' => 0], null, false, true, null],
            [null, null, null, null, false, false, 0],
        ],
    ],
    null, // $checkCondition
];
