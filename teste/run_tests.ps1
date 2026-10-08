# Script PowerShell para execução dos testes automatizados
Write-Host "========================================================" -ForegroundColor Cyan
Write-Host "   EXECUTANDO TESTES DO BACKEND & BANCO DE DADOS        " -ForegroundColor Cyan
Write-Host "========================================================" -ForegroundColor Cyan

$phpExe = "C:\Users\10345\AppData\Local\Microsoft\WinGet\Packages\PHP.PHP.8.3_Microsoft.Winget.Source_8wekyb3d8bbwe\php.exe"
if (-not (Test-Path $phpExe)) {
    $phpExe = (Get-Command php -ErrorAction SilentlyContinue).Source
}

if ($phpExe) {
    & $phpExe "$PSScriptRoot\run_tests.php"
} else {
    Write-Host "PHP não encontrado no PATH para executar os testes." -ForegroundColor Red
}
