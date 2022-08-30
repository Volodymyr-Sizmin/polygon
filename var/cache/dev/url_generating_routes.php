<?php

// This file has been auto-generated by the Symfony Routing Component.

return [
    'createpin' => [[], ['_controller' => 'App\\Controller\\CreatePinController::createPin'], [], [['text', '/api/auth/createpin']], [], []],
    'confirmpin' => [[], ['_controller' => 'App\\Controller\\CreatePinController::confPin'], [], [['text', '/api/auth/confpin']], [], []],
    'decode' => [[], ['_controller' => 'App\\Controller\\DecodeController::decodeJwtToken'], [], [['text', '/api/auth/decode']], [], []],
    'fetch' => [[], ['_controller' => 'App\\Controller\\FetchController::matchCodes'], [], [['text', '/api/auth/fetch']], [], []],
    'loginid' => [[], ['_controller' => 'App\\Controller\\LoginByIdController::idLogin'], [], [['text', '/api/auth/loginid']], [], []],
    'login' => [[], ['_controller' => 'App\\Controller\\LoginController::emailLogin'], [], [['text', '/api/auth/login']], [], []],
    'code' => [[], ['_controller' => 'App\\Controller\\MatchCodesController::matchCodes'], [], [['text', '/api/auth/code']], [], []],
    'nonclient' => [[], ['_controller' => 'App\\Controller\\NonClientRegisterController::nonClientRegister'], [], [['text', '/api/auth/nonclient']], [], []],
    'question' => [[], ['_controller' => 'App\\Controller\\OwnQuestionController::yourQuestion'], [], [['text', '/api/auth/quest']], [], []],
    'password' => [[], ['_controller' => 'App\\Controller\\PasswordController::passwordMatch'], [], [['text', '/api/auth/password']], [], []],
    'resetcode' => [[], ['_controller' => 'App\\Controller\\ResetCodeController::matchResetCodes'], [], [['text', '/api/auth/resetcode']], [], []],
    'reset' => [[], ['_controller' => 'App\\Controller\\ResetController::resetById'], [], [['text', '/api/auth/reset']], [], []],
    'newpassword' => [[], ['_controller' => 'App\\Controller\\ResetPasswordController::passwordMatch'], [], [['text', '/api/auth/newpassword']], [], []],
    'receiveId' => [[], ['_controller' => 'App\\Controller\\ResetPinController::recieveId'], [], [['text', '/api/auth/receiveId']], [], []],
    'matchPin' => [[], ['_controller' => 'App\\Controller\\ResetPinController::matchPin'], [], [['text', '/api/auth/matchPin']], [], []],
    'newPin' => [[], ['_controller' => 'App\\Controller\\ResetPinController::newPin'], [], [['text', '/api/auth/newPin']], [], []],
    'finalPin' => [[], ['_controller' => 'App\\Controller\\ResetPinController::finalSavePin'], [], [['text', '/api/auth/finalPin']], [], []],
    'nondata' => [[], ['_controller' => 'App\\Controller\\SaveNonBankClientDataController::savedata'], [], [['text', '/api/auth/savenondata']], [], []],
    'savedata' => [[], ['_controller' => 'App\\Controller\\SaveRegisterDataController::savedata'], [], [['text', '/api/auth/savedata']], [], []],
    'email' => [[], ['_controller' => 'App\\Controller\\SendEmailController::sendEmail'], [], [['text', '/api/auth/sendemail']], [], []],
    '_preview_error' => [['code', '_format'], ['_controller' => 'error_controller::preview', '_format' => 'html'], ['code' => '\\d+'], [['variable', '.', '[^/]++', '_format', true], ['variable', '/', '\\d+', 'code', true], ['text', '/_error']], [], []],
    'index_playlist' => [[], ['_controller' => 'App\\Controller\\PlaylistController::index'], [], [['text', '/api/playlists']], [], []],
    'create_playlist' => [[], ['_controller' => 'App\\Controller\\PlaylistController::createPlaylist'], [], [['text', '/api/playlists']], [], []],
    'show_playlist' => [['id'], ['_controller' => 'App\\Controller\\PlaylistController::showPlaylist'], [], [['variable', '/', '[^/]++', 'id', true], ['text', '/api/playlists']], [], []],
    'modify_playlist' => [['id'], ['_controller' => 'App\\Controller\\PlaylistController::modifyPlaylist'], [], [['variable', '/', '[^/]++', 'id', true], ['text', '/api/playlists']], [], []],
    'delete_playlist' => [['id'], ['_controller' => 'App\\Controller\\PlaylistController::deletePlaylist'], [], [['variable', '/', '[^/]++', 'id', true], ['text', '/api/playlists']], [], []],
    'add_track' => [[], ['_controller' => 'App\\Controller\\PlaylistController::addTrack'], [], [['text', '/api/playlists/addtrack']], [], []],
    'file_upload' => [[], ['_controller' => 'App\\Controller\\FileController::upload'], [], [['text', '/api/file/upload']], [], []],
    'api_account' => [[], ['_controller' => 'App\\Controller\\AccountController::accountApi'], [], [['text', '/api/accounts/logged-in-user']], [], []],
    'list_account' => [[], ['_controller' => 'App\\Controller\\AccountController::list'], [], [['text', '/api/accounts']], [], []],
    'update_account' => [['id'], ['_controller' => 'App\\Controller\\AccountController::update'], [], [['variable', '/', '[^/]++', 'id', true], ['text', '/api/accounts']], [], []],
    'change_account_password' => [['id'], ['_controller' => 'App\\Controller\\AccountController::changePassword'], [], [['variable', '/', '[^/]++', 'id', true], ['text', '/api/accounts/change_pass']], [], []],
    'delete_account' => [['id'], ['_controller' => 'App\\Controller\\AccountController::delete'], [], [['variable', '/', '[^/]++', 'id', true], ['text', '/api/accounts']], [], []],
    'email_login' => [[], ['_controller' => 'App\\Controller\\LoginController::emailLogin'], [], [['text', '/api/login/email']], [], []],
    'phone_login' => [[], ['_controller' => 'App\\Controller\\LoginController::phoneLogin'], [], [['text', '/api/login/phone']], [], []],
    'logout' => [[], ['_controller' => 'App\\Controller\\LoginController::logout'], [], [['text', '/api/logout']], [], []],
    'email_registration' => [[], ['_controller' => 'App\\Controller\\RegistrationController::emailRegistration'], [], [['text', '/api/registration/email']], [], []],
    'phone_registration' => [[], ['_controller' => 'App\\Controller\\RegistrationController::phoneRegistration'], [], [['text', '/api/registration/phone']], [], []],
    'send_email_verification' => [[], ['_controller' => 'App\\Controller\\VerificationController::emailVerification'], [], [['text', '/api/verify/email/send']], [], []],
    'verify_email' => [['url'], ['_controller' => 'App\\Controller\\VerificationController::verifyEmail'], [], [['variable', '/', '[^/]++', 'url', true], ['text', '/verify/email']], [], []],
    'send_email_reset' => [[], ['_controller' => 'App\\Controller\\ResetController::emailRequestCreation'], [], [['text', '/api/reset/email/send']], [], []],
    'activate_reset_email' => [['url'], ['_controller' => 'App\\Controller\\ResetController::activateResetEmail'], [], [['variable', '/', '[^/]++', 'url', true], ['text', '/reset/email']], [], []],
    'reset_password_email' => [[], ['_controller' => 'App\\Controller\\ResetController::resetPasswordEmail'], [], [['text', '/api/reset/email/update']], [], []],
    'index_mytracklist' => [[], ['_controller' => 'App\\Controller\\MyTracklist\\MyTracklistController::index'], [], [['text', '/api/mytracklist']], [], []],
    'create_mytracklist' => [[], ['_controller' => 'App\\Controller\\MyTracklist\\MyTracklistController::create'], [], [['text', '/api/mytracklist/create']], [], []],
    'store_mytracklist' => [[], ['_controller' => 'App\\Controller\\MyTracklist\\MyTracklistController::store'], [], [['text', '/api/mytracklist']], [], []],
    'show_mytracklist' => [['id'], ['_controller' => 'App\\Controller\\MyTracklist\\MyTracklistController::show'], [], [['variable', '/', '[^/]++', 'id', true], ['text', '/api/mytracklist']], [], []],
    'edit_mytracklist' => [['id'], ['_controller' => 'App\\Controller\\MyTracklist\\MyTracklistController::edit'], [], [['text', '/edit'], ['variable', '/', '[^/]++', 'id', true], ['text', '/api/mytracklist']], [], []],
    'update_mytracklist' => [['id'], ['_controller' => 'App\\Controller\\MyTracklist\\MyTracklistController::update'], [], [['variable', '/', '[^/]++', 'id', true], ['text', '/api/mytracklist']], [], []],
    'delete_mytracklist' => [['id'], ['_controller' => 'App\\Controller\\MyTracklist\\MyTracklistController::delete'], [], [['variable', '/', '[^/]++', 'id', true], ['text', '/api/mytracklist']], [], []],
    'upload_profile_photo' => [[], ['_controller' => 'App\\Controller\\ProfileController::uploadProfilePhoto'], [], [['text', '/api/profile/about/photo']], [], []],
    'get_profile_photo' => [[], ['_controller' => 'App\\Controller\\ProfileController::getProfilePhoto'], [], [['text', '/api/profile/about/photo']], [], []],
    'delete_profile_photo' => [[], ['_controller' => 'App\\Controller\\ProfileController::deleteProfilePhoto'], [], [['text', '/api/profile/about/photo']], [], []],
    'show_user_info' => [[], ['_controller' => 'App\\Controller\\ProfileController::showUserInfo'], [], [['text', '/api/profile/about/info']], [], []],
    'update_user_info' => [['id'], ['_controller' => 'App\\Controller\\ProfileController::updateUserInfo'], [], [['variable', '/', '[^/]++', 'id', true], ['text', '/api/profile/about/info']], [], []],
    'check_password' => [['id'], ['_controller' => 'App\\Controller\\ProfileController::checkPassword'], [], [['variable', '/', '[^/]++', 'id', true], ['text', '/api/profile/about/password']], [], []],
    'send_email_verification_id' => [['id'], ['_controller' => 'App\\Controller\\ProfileController::emailVerification'], [], [['variable', '/', '[^/]++', 'id', true], ['text', '/api/profile/about/email']], [], []],
    'verify_email_to_change' => [['url'], ['_controller' => 'App\\Controller\\ProfileController::verifyEmail'], [], [['variable', '/', '[^/]++', 'url', true], ['text', '/api/profile/about/email']], [], []],
    'add_to_nextup' => [['id'], ['_controller' => 'App\\Controller\\BurgerController::addNextUp'], [], [['variable', '/', '[^/]++', 'id', true], ['text', '/api/burger/addnextup']], [], []],
    'share_song' => [['id'], ['_controller' => 'App\\Controller\\BurgerController::shareSong'], [], [['variable', '/', '[^/]++', 'id', true], ['text', '/api/burger/sharesong']], [], []],
    'go_to_artist' => [[], ['_controller' => 'App\\Controller\\BurgerController::getArtist'], [], [['text', '/api/burger/gotoartist']], [], []],
    'go_to_album' => [[], ['_controller' => 'App\\Controller\\BurgerController::getAlbum'], [], [['text', '/api/burger/gotoalbum']], [], []],
    'ping' => [[], ['_controller' => 'App\\Controller\\PingController::ping'], [], [['text', '/api/ping']], [], []],
];