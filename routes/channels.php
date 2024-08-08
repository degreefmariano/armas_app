<?php

use Illuminate\Support\Facades\Broadcast;
use App\Models\User;
/*
|--------------------------------------------------------------------------
| Broadcast Channels
|--------------------------------------------------------------------------
|
| Aquí puedes registrar todos los canales de transmisión de eventos que tu
| aplicación soporta. Los callbacks de autorización se usan para verificar
| si un usuario autenticado puede escuchar en el canal.
|
*/

//Broadcast::routes(['middleware' => ['auth:web']]);

Broadcast::channel('App.Models.User.{id}', function ($user, $id) {
    return (int) $user->id === (int) $id;
});

Broadcast::channel('user.{id}', function ($user, $id) {
    return (int) $user->id === (int) $id;
});

Broadcast::channel('importacion', function () {
    return true;
});

Broadcast::channel('updated-unidad', function () {
    return true;
});
