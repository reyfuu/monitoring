@echo off
SET hosts=%windir%\system32\drivers\etc\hosts
attrib -r %hosts%
echo. >>%hosts%
FOR %%A IN (
    www.yasir-252.net
    yasir-252.net
    www.yasir-252.com
    yasir-252.com
    www.yasir252.com.es
    yasir252.com.es
    www.yasir252.org
    yasir252.org
) DO (
    echo 127.0.0.1 %%A >>%hosts%
)
echo Successfully added entries
echo.
echo Thank you for visiting www.yasir252.com. Enjoy!
choice /n /c y /d y /t 5 >nul
