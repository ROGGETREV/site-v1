<?php
require_once($_SERVER["DOCUMENT_ROOT"]."/main/Google2FA/Google2FA.php");
require_once($_SERVER["DOCUMENT_ROOT"]."/main/BaconQrCode/Exception/ExceptionInterface.php");
require_once($_SERVER["DOCUMENT_ROOT"]."/main/BaconQrCode/Exception/RuntimeException.php");
require_once($_SERVER["DOCUMENT_ROOT"]."/main/BaconQrCode/Renderer/RendererInterface.php");
require_once($_SERVER["DOCUMENT_ROOT"]."/main/BaconQrCode/Renderer/ImageRenderer.php");
require_once($_SERVER["DOCUMENT_ROOT"]."/main/BaconQrCode/Renderer/RendererStyle/EyeFill.php");
require_once($_SERVER["DOCUMENT_ROOT"]."/main/BaconQrCode/Renderer/Image/ImageBackEndInterface.php");
require_once($_SERVER["DOCUMENT_ROOT"]."/main/BaconQrCode/Renderer/Image/ImagickImageBackEnd.php");
require_once($_SERVER["DOCUMENT_ROOT"]."/main/BaconQrCode/Renderer/RendererStyle/Fill.php");
require_once($_SERVER["DOCUMENT_ROOT"]."/main/BaconQrCode/Renderer/RendererStyle/RendererStyle.php");
require_once($_SERVER["DOCUMENT_ROOT"]."/main/BaconQrCode/Renderer/Module/ModuleInterface.php");
require_once($_SERVER["DOCUMENT_ROOT"]."/main/BaconQrCode/Renderer/Module/SquareModule.php");
require_once($_SERVER["DOCUMENT_ROOT"]."/main/BaconQrCode/Renderer/Eye/EyeInterface.php");
require_once($_SERVER["DOCUMENT_ROOT"]."/main/BaconQrCode/Renderer/Eye/ModuleEye.php");
require_once($_SERVER["DOCUMENT_ROOT"]."/main/BaconQrCode/Renderer/Color/ColorInterface.php");
require_once($_SERVER["DOCUMENT_ROOT"]."/main/BaconQrCode/Renderer/Color/Gray.php");
require_once($_SERVER["DOCUMENT_ROOT"]."/main/BaconQrCode/Writer.php");

use PragmaRX\Google2FA\Google2FA;
use BaconQrCode\Renderer\ImageRenderer;
use BaconQrCode\Renderer\Image\ImagickImageBackEnd;
use BaconQrCode\Renderer\RendererStyle\RendererStyle;
use BaconQrCode\Writer;

$g2fa = new Google2FA();

$shit = [
    "2fasecret" => $g2fa->generateSecretKey(),
    "email" => "thebackytb@gmail.com"
];

$url = $g2fa->getQRCodeUrl(
    "ROGGET",
    $shit["email"],
    $shit["2fasecret"]
);

$renderer = new ImageRenderer(
    new RendererStyle(250),
    new ImagickImageBackEnd()
);
$writer = new Writer($renderer);

$writer->writeFile($url, 'qrcode.png');

$encoded = base64_encode($writer->writeString($url));

$otp = $g2fa->getCurrentOtp($shit["2fasecret"]);