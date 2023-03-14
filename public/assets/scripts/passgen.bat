@Echo Off
echo set speech = Wscript.CreateObject("SAPI.spVoice") >> "temp.vbs"
set text=Requiem's Password Generator. Please choose a length
echo speech.speak "%text%" >> "temp.vbs"
start temp.vbs
ping localhost -n 2 >nul
color c
echo Longer passwords might take longer to generate.
set /p l=Choose length (NUMBERS ONLY): 
cls
title Generating password length = %l%
echo Generating password length = %l%
del temp.vbs
goto 7
:7
ping localhost -n 2 >nul
Setlocal EnableDelayedExpansion
Set _RNDLength=%l%
Set _Alphanumeric=ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789!@#$
Set _Str=%_Alphanumeric%987654321
:_LenLoop
IF NOT "%_Str:~18%"=="" SET _Str=%_Str:~9%& SET /A _Len+=9& GOTO :_LenLoop
SET _tmp=%_Str:~9,1%
SET /A _Len=_Len+_tmp
Set _count=0
SET _RndAlphaNum=
:_loop
Set /a _count+=1
SET _RND=%Random%
Set /A _RND=_RND%%%_Len%
SET _RndAlphaNum=!_RndAlphaNum!!_Alphanumeric:~%_RND%,1!
If !_count! lss %_RNDLength% goto _loop
title Random password is !_RndAlphaNum!
cls
color 0a
Echo Random password is: !_RndAlphaNum!
echo !_RndAlphaNum!| clip
echo Copied to Clipboard!
echo set speech = Wscript.CreateObject("SAPI.spVoice") >> "temp.vbs"
set text=Password !_RndAlphaNum! Generated
echo speech.speak "%text%" >> "temp.vbs"
start temp.vbs
ping localhost -n 10 >nul
del temp.vbs
exit
