# Script untuk download Composer.phar untuk deployment ke Hostinger
# Jalankan script ini dengan: powershell -ExecutionPolicy Bypass -File download-composer.ps1

Write-Host "Downloading Composer installer..." -ForegroundColor Green

# Download installer
$installerUrl = "https://getcomposer.org/installer"
$installerFile = "composer-setup.php"

try {
    Invoke-WebRequest -Uri $installerUrl -OutFile $installerFile -UseBasicParsing
    Write-Host "Installer downloaded successfully!" -ForegroundColor Green
    
    # Run installer
    Write-Host "Installing Composer.phar..." -ForegroundColor Green
    php $installerFile --install-dir=. --filename=composer.phar
    
    # Clean up installer
    Remove-Item $installerFile -ErrorAction SilentlyContinue
    
    Write-Host "`nComposer.phar berhasil didownload!" -ForegroundColor Green
    Write-Host "File location: $(Get-Location)\composer.phar" -ForegroundColor Cyan
    Write-Host "`nUntuk menggunakan: php composer.phar install" -ForegroundColor Yellow
} catch {
    Write-Host "Error downloading Composer: $_" -ForegroundColor Red
    exit 1
}

