<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\WebhookController;

Route::post('/xendit/webhook', [WebhookController::class, 'handleXenditWebhook']);
