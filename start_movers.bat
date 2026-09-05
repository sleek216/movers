@echo off
title Movers v1.3 Backend Server
cd /d "H:\Projects\Movers v1.3\backend"
"C:\Users\hm862\AppData\Local\Microsoft\WinGet\Packages\PHP.PHP.8.3_Microsoft.Winget.Source_8wekyb3d8bbwe\php.exe" artisan serve --host=0.0.0.0 --port=8000
pause
